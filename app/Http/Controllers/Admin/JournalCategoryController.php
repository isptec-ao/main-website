<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreJournalCategoryRequest;
use App\Models\Canvas\JournalCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class JournalCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/JournalCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'journalcategories' => JournalCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/JournalCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreJournalCategoryRequest $request
     */
    public function store(StoreJournalCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $journalcategory = JournalCategory::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.journalcategories.index')->with('success',[
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
        $journalcategory = JournalCategory::find($id);

        return $journalcategory ? response()->json($journalcategory, 200) : response()->json(null, 404);
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
        $journalcategory = JournalCategory::with('posts')->find($id);

        return $journalcategory ? response()->json($journalcategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $journalcategory = JournalCategory::findOrFail($id);

        $journalcategory->delete();

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
        $journalcategory = JournalCategory::withTrashed()->findOrFail($id);

        $journalcategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $journalcategory = JournalCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/JournalCategories/Lang', [
            'lang' => $request->lang,
            'journalcategory' => [
                'id' => $journalcategory->id,
                'name' => $journalcategory->name,
                'description' => $journalcategory->description,
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
            $journalcategory = JournalCategory::findOrFail($id);

            $journalcategory->setTranslation('name', strtolower($request->lang), $request->name);
            $journalcategory->setTranslation('description', strtolower($request->lang), $request->description);

            $journalcategory->save();
        });

        return Redirect::route('canvas.journalcategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}