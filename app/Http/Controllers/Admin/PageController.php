<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StorePageRequest;
use App\Models\Canvas\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Pages/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'pages' => Page::orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Pages/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StorePageRequest $request
     */
    public function store(StorePageRequest $request)
    {

        DB::transaction(function () use ($request) {
            $page = Page::create([
                'title' => $request->title,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.pages.index')->with('success',[
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
        $page = Page::find($id);

        return $page ? response()->json($page, 200) : response()->json(null, 404);
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
        $page = Page::with('posts')->find($id);

        return $page ? response()->json($page->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $page = Page::findOrFail($id);

        $page->delete();

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
        $page = Page::withTrashed()->findOrFail($id);

        $page->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $page = Page::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Pages/Lang', [
            'lang' => $request->lang,
            'page' => [
                'id' => $page->id,
                'title' => $page->title,
                'description' => $page->description,
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
            $page = Page::findOrFail($id);

            $page->setTranslation('title', strtolower($request->lang), $request->title);
            $page->setTranslation('description', strtolower($request->lang), $request->description);

            $page->save();
        });

        return Redirect::route('canvas.pages.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}