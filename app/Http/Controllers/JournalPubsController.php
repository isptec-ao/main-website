<?php

namespace App\Http\Controllers;

use App\Models\Canvas\JournalPublication;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JournalPubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $posts = JournalPublication::with('category')
                        ->where('category_id', $request->cat)
                        ->filter($request->only('search', 'category'))
                        ->latest()
                        ->paginate(5)->withQueryString();

                        // dd($posts);

        return view('journalpublications', compact('posts'));
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
        
        $post =  Event::findOrFail($request->id);
        $related_posts = Event::latest()->take(3)->get();

        // dd(Post::where('slug->' . session()->get('locale'), collect(explode('/', $url))->last())->get());

        return view('events_single', compact('post', 'related_posts'));
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