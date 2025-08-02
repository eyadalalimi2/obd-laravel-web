<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author')->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = User::all();
        return view('admin.posts.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:posts,slug',
            'content'     => 'nullable|string',
            'author_id'   => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'required|in:draft,published',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/posts', 'public');
        }

        Post::create([
            'title'       => $request->title,
            'slug'        => $request->slug ?? Str::slug($request->title),
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'author_id'   => $request->author_id,
            'status'      => $request->status,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'تم إنشاء المقال.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $authors = User::all();
        return view('admin.posts.edit', compact('post', 'categories', 'authors'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:posts,slug,' . $post->id,
            'content'     => 'nullable|string',
            'author_id'   => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'required|in:draft,published',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $post->image = $request->file('image')->store('uploads/posts', 'public');
        }

        $post->update([
            'title'       => $request->title,
            'slug'        => $request->slug ?? Str::slug($request->title),
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'author_id'   => $request->author_id,
            'status'      => $request->status,
            'image'       => $post->image,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'تم تحديث المقال.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'تم حذف المقال.');
    }
}
