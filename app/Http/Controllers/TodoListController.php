<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('todo.index', [
            'lists' => TodoList::where('user_id', Auth::id())->with(['items', 'user'])->get(),
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $todoList = TodoList::create([
            'user_id' => Auth::id(),
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            
        ]);

        return redirect()->route('todo.index')->with('success', __('Todo list created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoList $todoList)
    {

        //if ($todoList->user_id !== Auth::id()) {
        //    abort(403, 'Unauthorized action.');
        //}

        //$list = TodoList::where('id' === $todoList)->with('items')->get();
        //$list = $todoList;
        /*
        $list = TodoList::findOrFail($todoList)->with('items')->get();
        return view('todo.show', [
            'list' => $list,
        ]);
        */
        
        $todoList->load('items');
        $todoList->load('user');

        dd('$todoList->id, $todoList->user_id, Auth::id(), Auth::user()->id' , $todoList->id, $todoList->user_id, Auth::id(), Auth::user()->id);

        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todoList->load('items');

        return view('todo.show', [
            'list' => $todoList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoList $todoList)
    {
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todoList->load('items');

        return view('todo.edit', [
            'list' => $todoList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $todoList)
    {
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $todoList->update($validatedData);

        return redirect()->route('todo.show', $todoList)->with('success', __('Todo list updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoList $todoList)
    {
        if ($todoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todoList->delete();

        return redirect()->route('todo.index')->with('success', __('Todo list deleted successfully!'));
    }
}