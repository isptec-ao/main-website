<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreRecruitmentSubmissionRequest;
use App\Models\Canvas\RecruitmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Canvas\RecruitmentPublication;
use App\Models\Canvas\AcademicCategory;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RecruitmentSubmissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/RecruitmentSubmissions/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'recruitmentsubmissions' => RecruitmentSubmission::with('academic', 'publication')->orderBy('full_name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/RecruitmentSubmissions/Create', [
            'recruitmentpublications' => RecruitmentPublication::get(['id','title']),
            'academiccategories' => AcademicCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreRecruitmentSubmissionRequest $request
     */
    public function store(StoreRecruitmentSubmissionRequest $request)
    {

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

        return Redirect::route('canvas.recruitmentsubmissions.index')->with('success',[
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
        $recruitmentsubmission = RecruitmentSubmission::findOrFail($id);

        $recruitmentsubmission->delete();

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
        $recruitmentsubmission = RecruitmentSubmission::withTrashed()->findOrFail($id);

        $recruitmentsubmission->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $recruitmentsubmission = RecruitmentSubmission::with('publication', 'academic')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/RecruitmentSubmissions/Lang', [
            'lang' => $request->lang,
            'recruitmentpublications' => RecruitmentPublication::get(['id','title']),
            'academiccategories' => AcademicCategory::get(['id','name']),
            'recruitmentsubmission' => [
                'id' => $recruitmentsubmission->id,
                'full_name' => $recruitmentsubmission->full_name,
                'pub_id' => $recruitmentsubmission->pub_id,
                'publication' => $recruitmentsubmission->publication,
                'acad_id' => $recruitmentsubmission->acad_id,
                'academic' => $recruitmentsubmission->academic,
                'gender' => $recruitmentsubmission->gender,
                'naturality' => $recruitmentsubmission->naturality,
                'id_no' => $recruitmentsubmission->id_no,
                'email' => $recruitmentsubmission->email,
                'dob' => $recruitmentsubmission->dob,
                'tel_no' => $recruitmentsubmission->tel_no,
                'country' => $recruitmentsubmission->country,
                'marital_status' => $recruitmentsubmission->marital_status,
                'address' => $recruitmentsubmission->address,
                'suburb' => $recruitmentsubmission->suburb,
                'postal_code' => $recruitmentsubmission->postal_code,
                'work_experience' => $recruitmentsubmission->work_experience,
                'other_info' => $recruitmentsubmission->other_info,
            ],
            'documents' => function() use ($recruitmentsubmission){
                return collect($recruitmentsubmission->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreRecruitmentSubmissionRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $recruitmentsubmission = RecruitmentSubmission::findOrFail($id);

            $recruitmentsubmission->acad_id = $request->acad_id;
            $recruitmentsubmission->pub_id = $request->pub_id;
            $recruitmentsubmission->full_name = $request->full_name;
            $recruitmentsubmission->gender = $request->gender;
            $recruitmentsubmission->naturality = $request->naturality;
            $recruitmentsubmission->id_no = $request->id_no;
            $recruitmentsubmission->email = $request->email;
            $recruitmentsubmission->tel_no = $request->tel_no;
            $recruitmentsubmission->dob = $request->dob;
            $recruitmentsubmission->country = $request->country;
            $recruitmentsubmission->marital_status = $request->marital_status;
            $recruitmentsubmission->address = $request->address;
            $recruitmentsubmission->suburb = $request->suburb;
            $recruitmentsubmission->postal_code = $request->postal_code;
            $recruitmentsubmission->work_experience = $request->work_experience;
            $recruitmentsubmission->other_info = $request->other_info;

            $recruitmentsubmission->save();

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $recruitmentsubmission
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.recruitmentsubmissions.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = RecruitmentSubmission::findOrFail(request()->model_id)->getMedia('attachments');

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