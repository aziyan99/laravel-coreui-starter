<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');//{{ route("users.destroy", $user) }}
        if ($request->ajax()) {
            $users = User::all();
            return DataTables::of($users)
                ->addColumn('Aksi', function ($user) {
                    return Blade::render('
                    @can("user_update")
                        <a href="{{ route("users.edit", $user) }}" class="btn btn-secondary btn-sm text-white"
                        data-coreui-toggle="tooltip" data-coreui-placement="top" data-coreui-original-title="{{ __("Edit") }}">
                            <svg class="icon icon-sm">
                            <use xlink:href="{{ asset("vendors/@coreui/icons/svg/free.svg#cil-pencil") }}"></use>
                            </svg>
                        </a>
                    @endcan
                    @can("user_update")
                        <a href="{{ route("users.show", $user) }}"
                        class="btn btn-secondary btn-sm text-white" data-coreui-toggle="tooltip"
                        data-coreui-placement="top" data-coreui-original-title="{{ __("Detail") }}">
                            <svg class="icon icon-sm">
                                <use
                                    xlink:href="{{ asset("vendors/@coreui/icons/svg/free.svg#cil-file") }}">
                                </use>
                            </svg>
                         </a>
                     @endcan
                     @can("user_delete")
                         <a class="btn btn-sm btn-danger text-white delete-btn" data-coreui-toggle="tooltip"
                         data-id="{{ $user->id }}"
                         data-coreui-placement="top" data-coreui-original-title="{{ __("Hapus") }}">
                             <svg class="icon icon-sm">
                                 <use
                                 xlink:href="{{ asset("vendors/@coreui/icons/svg/free.svg#cil-trash") }}">
                                 </use>
                             </svg>
                         </a>
                     @endcan
                    ', ['user' => $user]);
                })
                ->addColumn('roles', function ($user) {
                    return Blade::render('
                    @foreach($roles as $role)
                        <span class="badge bg-info text-white">{{ $role->title }}</span>
                    @endforeach
                    ', ['roles' => $user->roles]);
                })
                ->rawColumns(['Aksi', 'roles'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = new User();
        $roles = Role::all();
        return view('admin.users.create', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email)
        ]);
        $user->roles()->sync($request->roles);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->roles()->sync($request->roles);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->delete();
        return redirect()->route('users.index');
    }

    /**
     * Reset user password
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function resetPassword(Request $request, User $user)
    {
        $user->update([
            'password' => Hash::make($user->email)
        ]);
        return back();
    }
}
