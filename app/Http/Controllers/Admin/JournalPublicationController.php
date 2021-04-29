<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreJournalPublicationRequest;
use App\Models\Canvas\JournalPublication;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\JournalCategory;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JournalPublicationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/JournalPublications/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'journalpublications' => JournalPublication::with('category')->orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/JournalPublications/Create', [
            'categories' => JournalCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreJournalPublicationRequest $request
     */
    public function store(StoreJournalPublicationRequest $request)
    {

        DB::transaction(function () use ($request) {
            $journalpublication = JournalPublication::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::of($request->title)->slug('-')->__toString(),
                'summary' => $request->summary,
                'extra_data' => $request->extra_data,
                'published_at' => $request->published_at,
                'external_url' => $request->external_url,
                'journal_name' => $request->journal_name,
                'authors' => $request->authors,
                'lecturers' => $request->lecturers,
                'reference' => $request->reference,
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $journalpublication
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $journalpublication
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.journalpublications.index')->with('success',[
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
        $journalpublication = JournalPublication::findOrFail($id);

        $journalpublication->delete();

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
        $journalpublication = JournalPublication::withTrashed()->findOrFail($id);

        $journalpublication->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $journalpublication = JournalPublication::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/JournalPublications/Lang', [
            'lang' => $request->lang,
            'categories' => JournalCategory::get(['id','name']),
            'journalpublication' => [
                'id' => $journalpublication->id,
                'title' => $journalpublication->title,
                'summary' => $journalpublication->summary,
                'extra_data' => $journalpublication->extra_data,
                'published_at' => $journalpublication->published_at,
                'external_url' => $journalpublication->external_url,
                'journal_name' => $journalpublication->journal_name,
                'authors' => $journalpublication->authors,
                'lecturers' => $journalpublication->lecturers,
                'category_id' => $journalpublication->category_id,
                'category' => $journalpublication->category,
                'reference' => $journalpublication->reference,
            ],
            'featured_image' => function() use ($journalpublication){
                if($journalpublication->getFirstMedia('featured_image')){
                    return [
                        'id' => $journalpublication->getFirstMedia('featured_image')->id,
                        'name' => $journalpublication->getFirstMedia('featured_image')->name,
                        'size' => $journalpublication->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $journalpublication->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $journalpublication->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($journalpublication){
                return collect($journalpublication->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreJournalPublicationRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $journalpublication = JournalPublication::findOrFail($id);

            $journalpublication->category_id = $request->category_id;
            $journalpublication->published_at = $request->published_at;
            $journalpublication->external_url = $request->external_url;
            $journalpublication->authors = $request->authors;
            $journalpublication->lecturers = $request->lecturers;
            $journalpublication->reference = $request->reference;

            $journalpublication->setTranslation('title', strtolower($request->lang), $request->title);
            $journalpublication->setTranslation('slug', strtolower($request->lang), Str::of($request->title)->slug('-')->__toString());
            $journalpublication->setTranslation('summary', strtolower($request->lang), $request->summary);
            $journalpublication->setTranslation('extra_data', strtolower($request->lang), $request->extra_data);
            $journalpublication->setTranslation('journal_name', strtolower($request->lang), $request->journal_name);

            $journalpublication->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $journalpublication
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $journalpublication
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.journalpublications.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = JournalPublication::findOrFail(request()->model_id)->getMedia('attachments');

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