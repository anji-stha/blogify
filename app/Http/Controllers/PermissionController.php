<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('created_at')->get();
        return view('permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return view('permission.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:permissions'
        ]);

        if ($validate->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('index.permission')->with('success', 'Permission Added Successfully.');
        } else {
            return redirect()->route('create.permission')->withInput()->withErrors($validate);
        }
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            return view('permission.edit', [
                'permission' => $permission
            ]);
        } else {
            return redirect()->route('index.permission')->with('error', 'Something Went Wrong.');
        }
    }

    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();

            return redirect()->route('index.permission')->with('success', 'Permission Updated Successfully.');
        } else {
            return redirect()->route('edit.permission', $id)
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);

        if ($permission === null) {
            return redirect()->route('index.permission')->with('error', 'Permission Not Found.');
        }

        $permission->delete();
        return redirect()->route('index.permission')->with('success', 'Permission Deleted Successfully.');
    }
}
