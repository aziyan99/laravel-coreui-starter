<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $role = new Role();
        return view('admin.roles.create', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:roles,title'
        ]);
        Role::create([
            'title' => $request->title
        ]);
        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'title' => 'required|unique:roles,title,' . $role->id
        ]);
        $role->update([
            'title' => $request->title
        ]);
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
