<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreCourseCategoryRequest;
use App\Models\Canvas\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class CourseCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/CourseCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'coursecategories' => CourseCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/CourseCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreCourseCategoryRequest $request
     */
    public function store(StoreCourseCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $coursecategory = CourseCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => auth()->guard('website')->user()->id,
            ]);
        });

        return Redirect::route('canvas.coursecategories.index')->with('success',[
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
        $coursecategory = CourseCategory::find($id);

        return $coursecategory ? response()->json($coursecategory, 200) : response()->json(null, 404);
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
        $coursecategory = CourseCategory::with('posts')->find($id);

        return $coursecategory ? response()->json($coursecategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $coursecategory = CourseCategory::findOrFail($id);

        $coursecategory->delete();

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
        $coursecategory = CourseCategory::withTrashed()->findOrFail($id);

        $coursecategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $coursecategory = CourseCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/CourseCategories/Lang', [
            'lang' => $request->lang,
            'coursecategory' => [
                'id' => $coursecategory->id,
                'name' => $coursecategory->name,
                'description' => $coursecategory->description,
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
    public function settranslation(StoreCourseCategoryRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $coursecategory = CourseCategory::findOrFail($id);

            $coursecategory->setTranslation('name', strtolower($request->lang), $request->name);
            $coursecategory->setTranslation('description', strtolower($request->lang), $request->description);

            $coursecategory->save();
        });

        return Redirect::route('canvas.coursecategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}