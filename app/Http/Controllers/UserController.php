<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

        public function index()
    {
        // Retrieve all users and return as JSON response
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserRequest $request)
    {
        // Create a new user
        $user = $this->userService->createUser($request->validated());
        return response()->json($user, 201);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserRequest $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user
        $user = $this->userService->updateUser($user, $request->validated());
        return response()->json($user);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $this->userService->deleteUser($user);
        return response()->json(null, 204);
    }
}
