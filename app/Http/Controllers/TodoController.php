<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
Use App\Http\Requests\TodoRequest;


class TodoController extends Controller
{
    public function index(){
        return Todo::all();
    }

    public function store(TodoRequest $request){
        $todo = Todo::create($request->validated());
        return response()->json(['message' => 'Todo Created Successfully', 'data' => $todo], 201);
    }

    public function show(Todo $todo){
        // Verify if the record exists
        if (!$todo) {
            return response()->json(['message' => 'No record found'], 404);
        }

        return response()->json(['message' => 'Todo found', 'data' => $todo], 200);
    }

    public function update(TodoRequest $request, Todo $todo){
        // Verify if the record exists
        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->update($request->validated());
        return response()->json(['message' => 'Todo deleted successfully', 'data' => $todo], 200);
    }

    public function destroy(Todo $todo){
        // Verify if the record exists
        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->delete();
        return response()->json(['message' => 'Todo deleted successfully'], 200);
    }
}
