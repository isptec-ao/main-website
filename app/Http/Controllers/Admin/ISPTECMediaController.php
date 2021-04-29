<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreISPTECMediaRequest;
use App\Models\Canvas\ISPTECMedia;
use App\Models\Canvas\MediaCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ISPTECMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ISPTECMedia/Index', [
            'filters' => $request->all('search', 'trashed', 'range', 'type', 'published', 'scope', 'user'),
            'posts' => ISPTECMedia::filter($request->only('search', 'trashed'))
                ->latest()
                ->paginate(5),
            'draftCount' => ISPTECMedia::draft()->count(),
            'publishedCount' => ISPTECMedia::published()->count(),    
                // ->only('id', 'name')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllNews(Request $request)
    {   
        return ISPTECMedia::withCount('views')
        ->filter($request->only('search', 'trashed'))
        ->latest()
        ->paginate(5);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function index(Request $request): JsonResponse
    // {
    //     $type = $request->query('type', 'published');
    //     $scope = $request->query('scope', 'user');
    //     $hasPermission = $request->user('website')->isAdmin || $request->user('website')->isEditor;

    //     $posts = ISPTECMedia::when($scope, function ($query, $scope) use ($request, $hasPermission) {
    //         if ($scope === 'all' && $hasPermission) {
    //             return $query;
    //         }

    //         return $query->where('user_id', $request->user('website')->id);
    //     })->when($type, function ($query, $type) {
    //         if ($type === 'draft') {
    //             return $query->draft();
    //         }

    //         return $query->published();
    //     })->latest()->withCount('views')->paginate();

    //     if ($scope === 'all' && $hasPermission) {
    //         $draftCount = ISPTECMedia::draft()->count();
    //         $publishedCount = ISPTECMedia::published()->count();
    //     } else {
    //         $draftCount = ISPTECMedia::where('user_id', $request->user('website')->id)->draft()->count();
    //         $publishedCount = ISPTECMedia::where('user_id', $request->user('website')->id)->published()->count();
    //     }

    //     return response()->json([
    //         'posts' => $posts,
    //         'draftCount' => $draftCount,
    //         'publishedCount' => $publishedCount,
    //     ], 200);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function create(Request $request): JsonResponse
    // {
    //     $uuid = Uuid::uuid4();

    //     return response()->json([
    //         'post' => ISPTECMedia::make([
    //             'id' => $uuid->toString(),
    //             'slug' => "post-{$uuid->toString()}",
    //         ]),
    //         'tags' => Tag::get(['name', 'slug']),
    //         'topics' => Topic::get(['name', 'slug']),
    //     ]);
    // }

    public function create()
    {
        return Inertia::render('Website/ISPTECMedia/Create', [
            'categories' => MediaCategory::get(['id','name', 'slug']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreISPTECMediaRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function store(StoreISPTECMediaRequest $request)
    {
        DB::transaction(function () use ($request) {
            $post = ISPTECMedia::create([
                'title' => $request->title,
                'summary' => $request->summary,
                'body' => $request->body,
                'published_at' => $request->published_at,
                'featured_image_caption' => $request->featured_image_caption,
                'slug' => Str::of($request->title)->slug('-')->__toString(),
                'user_id' => auth()->guard('website')->user()->id
            ]);

            $post->categories()->sync($request->categories ?? []);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $post
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Featured Images
            if(isset($request->featured_images)){

                $fileAdders = $post
                    ->addMultipleMediaFromRequest(['featured_images'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_images');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $post
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.isptecmedia.index')->with('success',[
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
        $hasPermission = $request->user('website')->isAdmin || $request->user('website')->isEditor;

        if ($hasPermission) {
            $post = ISPTECMedia::with('tags:name,slug', 'topic:name,slug')->find($id);
        } else {
            $post = ISPTECMedia::where('user_id', $request->user('website')->id)->with('tags:name,slug', 'topic:name,slug')->find($id);
        }

        if ($post) {
            return response()->json([
                'post' => $post,
                'tags' => Tag::get(['name', 'slug']),
                'topics' => Topic::get(['name', 'slug']),
            ]);
        } else {
            return response()->json(null, 404);
        }
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
        $post = ISPTECMedia::findOrFail($id);

        $post->delete();

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
        $post = ISPTECMedia::withTrashed()->findOrFail($id);

        $post->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $post = ISPTECMedia::with('categories')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ISPTECMedia/Lang', [
            'lang' => $request->lang,
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'summary' => $post->summary,
                'body' => $post->body,
                'published_at' => $post->published_at->toDateTimeString(),
                'featured_image_caption' => $post->featured_image_caption,
                'categories' => function() use ($post) {
                    return collect($post->categories)->map(function($item){
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'slug' => $item->slug
                        ];
                    });
                }
            ],
            'featured_image' => function() use ($post){
                if($post->getFirstMedia('featured_image')){
                    return [
                        'id' => $post->getFirstMedia('featured_image')->id,
                        'name' => $post->getFirstMedia('featured_image')->name,
                        'size' => $post->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $post->getFirstMedia('featured_image')->mime_type
                    ];
                }
                return null;
            },
            'featured_images' => function() use ($post){
                return collect($post->getMedia('featured_images'))->map(function($item){
                    return [
                              'id' => $item->id,
                              'name' => $item->name,
                              'size' => $item->human_readable_size,
                              'type' => $item->mime_type
                        ];
                });
            },
            'documents' => function() use ($post){
                return collect($post->getMedia('documents'))->map(function($item){
                    return [
                              'id' => $item->id,
                              'name' => $item->name,
                              'size' => $item->human_readable_size,
                              'type' => $item->mime_type
                        ];
                });
            },
            'categories' => MediaCategory::get(['id','name', 'slug']),
        ]);
    }

    /**
     * Set the specified resource translation.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function settranslation(StoreISPTECMediaRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $post = ISPTECMedia::findOrFail($id);

            $post->setTranslation('title', strtolower($request->lang), $request->title);
            $post->setTranslation('slug', strtolower($request->lang), Str::of($request->title)->slug('-')->__toString());
            $post->setTranslation('body', strtolower($request->lang), $request->body);
            $post->setTranslation('summary', strtolower($request->lang), $request->summary);
            $post->published_at = $request->published_at;
            $post->setTranslation('featured_image_caption', strtolower($request->lang), $request->featured_image_caption);

            $post->save();

            $post->categories()->sync($request->categories ?? []);


            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $post
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Featured Images
            if(isset($request->featured_images)){

                $fileAdders = $post
                    ->addMultipleMediaFromRequest(['featured_images'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_images');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $post
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.isptecmedia.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = ISPTECMedia::findOrFail(request()->model_id)->getMedia('attachments');

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
