<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StorePartnershipRequest;
use App\Models\Canvas\Partnership;
use App\Models\Canvas\PartnerCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PartnershipController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Partnerships/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'partnerships' => Partnership::with('category')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Partnerships/Create',[
            'categories' => PartnerCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StorePartnershipRequest $request
     */
    public function store(StorePartnershipRequest $request)
    {

        DB::transaction(function () use ($request) {
            $partnership = Partnership::create([
                'name' => $request->name,
                'description' => $request->description,
                'link' => $request->link ?? '',
                'category_id' => $request->category_id,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $partnership
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $partnership
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.partnerships.index')->with('success',[
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
        $partnership = Partnership::find($id);

        return $partnership ? response()->json($partnership, 200) : response()->json(null, 404);
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
        $partnership = Partnership::with('posts')->find($id);

        return $partnership ? response()->json($partnership->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $partnership = Partnership::findOrFail($id);

        $partnership->delete();

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
        $partnership = Partnership::withTrashed()->findOrFail($id);

        $partnership->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $partnership = Partnership::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Partnerships/Lang', [
            'lang' => $request->lang,
            'categories' => PartnerCategory::get(['id','name']),
            'partnership' => [
                'id' => $partnership->id,
                'name' => $partnership->name,
                'description' => $partnership->description,
                'link' => $partnership->link,
                'category_id' => $partnership->category_id,
                'category' => $partnership->category,
            ],
            'featured_image' => function() use ($partnership){
                if($partnership->getFirstMedia('featured_image')){
                    return [
                        'id' => $partnership->getFirstMedia('featured_image')->id,
                        'name' => $partnership->getFirstMedia('featured_image')->name,
                        'size' => $partnership->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $partnership->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $partnership->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($partnership){
                return collect($partnership->getMedia('documents'))->map(function($item){
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
    public function settranslation(StorePartnershipRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $partnership = Partnership::findOrFail($id);

            $partnership->link = $request->link ?? '';
            $partnership->category_id = $request->category_id;

            $partnership->setTranslation('name', strtolower($request->lang), $request->name);
            $partnership->setTranslation('description', strtolower($request->lang), $request->description);
            $partnership->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $partnership->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $partnership
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $partnership
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.partnerships.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Partnership::findOrFail(request()->model_id)->getMedia('attachments');

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