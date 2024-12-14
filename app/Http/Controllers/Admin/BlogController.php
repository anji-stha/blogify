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
    /**
     * Display a listing of the blogs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Check if the user is a super admin
        if (Auth::user()->hasRole('super-admin')) {
            // If super admin, fetch all blogs
            $blogs = Blog::paginate(20);
        } else {
            // If regular user, fetch blogs created by the authenticated user
            $blogs = Blog::where('user_id', '=', Auth::user()->id)
                ->paginate(20);
        }

        // Return the view with the blogs
        return view('blogs.index', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all categories and tags to display in the form
        $category = Category::get();
        $tags = Tag::get();

        // Return the create blog view with categories and tags
        return view('blogs.create', [
            'tags' => $tags,
            'categories' => $category
        ]);
    }

    /**
     * Store a newly created blog in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        // Validate the incoming request data
        $validated = Validator::make($request->all(), [
            'title' => ['required', 'unique:blogs,title'],
            'slug' => ['required', 'unique:blogs,slug'],
            'categories' => ['required', 'array'],
            'tags' => ['required', 'array'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => ['required'],
            'status' => ['required', 'in:draft,published'],
        ]);

        // If validation fails, return errors
        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()->toArray()
            ]);
        }

        // Handle file upload for thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('uploads/thumbnails', 'public');
        }

        // Create a new blog entry in the database
        $blog = Blog::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'thumbnail' => $thumbnailPath,
            'body' => $request->input('content'),
            'status' => $request->input('status'),
            'user_id' => auth()->id(),
        ]);

        // Sync selected categories and tags with the blog
        $blog->categories()->sync($request->input('categories'));
        $blog->tags()->sync($request->input('tags'));

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully',
        ]);
    }

    /**
     * Show the form to edit an existing blog.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        // Get all categories and tags to display in the edit form
        $categories = Category::get();
        $tags = Tag::get();

        // Find the blog by ID
        $id = $request->id;
        $blog = Blog::findOrFail($id);

        // Get the existing categories and tags associated with the blog
        $hasCategory = $blog->categories->pluck('name');
        $hasTag = $blog->tags->pluck('name');

        // Return the edit view with the blog details, categories, and tags
        return view('blogs.edit', [
            'blog' => $blog,
            'categories' => $categories,
            'tags' => $tags,
            'hasCategory' => $hasCategory,
            'hasTag' => $hasTag
        ]);
    }

    /**
     * Update the specified blog in the database.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        // Find the blog by ID
        $blog = Blog::findOrFail($id);

        // Validate the incoming request data
        $validated = Validator::make($request->all(), [
            'title' => ['required', 'unique:blogs,title,' . $id],
            'slug' => ['required', 'unique:blogs,slug,' . $id],
            'categories' => ['required', 'array'],
            'tags' => ['required', 'array'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => ['required'],
            'status' => ['required', 'in:draft,published']
        ]);

        // If validation fails, return errors
        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()->toArray()
            ]);
        }

        // Handle file upload for thumbnail, if present
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            Storage::disk('public')->delete($blog->thumbnail);
            // Store new thumbnail
            $thumbnailPath = $request->file('thumbnail')->store('uploads/thumbnails', 'public');
        } else {
            // Keep the old thumbnail if no new file is uploaded
            $thumbnailPath = $blog->thumbnail;
        }

        // Update the blog entry in the database
        $blog->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'thumbnail' => $thumbnailPath,
            'body' => $request->input('content'),
            'status' => $request->input('status'),
            'user_id' => auth()->id(),
        ]);

        // Sync selected categories and tags with the blog
        $blog->categories()->sync($request->input('categories'));
        $blog->tags()->sync($request->input('tags'));

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully',
        ]);
    }

    /**
     * Delete the specified blog and move it to the trash.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        // Find the blog by ID
        $id = $request->id;
        $blog = Blog::find($id);

        // If blog not found, redirect with error message
        if ($blog == null) {
            return redirect()->route('blog.index')->with('error', 'Blog Not Found');
        }

        // Delete the blog (move to trash)
        $blog->delete();

        // Redirect to blog index with success message
        return redirect()->route('blog.index')->with('success', 'Blog moved to trash successfully');
    }

    /**
     * Display a listing of deleted blogs (trash).
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        // Fetch trashed blogs for either super-admin or the authenticated user
        if (Auth::user()->hasRole('super-admin')) {
            $blogs = Blog::onlyTrashed()->paginate(20);
        } else {
            $blogs = Blog::onlyTrashed()
                ->where('user_id', '=', Auth::user()->id)
                ->paginate(20);
        }

        // Return the trash view with the trashed blogs
        return view('blogs.trash', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Permanently delete the specified blog from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function permanentDelete(Request $request)
    {
        // Find the trashed blog by ID
        $id = $request->id;
        $blog = Blog::withTrashed()->find($id);

        // If blog not found, redirect with error message
        if ($blog == null) {
            return redirect()->route('blog.index')->with('error', 'Blog Not Found');
        }

        // Delete the thumbnail file if it exists
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        // Permanently delete the blog
        $blog->forceDelete();

        // Redirect with success message
        return redirect()->route('blog.index')->with('success', 'Blog deleted permanently');
    }

    /**
     * Restore a trashed blog.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Find the trashed blog by ID
        $blog = Blog::withTrashed()->find($id);

        // Restore the blog
        $blog->restore();

        // Redirect with success message
        return redirect()->route('blog.index')->with('success', 'Blog restored successfully');
    }
}
