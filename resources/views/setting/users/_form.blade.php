<div class="row">
    {{-- Nama --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="name">Nama <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name"
                class="form-control form-control-sm @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name ?? '') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Email --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email"
                class="form-control form-control-sm @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email ?? '') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Password --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="password">Password <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password"
                class="form-control form-control-sm @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Konfirmasi Password --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Role --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="role_id">Role <span class="text-danger">*</span></label>
            <select id="role_id" name="role_id"
                class="form-select form-select-sm @error('role_id') is-invalid @enderror">
                <option value="">-- Pilih Role --</option>
                @php
                    $selectedRoleId = old('role_id', isset($user) ? $user->roles->first()->id ?? '' : '');
                @endphp

                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $selectedRoleId == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
