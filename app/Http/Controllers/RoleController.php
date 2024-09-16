<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return view('roles.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles'
        ]);

        if ($validate->passes()) {
            $role = Role::create(['name' => $request->name]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('index.role')->with('success', 'Role Added Successfully.');
        } else {
            return redirect()->route('create.role')->withInput()->withErrors($validate);
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name')->get();
        return view('roles.edit', [
            'permissions' => $permissions,
            'roles' => $role,
            'hasPermissions' => $hasPermissions
        ]);
    }

    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id'
        ]);

        if ($validate->passes()) {
            $role->name = $request->name;
            $role->save();

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('index.role')->with('success', 'Role Updated Successfully.');
        } else {
            return redirect()->route('edit.role', $id)
                ->withInput()
                ->withErrors($validate);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);

        if ($role === null) {
            return redirect()->route('index.role')->with('error', 'Role Not Found.');
        }

        $role->delete();
        return redirect()->route('index.role')->with('success', 'Role Deleted Successfully.');
    }
}
