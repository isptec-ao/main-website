<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreSliderRequest;
use App\Models\Canvas\Slider;
use App\Models\Canvas\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\Page;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SliderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Sliders/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'sliders' => Slider::with('page')->orderBy('title')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Sliders/Create', [
            'pages' => Page::get(['id','title']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreSliderRequest $request
     */
    public function store(StoreSliderRequest $request)
    {

        DB::transaction(function () use ($request) {
            $slider = Slider::create([
                'page_id' => $request->page_id,
                'title' => $request->title,
                'description' => $request->description,
                'height' => $request->height,
                'width' => $request->width
            ]);

            // Add Possible Featured Images
            if(isset($request->images)){

                foreach($request->images as $image) {
                    $img = SliderImage::create([
                        'slider_id' => $slider->id,
                        'title' => $image['title'],
                        'description' => $image['description'],
                        'link' => $image['link'],
                    ]);

                    if(isset($image['image'])){
                        $img
                        ->addMedia($image['image'])
                        ->toMediaCollection('image');
                    }
                }
            }
        });

        return Redirect::route('canvas.sliders.index')->with('success',[
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
        $slider = Slider::find($id);

        return $slider ? response()->json($slider, 200) : response()->json(null, 404);
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
        $slider = Slider::with('posts')->find($id);

        return $slider ? response()->json($slider->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $slider = Slider::findOrFail($id);

        $slider->delete();

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
        $slider = Slider::withTrashed()->findOrFail($id);

        $slider->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $slider = Slider::with('images', 'page')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Sliders/Lang', [
            'lang' => $request->lang,
            'pages' => Page::get(['id','title']),
            'slider' => [
                'id' => $slider->id,
                'title' => $slider->title,
                'page_id' => $slider->page_id,
                'page' => $slider->page,
                'description' => $slider->description,
                'height' => $slider->height,
                'width' => $slider->width,
            ],
            'images' => function() use ($slider){
                return collect($slider->images)->map(function($item){
                    if($item->getFirstMedia('image')){
                        return [
                            'id' => $item->id,
                            'media_id' => $item->getFirstMedia('image')->id,
                            'title' => $item->title,
                            'description' => $item->description,
                            'link' => $item->link,
                            'image' => null,
                            'image_url' => $item->getFirstMediaUrl('image')
                        ];
                    }
                    return [];
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
    public function settranslation(StoreSliderRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $slider = Slider::findOrFail($id);

            $slider->page_id = $request->page_id;
            $slider->height = $request->height;
            $slider->width = $request->width;

            $slider->setTranslation('title', strtolower($request->lang), $request->title);
            $slider->setTranslation('description', strtolower($request->lang), $request->description);

            $slider->save();

            // Add Possible Featured Images
            if(isset($request->images)){

                foreach($request->images as $image) {

                    if($image['id']) {
                        $img = SliderImage::findOrFail($image['id']);

                        $img->link = $image['link'];

                        $img->setTranslation('title', strtolower($request->lang), $image['title']);
                        $img->setTranslation('description', strtolower($request->lang), $image['description']);
                        $img->save();

                        if(isset($image['image'])){
                            $img
                            ->addMedia($image['image'])
                            ->toMediaCollection('image');
                        }
                    } else {
                        $img = SliderImage::create([
                            'slider_id' => $slider->id,
                            'title' => $image['title'],
                            'description' => $image['description'],
                            'link' => $image['link'],
                        ]);
    
                        if(isset($image['image'])){
                            $img
                            ->addMedia($image['image'])
                            ->toMediaCollection('image');
                        }
                    }
                }
            }
        });

        return Redirect::route('canvas.sliders.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadsingleattachment()
    {
        return Media::findOrFail(request()->model_id);
    }

    public function deletesingleattachment()
    {
        $media = Media::findOrFail(request()->model_id);

        $media->delete();

        return Redirect::back();
        // return Media::findOrFail(request()->model_id);
    }
}