<div class="mb-3">
    <label for="name" class="form-label">{{ __('Nama') }}</label>
    <input type="text" name="name" class="form-control @error('name')
                                            is-invalid
                                        @enderror" value="{{ old('name', $user->name) }}">
    @error('name')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
<div class="mb-3">
    <label for="email" class="form-label">{{ __('Email') }}</label>
    <input type="email" name="email" class="form-control @error('email')
                                            is-invalid
                                        @enderror" value="{{ old('email', $user->email) }}">
    @error('email')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
<div class="mb-3">
    <label for="role" class="form-label">{{ __('Role') }}
        <span class="btn btn-info btn-sm select-all text-white">{{ __('Pilih semua') }}</span>
        <span class="btn btn-info btn-sm deselect-all text-white">{{ __('Hapus semua') }}</span>
    </label>
    <select id="role" name="roles[]" multiple="multiple" class="form-select @error('role')
    is-invalid
    @enderror">
        @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ (in_array($role->id, old('roles', [])) || isset($role) && $user->roles->contains($role->id)) ? 'selected' : '' }}>{{ $role->title }}</option>
        @endforeach
    </select>
    @error('roles')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
