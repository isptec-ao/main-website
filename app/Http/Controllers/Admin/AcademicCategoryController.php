<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreAcademicCategoryRequest;
use App\Models\Canvas\AcademicCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class AcademicCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/AcademicCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'academiccategories' => AcademicCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/AcademicCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreAcademicCategoryRequest $request
     */
    public function store(StoreAcademicCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $academicCategory = AcademicCategory::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.academiccategories.index')->with('success',[
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
        $academicCategory = AcademicCategory::find($id);

        return $academicCategory ? response()->json($academicCategory, 200) : response()->json(null, 404);
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
        $academicCategory = AcademicCategory::with('posts')->find($id);

        return $academicCategory ? response()->json($academicCategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $academicCategory = AcademicCategory::findOrFail($id);

        $academicCategory->delete();

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
        $academiccategory = AcademicCategory::withTrashed()->findOrFail($id);

        $academiccategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $academiccategory = AcademicCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/AcademicCategories/Lang', [
            'lang' => $request->lang,
            'academiccategory' => [
                'id' => $academiccategory->id,
                'name' => $academiccategory->name,
                'description' => $academiccategory->description,
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
            $academiccategory = AcademicCategory::findOrFail($id);

            $academiccategory->setTranslation('name', strtolower($request->lang), $request->name);
            $academiccategory->setTranslation('description', strtolower($request->lang), $request->description);

            $academiccategory->save();
        });

        return Redirect::route('canvas.academiccategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}