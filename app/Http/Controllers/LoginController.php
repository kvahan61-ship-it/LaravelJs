<?php
namespace App\Http\Controllers;

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
