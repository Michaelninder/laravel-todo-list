<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\TodoItem;
use App\Http\Requests\StoreTodoListRequest; // Assuming you're using this for store
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import this for 404

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('todo.index', [
            'lists' => TodoList::where('user_id', Auth::id())->withCount('items')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoListRequest $request) // Using StoreTodoListRequest for validation
    {
        $validatedData = $request->validated();

        $todoList = Auth::user()->todoLists()->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);

        return redirect()->route('todo.index')->with('success', __('Todo list created successfully!'));
    }

    /**
     * Display the specified resource.
     * Use $id parameter and manually find the model.
     */
    public function show($id)
    {
        try {
            $todoList = TodoList::findOrFail($id); // Find the model, throws 404 if not found
        } catch (ModelNotFoundException $e) {
            abort(404, 'Todo list not found.');
        }

        // Authorization check
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todoList->load('items'); // Eager load items for the view

        return view('todo.show', [
            'list' => $todoList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * Use $id parameter and manually find the model.
     */
    public function edit($id)
    {
        try {
            $todoList = TodoList::findOrFail($id); // Find the model, throws 404 if not found
        } catch (ModelNotFoundException $e) {
            abort(404, 'Todo list not found for editing.');
        }

        // Authorization check
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todoList->load('items'); // Eager load items if displayed on the edit page

        return view('todo.edit', [
            'list' => $todoList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Use $id parameter and manually find the model.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  The UUID of the TodoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $todoList = TodoList::findOrFail($id); // Find the model
        } catch (ModelNotFoundException $e) {
            abort(404, 'Todo list not found for updating.');
        }

        // Authorization check
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validation (can use a Form Request here too)
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $todoList->update($validatedData);

        return redirect()->route('todo.show', $todoList->id)->with('success', __('Todo list updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     * Use $id parameter and manually find the model.
     *
     * @param  string  $id  The UUID of the TodoList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $todoList = TodoList::findOrFail($id); // Find the model
        } catch (ModelNotFoundException $e) {
            abort(404, 'Todo list not found for deletion.');
        }

        // Authorization check
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todoList->delete();

        return redirect()->route('todo.index')->with('success', __('Todo list deleted successfully!'));
    }
}