<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;

class UserCollectionController extends Controller
{
    // POST /api/users/{user}/collection
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'media_id' => ['required', 'integer', 'exists:media,id'],
        ]);

        $mediaId = $validated['media_id'];

        $alreadyExists = $user->media()
            ->where('media.id', $mediaId)
            ->exists();

        if ($alreadyExists) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi',
            ], 409);
        }

        $user->media()->attach($mediaId);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi',
        ], 201);
    }

    // DELETE /api/users/{user}/collection/{media}
    public function destroy(User $user, Media $media)
    {
        $exists = $user->media()
            ->where('media.id', $media->id)
            ->exists();

        if (!$exists) {
            return response()->json([
                'message' => 'Media tidak ditemukan di koleksi',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi',
        ], 200);
    }
}
