<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * GET /notes
     * Return all notes
     */
    public function index()
    {
        return Note::all();
    }

    /**
     * POST /notes
     * Create a new note
     */
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'is_checked' => 'boolean',
            'user_id' => 'required|integer',
        ]);

        // Create new note
        $note = Note::create($data);

        return response()->json($note, 201);
    }

    /**
     * GET /notes/{id}
     * Show one note
     */
    public function show($id)
    {
        return Note::findOrFail($id);
    }

    /**
     * PUT/PATCH /notes/{id}
     * Update a note
     */
    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'desc' => 'nullable|string',
            'is_checked' => 'boolean',
            'user_id' => 'integer',
        ]);

        $note->update($data);

        return response()->json($note);
    }

    /**
     * DELETE /notes/{id}
     * Delete a note
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json(['message' => 'Note deleted successfully']);
    }
}

