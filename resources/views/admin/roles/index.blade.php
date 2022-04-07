@extends('layouts.admin')

@section('title', 'Role')

@section('breadcump')
    <li class="breadcrumb-item">
        <a href="#">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('roles.index') }}">{{ __('Role') }}</a>
    </li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Data roles') }}</div>
                <div class="card-body">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm mb-2">
                        <svg class="icon icon-sm me-1">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                        </svg>
                        {{ __('Tambah') }}
                    </a>
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>{{ __('Nama') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->title }}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-secondary btn-sm"
                                        data-coreui-toggle="tooltip" data-coreui-placement="top" data-coreui-original-title="{{ __('Edit') }}">
                                            <svg class="icon icon-sm">
                                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                                            </svg>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role) }}" style="display: inline-block;" method="POST"
                                        onsubmit="return confirm('{{ __('Hapus data ini?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit"
                                            data-coreui-toggle="tooltip" data-coreui-placement="top" data-coreui-original-title="{{ __('Hapus') }}">
                                                <svg class="icon icon-sm">
                                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                                                </svg>
                                            </button>
                                        </form>
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
