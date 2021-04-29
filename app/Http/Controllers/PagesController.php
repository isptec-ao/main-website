<?php

namespace App\Http\Controllers;

use App\Models\Canvas\Page;
use App\Models\Canvas\Section;
use App\Models\Canvas\Slider;
use App\Models\Canvas\Partnership;
use App\Models\Canvas\Post;
use App\Models\Canvas\Event;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {  
        $post = Page::with('sections', 'sliders')->where('code', 'home')->first();
        $news = Post::latest()->take(5)->get();
        $events = Event::latest()->take(5)->get();

        return view('index', compact('post', 'news', 'events'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function msg_from_dg(Request $request)
    {  
        $post = Page::with('sections', 'sliders')->where('code', 'msg_from_dg')->first();

        return view('msg_from_dg', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function institutional_presentation(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'institutional_presentation')->first();

        return view('institutional_presentation', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function org_chart(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'org_chart')->first();

        return view('org_chart', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mission_vision_values(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'mission_vision_values')->first();

        return view('mission_vision_values', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'history')->first();

        return view('history', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function infrastructure(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'infrastructure')->first();

        return view('infrastructure', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function legislation(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'legislation')->first();

        return view('legislation', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aggr_protocols(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'aggr_protocols')->first();
        $partnerships = collect(Partnership::with('category')->get())->map(function($item){
            return [
                'id' => $item->id,
                  'name' => $item->name,
                  'description' => $item->descriptipn,
                  'category' => $item->category->name,
                  'img' => $item->getFirstMediaUrl('featured_image'),
      	          'link' => $item->link
            ];
        })->groupBy('category')->all();

        return view('aggr_protocols', compact('post', 'partnerships'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function social_wellfare(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'social_wellfare')->first();

        return view('social_wellfare', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function social_support(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'social_support')->first();

        return view('social_support', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extracurricular_activities(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extracurricular_activities')->first();

        return view('extracurricular_activities', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function health(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'health')->first();

        return view('health', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function acad_calendar(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'acad_calendar')->first();

        return view('acad_calendar', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function regulations(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'regulations')->first();

        return view('regulations', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edicts(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'edicts')->first();

        return view('edicts', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function student_mobility(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'student_mobility')->first();

        return view('student_mobility', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function education_det(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'education_det')->first();

        return view('education_det', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function education_dgc(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'education_dgc')->first();

        return view('education_dgc', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function education_teachers(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'education_teachers')->first();

        return view('education_teachers', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function education_library_presentation(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'education_library_presentation')->first();

        return view('education_library_presentation', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function education_library_rules(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'education_library_rules')->first();

        return view('education_library_rules', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scientific_research_aasr_center(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'scientific_research_aasr_center')->first();

        return view('scientific_research_aasr_center', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scientific_research_lec_cycles(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'scientific_research_lec_cycles')->first();

        return view('scientific_research_lec_cycles', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scientific_research_innovation_award(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'scientific_research_innovation_award')->first();

        return view('scientific_research_innovation_award', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scientific_research_events(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'scientific_research_events')->first();

        return view('scientific_research_events', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scientific_research_project_guide(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'scientific_research_project_guide')->first();

        return view('scientific_research_project_guide', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scientific_research_policy(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'scientific_research_policy')->first();

        return view('scientific_research_policy', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_policy(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_policy')->first();

        return view('extension_services_policy', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_trans_knowledge(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_trans_knowledge')->first();

        return view('extension_services_trans_knowledge', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_non_curricular_internships(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_non_curricular_internships')->first();

        return view('extension_services_non_curricular_internships', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_entrepreneurship_program(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_entrepreneurship_program')->first();

        return view('extension_services_entrepreneurship_program', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_olympiads(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_olympiads')->first();

        return view('extension_services_olympiads', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_employment_careers(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_employment_careers')->first();

        return view('extension_services_employment_careers', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_ltc(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_ltc')->first();

        return view('extension_services_ltc', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extension_services_cu_program(Request $request)
    {   
        $post = Page::with('sections', 'sliders')->where('code', 'extension_services_cu_program')->first();

        return view('extension_services_cu_program', compact('post'));
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