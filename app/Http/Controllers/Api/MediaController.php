<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // GET /api/media
    public function index(Request $request)
    {
        $query = Media::with('users');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $media = $query->latest()->paginate(10);

        return MediaResource::collection($media);
    }

    // POST /api/media
    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/media/{media}
    public function show(Media $media)
    {
        $media->load('users');

        return new MediaResource($media);
    }

    // PATCH /api/media/{media}
    public function update(StoreMediaRequest $request, Media $media)
    {
        $media->update($request->validated());
        $media->load('users');

        return new MediaResource($media);
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus',
        ], 200);
    }
}
