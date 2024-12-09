<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('super-admin')) {
            $blogs = Blog::paginate(20);
        } else {
            $blogs = Blog::where('user_id', '=', Auth::user()->id)
                ->paginate(20);
        }
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
            'content' => ['required'],
            'status' => ['required', 'in:draft,published'],
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
            'status' => $request->input('status'),
            'user_id' => auth()->id(),
        ]);

        $blog->categories()->sync($request->input('categories'));
        $blog->tags()->sync($request->input('tags'));

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully',
        ]);
    }

    public function edit(Request $request)
    {
        $categories = Category::get();
        $tags = Tag::get();

        $id = $request->id;
        $blog = Blog::findOrFail($id);

        $hasCategory = $blog->categories->pluck('name');
        $hasTag = $blog->tags->pluck('name');

        return view('blogs.edit', [
            'blog' => $blog,
            'categories' => $categories,
            'tags' => $tags,
            'hasCategory' => $hasCategory,
            'hasTag' => $hasTag
        ]);
    }

    public function update($id, Request $request)
    {
        $blog = Blog::findOrFail($id);

        $validated = Validator::make($request->all(), [
            'title' => ['required', 'unique:blogs,title,' . $id . ''],
            'slug' => ['required', 'unique:blogs,slug,' . $id . ''],
            'categories' => ['required', 'array'],
            'tags' => ['required', 'array'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => ['required'],
            'status' => ['required', 'in:draft,published']
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()->toArray()
            ]);
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($blog->thumbnail);
            $thumbnailPath = $request->file('thumbnail')->store('uploads/thumbnails', 'public');
        } else {
            $thumbnailPath = $blog->thumbnail;
        }

        $blog->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'thumbnail' => $thumbnailPath,
            'body' => $request->input('content'),
            'status' => $request->input('status'),
            'user_id' => auth()->id(),
        ]);

        $blog->categories()->sync($request->input('categories'));
        $blog->tags()->sync($request->input('tags'));

        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully',
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $blog = Blog::find($id);

        if ($blog == null) {
            return redirect()->route('blog.index')->with('error', 'Blog Not Found');
        }

        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }
        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Blog deleted successfully');
    }
}
