<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\TodoRequest;


class FakerController extends Controller
{
    public function index()
    {
        // Make a GET request to fetch users from JSON Faker API
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');

        // Check if the request was successful
        if ($response->successful()) {

            // Parse JSON response
            $users = $response->json();

            // Return users data
            return response()->json($users);
        } else {
            // Return error response if request failed
            return response()->json(['error' => 'Failed to fetch todo'], $response->status());
        }
    }

    public function show($id)
    {
        // Make a GET request to fetch a specific user from JSON Faker API
        $response = Http::get('https://jsonplaceholder.typicode.com/todos/'.$id);

        // Check if the request was successful
        if ($response->successful()) {
            // Parse JSON response
            $user = $response->json();

            // Return user data
            return response()->json($user);
        } else {
            // Return error response if request failed
            return response()->json(['error' => 'Failed to fetch todo '], $response->status());
        }
    }

    public function store(TodoRequest $request)
    {
        // Make a POST request to create a new todo on JSON Faker API
        $response = Http::post('https://jsonplaceholder.typicode.com/todos', $request->validated());

        // Check if the request was successful
        if ($response->successful()) {
            // Parse JSON response
            $todo = $response->json();

            // Return newly created todo data
            return response()->json($todo, 201);
        } else {
            // Return error response if request failed
            return response()->json(['error' => 'Failed to create todo'], $response->status());
        }
    }

    public function update(TodoRequest $request, $id)
    {
        // Make a PUT request to update the todo on JSON Faker API
        $response = Http::put('https://jsonplaceholder.typicode.com/todos/'.$id, $request->validated());

        // Check if the request was successful
        if ($response->successful()) {
            // Parse JSON response
            $todo = $response->json();

            // Return updated todo data
            return response()->json($todo);
        } else {
            // Return error response if request failed
            return response()->json(['error' => 'Failed to update todo'], $response->status());
        }
    }


}