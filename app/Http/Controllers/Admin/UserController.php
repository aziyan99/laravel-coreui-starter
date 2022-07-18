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
        // abort_if(Gate::denies('user_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');//{{ route("users.destroy", $user) }}
        if ($request->ajax()) {
            $users = User::all();
            return DataTables::of($users)
                ->addColumn('Aksi', function ($user) {
                    return Blade::render('
                    @can("user_update")
                        <a href="{{ route("users.edit", $user) }}" class="text-decoration-none text-dark me-2"
                        data-coreui-toggle="tooltip" data-coreui-placement="top" data-coreui-original-title="{{ __("Edit") }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    @endcan
                    @can("user_update")
                        <a href="{{ route("users.show", $user) }}"
                        class="text-decoration-none text-dark me-2" data-coreui-toggle="tooltip"
                        data-coreui-placement="top" data-coreui-original-title="{{ __("Detail") }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                         </a>
                     @endcan
                     @can("user_delete")
                         <a class="text-decoration-none text-dark me-2 delete-btn" data-coreui-toggle="tooltip"
                         data-id="{{ $user->id }}"
                         data-coreui-placement="top" data-coreui-original-title="{{ __("Hapus") }}">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
        toast('User saved','success');
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
        toast('User updated','success');
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
        toast('User deleted','success');
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
        toast('Password reseted','success');
        return back();
    }
}
