@extends('layouts.admin')

@section('title', 'Edit pengguna')

@section('breadcump')
<li class="breadcrumb-item">
    <a href="#">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('users.index') }}">{{ __('Pengguna') }}</a>
</li>
<li class="breadcrumb-item active">
    <a href="javascript:void(0);">{{ __('Edit pengguna') }}</a>
</li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-header">{{ __('Edit pengguna') }}</div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.users._form')
                        <div class="mb-2">
                            <button class="btn btn-primary px-3">
                                <b>{{ __('Simpan') }}</b>
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-default px-3">
                                <b>{{ __('Kembali') }}</b>
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
        $('#role').select2();
    });
    $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('#role')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
    });
    $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('#role')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
    });
</script>
@endpush
