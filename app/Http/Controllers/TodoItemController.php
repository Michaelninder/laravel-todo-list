<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoItemController extends Controller
{
    public function create($todoId)
    {
        try {
            $todoList = TodoList::findOrFail($todoId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($todoList->user_id !== Auth::id()) {
            abort(403);
        }

        return view('todo.items.create', [
            'list' => $todoList,
        ]);
    }

    public function store(Request $request, $todoId)
    {
        try {
            $todoList = TodoList::findOrFail($todoId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($todoList->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required', 'in:done,in_progress,open,cancelled'],
        ]);

        $todoList->items()->create([
            'name' => $validatedData['name'],
            'state' => $validatedData['state'] ?? 'open',
        ]);

        return redirect()->route('todo.show', $todoList->id)->with('success', __('Item added successfully!'));
    }

    public function edit($todoId, TodoItem $item)
    {
        try {
            $todoList = TodoList::findOrFail($todoId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($todoList->user_id !== Auth::id()) {
            abort(403);
        }

        if ($item->list_id !== $todoList->id) {
             abort(404);
        }

        return view('todo.items.edit', [
            'list' => $todoList,
            'item' => $item,
        ]);
    }

    public function update(Request $request, $todoId, TodoItem $item)
    {
        try {
            $todoList = TodoList::findOrFail($todoId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($todoList->user_id !== Auth::id()) {
            abort(403);
        }

        if ($item->list_id !== $todoList->id) {
             abort(404);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required', 'in:done,in_progress,open,cancelled'],
        ]);

        $item->update($validatedData);

        return redirect()->route('todo.show', $todoList->id)->with('success', __('Item updated successfully!'));
    }

    public function destroy($todoId, TodoItem $item)
    {
        try {
            $todoList = TodoList::findOrFail($todoId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($todoList->user_id !== Auth::id()) {
            abort(403);
        }

        if ($item->list_id !== $todoList->id) {
             abort(404);
        }

        $item->delete();

        return redirect()->route('todo.show', $todoList->id)->with('success', __('Item deleted successfully!'));
    }
}