@extends('layouts.dashboard')

@php
    $page = 'setting/approval_routes';
    $action = 'create';
@endphp

@section('dashboard-content')
    <x-breadcrumbs></x-breadcrumbs>
    <div class="card rounded-4 w-100 m-0">
        <form action="{{ route('approval_routes.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h5 class="card-title">Tambah Data</h5>
            </div>
            <div class="card-body">
                <!-- Module Select -->
                <div class="form-group mb-3">
                    <label for="module">Module <span class="text-danger">*</span></label>
                    <select name="module" id="module" class="form-select form-select-sm select2-module" required>
                        <option></option> <!-- Placeholder -->
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->route }}" @selected(old('module') == $menu->route)>
                                {{ $menu->route }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Role Select -->
                <div class="form-group mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select name="role_id" id="role_id"
                        class="form-select form-select-sm select2-role @error('role_id') is-invalid @enderror" required>
                        <option></option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- User Select -->
                <div class="form-group mb-3">
                    <label for="assigned_user_id">Assigned User (Opsional)</label>
                    <select name="assigned_user_id" id="assigned_user_id"
                        class="form-select form-select-sm select2-user @error('assigned_user_id') is-invalid @enderror">
                        <option></option>
                    </select>
                </div>

                {{-- Urutan Approval --}}
                <div class="form-group mb-3">
                    <label for="sequence">Urutan Approval (Sequence) <span class="text-danger">*</span></label>
                    <input type="number" name="sequence" id="sequence"
                        class="form-select form-select-sm @error('sequence') is-invalid @enderror"
                        value="{{ old('sequence') }}" min="1" required>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('approval_routes.index') }}" class="btn btn-sm rounded-4 btn-secondary">
                    Batal <i class="bi bi-x-square-fill"></i>
                </a>
                <button type="submit" class="btn btn-sm rounded-4 btn-primary">
                    Simpan <i class="bi bi-save-fill"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
