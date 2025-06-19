@extends('layouts.dashboard')

@php
    $page = 'master/customers';
    $action = 'index';
@endphp

@section('dashboard-content')
    <x-breadcrumbs>
        @if (Auth::user()->hasMenuPermission($activeMenu->id, 'create'))
            <a class="btn btn-sm rounded-4 btn-primary shadow-sm" href="{{ route('master_customers.create') }}">
                <i class="bi bi-plus-circle-fill"></i> Tambah Data
            </a>
        @endif
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12 d-flex">
            <div class="card rounded-4 w-100 m-0">
                <div class="card-body">
                    <table id="datatables" data-url="{{ route('master_customers.data') }}"
                        class="table table-sm align-middle table-striped table-bordered">
                        <thead class="bg-gd">
                            <tr>
                                <th>No</th>
                                <th>Kode Customer</th>
                                <th>Nama Customer</th>
                                <th>Pemilik</th>
                                <th>Alamat</th>
                                <th>ID Pasar</th>
                                <th>Nama Pasar</th>
                                <th>Tipe Outlet</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
