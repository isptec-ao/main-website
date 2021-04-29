<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StorePartnerCategoryRequest;
use App\Models\Canvas\PartnerCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class PartnerCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/PartnerCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'partnercategories' => PartnerCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/PartnerCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StorePartnerCategoryRequest $request
     */
    public function store(StorePartnerCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $partnerCategory = PartnerCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
            ]);
        });

        return Redirect::route('canvas.partnercategories.index')->with('success',[
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
        $partnerCategory = PartnerCategory::find($id);

        return $partnerCategory ? response()->json($partnerCategory, 200) : response()->json(null, 404);
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
        $partnerCategory = PartnerCategory::with('posts')->find($id);

        return $partnerCategory ? response()->json($partnerCategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $partnerCategory = PartnerCategory::findOrFail($id);

        $partnerCategory->delete();

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
        $partnercategory = PartnerCategory::withTrashed()->findOrFail($id);

        $partnercategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $partnercategory = PartnerCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/PartnerCategories/Lang', [
            'lang' => $request->lang,
            'partnercategory' => [
                'id' => $partnercategory->id,
                'name' => $partnercategory->name,
                'description' => $partnercategory->description
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
    public function settranslation(StorePartnerCategoryRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $partnercategory = PartnerCategory::findOrFail($id);

            $partnercategory->setTranslation('name', strtolower($request->lang), $request->name);
            $partnercategory->setTranslation('description', strtolower($request->lang), $request->description);
            $partnercategory->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $partnercategory->save();
        });

        return Redirect::route('canvas.partnercategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}