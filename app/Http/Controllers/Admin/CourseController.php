<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreCourseRequest;
use App\Models\Canvas\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\CourseCategory;
use App\Models\Canvas\Department;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Courses/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'courses' => Course::with('category', 'department')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Courses/Create', [
            'categories' => CourseCategory::get(['id','name']),
            'departments' => Department::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreCourseRequest $request
     */
    public function store(StoreCourseRequest $request)
    {

        DB::transaction(function () use ($request) {
            $course = Course::create([
                'category_id' => $request->category_id,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'duration' => $request->duration,
                'start_date' => $request->start_date
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $course
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $course
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.courses.index')->with('success',[
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
        $course = Course::findOrFail($id);

        $course->delete();

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
        $course = Course::withTrashed()->findOrFail($id);

        $course->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $course = Course::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Courses/Lang', [
            'lang' => $request->lang,
            'categories' => CourseCategory::get(['id','name']),
            'departments' => Department::get(['id','name']),
            'course' => [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'duration' => $course->duration,
                'category_id' => $course->category_id,
                'category' => $course->category,
                'department_id' => $course->department_id,
                'department' => $course->department,
                'start_date' => $course->start_date
            ],
            'featured_image' => function() use ($course){
                if($course->getFirstMedia('featured_image')){
                    return [
                        'id' => $course->getFirstMedia('featured_image')->id,
                        'name' => $course->getFirstMedia('featured_image')->name,
                        'size' => $course->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $course->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $course->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($course){
                return collect($course->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreCourseRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $course = Course::findOrFail($id);

            $course->category_id = $request->category_id;
            $course->department_id = $request->department_id;
            $course->start_date = $request->start_date;

            $course->setTranslation('name', strtolower($request->lang), $request->name);
            $course->setTranslation('description', strtolower($request->lang), $request->description);
            $course->setTranslation('duration', strtolower($request->lang), $request->duration);

            $course->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $course
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $course
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.courses.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Course::findOrFail(request()->model_id)->getMedia('attachments');

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