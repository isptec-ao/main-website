<?php

namespace App\Http\Controllers;

use App\Models\Canvas\Service;
use App\Models\Canvas\WebsiteMessage;
use App\Models\Canvas\ServiceCategory;
use App\Models\Canvas\Department;
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

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $departments = Department::orderBy('name')->get();
        $services = ServiceCategory::all();

        return view('contacts', compact('departments', 'services'));
    }


        /**
     * Store a newly created resource in storage. j
     *
     * @param Request $request
     */
    public function storecontactrequest(Request $request)
    {
        DB::transaction(function () use ($request) {
            $message = WebsiteMessage::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'tel_no' => $request->tel_no,
                'message' => $request->message
            ]);
        });

        return back();
    }


    /**
     * Store a newly created resource in storage. j
     *
     * @param Request $request
     */
    public function storeservicerequest(Request $request)
    {

        DB::transaction(function () use ($request) {
            $service = Service::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'description' => $request->description
            ]);
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