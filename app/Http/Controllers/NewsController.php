<?php

namespace App\Http\Controllers;

use App\Models\Canvas\Post;
use App\Models\Canvas\Tag;
use App\Models\Canvas\Topic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $posts = Post::withCount('views')
        ->filter($request->only('search', 'topic'))
        ->latest()
        ->paginate(5)->withQueryString();

        $latest_posts = Post::latest()->take(5)->get();

        return view('news', compact('posts', 'latest_posts'));
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
        
        $post =  Post::with('topic')->findOrFail($request->id);
        $related_posts = Post::related($post->topic()->pluck('topic_id')->toArray());

        // dd(Post::where('slug->' . session()->get('locale'), collect(explode('/', $url))->last())->get());

        return view('news_single', compact('post', 'related_posts'));
    }


    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Post::findOrFail(request()->model_id)->getMedia('attachments');

        return MediaStream::create('attachments.zip')->addMedia($attachments);
    }

    public function downloadsingleattachment()
    {
        return Media::findOrFail(request()->model_id);
    }

}