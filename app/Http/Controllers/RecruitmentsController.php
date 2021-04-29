<?php

namespace App\Http\Controllers;

use App\Models\Canvas\RecruitmentPublication;
use App\Models\Canvas\RecruitmentSubmission;
use App\Models\Canvas\AcademicCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RecruitmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $posts = RecruitmentPublication::published()->with('category')
                        ->where('category_id', $request->cat)
                        ->filter($request->only('search', 'category'))
                        ->latest()
                        ->paginate(5)->withQueryString();

                        // dd($posts);

        return view('recruitmentpublications', compact('posts'));
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
        
        $post =  RecruitmentPublication::with('category')->findOrFail($request->id);
        $academiccategories = AcademicCategory::all();

        // dd(Post::where('slug->' . session()->get('locale'), collect(explode('/', $url))->last())->get());

        return view('recruitmentpublications_single', compact('post', 'academiccategories'));
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        // dd($request->all());

        DB::transaction(function () use ($request) {
            $recruitmentsubmission = RecruitmentSubmission::create([
                'pub_id' => $request->pub_id,
                'acad_id' => $request->acad_id,
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'naturality' => $request->naturality,
                'id_no' => $request->id_no,
                'email' => $request->email,
                'tel_no' => $request->tel_no,
                'dob' => $request->dob,
                'country' => $request->country,
                'marital_status' => $request->marital_status,
                'address' => $request->address,
                'suburb' => $request->suburb,
                'status' => ($request->status == 'on' ? 1 : 0),
                'postal_code' => $request->postal_code,
                'work_experience' => $request->work_experience,
                'other_info' => $request->other_info,
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $recruitmentsubmission
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $recruitmentsubmission
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
        $attachments = Event::findOrFail(request()->model_id)->getMedia('attachments');

        return MediaStream::create('attachments.zip')->addMedia($attachments);
    }

    public function downloadsingleattachment()
    {
        return Media::findOrFail(request()->model_id);
    }

}