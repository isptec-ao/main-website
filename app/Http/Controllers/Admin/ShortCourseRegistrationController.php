<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreShortCourseRegistrationRequest;
use App\Models\Canvas\ShortCourseRegistration;
use App\Models\Canvas\ShortCourseClass;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ShortCourseRegistrationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ShortCourseRegistrations/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'shortcourseregistrations' => ShortCourseRegistration::with('class.course')->orderBy('full_name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ShortCourseRegistrations/Create',[
            'classes' => ShortCourseClass::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreShortCourseRegistrationRequest $request
     */
    public function store(StoreShortCourseRegistrationRequest $request)
    {

        DB::transaction(function () use ($request) {
            $shortcourseregistration = ShortCourseRegistration::create([
                'full_name' => $request->full_name,
                'description' => $request->description,
                'class_id' => $request->class_id,
                'dob' => $request->dob,
                'tel_no' => $request->tel_no,
                'email' => $request->email,
                'id_no' => $request->id_no,
                'institution' => $request->institution,
                'paid' => $request->paid,
                'registration_active' => $request->registration_active,
                'is_student' => $request->is_student
            ]);

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $shortcourseregistration
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.shortcourseregistrations.index')->with('success',[
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
        $shortcourseregistration = ShortCourseRegistration::find($id);

        return $shortcourseregistration ? response()->json($shortcourseregistration, 200) : response()->json(null, 404);
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
        $shortcourseregistration = ShortCourseRegistration::with('posts')->find($id);

        return $shortcourseregistration ? response()->json($shortcourseregistration->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $shortcourseregistration = ShortCourseRegistration::findOrFail($id);

        $shortcourseregistration->delete();

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
        $shortcourseclass = ShortCourseRegistration::withTrashed()->findOrFail($id);

        $shortcourseclass->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $shortcourseregistration = ShortCourseRegistration::with('class')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ShortCourseRegistrations/Lang', [
            'lang' => $request->lang,
            'classes' => ShortCourseClass::get(['id','name']),
            'shortcourseregistration' => [
                'id' => $shortcourseregistration->id,
                'full_name' => $shortcourseregistration->full_name,
                'description' => $shortcourseregistration->description,
                'class_id' => $shortcourseregistration->class_id,
                'class' => $shortcourseregistration->class,
                'dob' => $shortcourseregistration->dob,
                'tel_no' => $shortcourseregistration->tel_no,
                'email' => $shortcourseregistration->email,
                'id_no' => $shortcourseregistration->id_no,
                'institution' => $shortcourseregistration->institution,
                'paid' => $shortcourseregistration->paid,
                'registration_active' => $shortcourseregistration->registration_active,
                'is_student' => $shortcourseregistration->is_student,
            ],
            'documents' => function() use ($shortcourseregistration){
                return collect($shortcourseregistration->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreShortCourseRegistrationRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $shortcourseregistration = ShortCourseRegistration::findOrFail($id);

            $shortcourseregistration->full_name = $request->full_name;
            $shortcourseregistration->description = $request->description;
            $shortcourseregistration->class_id = $request->class_id;
            $shortcourseregistration->dob = $request->dob;
            $shortcourseregistration->tel_no = $request->tel_no;
            $shortcourseregistration->email = $request->email;
            $shortcourseregistration->id_no = $request->id_no;
            $shortcourseregistration->institution = $request->institution;
            $shortcourseregistration->paid = $request->paid;
            $shortcourseregistration->registration_active = $request->registration_active;
            $shortcourseregistration->is_student = $request->is_student;

            $shortcourseregistration->save();


            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $shortcourseregistration
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.shortcourseregistrations.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}