<div class="mb-3">
    <label for="title" class="form-label">{{ __('Title') }}</label>
    <input type="text" name="title" class="form-control @error('title')
                                            is-invalid
                                        @enderror" value="{{ old('title', $role->title) }}">
    @error('title')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
<div class="mb-3">
    <label for="permission" class="form-label">{{ __('Permission') }}</label>
    <select id="permission" name="permissions[]" multiple="multiple" class="form-select @error('title')
    is-invalid
    @enderror">
        @foreach ($permissions as $permission)
        <option value="{{ $permission->id }}" {{ (in_array($permission->id, old('permissions', [])) || isset($role) && $role->permissions->contains($permission->id)) ? 'selected' : '' }}>{{ $permission->title }}</option>
        @endforeach
    </select>
    @error('permission')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
