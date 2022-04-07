@extends('layouts.admin')

@section('title', 'Permission')

@section('breadcump')
<li class="breadcrumb-item">
    <a href="#">{{ __('Dashboard') }}</a>
</li>
<li class="breadcrumb-item active">
    <a href="{{ route('permissions.index') }}">{{ __('Permission') }}</a>
</li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            @can('permission_create')
            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm mb-2">
                <svg class="icon icon-sm me-1">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                {{ __('Tambah') }}
            </a>
            @endcan
            <div class="card">
                <div class="card-header">{{ __('Data permissions') }}</div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('Nama') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->title }}</td>
                                <td>
                                    @can('permission_update')
                                    <a href="{{ route('permissions.edit', $permission) }}"
                                        class="btn btn-secondary btn-sm" data-coreui-toggle="tooltip"
                                        data-coreui-placement="top" data-coreui-original-title="{{ __('Edit') }}">
                                        <svg class="icon icon-sm">
                                            <use
                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
                                            </use>
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('permission_delete')
                                    <form action="{{ route('permissions.destroy', $permission) }}"
                                        style="display: inline-block;" method="POST"
                                        onsubmit="return confirm('{{ __('Hapus data ini?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit" data-coreui-toggle="tooltip"
                                            data-coreui-placement="top" data-coreui-original-title="{{ __('Hapus') }}">
                                            <svg class="icon icon-sm">
                                                <use
                                                    xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                </use>
                                            </svg>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
