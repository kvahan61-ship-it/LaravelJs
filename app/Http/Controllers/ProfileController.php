<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $myPosts = Post::where('user_id', $user->id)->latest()->get();

        return view('profile.index', compact('user', 'myPosts'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->back()->with('success', 'Պրոֆիլը հաջողությամբ թարմացվեց։');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            // Եթե հին նկար ունի, ջնջում ենք storage-ից, որ տեղ չզբաղեցնի
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            $user->update(['avatar' => $path]);
        }

        return redirect()->back()->with('success', 'Ավատարը հաջողությամբ թարմացվեց։');
    }
}
