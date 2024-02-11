<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
Use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            // Generate new API token
            $apiToken = $this->generateToken($user);
            return response()->json(['message' => 'Login successful', 'Bearer token' => $apiToken, 'data' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function register(UserRequest $request){
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate API token after user creation
        $apiToken = $this->generateToken($user);
        return response()->json(['message' => 'User registered successfully','Bearer token' => $apiToken, 'data' => $user], 201);
    }

    public function logout(Request $request, $id){
        $user = User::find($id);
        
        if ($user) {
            $user->update(['api_token' => null]);
            return response()->json(['message' => 'Logout successful'], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function refreshToken(Request $request, $id){
        $user = User::find($id);

        if ($user) {
            $token = $this->generateToken($user);
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    private function generateToken(User $user){
        $apiToken = bcrypt($user->email . '|' . now());
        $user->update(['api_token' => $apiToken]);

        return $apiToken;
    }
}
