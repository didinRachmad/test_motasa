@extends('layouts.dashboard')

@php
    $page = 'setting/users';
    $action = 'create';
@endphp

@section('dashboard-content')
    <x-breadcrumbs></x-breadcrumbs>
    <div class="card rounded-4 w-100 m-0">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h5 class="card-title" id="addModalLabel">Tambah Data</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">Nama <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control form-control-sm @error('name') is-invalid @enderror" required
                        value="{{ old('name') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email"
                        class="form-control form-control-sm @error('email') is-invalid @enderror" required
                        value="{{ old('email') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password"
                        class="form-control form-control-sm @error('password') is-invalid @enderror" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror" required>
                </div>

                <!-- Role -->
                <div class="form-group mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select id="role_id" name="role_id"
                        class="form-select form-select-sm @error('role_id') is-invalid @enderror">
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
