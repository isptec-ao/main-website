<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreFileRequest;
use App\Models\Canvas\WebsiteFile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\FileCategory;
use App\Models\Canvas\Department;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Files/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'files' => WebsiteFile::with('category', 'department')->orderBy('name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Files/Create', [
            'categories' => FileCategory::get(['id','name']),
            'departments' => Department::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreFileRequest $request
     */
    public function store(StoreFileRequest $request)
    {

        DB::transaction(function () use ($request) {
            $file = WebsiteFile::create([
                'category_id' => $request->category_id,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::of($request->name)->slug('-')->__toString(),
            ]);

            // Add Possible Featured Image
            if(isset($request->document)){

                $fileAdders = $file
                    ->addMultipleMediaFromRequest(['document'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('document');
                    });
            }

        });

        return Redirect::route('canvas.files.index')->with('success',[
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
        $section = Section::find($id);

        return $section ? response()->json($section, 200) : response()->json(null, 404);
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
        $section = Section::with('posts')->find($id);

        return $section ? response()->json($section->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $file = WebsiteFile::findOrFail($id);

        $file->delete();

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
        $file = WebsiteFile::withTrashed()->findOrFail($id);

        $file->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $file = WebsiteFile::with('category', 'department')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Files/Lang', [
            'lang' => $request->lang,
            'categories' => FileCategory::get(['id','name']),
            'departments' => Department::get(['id','name']),
            'file' => [
                'id' => $file->id,
                'name' => $file->name,
                'category_id' => $file->category_id,
                'category' => $file->category,
                'department_id' => $file->department_id,
                'department' => $file->department,
                'description' => $file->description,
            ],
            'document' => function() use ($file){
                if($file->getFirstMedia('document')){
                    return [
                        'id' => $file->getFirstMedia('document')->id,
                        'name' => $file->getFirstMedia('document')->name,
                        'size' => $file->getFirstMedia('document')->human_readable_size,
                        'type' => $file->getFirstMedia('document')->mime_type,
                        'image_url' => $file->getFirstMediaUrl('document')
                    ];
                }
                return null;
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
    public function settranslation(StoreFileRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $file = WebsiteFile::findOrFail($id);

            $file->category_id = $request->category_id;
            $file->department_id = $request->department_id;
            
            $file->setTranslation('name', strtolower($request->lang), $request->name);
            $file->setTranslation('description', strtolower($request->lang), $request->description);
            $file->setTranslation('slug', strtolower($request->lang), Str::of($request->name)->slug('-')->__toString());

            $file->save();

            // Add Possible Featured Image
            if(isset($request->document)){

                $fileAdders = $file
                    ->addMultipleMediaFromRequest(['document'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('document');
                    });
            }

        });

        return Redirect::route('canvas.files.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = WebsiteFile::findOrFail(request()->model_id)->getMedia('attachments');

        return MediaStream::create('attachments.zip')->addMedia($attachments);
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