<?php

namespace App\Http\Controllers;

use App\Models\Canvas\Post;
use App\Models\Canvas\ContentSubmission;
use App\Models\Canvas\ISPTECMedia;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ACIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitcontent(Request $request)
    {   
        return view('contentsubmission');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isptecmedia(Request $request)
    {   
        $posts = ISPTECMedia::filter($request->only('search'))
        ->latest()
        ->paginate(5)->withQueryString();

        $latest_posts = ISPTECMedia::latest()->take(5)->get();

        return view('isptecmedia', compact('posts', 'latest_posts'));
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showisptecmedia(Request $request)
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
        
        $post =  ISPTECMedia::with('categories')->findOrFail($request->id);
        $related_posts = ISPTECMedia::related($post->categories()->pluck('category_id')->toArray());

        // dd(Post::where('slug->' . session()->get('locale'), collect(explode('/', $url))->last())->get());

        return view('isptecmedia_single', compact('post', 'related_posts'));
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param Request $request
     */
    public function storesubmitedcontent(Request $request)
    {

        DB::transaction(function () use ($request) {
            $contentsubmission = ContentSubmission::create([
                'title' => $request->title,
                'category' => $request->category,
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'description_pt' => $request->description_pt,
                'description_en' => $request->description_en,
                'obs' => $request->obs,
            ]);

            // Add Possible Featured Image
            if(isset($request->featured_image)){

                $fileAdders = $contentsubmission
                    ->addMultipleMediaFromRequest(['featured_image'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('featured_image');
                    });
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $contentsubmission
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