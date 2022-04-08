@extends('layouts.admin')

@section('title', 'Profile')

@section('breadcump')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
    </li>
@endsection

@section('main')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card  mb-2">
                    <div class="card-header">
                        {{ __('Gambar') }}
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-2">
                            <img src="{{ (auth()->user()->avatar != null) ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?size=256&background=0D8ABC&color=fff&name=' . auth()->user()->name }}" alt="img" class="img-thumbnail">
                        </div>
                        <form action="{{ route('profile.avatar.update', auth()->user()) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="mb-3">
                                <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                                @error('avatar')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <svg class="icon icon-sm me-1">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                    </svg>
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </form>
                        <hr>
                        <div class="mt-2 mb-2">
                            @foreach(auth()->user()->roles as $role)
                                <span class="badge bg-info">{{ $role->title }}</span>
                            @endforeach
                        </div>
                        <div class="mt-2 mb-2">
                            <i class="text-muted">{{ __('Terdaftar sejak') }} {{ auth()->user()->created_at->diffForHumans() }}</i>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit password') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.password.update', auth()->user()) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password baru') }}</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Ulangi password baru') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <svg class="icon icon-sm me-1">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                    </svg>
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Data profile') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update', auth()->user()) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nama lengkap') }}</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ auth()->user()->name }}">
                                @error('name')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}">
                                @error('email')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <svg class="icon icon-sm me-1">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                    </svg>
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
