<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Canvas;
use App\Events\PostViewed;
use App\Models\Post;

class CaptureView
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * A view is captured when a user loads a post for the first time
     * in a given hour. The ID of the post is stored in session to
     * be validated against until it "expires" and is pruned.
     *
     * @param PostViewed $event
     * @return void
     */
    public function handle($event)
    {
        if (! $this->wasRecentlyViewed($event->post)) {
            $referer = request()->header('referer');

            $data = [
                'post_id' => $event->post->id,
                'ip' => request()->getClientIp(),
                'agent' => request()->header('user_agent'),
                'referer' => Canvas::isValid($referer) ? Canvas::trim($referer) : false,
            ];

            $event->post->views()->create($data);

            $this->storeInSession($event->post);
        }
    }

    /**
     * Check if a given post exists in the session.
     *
     * @param Post $post
     * @return bool
     */
    protected function wasRecentlyViewed(Post $post): bool
    {
        $viewed = session()->get('viewed_posts', []);

        return array_key_exists($post->id, $viewed);
    }

    /**
     * Add a given post to the session.
     *
     * @param Post $post
     * @return void
     */
    protected function storeInSession(Post $post)
    {
        session()->put("viewed_posts.{$post->id}", now()->timestamp);
    }
}
