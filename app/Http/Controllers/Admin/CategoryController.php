<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::paginate(10);
        return view('categories.index', [
            'category' => $category
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories,name'],
            'slug' => ['required', 'unique:categories,slug'],
        ]);

        if ($validated->fails()) {
            if ($request->wantsJson()) {
                // Return JSON response for API requests
                return response()->json([
                    'success' => false,
                    'errors' => $validated->errors()
                ], 400);
            }
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        if ($request->wantsJson()) {
            // JSON response for API requests
            return response()->json([
                'success' => true,
                'message' => 'Category Created Successfully',
                'category' => $category
            ], 201);
        }

        return redirect()->route('category.index')->with('success', 'Category Added Successfully');
    }

    public function edit($id)
    {
        $category = Category::findorFail($id);
        return view(
            'categories.edit',
            [
                'id' => $id,
                'category' => $category
            ]
        );
    }

    public function update($id, Request $request)
    {
        $category = Category::findorFail($id);

        $validated = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories,name,' . $id . ',id'],
            'slug' => ['required', 'unique:categories,slug,' . $id . ',id'],
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withInput()->withErrors($validated);
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);

        if ($category == null) {
            return redirect()->route('category.index')->with('error', 'Category Not Found');
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category Deleted Successfully');
    }
}
