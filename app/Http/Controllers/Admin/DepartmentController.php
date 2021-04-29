<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Canvas\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Departments/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'departments' => Department::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Departments/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreDepartmentRequest $request
     */
    public function store(StoreDepartmentRequest $request)
    {

        DB::transaction(function () use ($request) {
            $department = Department::create([
                'name' => $request->name,
                'code' => $request->code,
                'email' => $request->email,
                'tel_no' => $request->tel_no,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.departments.index')->with('success',[
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
        $department = Department::find($id);

        return $department ? response()->json($department, 200) : response()->json(null, 404);
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
        $department = Department::with('posts')->find($id);

        return $department ? response()->json($department->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $department = Department::findOrFail($id);

        $department->delete();

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
        $department = Department::withTrashed()->findOrFail($id);

        $department->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $department = Department::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Departments/Lang', [
            'lang' => $request->lang,
            'department' => [
                'id' => $department->id,
                'name' => $department->name,
                'code' => $department->code,
                'email' => $department->email,
                'tel_no' => $department->tel_no,
                'description' => $department->description,
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
            $department = Department::findOrFail($id);

            $department->email = $request->email;
            $department->tel_no = $request->tel_no;
            $department->setTranslation('name', strtolower($request->lang), $request->name);
            $department->setTranslation('code', strtolower($request->lang), $request->code);
            $department->setTranslation('description', strtolower($request->lang), $request->description);

            $department->save();
        });

        return Redirect::route('canvas.departments.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}
