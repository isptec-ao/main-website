<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreRecruitmentPublicationRequest;
use App\Models\Canvas\RecruitmentPublication;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\RecruitmentCategory;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RecruitmentPublicationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/RecruitmentPublications/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'recruitmentpublications' => RecruitmentPublication::with('category')->orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/RecruitmentPublications/Create', [
            'categories' => RecruitmentCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreRecruitmentPublicationRequest $request
     */
    public function store(StoreRecruitmentPublicationRequest $request)
    {

        DB::transaction(function () use ($request) {
            $recruitmentpublication = RecruitmentPublication::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::of($request->title)->slug('-')->__toString(),
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'requirements' => $request->requirements,
                'user_id' => auth()->guard('website')->user()->id
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $recruitmentpublication
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $recruitmentpublication
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.recruitmentpublications.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        $section = Section::find($id);

        return $section ? response()->json($section, 200) : response()->json(null, 404);
    }

    /**
     * Display the specified relationship.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function showPosts(Request $request, $id): JsonResponse
    {
        $section = Section::with('posts')->find($id);

        return $section ? response()->json($section->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        $recruitmentpublication = RecruitmentPublication::findOrFail($id);

        $recruitmentpublication->delete();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function restore(Request $request, $id)
    {
        $recruitmentpublication = RecruitmentPublication::withTrashed()->findOrFail($id);

        $recruitmentpublication->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $recruitmentpublication = RecruitmentPublication::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/RecruitmentPublications/Lang', [
            'lang' => $request->lang,
            'categories' => RecruitmentCategory::get(['id','name']),
            'recruitmentpublication' => [
                'id' => $recruitmentpublication->id,
                'title' => $recruitmentpublication->title,
                'category_id' => $recruitmentpublication->category_id,
                'category' => $recruitmentpublication->category,
                'description' => $recruitmentpublication->description,
                'start_date' => $recruitmentpublication->start_date,
                'end_date' => $recruitmentpublication->end_date,
                'start_time' => $recruitmentpublication->start_time,
                'end_time' => $recruitmentpublication->end_time,
                'requirements' => $recruitmentpublication->requirements,
            ],
            'featured_image' => function() use ($recruitmentpublication){
                if($recruitmentpublication->getFirstMedia('featured_image')){
                    return [
                        'id' => $recruitmentpublication->getFirstMedia('featured_image')->id,
                        'name' => $recruitmentpublication->getFirstMedia('featured_image')->name,
                        'size' => $recruitmentpublication->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $recruitmentpublication->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $recruitmentpublication->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($recruitmentpublication){
                return collect($recruitmentpublication->getMedia('documents'))->map(function($item){
                    return [
                              'id' => $item->id,
                              'name' => $item->name,
                              'size' => $item->human_readable_size,
                              'type' => $item->mime_type
                        ];
                });
            },
        ]);
    }

    /**
     * Set the specified resource translation.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function settranslation(StoreRecruitmentPublicationRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $recruitmentpublication = RecruitmentPublication::findOrFail($id);

            $recruitmentpublication->category_id = $request->category_id;
            $recruitmentpublication->start_date = $request->start_date;
            $recruitmentpublication->end_date = $request->end_date;
            $recruitmentpublication->start_time = $request->start_time;
            $recruitmentpublication->end_time = $request->end_time;
            $recruitmentpublication->user_id = auth()->guard('website')->user()->id;

            $recruitmentpublication->setTranslation('title', strtolower($request->lang), $request->title);
            $recruitmentpublication->setTranslation('slug', strtolower($request->lang), Str::of($request->title)->slug('-')->__toString());
            $recruitmentpublication->setTranslation('description', strtolower($request->lang), $request->description);
            $recruitmentpublication->setTranslation('requirements', strtolower($request->lang), $request->requirements);

            $recruitmentpublication->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $recruitmentpublication
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $recruitmentpublication
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.recruitmentpublications.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = RecruitmentPublication::findOrFail(request()->model_id)->getMedia('attachments');

        return MediaStream::create('attachments.zip')->addMedia($attachments);
    }

    public function downloadsingleattachment()
    {
        return Media::findOrFail(request()->model_id);
    }

    public function deletesingleattachment()
    {
        $media = Media::findOrFail(request()->model_id);

        $media->delete();

        return Redirect::back();
        // return Media::findOrFail(request()->model_id);
    }
}