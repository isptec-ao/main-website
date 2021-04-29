<?php

namespace App\Http\Controllers;

use App\Models\Canvas\WebsiteFile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $posts = WebsiteFile::with('category', 'department')
                        ->filter($request->only('search'))
                        ->latest()
                        ->paginate(10)->withQueryString();

        return view('files', compact('posts'));
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

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