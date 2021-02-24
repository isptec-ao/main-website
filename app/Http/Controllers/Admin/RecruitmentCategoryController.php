<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreRecruitmentCategoryRequest;
use App\Models\Canvas\RecruitmentCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class RecruitmentCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/RecruitmentCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'recruitmentcategories' => RecruitmentCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/RecruitmentCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreRecruitmentCategoryRequest $request
     */
    public function store(StoreRecruitmentCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $recruitmentcategory = RecruitmentCategory::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.recruitmentcategories.index')->with('success',[
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
        $recruitmentcategory = RecruitmentCategory::find($id);

        return $recruitmentcategory ? response()->json($recruitmentcategory, 200) : response()->json(null, 404);
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
        $recruitmentcategory = RecruitmentCategory::with('posts')->find($id);

        return $recruitmentcategory ? response()->json($recruitmentcategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $recruitmentcategory = RecruitmentCategory::findOrFail($id);

        $recruitmentcategory->delete();

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
        $recruitmentcategory = RecruitmentCategory::withTrashed()->findOrFail($id);

        $recruitmentcategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $recruitmentcategory = RecruitmentCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/RecruitmentCategories/Lang', [
            'lang' => $request->lang,
            'recruitmentcategory' => [
                'id' => $recruitmentcategory->id,
                'name' => $recruitmentcategory->name,
                'description' => $recruitmentcategory->description,
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
            $recruitmentcategory = RecruitmentCategory::findOrFail($id);

            $recruitmentcategory->setTranslation('name', strtolower($request->lang), $request->name);
            $recruitmentcategory->setTranslation('description', strtolower($request->lang), $request->description);

            $recruitmentcategory->save();
        });

        return Redirect::route('canvas.recruitmentcategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}