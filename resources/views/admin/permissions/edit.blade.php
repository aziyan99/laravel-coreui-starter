@extends('layouts.admin')

@section('title', 'Edit permission')

@section('breadcump')
<li class="breadcrumb-item">
    <a href="#">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('permissions.index') }}">{{ __('Permission') }}</a>
</li>
<li class="breadcrumb-item active">
    <a href="javascript:void(0);">{{ __('Edit permission') }}</a>
</li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-header">{{ __('Edit permission') }}</div>
                <div class="card-body">
                    <form action="{{ route('permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.permissions._form')
                        <div class="mb-2">
                            <button class="btn btn-primary btn-sm">
                                <svg class="icon icon-sm me-1">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                </svg>
                                {{ __('Simpan') }}
                            </button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">
                                <svg class="icon icon-sm me-1">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}"></use>
                                </svg>
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
