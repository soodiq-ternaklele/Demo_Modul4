<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        $users = User::with('media')->paginate(10);

        return UserResource::collection($users);
    }

    // GET /api/users/{user}
    public function show(User $user)
    {
        $user->load('media');

        return new UserResource($user);
    }
}
