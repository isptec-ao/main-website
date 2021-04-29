<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreNewsletterCategoryRequest;
use App\Models\Canvas\NewsletterCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class NewsletterCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/NewsletterCategories/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'newslettercategories' => NewsletterCategory::orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/NewsletterCategories/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreNewsletterCategoryRequest $request
     */
    public function store(StoreNewsletterCategoryRequest $request)
    {

        DB::transaction(function () use ($request) {
            $newslettercategory = NewsletterCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'period' => $request->period,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $newslettercategory
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $newslettercategory
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.newslettercategories.index')->with('success',[
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
        $newsletterCategory = NewsletterCategory::find($id);

        return $newsletterCategory ? response()->json($newsletterCategory, 200) : response()->json(null, 404);
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
        $newsletterCategory = NewsletterCategory::with('posts')->find($id);

        return $newsletterCategory ? response()->json($newsletterCategory->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $newsletterCategory = NewsletterCategory::findOrFail($id);

        $newsletterCategory->delete();

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
        $newslettercategory = NewsletterCategory::withTrashed()->findOrFail($id);

        $newslettercategory->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $newslettercategory = NewsletterCategory::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/NewsletterCategories/Lang', [
            'lang' => $request->lang,
            'newslettercategory' => [
                'id' => $newslettercategory->id,
                'name' => $newslettercategory->name,
                'description' => $newslettercategory->description,
                'period' => $newslettercategory->period,
            ],
            'featured_image' => function() use ($newslettercategory){
                if($newslettercategory->getFirstMedia('featured_image')){
                    return [
                        'id' => $newslettercategory->getFirstMedia('featured_image')->id,
                        'name' => $newslettercategory->getFirstMedia('featured_image')->name,
                        'size' => $newslettercategory->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $newslettercategory->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $newslettercategory->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($newslettercategory){
                return collect($newslettercategory->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreNewsletterCategoryRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $newslettercategory = NewsletterCategory::findOrFail($id);

            $newslettercategory->period = $request->period;

            $newslettercategory->setTranslation('name', strtolower($request->lang), $request->name);
            $newslettercategory->setTranslation('description', strtolower($request->lang), $request->description);
            $newslettercategory->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $newslettercategory->save();


            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $newslettercategory
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $newslettercategory
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.newslettercategories.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}