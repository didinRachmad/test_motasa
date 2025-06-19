<div class="row">
    {{-- Module Select --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="module" class="form-label">Module <span class="text-danger">*</span></label>
            <select name="module" id="module"
                class="form-select form-select-sm select2-module @error('module') is-invalid @enderror">
                <option></option>
                @foreach ($menus as $menu)
                    <option value="{{ $menu->route }}"
                        {{ old('module', $approval_route->module ?? '') == $menu->route ? 'selected' : '' }}>
                        {{ $menu->route }}
                    </option>
                @endforeach
            </select>
            @error('module')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Role Select --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
            <select name="role_id" id="role_id"
                class="form-select form-select-sm select2-role @error('role_id') is-invalid @enderror">
                <option></option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ old('role_id', $approval_route->role_id ?? '') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Assigned User Select --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="assigned_user_id" class="form-label">Assigned User (Opsional)</label>
            <select name="assigned_user_id" id="assigned_user_id"
                class="form-select form-select-sm select2-user @error('assigned_user_id') is-invalid @enderror">
                <option></option>
                @if (isset($approval_route) && $approval_route->assigned_user)
                    <option value="{{ $approval_route->assigned_user_id }}" selected>
                        {{ $approval_route->assigned_user->name }}
                    </option>
                @endif
            </select>
            @error('assigned_user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Sequence Input --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="sequence" class="form-label">Urutan Approval (Sequence) <span
                    class="text-danger">*</span></label>
            <input type="number" name="sequence" id="sequence"
                class="form-control form-control-sm @error('sequence') is-invalid @enderror"
                value="{{ old('sequence', $approval_route->sequence ?? '') }}" min="1">
            @error('sequence')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
