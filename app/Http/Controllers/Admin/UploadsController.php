<?php

namespace App\Http\Controllers\Admin;

use App\Models\Canvas\Canvas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UploadsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $payload = $request->file();

        if (! $payload) {
            return response()->json(null, 400);
        }

        // Only grab the first element because single file uploads
        // are not supported at this time
        $file = reset($payload);

        $path = $file->storePublicly(Canvas::baseStoragePath(), [
            'disk' => config('blog.storage_disk'),
        ]);

        return Storage::disk(config('blog.storage_disk'))->url($path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if (empty($request->getContent())) {
            return response()->json(null, 400);
        }

        $file = pathinfo($request->getContent());

        $storagePath = Canvas::baseStoragePath();

        $path = "{$storagePath}/{$file['basename']}";

        Storage::disk(config('blog.storage_disk'))->delete($path);

        return response()->json([], 204);
    }
}
