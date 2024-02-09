<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    public function index() {
        $todos = Todo::all();
        return Inertia::render('HomePage', compact('todos'));
    }

    public function store(Request $request) {
        // Todo: validation
        $todo = Todo::create($request->all());
        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo) {
        // Todo: validation
        $todo->update($request->all());
        return response()->json($todo, 200);
    }

    public function destroy(Todo $todo) {
        $todo->delete();
        return response()->json(null, 204);
    }
}
