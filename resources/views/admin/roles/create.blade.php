@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcump')
<li class="breadcrumb-item">
    <a href="#">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('roles.index') }}">{{ __('Role') }}</a>
</li>
<li class="breadcrumb-item active">
    <a href="javascript:void(0);">{{ __('Tambah role') }}</a>
</li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-header">{{ __('Tambah role') }}</div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        @include('admin.roles._form')
                        <div class="mb-2">
                            <button class="btn btn-primary btn-sm">
                                <svg class="icon icon-sm me-1">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                </svg>
                                {{ __('Simpan') }}
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                                <svg class="icon icon-sm me-1">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}">
                                    </use>
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

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#permission').select2();
    });
    $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('#permission')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
    });
    $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('#permission')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
    });
</script>
@endpush
