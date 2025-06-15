@extends('layouts.dashboard')

@php
    $page = 'setting/users';
    $action = 'edit';
@endphp

@section('dashboard-content')
    <x-breadcrumbs></x-breadcrumbs>
    <div class="card rounded-4 w-100 m-0">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Data</h5>
            </div>
            <div class="card-body">
                {{-- Nama --}}
                <div class="form-group mb-3">
                    <label for="name">Nama <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required>
                </div>

                {{-- Email --}}
                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email"
                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- Role -->
                <div class="form-group mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select id="role_id" name="role_id"
                        class="form-select form-select-sm @error('role_id') is-invalid @enderror">
                        @if (isset($user->roles))
                            <option value="{{ $user->roles->first()?->id }}" selected>
                                {{ $user->roles->first()?->name }}
                            </option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('users.index') }}" class="btn btn-sm rounded-4 btn-secondary">Batal <i
                        class="bi bi-x-square-fill"></i></a>
                <button type="submit" class="btn btn-sm btn-submit rounded-4 btn-primary">Simpan <i
                        class="bi bi-save-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
