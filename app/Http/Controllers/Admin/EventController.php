<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreEventRequest;
use App\Models\Canvas\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media; 

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Events/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'events' => Event::orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Events/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreEventRequest $request
     */
    public function store(StoreEventRequest $request)
    {

        DB::transaction(function () use ($request) {
            $event = Event::create([
                'title' => $request->title,
                'slug' => Str::of($request->title)->slug('-')->__toString(),
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'venue' => $request->venue,
                'color' => $request->color,
                'user_id' => auth()->guard('website')->user()->id
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $event
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $event
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.events.index')->with('success',[
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
    public function showEvents(Request $request, $id): JsonResponse
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
        $event = Event::findOrFail($id);

        $event->delete();

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
        $event = Event::withTrashed()->findOrFail($id);

        $event->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $event = Event::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Events/Lang', [
            'lang' => $request->lang,
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'venue' => $event->venue,
                'description' => $event->description,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'color' => $event->color,
            ],
            'featured_image' => function() use ($event){
                if($event->getFirstMedia('featured_image')){
                    return [
                        'id' => $event->getFirstMedia('featured_image')->id,
                        'name' => $event->getFirstMedia('featured_image')->name,
                        'size' => $event->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $event->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $event->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($event){
                return collect($event->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreEventRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $event = Event::findOrFail($id);

            $event->color = $request->color;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->user_id = auth()->guard('website')->user()->id;

            $event->setTranslation('title', strtolower($request->lang), $request->title);
            $event->setTranslation('slug', strtolower($request->lang), Str::of($request->title)->slug('-')->__toString());
            $event->setTranslation('description', strtolower($request->lang), $request->description);
            $event->setTranslation('venue', strtolower($request->lang), $request->venue);

            $event->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $event
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $event
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.events.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Event::findOrFail(request()->model_id)->getMedia('attachments');

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