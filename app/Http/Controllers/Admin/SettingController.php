<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreSettingRequest;
use App\Models\Canvas\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Settings/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'settings' => Setting::orderBy('option')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Settings/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreSettingRequest $request
     */
    public function store(StoreSettingRequest $request)
    {

        DB::transaction(function () use ($request) {
            $setting = Setting::create([
                'option' => $request->option,
                'value' => $request->value,
                'user_id' => auth()->guard('website')->user()->id
            ]);

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $setting
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.settings.index')->with('success',[
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
        $setting = Setting::findOrFail($id);

        $setting->delete();

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
        $setting = Setting::withTrashed()->findOrFail($id);

        $setting->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $setting = Setting::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Settings/Lang', [
            'lang' => $request->lang,
            'setting' => [
                'id' => $setting->id,
                'option' => $setting->option,
                'value' => $setting->value,
            ],
            'documents' => function() use ($setting){
                return collect($setting->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreSettingRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $setting = Setting::findOrFail($id);

            $setting->user_id = auth()->guard('website')->user()->id;

            $setting->setTranslation('option', strtolower($request->lang), $request->option);
            $setting->setTranslation('value', strtolower($request->lang), $request->value);

            $setting->save();

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $setting
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.settings.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Setting::findOrFail(request()->model_id)->getMedia('attachments');

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