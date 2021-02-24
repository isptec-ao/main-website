<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreSectionRequest;
use App\Models\Canvas\Section;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class SectionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Sections/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'pages' => Section::orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Sections/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreSectionRequest $request
     */
    public function store(StoreSectionRequest $request)
    {

        DB::transaction(function () use ($request) {
            $section = Section::create([
                'page_id' => $request->page_id,
                'title' => $request->title,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.sections.index')->with('success',[
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
        $section = Section::find($id);

        return $section ? response()->json($section, 200) : response()->json(null, 404);
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
        $section = Section::with('posts')->find($id);

        return $section ? response()->json($section->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $section = Section::findOrFail($id);

        $section->delete();

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
        $section = Section::withTrashed()->findOrFail($id);

        $section->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $section = Section::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Sections/Lang', [
            'lang' => $request->lang,
            'page' => [
                'id' => $section->id,
                'title' => $section->title,
                'page_id' => $section->page_id,
                'description' => $section->description,
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
            $section = Section::findOrFail($id);

            $section->page_id = $request->page_id;

            $section->setTranslation('title', strtolower($request->lang), $request->title);
            $section->setTranslation('description', strtolower($request->lang), $request->description);

            $section->save();
        });

        return Redirect::route('canvas.sections.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}