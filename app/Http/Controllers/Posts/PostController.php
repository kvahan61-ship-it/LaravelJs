<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index() { abort(404);}
    public function edit(Post $post) { abort(404); }

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
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->title = $request->title;
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
        $post->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Post deleted successfully']);
        }

        return redirect()->route('post.index');
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
