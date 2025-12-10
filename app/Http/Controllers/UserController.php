<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * GET /users
     * Display all users
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * POST /users
     * Create a new user
     */
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:3',
            'email_verified_at' => 'nullable|date',
        ]);

        // Create user with plain password
        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * GET /users/{id}
     * Display a single user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * PUT/PATCH /users/{id}
     * Update a user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate input
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'sometimes|string|min:3',
            'email_verified_at' => 'nullable|date',
        ]);

        // Update user
        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    /**
     * DELETE /users/{id}
     * Delete a user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * GET /users/{id}/notes
     * Get all notes for a specific user
     */
    public function getUserNotes($id)
    {
        $user = User::with('notes')->findOrFail($id);
        return response()->json($user->notes);
    }
}