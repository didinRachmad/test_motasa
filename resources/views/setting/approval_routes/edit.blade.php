@extends('layouts.dashboard')

@php
    $page = 'setting/approval_routes';
    $action = 'edit';
@endphp

@section('dashboard-content')
    <x-breadcrumbs></x-breadcrumbs>
    <div class="card rounded-4 w-100 m-0">

        <form action="{{ route('approval_routes.update', $approval_route->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Konfigurasi Approval</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="module">Module <span class="text-danger">*</span></label>
                    <select name="module" id="module"
                        class="form-select form-select-sm select2-module @error('module') is-invalid @enderror" required>
                        <option value="">-- Pilih Module --</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->route }}"
                                {{ old('module', $approval_route->module) == $menu->route ? 'selected' : '' }}>
                                {{ $menu->route }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Role -->
                <div class="form-group mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select id="role_id" name="role_id" class="form-select form-select-sm">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id', $approval_route->role_id) == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="assigned_user_id">Assigned User (Opsional)</label>
                    <select id="assigned_user_id" name="assigned_user_id" class="form-select form-select-sm"
                        data-selected-id="{{ old('assigned_user_id', $approval_route->assigned_user_id) }}"
                        data-selected-email="{{ old('assigned_user_id', $approval_route->assigned_user_id) ? $approval_route->assignedUser->email : '' }}">
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="sequence">Urutan Approval (Sequence) <span class="text-danger">*</span></label>
                    <input type="number" name="sequence" id="sequence"
                        class="form-control form-control-sm @error('sequence') is-invalid @enderror"
                        value="{{ old('sequence', $approval_route->sequence) }}" min="1" required>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('approval_routes.index') }}" class="btn btn-sm rounded-4 btn-secondary">Batal <i
                        class="bi bi-x-square-fill"></i></a>
                <button type="submit" class="btn btn-sm btn-submit rounded-4 btn-primary">Simpan <i
                        class="bi bi-save-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
