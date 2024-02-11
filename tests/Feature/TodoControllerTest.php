<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_list_of_todos()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Generate API token
        $apiToken = Str::random(60);
        $user->update(['api_token' => $apiToken]);

         // Create a todo with the authenticated user
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->postJson('/api/v1/todos', [
            'title' => 'Test Todo',
            'user_id' => $user->id, // Use the user's ID here
            'description' => 'This is a test todo',
        ]);

        // Fetch the list of todos with the authenticated user
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->getJson('/api/v1/todos');
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'user_id',
                    'description',
                    'status',
                ],
            ]);
    }

    public function test_can_create_todo()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Generate API token
        $apiToken = Str::random(60);
        $user->update(['api_token' => $apiToken]);

        // Create a todo with the authenticated user
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken, // Use the generated API token here
        ])->postJson('/api/v1/todos', [
            'title' => 'Test Todo',
            'user_id' => $user->id, // Use the user's ID here
            'description' => 'This is a test todo',
        ]);

        // Assert that the todo is created successfully
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Todo Created Successfully',
            ])
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'user_id',
                    'description',
                ],
            ]);
    }


    public function test_can_update_todos()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Generate API token
        $apiToken = Str::random(60);
        $user->update(['api_token' => $apiToken]);

         // Create a todo with the authenticated user
        $todo = $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->postJson('/api/v1/todos', [
            'title' => 'Test Todo',
            'user_id' => $user->id, // Use the user's ID here
            'description' => 'This is a test todo',
        ]);

        // New todo data
        $newTodoData = [
            'title' => 'Updated Todo Title',
            'description' => 'Updated description',
        ];

        // Update the todo
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken, // Use the generated API token here
        ])->putJson("/api/v1/todos/{$todo['data']['id']}", $newTodoData);

        // Assert that the todo is updated successfully
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Todo updated successfully',
            ])
            ->assertJsonFragment($newTodoData);
    }

    public function test_can_get_delete_todos()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Generate API token
        $apiToken = Str::random(60);
        $user->update(['api_token' => $apiToken]);

         // Create a todo with the authenticated user
        $todo = $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->postJson('/api/v1/todos', [
            'title' => 'Test Todo',
            'user_id' => $user->id, // Use the user's ID here
            'description' => 'This is a test todo',
        ]);

        // Delete the todo
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $apiToken, // Use the generated API token here
        ])->deleteJson("/api/v1/todos/{$todo['data']['id']}");

        // Assert that the todo is deleted successfully
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Todo deleted successfully',
            ]);

        // Verify that the todo no longer exists in the database
        $this->assertDatabaseMissing('todos', [
            'id' => $todo['data']['id'],
        ]);
    }
}