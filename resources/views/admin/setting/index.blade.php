@extends('layouts.admin')

@section('title', 'Settings')

@section('breadcump')
    <li class="breadcrumb-item">
        <a href="#">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('settings.index') }}">{{ __('Settings') }}</a>
    </li>
@endsection

@section('main')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('General Data') }}</div>
                    <div class="card-body">
                        <form action="{{ route('settings.general.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="web_name" class="form-label">{{ __('Web Name') }}</label>
                                <input type="text" name="web_name" class="form-control @error('web_name')
                                            is-invalid
                                        @enderror" value="{{ old('web_name', $settingData->web_name) }}">
                                @error('web_name')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" id="register_enabled" type="checkbox" name="register_enabled" {{ ($settingData->register_enabled == 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="register_enabled">{{ __('User Registration') }}</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" id="reset_password_enabled" type="checkbox" name="reset_password_enabled" {{ ($settingData->reset_password_enabled == 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reset_password_enabled">{{ __('User Forgot Password') }}</label>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-primary px-3">
                                    <b>{{ __('Update') }}</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Logo') }}</div>
                    <div class="card-body">
                        <form action="{{ route('settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if ($settingData->logo == null)
                                <img src="{{ $settingData->logo }}" alt="logo" width="256" class="mb-2 img-thumbnail">
                            @else
                                <img src="{{ asset($settingData->logo) }}" alt="logo" width="256" class="mb-2 img-thumbnail">
                            @endif
                            <div class="mb-3">
                                <label for="logo" class="form-label">{{ __('Logo') }}</label>
                                <input type="file" name="logo" class="form-control @error('logo')
                                            is-invalid
                                        @enderror" value="{{ old('logo', $settingData->logo) }}">
                                @error('logo')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-primary px-3">
                                    <b>{{ __('Update') }}</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
