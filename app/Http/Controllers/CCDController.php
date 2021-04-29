<?php

namespace App\Http\Controllers;

use App\Models\Canvas\ShortCourse;
use App\Models\Canvas\ShortCourseClass;
use App\Models\Canvas\ShortCourseRegistration;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CCDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $posts = ShortCourse::with('department', 'employee')
                        ->orderBy('name')
                        ->filter($request->only('search'))
                        ->latest()
                        ->paginate(10)->withQueryString();

        return view('ccd', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registration(Request $request)
    {   
        $post = ShortCourseClass::with('course')->findOrFail($request->class_id);

        return view('ccd_register', compact('post'));
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // dd($request->all(), url()->current(), session()->get('locale'));
        // dd(session()->get('locale') ?? 'None');  
        $url = url()->current();
        $lang = session()->get('locale');
        // $condition = 'slug->' . session()->get('locale') ?? 'pt';

        // dd(session()->get('locale'));
        // $segment = collect(explode('/', $url))->last();

        // return Post::where("slug->{$lang}", collect(explode('/', $url))->last())->get();
        // $post =  Post::where('slug->' . (session()->get('locale') ?? 'pt'), collect(explode('/', $url))->last())->first();
        
        $post =  ShortCourse::with('department', 'employee', 'classes')->findOrFail($request->id);

        // dd(Post::where('slug->' . session()->get('locale'), collect(explode('/', $url))->last())->get());

        return view('ccd_single', compact('post'));
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {
            $shortcourseregistration = ShortCourseRegistration::create([
                'full_name' => $request->full_name,
                'description' => $request->description,
                'class_id' => $request->class_id,
                'dob' => $request->dob,
                'id_no' => $request->id_no,
                'tel_no' => $request->tel_no,
                'email' => $request->email,
                'institution' => $request->institution,
                'paid' => 0,
                'registration_active' => 1,
                'is_student' => 0
            ]);

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $shortcourseregistration
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return back();
    }


    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Alumni::findOrFail(request()->model_id)->getMedia('attachments');

        return MediaStream::create('attachments.zip')->addMedia($attachments);
    }

    public function downloadsingleattachment()
    {
        return Media::findOrFail(request()->model_id);
    }

}