<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{


    public function dashboard()
    {
        $usersCount = User::count();
        $postsCount = Post::count();
        $publicPosts=Post::where('is_published', 1)->count();
        $blockedPosts=Post::where('is_published', 0)->count();

        $query = User::orderBy('id', 'desc');
        if (auth()->user()->role === 'admin') {
            $query->where('role', 'user');
            $users = $query->get();
        } elseif (auth()->user()->role === 'superadmin') {
            $query->where('role', '!=', 'superadmin');
            $users = $query->get();
        } else {
            $users = collect();
        }

        $posts = Post::with('user')->orderBy('id', 'desc')->get();

        return view('admin.dashboard', compact('usersCount', 'postsCount','publicPosts','blockedPosts', 'users', 'posts'));
    }

    public function toggleBlockPost(Post $post)
    {
        if (!in_array(auth()->user()->role, ['moderator', 'admin', 'superadmin'])) {
            return redirect()->back()->with('error', 'Անթույլատրելի գործողություն։');
        }

        $post->update([
            'is_published' => !$post->is_published
        ]);

        $statusMessage = $post->is_published ? 'Պոստը հաջողությամբ ակտիվացվեց։' : 'Պոստը հաջողությամբ ապակտիվացվեց (արգելափակվեց)։';

        return redirect()->back()->with('success', $statusMessage);
    }
    public function toggleActiveUser(User $user)
    {
        if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            return redirect()->back()->with('error', 'Անթույլատրելի գործողություն։');
        }

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->back()->with('error', 'Դուք կարող եք արգելափակել միայն սովորական օգտատերերի։');
        }

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Դուք չեք կարող արգելափակել ինքներդ ձեզ։');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $message = $user->is_active ? 'Օգտատերը հաջողությամբ ակտիվացվեց։' : 'Օգտատերը հաջողությամբ արգելափակվեց։';

        return redirect()->back()->with('success', $message);
    }
    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Միայն Super Admin-ը կարող է փոխել դերերը։');
        }

        $request->validate(['role' => 'required|in:user,admin,moderator']);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Օգտատիրոջ դերը հաջողությամբ թարմացվեց։');
    }

    public function destroy(User $user)
    {
        if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            return redirect()->back()->with('error', 'Անթույլատրելի գործողություն։');
        }

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->back()->with('error', 'Դուք իրավունք ունեք ջնջել միայն սովորական օգտատերերի։');
        }

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Դուք չեք կարող ջնջել ինքներդ ձեզ։');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Օգտատերը հաջողությամբ ջնջվեց։');
    }
}
