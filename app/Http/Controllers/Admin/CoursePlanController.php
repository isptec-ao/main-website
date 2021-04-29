<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreCoursePlanRequest;
use App\Models\Canvas\CoursePlan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\Course;
use App\Models\Canvas\Subject;
use App\Models\Canvas\Semester;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CoursePlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/CoursePlans/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'courseplans' => CoursePlan::with('course', 'subject', 'semester')->orderBy('created_at')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/CoursePlans/Create', [
            'courses' => Course::get(['id','name']),
            'subjects' => Subject::get(['id','name']),
            'semesters' => Semester::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreCoursePlanRequest $request
     */
    public function store(StoreCoursePlanRequest $request)
    {

        DB::transaction(function () use ($request) {
            $courseplan = CoursePlan::create([
                'course_id' => $request->course_id,
                'subject_id' => $request->subject_id,
                'semester_id' => $request->semester_id,
                'theoretical' => $request->theoretical,
                'practical' => $request->practical,
                'theoretical_practical' => $request->theoretical_practical,
                'weekly_hours' => $request->weekly_hours,
                'semester_hours' => $request->semester_hours,
            ]);

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $courseplan
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.courseplans.index')->with('success',[
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
        $courseplan = CoursePlan::findOrFail($id);

        $courseplan->delete();

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
        $courseplan = CoursePlan::withTrashed()->findOrFail($id);

        $courseplan->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $courseplan = CoursePlan::with('course', 'subject', 'semester')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/CoursePlans/Lang', [
            'lang' => $request->lang,
            'courses' => Course::get(['id','name']),
            'subjects' => Subject::get(['id','name']),
            'semesters' => Semester::get(['id','name']),
            'courseplan' => [
                'id' => $courseplan->id,
                'theoretical' => $courseplan->theoretical,
                'practical' => $courseplan->practical,
                'theoretical_practical' => $courseplan->theoretical_practical,
                'weekly_hours' => $courseplan->weekly_hours,
                'semester_hours' => $courseplan->semester_hours,
                'course_id' => $courseplan->course_id,
                'course' => $courseplan->course,
                'subject_id' => $courseplan->subject_id,
                'subject' => $courseplan->subject,
                'semester_id' => $courseplan->semester_id,
                'semester' => $courseplan->semester
            ],
            
            'documents' => function() use ($courseplan){
                return collect($courseplan->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreCoursePlanRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $courseplan = CoursePlan::findOrFail($id);

            $courseplan->course_id = $request->course_id;
            $courseplan->subject_id = $request->subject_id;
            $courseplan->semester_id = $request->semester_id;

            $courseplan->theoretical = $request->theoretical;
            $courseplan->practical = $request->practical;
            $courseplan->theoretical_practical = $request->theoretical_practical;
            $courseplan->semester_hours = $request->semester_hours;
            $courseplan->weekly_hours = $request->weekly_hours;


            $courseplan->save();

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $courseplan
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.courseplans.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = CoursePlan::findOrFail(request()->model_id)->getMedia('attachments');

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