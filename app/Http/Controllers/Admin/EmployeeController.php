<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Canvas\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/Employees/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'employees' => Employee::orderBy('full_name')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/Employees/Create');
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreEmployeeRequest $request
     */
    public function store(StoreEmployeeRequest $request)
    {

        DB::transaction(function () use ($request) {
            $employee = Employee::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'dob' => $request->dob,
                'receive_bday_notification' => $request->receive_bday_notification,
                'is_lecturer' => $request->is_lecturer,
                'is_national' => $request->is_national,
                'gender' => $request->gender,
                'tel_no' => $request->tel_no,
                'description' => $request->description,
                'extension' => $request->extension,
                'orchid_id' => $request->orchid_id,
            ]);

            // Assign Avatar
            if(isset($request->avatar)){
                
                // Add to avatars media collection
                $employee->addMediaFromRequest('avatar')
                    ->usingName('avatar')
                    ->toMediaCollection('avatar');
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $employee
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.employees.index')->with('success',[
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
        $employee = Employee::findOrFail($id);

        $employee->delete();

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
        $employee = Employee::withTrashed()->findOrFail($id);

        $employee->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $employee = Employee::withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/Employees/Lang', [
            'lang' => $request->lang,
            'employee' => [
                'id' => $employee->id,
                'full_name' => $employee->full_name,
                'email' => $employee->email,
                'dob' => $employee->dob->format('Y-m-d'),
                'receive_bday_notification' => $employee->receive_bday_notification,
                'is_lecturer' => $employee->is_lecturer,
                'is_national' => $employee->is_national,
                'gender' => $employee->gender,
                'tel_no' => $employee->tel_no,
                'extension' => $employee->extension,
                'orchid_id' => $employee->orchid_id,
                'description' => $employee->description,
                'avatar_link' => $employee->getFirstMediaUrl('avatar') ?? null,
            ],
            'documents' => function() use ($employee){
                return collect($employee->getMedia('documents'))->map(function($item){
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
    public function settranslation(StoreEmployeeRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $employee = Employee::findOrFail($id);

            $employee->full_name = $request->full_name;
            $employee->dob = $request->dob;
            $employee->gender = $request->gender;
            $employee->email = $request->email;
            $employee->tel_no = $request->tel_no;
            $employee->extension = $request->extension;
            $employee->orchid_id = $request->orchid_id;
            $employee->receive_bday_notification = $request->receive_bday_notification;
            $employee->is_lecturer = $request->is_lecturer;
            $employee->is_national = $request->is_national;

            $employee->setTranslation('description', strtolower($request->lang), $request->description);

            $employee->save();

            // Assign Avatar
            if(isset($request->avatar)){
                
                // Add to avatars media collection
                $employee->addMediaFromRequest('avatar')
                    ->usingName('avatar')
                    ->toMediaCollection('avatar');
            }

            // Add Possible Documets
            if(isset($request->documents)){

                $fileAdders = $employee
                    ->addMultipleMediaFromRequest(['documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('documents');
                    });
            }
        });

        return Redirect::route('canvas.employees.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }

    public function downloadallattachments()
    {
        // Get all Media
        $attachments = Employee::findOrFail(request()->model_id)->getMedia('attachments');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function togglenotification(Request $request)
    {
        DB::transaction(function () use ($request) {
            $employee = Employee::find(request()->id);

            if($employee->receive_bday_notification){
                $employee->update([
                    'receive_bday_notification' => false
                ]);
            } else{

                $employee->update([
                    'receive_bday_notification' => true
                ]);
            }
        });

        return Redirect::route('canvas.employees.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item modificado com êxito.'
        ]);
    }
}