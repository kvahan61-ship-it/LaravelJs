<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;

class SavedPostsController extends Controller
{
    public function saved()
    {
        $savedPosts = auth()->user()->savedPosts()->with('user')->latest()->get();
        return view('saved', compact('savedPosts'));
    }
    public function toggleSave($postId)
    {
        $user = auth()->user();


        $user->savedPosts()->toggle($postId);

        return back();
    }
}
