<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreContentSubmissionRequest;
use App\Models\Canvas\ContentSubmission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\Course;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContentSubmissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ContentSubmissions/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'contentsubmissions' => ContentSubmission::orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ContentSubmissions/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreContentSubmissionRequest $request
     */
    public function store(StoreContentSubmissionRequest $request)
    {

        DB::transaction(function () use ($request) {
            $contentsubmission = ContentSubmission::create([
                'title' => $request->title,
                'category' => $request->category,
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'description_pt' => $request->description_pt,
                'description_en' => $request->description_en,
                'obs' => $request->obs,
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $contentsubmission
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $contentsubmission
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.contentsubmissions.index')->with('success',[
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
        $contentsubmission = ContentSubmission::findOrFail($id);

        $contentsubmission->delete();

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
        $contentsubmission = ContentSubmission::withTrashed()->findOrFail($id);

        $contentsubmission->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $contentsubmission = ContentSubmission::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ContentSubmissions/Lang', [
            'lang' => $request->lang,
            'courses' => Course::get(['id','name']),
            'contentsubmission' => [
                'id' => $contentsubmission->id,
                'title' => $contentsubmission->title,
                'category' => $contentsubmission->category,
                'name' => $contentsubmission->name,
                'email' => $contentsubmission->email,
                'contact' => $contentsubmission->contact,
                'description_pt' => $contentsubmission->description_pt,
                'description_en' => $contentsubmission->description_en,
                'obs' => $contentsubmission->obs,
            ],
            'featured_image' => function() use ($contentsubmission){
                if($contentsubmission->getFirstMedia('featured_image')){
                    return [
                        'id' => $contentsubmission->getFirstMedia('featured_image')->id,
                        'name' => $contentsubmission->getFirstMedia('featured_image')->name,
                        'size' => $contentsubmission->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $contentsubmission->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $contentsubmission->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($contentsubmission){
                return collect($contentsubmission->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreContentSubmissionRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $contentsubmission = ContentSubmission::findOrFail($id);

            $contentsubmission->title = $request->title;
            $contentsubmission->category = $request->category;
            $contentsubmission->name = $request->name;
            $contentsubmission->email = $request->email;
            $contentsubmission->contact = $request->contact;
            $contentsubmission->description_pt = $request->description_pt;
            $contentsubmission->description_en = $request->description_en;

            $contentsubmission->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $contentsubmission
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $contentsubmission
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.contentsubmissions.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = ContentSubmission::findOrFail(request()->model_id)->getMedia('attachments');

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