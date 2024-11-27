<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(20);
        return view('blogs.index', [
            'blogs' => $blogs
        ]);
    }

    public function create()
    {
        $category = Category::get();
        $tags = Tag::get();
        return view('blogs.create', [
            'tags' => $tags,
            'categories' => $category
        ]);
    }

    public function save(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => ['required', 'unique:blogs,title'],
            'slug' => ['required', 'unique:blogs,slug'],
            'categories' => ['required', 'array'],
            'tags' => ['required', 'array'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => ['required']
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()->toArray()
            ]);
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('uploads/thumbnails', 'public');
        }

        $blog = Blog::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'thumbnail' => $thumbnailPath,
            'body' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        $blog->categories()->sync($request->input('categories'));
        $blog->tags()->sync($request->input('tags'));

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully',
        ]);
    }
}
