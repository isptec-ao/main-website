<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreClubMembershipRequest;
use App\Models\Canvas\ClubMembership;
use App\Models\Canvas\CelCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ClubMembershipController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ClubMemberships/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'clubmemberships' => ClubMembership::with('category')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ClubMemberships/Create',[
            'categories' => CelCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreClubMembershipRequest $request
     */
    public function store(StoreClubMembershipRequest $request)
    {

        DB::transaction(function () use ($request) {
            $clubmembership = ClubMembership::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'member_type' => $request->member_type,
                'email' => $request->email,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
                'category_id' => $request->category_id,
            ]);
        });

        return Redirect::route('canvas.clubmemberships.index')->with('success',[
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
        $clubmembership = ClubMembership::find($id);

        return $clubmembership ? response()->json($clubmembership, 200) : response()->json(null, 404);
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
        $clubmembership = ClubMembership::with('posts')->find($id);

        return $clubmembership ? response()->json($clubmembership->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $clubmembership = ClubMembership::findOrFail($id);

        $clubmembership->delete();

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
        $clubmembership = ClubMembership::withTrashed()->findOrFail($id);

        $clubmembership->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $clubmembership = ClubMembership::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ClubMemberships/Lang', [
            'lang' => $request->lang,
            'categories' => CelCategory::get(['id','name']),
            'clubmembership' => [
                'id' => $clubmembership->id,
                'name' => $clubmembership->name,
                'surname' => $clubmembership->surname,
                'member_type' => $clubmembership->member_type,
                'email' => $clubmembership->email,
                'category_id' => $clubmembership->category_id,
                'category' => $clubmembership->category,
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
    public function settranslation(StoreClubMembershipRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $clubmembership = ClubMembership::findOrFail($id);

            $clubmembership->name = $request->name;
            $clubmembership->surname = $request->surname;
            $clubmembership->member_type = $request->member_type;
            $clubmembership->email = $request->email;
            $clubmembership->category_id = $request->category_id;

            $clubmembership->save();
        });

        return Redirect::route('canvas.clubmemberships.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}