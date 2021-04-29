<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreFileCategoryRequest;
use App\Models\Canvas\FileCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class FileCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/FileCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'filecategories' => FileCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/FileCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreFileCategoryRequest $request
     */
    public function store(StoreFileCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $fileCategory = FileCategory::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.filecategories.index')->with('success',[
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
        $fileCategory = FileCategory::find($id);

        return $fileCategory ? response()->json($fileCategory, 200) : response()->json(null, 404);
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
        $fileCategory = FileCategory::with('posts')->find($id);

        return $fileCategory ? response()->json($fileCategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $fileCategory = FileCategory::findOrFail($id);

        $fileCategory->delete();

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
        $filecategory = FileCategory::withTrashed()->findOrFail($id);

        $filecategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $filecategory = FileCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/FileCategories/Lang', [
            'lang' => $request->lang,
            'filecategory' => [
                'id' => $filecategory->id,
                'name' => $filecategory->name,
                'description' => $filecategory->description,
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
            $filecategory = FileCategory::findOrFail($id);

            $filecategory->setTranslation('name', strtolower($request->lang), $request->name);
            $filecategory->setTranslation('description', strtolower($request->lang), $request->description);

            $filecategory->save();
        });

        return Redirect::route('canvas.filecategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}