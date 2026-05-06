<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Ուղղվեց "se"-ն
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.Reg');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'sureName' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'phone' => 'required|string',
                'gender' => 'required|string',
                'avatar' => 'nullable|image|max:2048',
            ]);


            $path = null;
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('avatars', 'public');
            }


            $user = User::create([
                'name' => $request->name,
                'sureName' => $request->sureName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'gender' => $request->gender,
                'avatar' => $path,
                'role' => 'user',
                'is_active' => true,
            ]);

            Auth::login($user);


            return response()->json([
                'message' => 'Success',
                'redirect' => route('home')
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'errors' => ['server' => [$e->getMessage()]]
            ], 500);
        }
    }
}
