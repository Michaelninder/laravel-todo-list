<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NoteController extends Controller
{
    public function index()
    {
        return view('notes.index', [
            'notes' => Auth::user()->notes()->orderBy('updated_at', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string', 'max:102400'],
        ]);

        $note = Auth::user()->notes()->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'content' => $validatedData['content'] ?? null,
        ]);

        return redirect()->route('notes.show', $note->id)->with('success', __('Note created successfully!'));
    }

    public function show($id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.show', [
            'note' => $note,
        ]);
    }

    public function edit($id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.edit', [
            'note' => $note,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string', 'max:102400'],
        ]);

        $note->update($validatedData);

        return redirect()->route('notes.show', $note->id)->with('success', __('Note updated successfully!'));
    }

    public function destroy($id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', __('Note deleted successfully!'));
    }

    public function preview($id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        dd('Previewing Note: ' . $note->name, $note->content);
    }

    public function export($id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        dd('Exporting Note: ' . $note->name, $note->content);
    }

    public function share($id)
    {
        try {
            $note = Note::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        dd('Sharing Note: ' . $note->name, 'Link would be generated here.');
    }
}