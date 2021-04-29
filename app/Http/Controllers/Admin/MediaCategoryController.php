<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreMediaCategoryRequest;
use App\Models\Canvas\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class MediaCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/MediaCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'mediacategories' => MediaCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/MediaCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreMediaCategoryRequest $request
     */
    public function store(StoreMediaCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $mediacategory = MediaCategory::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        });

        return Redirect::route('canvas.mediacategories.index')->with('success',[
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
        $mediacategory = MediaCategory::find($id);

        return $mediacategory ? response()->json($mediacategory, 200) : response()->json(null, 404);
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
        $mediacategory = MediaCategory::with('posts')->find($id);

        return $mediacategory ? response()->json($mediacategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $mediacategory = MediaCategory::findOrFail($id);

        $mediacategory->delete();

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
        $mediacategory = MediaCategory::withTrashed()->findOrFail($id);

        $mediacategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $mediacategory = MediaCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/MediaCategories/Lang', [
            'lang' => $request->lang,
            'mediacategory' => [
                'id' => $mediacategory->id,
                'name' => $mediacategory->name,
                'description' => $mediacategory->description,
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
    public function settranslation(StoreMediaCategoryRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $mediacategory = MediaCategory::findOrFail($id);

            $mediacategory->setTranslation('name', strtolower($request->lang), $request->name);
            $mediacategory->setTranslation('description', strtolower($request->lang), $request->description);

            $mediacategory->save();
        });

        return Redirect::route('canvas.mediacategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}