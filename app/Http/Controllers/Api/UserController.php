<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Traits\CanLoadRelationship;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use CanLoadRelationship;
    protected $relations = ['relations'];

    public function index()
    {
        $query = $this->loadRelationships(User::query());
        return UserResource::collection($query->paginate());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create($validated);
        return new UserResource($this->loadRelationships($user));
    }

    public function show(User $user)
    {
        return new UserResource($this->loadRelationships($user));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users',
            'password' => 'sometimes|string|confirmed|min:8',
        ]);

        $user->update($validated);
        return new UserResource($this->loadRelationships($user));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
