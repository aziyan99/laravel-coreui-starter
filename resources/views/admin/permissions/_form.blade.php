<div class="mb-2">
    <label for="title" class="form-label">{{ __('Title') }}</label>
    <input type="text" name="title" class="form-control @error('title')
                                            is-invalid
                                        @enderror" value="{{ old('title', $permission->title) }}">
    @error('title')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
