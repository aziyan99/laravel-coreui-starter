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
                    class="btn btn-secondary btn-sm" data-coreui-toggle="tooltip"
                    data-coreui-placement="top" data-coreui-original-title="{{ __("Edit") }}">
                        <svg class="icon icon-sm">
                            <use
                                xlink:href="{{ asset("vendors/@coreui/icons/svg/free.svg#cil-pencil") }}">
                            </use>
                        </svg>
                     </a>
                     @endcan
                     @can("permission_delete")
                         <a class="btn btn-sm btn-danger text-white delete-btn" data-coreui-toggle="tooltip"
                         data-id="{{ $role->id }}"
                         data-coreui-placement="top" data-coreui-original-title="{{ __("Hapus") }}">
                             <svg class="icon icon-sm">
                                 <use
                                 xlink:href="{{ asset("vendors/@coreui/icons/svg/free.svg#cil-trash") }}">
                                 </use>
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
