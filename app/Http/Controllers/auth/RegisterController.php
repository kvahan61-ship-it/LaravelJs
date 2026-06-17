<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.Reg');
    }

    public function sendVerificationCode(Request $request)
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

            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            $code = rand(100000, 999999);

            session([
                'reg_user_data' => [
                    'name' => $request->name,
                    'sureName' => $request->sureName,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'avatar' => $avatarPath,
                ],
                'reg_verification_code' => $code,
                'reg_code_expires_at' => now()->addMinutes(15)
            ]);

            Mail::to($request->email)->send(new VerificationCodeMail($code));

            return response()->json([
                'status' => 'code_sent',
                'message' => 'Հաստատման կոդը հաջողությամբ ուղարկվել է Ձեր Gmail-ին։'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => ['server' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function verifyAndRegister(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|numeric',
            ]);

            if (!session()->has('reg_verification_code')) {
                return response()->json(['errors' => ['code' => ['Ժամանակը սպառվել է, խնդրում ենք փորձել նորից։']]], 422);
            }

            if ($request->code != session('reg_verification_code')) {
                return response()->json(['errors' => ['code' => ['Մուտքագրված հաստատման կոդը սխալ է։']]], 422);
            }

            if (now()->isAfter(session('reg_code_expires_at'))) {
                $this->clearRegistrationSession();
                return response()->json(['errors' => ['code' => ['Կոդի վավերականության ժամկետն անցել է։']]], 422);
            }

            $userData = session('reg_user_data');

            $user = User::create([
                'name' => $userData['name'],
                'sureName' => $userData['sureName'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'phone' => $userData['phone'],
                'gender' => $userData['gender'],
                'avatar' => $userData['avatar'],
                'role' => 'user',
                'is_active' => true,
            ]);

            $this->clearRegistrationSession();

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Success',
                'redirect' => route('home')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => ['server' => [$e->getMessage()]]
            ], 500);
        }
    }

    private function clearRegistrationSession()
    {
        session()->forget(['reg_user_data', 'reg_verification_code', 'reg_code_expires_at']);
    }
}
