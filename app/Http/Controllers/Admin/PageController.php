<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StorePageRequest;
use App\Models\Canvas\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Pages/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'pages' => Page::orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Pages/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StorePageRequest $request
     */
    public function store(StorePageRequest $request)
    {

        DB::transaction(function () use ($request) {
            $page = Page::create([
                'title' => $request->title,
                'code' => $request->code,
                'description' => $request->description
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $page
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $page
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.pages.index')->with('success',[
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
        $page = Page::find($id);

        return $page ? response()->json($page, 200) : response()->json(null, 404);
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
        $page = Page::with('posts')->find($id);

        return $page ? response()->json($page->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $page = Page::findOrFail($id);

        $page->delete();

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
        $page = Page::withTrashed()->findOrFail($id);

        $page->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $page = Page::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Pages/Lang', [
            'lang' => $request->lang,
            'page' => [
                'id' => $page->id,
                'title' => $page->title,
                'code' => $page->code,
                'description' => $page->description,
            ],
            'featured_image' => function() use ($page){
                if($page->getFirstMedia('featured_image')){
                    return [
                        'id' => $page->getFirstMedia('featured_image')->id,
                        'name' => $page->getFirstMedia('featured_image')->name,
                        'size' => $page->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $page->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $page->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($page){
                return collect($page->getMedia('documents'))->map(function($item){
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
    public function settranslation(Request $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $page = Page::findOrFail($id);

            $page->code = $request->code;

            $page->setTranslation('title', strtolower($request->lang), $request->title);
            $page->setTranslation('description', strtolower($request->lang), $request->description);

            $page->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $page
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $page
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.pages.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Page::findOrFail(request()->model_id)->getMedia('attachments');

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