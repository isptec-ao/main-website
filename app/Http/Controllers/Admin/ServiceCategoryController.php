<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreServiceCategoryRequest;
use App\Models\Canvas\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ServiceCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ServiceCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'servicecategories' => ServiceCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ServiceCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreServiceCategoryRequest $request
     */
    public function store(StoreServiceCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $servicecategory = ServiceCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'department_id' => $request->department_id
            ]);
        });

        return Redirect::route('canvas.servicecategories.index')->with('success',[
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
        $servicecategory = ServiceCategory::find($id);

        return $servicecategory ? response()->json($servicecategory, 200) : response()->json(null, 404);
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
        $servicecategory = ServiceCategory::with('posts')->find($id);

        return $servicecategory ? response()->json($servicecategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $servicecategory = ServiceCategory::findOrFail($id);

        $servicecategory->delete();

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
        $servicecategory = ServiceCategory::withTrashed()->findOrFail($id);

        $servicecategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $servicecategory = ServiceCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ServiceCategories/Lang', [
            'lang' => $request->lang,
            'academiccategory' => [
                'id' => $servicecategory->id,
                'name' => $servicecategory->name,
                'description' => $servicecategory->description,
                'department_id' => $servicecategory->department_id,
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
            $servicecategory = ServiceCategory::findOrFail($id);

            $servicecategory->department_id = $request->department_id;

            $servicecategory->setTranslation('name', strtolower($request->lang), $request->name);
            $servicecategory->setTranslation('description', strtolower($request->lang), $request->description);

            $servicecategory->save();
        });

        return Redirect::route('canvas.servicecategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}