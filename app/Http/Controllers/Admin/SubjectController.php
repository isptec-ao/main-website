<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreSubjectRequest;
use App\Models\Canvas\Subject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class SubjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Subjects/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'subjects' => Subject::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Subjects/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreSubjectRequest $request
     */
    public function store(StoreSubjectRequest $request)
    {

        DB::transaction(function () use ($request) {
            $subject = Subject::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.subjects.index')->with('success',[
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
        $subject = Subject::find($id);

        return $subject ? response()->json($subject, 200) : response()->json(null, 404);
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
        $subject = Subject::with('posts')->find($id);

        return $subject ? response()->json($subject->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $subject = Subject::findOrFail($id);

        $subject->delete();

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
        $subject = Subject::withTrashed()->findOrFail($id);

        $subject->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $subject = Subject::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Subjects/Lang', [
            'lang' => $request->lang,
            'subject' => [
                'id' => $subject->id,
                'name' => $subject->name,
                'description' => $subject->description,
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
            $subject = Subject::findOrFail($id);

            $subject->setTranslation('name', strtolower($request->lang), $request->name);
            $subject->setTranslation('description', strtolower($request->lang), $request->description);

            $subject->save();
        });

        return Redirect::route('canvas.subjects.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}
