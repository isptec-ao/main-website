<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreServiceRequest;
use App\Models\Canvas\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\ServiceCategory;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Services/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'services' => Service::with('category')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Services/Create', [
            'categories' => ServiceCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreServiceRequest $request
     */
    public function store(StoreServiceRequest $request)
    {

        DB::transaction(function () use ($request) {
            $service = Service::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'description' => $request->description
            ]);
        });

        return Redirect::route('canvas.services.index')->with('success',[
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
        $service = Service::find($id);

        return $service ? response()->json($service, 200) : response()->json(null, 404);
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
        $service = Service::with('posts')->find($id);

        return $service ? response()->json($service->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $service = Service::findOrFail($id);

        $service->delete();

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
        $service = Service::withTrashed()->findOrFail($id);

        $service->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $service = Service::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Services/Lang', [
            'lang' => $request->lang,
            'categories' => ServiceCategory::get(['id','name']),
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'contact' => $service->contact,
                'email' => $service->email,
                'category_id' => $service->category_id,
                'category' => $service->category,
                'description' => $service->description,
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
    public function settranslation(StoreServiceRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $service = Service::findOrFail($id);

            $service->category_id = $request->category_id;
            $service->contact = $request->contact;
            $service->email = $request->email;

            $service->setTranslation('name', strtolower($request->lang), $request->name);
            $service->setTranslation('description', strtolower($request->lang), $request->description);

            $service->save();
        });

        return Redirect::route('canvas.services.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}