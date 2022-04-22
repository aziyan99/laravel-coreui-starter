<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('permission_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $permissions = Permission::latest()->get();
            return DataTables::of($permissions)
                ->addColumn('Aksi', function ($permission) {
                    return Blade::render('
                    @can("permission_update")
                    <a href="{{ route("permissions.edit", $permission) }}"
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
                         data-id="{{ $permission->id }}"
                         data-coreui-placement="top" data-coreui-original-title="{{ __("Hapus") }}">
                             <svg class="icon icon-sm">
                                 <use
                                 xlink:href="{{ asset("vendors/@coreui/icons/svg/free.svg#cil-trash") }}">
                                 </use>
                             </svg>
                         </a>
                     @endcan
                    ', ['permission' => $permission]);
                })
                ->rawColumns(['Aksi'])
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permission = new Permission();
        return view('admin.permissions.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required|unique:permissions,title'
        ]);
        Permission::create([
            'title' => $request->title
        ]);
        toast('Permission saved','success');
        return redirect()->route('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        abort_if(Gate::denies('permission_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required|unique:permissions,title,' . $permission->id,
        ]);
        $permission->update([
            'title' => $request->title,
        ]);
        toast('Permission updated','success');
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permission->delete();
        toast('Permission deleted','success');
        return redirect()->route('permissions.index');
    }
}
