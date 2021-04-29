<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreCelCategoryRequest;
use App\Models\Canvas\CelCategory;
use App\Models\Canvas\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class CelCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/CelCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'celcategories' => CelCategory::with('employee')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/CelCategories/Create',[
            'employees' => Employee::get(['id','full_name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreCelCategoryRequest $request
     */
    public function store(StoreCelCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $celcategory = CelCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'responsible_name' => $request->responsible_name ?? '',
                'employee_id' => $request->employee_id,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $celcategory
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $celcategory
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.celcategories.index')->with('success',[
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
        $celCategory = CelCategory::find($id);

        return $celCategory ? response()->json($celCategory, 200) : response()->json(null, 404);
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
        $celCategory = CelCategory::with('posts')->find($id);

        return $celCategory ? response()->json($celCategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $celCategory = CelCategory::findOrFail($id);

        $celCategory->delete();

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
        $celcategory = CelCategory::withTrashed()->findOrFail($id);

        $celcategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $celcategory = CelCategory::with('employee')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/CelCategories/Lang', [
            'lang' => $request->lang,
            'employees' => Employee::get(['id','full_name']),
            'celcategory' => [
                'id' => $celcategory->id,
                'name' => $celcategory->name,
                'description' => $celcategory->description,
                'responsible_name' => $celcategory->responsible_name,
                'employee_id' => $celcategory->employee_id,
                'employee' => $celcategory->employee,
            ],
            'featured_image' => function() use ($celcategory){
                if($celcategory->getFirstMedia('featured_image')){
                    return [
                        'id' => $celcategory->getFirstMedia('featured_image')->id,
                        'name' => $celcategory->getFirstMedia('featured_image')->name,
                        'size' => $celcategory->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $celcategory->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $celcategory->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($celcategory){
                return collect($celcategory->getMedia('documents'))->map(function($item){
                    return [
                              'id' => $item->id,
                              'name' => $item->name,
                              'size' => $item->human_readable_size,
                              'type' => $item->mime_type
                        ];
                });
            },
        ]);
    }

    /**
     * Set the specified resource translation.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function settranslation(StoreCelCategoryRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $celcategory = CelCategory::findOrFail($id);

            $celcategory->responsible_name = $request->responsible_name ?? '';

            $celcategory->setTranslation('name', strtolower($request->lang), $request->name);
            $celcategory->setTranslation('description', strtolower($request->lang), $request->description);
            $celcategory->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $celcategory->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $celcategory
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $celcategory
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.celcategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}