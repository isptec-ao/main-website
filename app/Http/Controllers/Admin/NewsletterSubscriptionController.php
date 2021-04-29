<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use App\Models\Canvas\NewsletterSubscription;
use App\Models\Canvas\NewsletterCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class NewsletterSubscriptionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return Inertia::render('Website/NewsletterSubscriptions/Index', [
            'filters' => $request->all('search', 'trashed', 'range'),
            'newslettersubscriptions' => NewsletterSubscription::with('category')->orderBy('fullname')
                ->filter($request->only('search', 'trashed'))
                ->paginate(5)
                // ->only('id', 'name', 'description')
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Website/NewsletterSubscriptions/Create',[
            'categories' => NewsletterCategory::get(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage. j
     *
     * @param StoreNewsletterSubscriptionRequest $request
     */
    public function store(StoreNewsletterSubscriptionRequest $request)
    {

        DB::transaction(function () use ($request) {
            $newslettersubscription = NewsletterSubscription::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);
        });

        return Redirect::route('canvas.newslettersubscriptions.index')->with('success',[
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
        $newslettersubscription = NewsletterSubscription::find($id);

        return $newslettersubscription ? response()->json($newslettersubscription, 200) : response()->json(null, 404);
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
        $newslettersubscription = NewsletterSubscription::with('posts')->find($id);

        return $newslettersubscription ? response()->json($newslettersubscription->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $newslettersubscription = NewsletterSubscription::findOrFail($id);

        $newslettersubscription->delete();

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
        $newslettersubscription = NewsletterSubscription::withTrashed()->findOrFail($id);

        $newslettersubscription->restore();

        return Redirect::back();
    }

    public function lang(Request $request, $id)
    {
        $newslettersubscription = NewsletterSubscription::with('category')->withTrashed()->findOrFail($id)->setLocale($request->lang);

        return Inertia::render('Website/NewsletterSubscriptions/Lang', [
            'lang' => $request->lang,
            'categories' => NewsletterCategory::get(['id','name']),
            'newslettersubscription' => [
                'id' => $newslettersubscription->id,
                'fullname' => $newslettersubscription->fullname,
                'email' => $newslettersubscription->email,
                'category_id' => $newslettersubscription->category_id,
                'category' => $newslettersubscription->category,
                'status' => $newslettersubscription->status,
            ],
        ]);
    }

    /**
     * Set the specified resource translation.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function settranslation(StoreNewsletterSubscriptionRequest $request, $id)
    {

        DB::transaction(function () use ($request, $id) {
            $newslettersubscription = NewsletterSubscription::findOrFail($id);

            $newslettersubscription->fullname = $request->fullname;
            $newslettersubscription->email = $request->email;
            $newslettersubscription->category_id = $request->category_id;
            $newslettersubscription->status = $request->status;

            $newslettersubscription->save();
        });

        return Redirect::route('canvas.newslettersubscriptions.index')->with('success',[
            'icon' => '',
            'time' => now()->diffForHumans(),
            'message' => 'Item registado com êxito.'
        ]);
    }
}