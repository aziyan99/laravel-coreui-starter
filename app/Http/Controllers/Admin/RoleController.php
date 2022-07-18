<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('role_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $roles = Role::with('permissions')->get();
            return DataTables::of($roles)
                ->addColumn('Aksi', function ($role) {
                    return Blade::render('
                    @can("permission_update")
                    <a href="{{ route("roles.edit", $role) }}"
                    class="text-decoration-none text-dark me-2" data-coreui-toggle="tooltip"
                    data-coreui-placement="top" data-coreui-original-title="{{ __("Edit") }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                     </a>
                     @endcan
                     @can("permission_delete")
                         <a class="text-decoration-none text-dark delete-btn" data-coreui-toggle="tooltip"
                         data-id="{{ $role->id }}"
                         data-coreui-placement="top" data-coreui-original-title="{{ __("Hapus") }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                         </a>
                     @endcan
                    ', ['role' => $role]);
                })
                ->addColumn('Permissions', function ($role) {
                    return Blade::render('
                    @foreach($permissions as $permission)
                    <span class="badge bg-info text-white">{{ $permission->title }}</span>
                    @endforeach
                    ', ['permissions' => $role->permissions]);
                })
                ->rawColumns(['Aksi', 'Permissions'])
                ->make(true);
        }
        return view('admin.roles.index');
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
        toast('Role saved','success');
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
        toast('Role updated','success');
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->delete();
        toast('Role deleted','success');
        return redirect()->route('roles.index');
    }
}
