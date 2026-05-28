<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::with(['images', 'category']);


        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $posts = $query->latest()->get();

        return view('home', compact('posts'));
    }
}
