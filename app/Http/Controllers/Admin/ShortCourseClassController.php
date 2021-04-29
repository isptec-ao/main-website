<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreShortCourseClassRequest;
use App\Models\Canvas\ShortCourseClass;
use App\Models\Canvas\ShortCourse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ShortCourseClassController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/ShortCourseClasses/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'shortcourseclasses' => ShortCourseClass::with('course')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/ShortCourseClasses/Create',[
            'courses' => ShortCourse::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreShortCourseClassRequest $request
     */
    public function store(StoreShortCourseClassRequest $request)
    {

        DB::transaction(function () use ($request) {
            $shortcourseclass = ShortCourseClass::create([
                'name' => $request->name,
                'description' => $request->description,
                'total_hours' => $request->total_hours,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'price' => $request->price,
                'registration_fee' => $request->registration_fee,
                'course_id' => $request->course_id,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $shortcourseclass
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $shortcourseclass
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.shortcourseclasses.index')->with('success',[
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
        $shortcourseclass = ShortCourseClass::find($id);

        return $shortcourseclass ? response()->json($shortcourseclass, 200) : response()->json(null, 404);
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
        $shortcourseclass = ShortCourseClass::with('posts')->find($id);

        return $shortcourseclass ? response()->json($shortcourseclass->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $shortcourseclass = ShortCourseClass::findOrFail($id);

        $shortcourseclass->delete();

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
        $shortcourseclass = ShortCourseClass::withTrashed()->findOrFail($id);

        $shortcourseclass->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $shortcourseclass = ShortCourseClass::with('course')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/ShortCourseClasses/Lang', [
            'lang' => $request->lang,
            'courses' => ShortCourse::get(['id','name']),
            'shortcourseclass' => [
                'id' => $shortcourseclass->id,
                'name' => $shortcourseclass->name,
                'description' => $shortcourseclass->description,
                'total_hours' => $shortcourseclass->total_hours,
                'start_time' => $shortcourseclass->start_time,
                'end_time' => $shortcourseclass->end_time,
                'start_date' => $shortcourseclass->start_date,
                'end_date' => $shortcourseclass->end_date,
                'price' => $shortcourseclass->price,
                'registration_fee' => $shortcourseclass->registration_fee,
                'course_id' => $shortcourseclass->course_id,
                'course' => $shortcourseclass->course,
            ],
            'featured_image' => function() use ($shortcourseclass){
                if($shortcourseclass->getFirstMedia('featured_image')){
                    return [
                        'id' => $shortcourseclass->getFirstMedia('featured_image')->id,
                        'name' => $shortcourseclass->getFirstMedia('featured_image')->name,
                        'size' => $shortcourseclass->getFirstMedia('featured_image')->human_readable_size,
                        'type' => $shortcourseclass->getFirstMedia('featured_image')->mime_type,
                        'image_url' => $shortcourseclass->getFirstMediaUrl('featured_image')
                    ];
                }
                return null;
            },
            'documents' => function() use ($shortcourseclass){
                return collect($shortcourseclass->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreShortCourseClassRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $shortcourseclass = ShortCourseClass::findOrFail($id);

            $shortcourseclass->total_hours = $request->total_hours;
            $shortcourseclass->start_time = $request->start_time;
            $shortcourseclass->end_time = $request->end_time;
            $shortcourseclass->start_date = $request->start_date;
            $shortcourseclass->end_date = $request->end_date;
            $shortcourseclass->price = $request->price;
            $shortcourseclass->registration_fee = $request->registration_fee;
            $shortcourseclass->course_id = $request->course_id;

            $shortcourseclass->setTranslation('name', strtolower($request->lang), $request->name);
            $shortcourseclass->setTranslation('description', strtolower($request->lang), $request->description);
            $shortcourseclass->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $shortcourseclass->save();

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $shortcourseclass
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $shortcourseclass
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.shortcourseclasses.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}