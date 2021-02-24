<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTagRequest;
use App\Models\Canvas\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function index(Request $request): JsonResponse
    // {
    //     return response()->json(
    //         Tag::latest()
    //            ->withCount('posts')
    //            ->paginate(), 200
    //     );
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Tags/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'tags' => Tag::withCount('posts')
                // ->orderByName()
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Tags/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreTagRequest $request
     */
    public function store(StoreTagRequest $request)
    {

        DB::transaction(function () use ($request) {
            $tag = Tag::create([
                'name' => $request->name,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
                'user_id' => auth()->guard('website')->user()->id
            ]);

            // $tag = Tag::create([

            // ]);
        });

        return Redirect::route('canvas.tags.index')->with('success',[
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
        $tag = Tag::find($id);

        return $tag ? response()->json($tag, 200) : response()->json(null, 404);
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
        $tag = Tag::with('posts')->find($id);

        return $tag ? response()->json($tag->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $tag = Tag::findOrFail($id);

        $tag->delete();

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
        $tag = Tag::withTrashed()->findOrFail($id);

        $tag->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $tag = Tag::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Tags/Lang', [
            'lang' => $request->lang,
            'tag' => [
                'id' => $tag->id,
                'name' => $tag->name,
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
            $tag = Tag::findOrFail($id);

            $tag->setTranslation('name', strtolower($request->lang), $request->name);
            $tag->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $tag->save();
        });

        return Redirect::route('canvas.tags.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}
