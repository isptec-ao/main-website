<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreClubSessionRequest;
use App\Models\Canvas\ClubSession;
use App\Models\Canvas\CelCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ClubSessionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ClubSessions/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'clubsessions' => ClubSession::with('category')->orderBy('topic')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ClubSessions/Create',[
            'categories' => CelCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreClubSessionRequest $request
     */
    public function store(StoreClubSessionRequest $request)
    {

        DB::transaction(function () use ($request) {
            $clubsession = ClubSession::create([
                'topic' => $request->topic,
                'venue' => $request->venue,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
                'slug' => Str::of($request->topic)->slug('-')->__toString(),
                'category_id' => $request->category_id,
            ]);
        });

        return Redirect::route('canvas.clubsessions.index')->with('success',[
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
        $clubsession = ClubSession::find($id);

        return $clubsession ? response()->json($clubsession, 200) : response()->json(null, 404);
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
        $clubsession = ClubSession::with('posts')->find($id);

        return $clubsession ? response()->json($clubsession->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $clubsession = ClubSession::findOrFail($id);

        $clubsession->delete();

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
        $clubsession = ClubSession::withTrashed()->findOrFail($id);

        $clubsession->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $clubsession = ClubSession::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ClubSessions/Lang', [
            'lang' => $request->lang,
            'categories' => CelCategory::get(['id','name']),
            'clubsession' => [
                'id' => $clubsession->id,
                'topic' => $clubsession->topic,
                'description' => $clubsession->description,
                'venue' => $clubsession->venue,
                'start_time' => $clubsession->start_time,
                'end_time' => $clubsession->end_time,
                'date' => $clubsession->date,
                'category_id' => $clubsession->category_id,
                'category' => $clubsession->category,
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
    public function settranslation(StoreClubSessionRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $clubsession = ClubSession::findOrFail($id);

            $clubsession->venue = $request->venue;
            $clubsession->date = $request->date;
            $clubsession->start_time = $request->start_time;
            $clubsession->end_time = $request->end_time;
            $clubsession->category_id = $request->category_id;

            $clubsession->setTranslation('topic', strtolower($request->lang), $request->topic);
            $clubsession->setTranslation('description', strtolower($request->lang), $request->description);
            $clubsession->setTranslation('slug', strtolower($request->lang), Str::of($request->topic)->slug('-')->__toString());

            $clubsession->save();
        });

        return Redirect::route('canvas.clubsessions.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}