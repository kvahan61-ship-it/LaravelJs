<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index() { abort(404); }

    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Անթույլատրելի գործողություն։');
        }

        $categories = \App\Models\Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Անթույլատրելի գործողություն։');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('images')) {
            $userId = auth()->id();
            $path = "posts/user_{$userId}";

            foreach ($request->file('images') as $image) {
                $imagePath = $image->store($path, 'public');
                $post->images()->create([
                    'path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('profile.index')->with('success', 'Պոստը հաջողությամբ թարմացվեց:');
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->price = $request->price;
        $post->category_id = $request->category_id;
        $post->save();

        if ($request->hasFile('images')) {
            $userId = auth()->id();
            $path = "posts/user_{$userId}";

            foreach ($request->file('images') as $image) {
                $imagePath = $image->store($path, 'public');
                $post->images()->create([
                    'path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Պոստը հաջողությամբ ստեղծվեց:');
    }

    public function destroy(Post $post)
    {
        foreach($post->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $post->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Post deleted successfully']);
        }

        return redirect()->route('profile.index');
    }

    public function show($id)
    {
        $post = Post::with('images', 'category')->findOrFail($id);

        $ip = request()->ip();
        $userId = auth()->id();

        $alreadyViewed = DB::table('post_views')
            ->where('post_id', $post->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>', Carbon::now()->subHour())
            ->exists();

        if (!$alreadyViewed) {
            DB::table('post_views')->insert([
                'user_id' => $userId,
                'post_id' => $post->id,
                'ip_address' => $ip,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $viewsCount = DB::table('post_views')->where('post_id', $post->id)->count();

        return view('posts.show', compact('post', 'viewsCount'));
    }
}
