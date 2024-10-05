<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        return view('tags.index');
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request):RedirectResponse
    {
        dd($request->all());
        $validated = Validator::make($request->all(),[

        ]);
        echo 'here';
    }
}
