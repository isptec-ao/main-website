<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreAlumniRequest;
use App\Models\Canvas\Alumni;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\Course;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AlumniController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Alumnis/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'alumnis' => Alumni::with('course')->orderBy('student_full_name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Alumnis/Create', [
            'courses' => Course::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreAlumniRequest $request
     */
    public function store(StoreAlumniRequest $request)
    {

        DB::transaction(function () use ($request) {
            $alumni = Alumni::create([
                'course_id' => $request->course_id,
                'student_full_name' => $request->student_full_name,
                'summary' => $request->summary,
                'year' => $request->year,
                'slug' => Str::of($request->student_full_name)->slug('-')->__toString(),
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $alumni
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $alumni
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.alumnis.index')->with('success',[
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
        $alumni = Alumni::findOrFail($id);

        $alumni->delete();

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
        $alumni = Alumni::withTrashed()->findOrFail($id);

        $alumni->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $alumni = Alumni::with('course')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Alumnis/Lang', [
            'lang' => $request->lang,
            'courses' => Course::get(['id','name']),
            'alumni' => [
                'id' => $alumni->id,
                'student_full_name' => $alumni->student_full_name,
                'course_id' => $alumni->course_id,
                'course' => $alumni->course,
                'summary' => $alumni->summary,
                'year' => $alumni->year,
            ],
            'featured_image' => function() use ($alumni){
                if($alumni->getFirstMedia('featured_image')){
                    return [
                        'id' => $alumni->getFirstMedia('featured_image')->id,
                        'name' => $alumni->getFirstMedia('featured_image')->name,
                        'size' => $alumni->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $alumni->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $alumni->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($alumni){
                return collect($alumni->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreAlumniRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $alumni = Alumni::findOrFail($id);

            $alumni->course_id = $request->course_id;
            $alumni->student_full_name = $request->student_full_name;
            $alumni->year = $request->year;
            $alumni->slug = Str::of($request->student_full_name)->slug('-')->__toString();
            
            $alumni->setTranslation('summary', strtolower($request->lang), $request->summary);

            $alumni->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $alumni
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $alumni
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.alumnis.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Alumni::findOrFail(request()->model_id)->getMedia('attachments');

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