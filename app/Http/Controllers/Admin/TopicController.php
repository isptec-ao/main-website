<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTopicRequest;
use App\Models\Canvas\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Topics/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'topics' => Topic::withCount('posts')
                // ->orderByName()
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Topics/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTopicRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function store(StoreTopicRequest $request)
    {
        DB::transaction(function () use ($request) {
            $topic = Topic::create([
                'name' => $request->name,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
                'user_id' => auth()->guard('website')->user()->id
            ]);
        });

        return Redirect::route('canvas.topics.index')->with('success',[
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
        $topic = Topic::find($id);

        return $topic ? response()->json($topic, 200) : response()->json(null, 404);
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
        $topic = Topic::with('posts')->find($id);

        return $topic ? response()->json($topic->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $topic = Topic::findOrFail($id);

        $topic->delete();

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
        $topic = Topic::withTrashed()->findOrFail($id);

        $topic->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $topic = Topic::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Topics/Lang', [
            'lang' => $request->lang,
            'topic' => [
                'id' => $topic->id,
                'name' => $topic->name,
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
            $topic = Topic::findOrFail($id);

            $topic->setTranslation('name', strtolower($request->lang), $request->name);
            $topic->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $topic->save();
        });

        return Redirect::route('canvas.topics.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}
