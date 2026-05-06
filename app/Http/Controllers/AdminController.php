<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $postsCount = Post::count();

        return view('admin.dashboard', compact('usersCount', 'postsCount'));
    }
}
