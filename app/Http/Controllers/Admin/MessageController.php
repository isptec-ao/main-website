<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreMessageRequest;
use App\Models\Canvas\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MessageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Messages/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'messages' => Message::orderBy('description')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Messages/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreMessageRequest $request
     */
    public function store(StoreMessageRequest $request)
    {

        DB::transaction(function () use ($request) {
            $message = Message::create([
                'description' => $request->description,
                'gender' => $request->gender,
            ]);

            // Assign Banner
            if(isset($request->banner)){
                
                // Add to banner media collection
                $message->addMediaFromRequest('banner')
                    ->usingName('banner')
                    ->toMediaCollection('banner');
            }
        });

        return Redirect::route('canvas.messages.index')->with('success',[
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
        $message = Message::findOrFail($id);

        $message->delete();

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
        $message = Message::withTrashed()->findOrFail($id);

        $message->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $message = Message::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Messages/Lang', [
            'lang' => $request->lang,
            'message' => [
                'id' => $message->id,
                'description' => $message->description,
                'gender' => $message->gender,
                'banner_link' => $message->getFirstMediaUrl('banner') ?? null,
            ],
        ]);
    }

    /**
     * Set the specified resource translation.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function settranslation(StoreMessageRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $message = Message::findOrFail($id);

            $message->description = $request->description;
            $message->gender = $request->gender;

            $message->save();

            // Assign Banner
            if(isset($request->banner)){
                
                // Add to banner media collection
                $message->addMediaFromRequest('banner')
                    ->usingName('banner')
                    ->toMediaCollection('banner');
            }
        });

        return Redirect::route('canvas.messages.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Message::findOrFail(request()->model_id)->getMedia('attachments');

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