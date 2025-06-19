<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="name" class="form-label">Nama Permission <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name"
                class="form-control form-control-sm @error('name') is-invalid @enderror"
                value="{{ old('name', $permission->name ?? '') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
