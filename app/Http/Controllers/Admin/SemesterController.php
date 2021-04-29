<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreSemesterRequest;
use App\Models\Canvas\Semester;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class SemesterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Semesters/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'semesters' => Semester::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Semesters/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreSemesterRequest $request
     */
    public function store(StoreSemesterRequest $request)
    {

        DB::transaction(function () use ($request) {
            $semester = Semester::create([
                'name' => $request->name,
                'year' => $request->year
            ]);
        });

        return Redirect::route('canvas.semesters.index')->with('success',[
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
        $semester = Semester::find($id);

        return $semester ? response()->json($semester, 200) : response()->json(null, 404);
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
        $semester = Semester::with('posts')->find($id);

        return $semester ? response()->json($semester->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $semester = Semester::findOrFail($id);

        $semester->delete();

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
        $semester = Semester::withTrashed()->findOrFail($id);

        $semester->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $semester = Semester::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Semesters/Lang', [
            'lang' => $request->lang,
            'semester' => [
                'id' => $semester->id,
                'name' => $semester->name,
                'year' => $semester->year,
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
            $semester = Semester::findOrFail($id);

            $semester->setTranslation('name', strtolower($request->lang), $request->name);
            $semester->setTranslation('year', strtolower($request->lang), $request->year);

            $semester->save();
        });

        return Redirect::route('canvas.semesters.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}
