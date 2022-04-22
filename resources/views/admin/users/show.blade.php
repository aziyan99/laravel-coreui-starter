@extends('layouts.admin')

@section('title', 'Detail pengguna')

@section('breadcump')
<li class="breadcrumb-item">
    <a href="#">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('users.index') }}">{{ __('Pengguna') }}</a>
</li>
<li class="breadcrumb-item active">
    <a href="javascript:void(0);">{{ __('Detail pengguna') }}</a>
</li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">{{ __('Detail pengguna') }}</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <img src="{{ ($user->avatar == null) ? 'https://ui-avatars.com/api/?size=256&background=0D8ABC&color=fff&name=' . $user->name : asset($user->avatar) }}" alt="img" class="img-thumbnail">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-sm table-hover table-bordered">
                                <tr>
                                    <th>{{ __('Nama') }}</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Role') }}</th>
                                    <td>
                                        @foreach ($user->roles as $role)
                                        <span class="badge bg-info">{{ $role->title }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Tanggal terdaftar') }}</th>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm text-white">
                        <svg class="icon icon-sm me-1">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}"></use>
                        </svg>
                        {{ __('Kembali') }}
                    </a>
                    <form action="{{ route('users.reset.password', $user) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Reset password pengguna?')">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-danger btn-sm text-white" type="submit">
                            <svg class="icon icon-sm me-1">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                            </svg>
                            {{ __('Reset password') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
