<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ], [
                'email.exists' => 'Այս էլ. հասցեով օգտատեր չի գտնվել։'
            ]);

            $code = rand(100000, 999999);

            session([
                'reset_email' => $request->email,
                'reset_verification_code' => $code,
                'reset_code_expires_at' => now()->addMinutes(15)
            ]);

            Mail::send('emails.verification-code', ['code' => $code], function($message) use ($request) {
                $message->to($request->email)->subject('🔒 Գաղտնաբառի վերականգնման կոդ');
            });

            return response()->json([
                'status' => 'code_sent',
                'message' => 'Վերականգնման կոդը ուղարկվել է Ձեր Gmail-ին։'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['server' => [$e->getMessage()]]], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|numeric',
                'password' => 'required|min:8|confirmed',
            ]);

            if (!session()->has('reset_verification_code')) {
                return response()->json(['errors' => ['code' => ['Ժամանակը սպառվել է, խնդրում ենք փորձել նորից։']]], 422);
            }

            if ($request->code != session('reset_verification_code')) {
                return response()->json(['errors' => ['code' => ['Մուտքագրված կոդը սխալ է։']]], 422);
            }

            if (now()->isAfter(session('reset_code_expires_at'))) {
                $this->clearResetSession();
                return response()->json(['errors' => ['code' => ['Կոդի վավերականության ժամկետն անցել է։']]], 422);
            }

            $user = User::where('email', session('reset_email'))->first();
            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            $this->clearResetSession();

            return response()->json([
                'message' => 'Success',
                'redirect' => route('login')
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['server' => [$e->getMessage()]]], 500);
        }
    }

    private function clearResetSession()
    {
        session()->forget(['reset_email', 'reset_verification_code', 'reset_code_expires_at']);
    }
}
