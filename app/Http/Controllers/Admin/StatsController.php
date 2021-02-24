<?php

namespace App\Http\Controllers\Admin;

use App\Models\Canvas\Post;
use App\Models\Canvas\User;
use App\Services\StatsAggregatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function index(Request $request): JsonResponse
    // {
    //     return response()->json(StatsAggregatorService::getByUserAndScope(
    //         $request->user('website'),
    //         $request->query('scope', 'user'),
    //         30
    //     ));
    // }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Dashboard');
        // return response()->json(StatsAggregatorService::getByUserAndScope(
        //     $request->user('website'),
        //     $request->query('scope', 'user'),
        //     30
        // ));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $user = User::firstWhere('id', $request->user('website')->id);

        if ($user->isAdmin || $user->isEditor) {
            $post = Post::find($id);
        } else {
            $post = Post::where('user_id', $request->user('website')->id)->find($id);
        }

        if (! $post || ! $post->published) {
            return response()->json(null, 404);
        }

        return response()->json(StatsAggregatorService::getForPost($post, 30));
    }
}
