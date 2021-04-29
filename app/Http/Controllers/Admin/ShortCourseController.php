<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreShortCourseRequest;
use App\Models\Canvas\ShortCourse;
use App\Models\Canvas\Department;
use App\Models\Canvas\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ShortCourseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ShortCourses/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'shortcourses' => ShortCourse::with('department', 'employee')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ShortCourses/Create', [
            'departments' => Department::get(['id','name']),
            'employees' => Employee::get(['id','full_name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreShortCourseRequest $request
     */
    public function store(StoreShortCourseRequest $request)
    {

        DB::transaction(function () use ($request) {
            $shortcourse = ShortCourse::create([
                'name' => $request->name,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
                'description' => $request->description,
                'department_id' => $request->department_id,
                'employee_id' => $request->employee_id,
                'external_employee' => $request->external_employee,
            ]);
        });

        return Redirect::route('canvas.shortcourses.index')->with('success',[
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
        $shortcourse = ShortCourse::find($id);

        return $shortcourse ? response()->json($shortcourse, 200) : response()->json(null, 404);
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
        $shortcourse = ShortCourse::with('posts')->find($id);

        return $shortcourse ? response()->json($shortcourse->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $shortcourse = ShortCourse::findOrFail($id);

        $shortcourse->delete();

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
        $shortcourse = ShortCourse::withTrashed()->findOrFail($id);

        $shortcourse->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $shortcourse = ShortCourse::with('department', 'employee')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ShortCourses/Lang', [
            'lang' => $request->lang,
            'departments' => Department::get(['id','name']),
            'employees' => Employee::get(['id','full_name']),
            'shortcourse' => [
                'id' => $shortcourse->id,
                'name' => $shortcourse->name,
                'description' => $shortcourse->description,
                'department_id' => $shortcourse->department_id,
                'department' => $shortcourse->department,
                'employee_id' => $shortcourse->employee_id,
                'employee' => $shortcourse->employee,
                'external_employee' => $shortcourse->external_employee,
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
    public function settranslation(Request $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $shortcourse = ShortCourse::findOrFail($id);

            $shortcourse->external_employee = $request->external_employee;

            $shortcourse->setTranslation('name', strtolower($request->lang), $request->name);
            $shortcourse->setTranslation('description', strtolower($request->lang), $request->description);
            $shortcourse->setTranslation('slug', strtolower($request->lang), Str::of($request->title)->slug('-')->__toString());

            $shortcourse->save();
        });

        return Redirect::route('canvas.shortcourses.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}
