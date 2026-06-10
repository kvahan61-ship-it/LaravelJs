<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            if (!Auth::user()->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json([
                    'errors' => ['auth' => 'Ձեր հաշիվը արգելափակված է ադմինիստրատորի կողմից։']
                ], 422);
            }

            $request->session()->regenerate();
            return response()->json(['redirect' => route('home')], 200);
        }

        return response()->json([
            'errors' => ['auth' => 'Մուտքանունը կամ գաղտնաբառը սխալ է:']
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
