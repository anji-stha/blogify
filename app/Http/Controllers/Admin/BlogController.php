<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blogs.index');
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
        dd($request->all());
    }
}
