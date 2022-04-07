<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = new Role();
        $permissions = Permission::all();
        return view('admin.roles.create', compact('role', 'permissions'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required|unique:roles,title'
        ]);
        $role = Role::create([
            'title' => $request->title
        ]);
        $role->permissions()->sync($request->permissions, []);
        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        abort_if(Gate::denies('role_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required|unique:roles,title,' . $role->id
        ]);
        // dd($request->all());
        $role->update([
            'title' => $request->title
        ]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->delete();
        return redirect()->route('roles.index');
    }
}
