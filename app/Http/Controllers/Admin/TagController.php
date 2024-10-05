<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::get();
        return view('tags.index', [
            'tags' => $tags
        ]);
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'unique:tags,name'],
            'slug' => ['required', 'unique:tags,slug']
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        Tag::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug')
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag Created Successfully');
    }

    public function edit($id)
    {
        $tag = Tag::findorFail($id);
        return view('tags.edit', [
            'tag' => $tag
        ]);
    }

    public function update($id, Request $request): RedirectResponse
    {
        $tag = Tag::findorFail($id);

        $validated = Validator::make($request->all(), [
            'name' => ['required', 'unique:tags,name,' . $id . ''],
            'slug' => ['required', 'unique:tags,slug,' . $id . '']
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $tag->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug')
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag Updated Successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $tag = Tag::find($id);

        if ($tag == null) {
            return redirect()->route('tags.index')->with('error', 'Tag Not Found');
        }

        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag Deleted Successfully');
    }
}
