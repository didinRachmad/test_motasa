@extends('layouts.dashboard')

@php
    $page = 'setting/approval_routes';
    $action = 'index';
@endphp

@section('dashboard-content')
    <x-breadcrumbs>
        @if (Auth::user()->hasMenuPermission($activeMenu->id, 'create'))
            <a class="btn btn-sm rounded-4 btn-primary shadow-sm" href="{{ route('approval_routes.create') }}">
                <i class="bi bi-plus-circle-fill"></i> Tambah Data
            </a>
        @endif
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12 d-flex">
            <div class="card rounded-4 w-100 m-0">
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="datatables" data-url="{{ route('approval_routes.data') }}"
                            class="table table-sm align-middle table-striped table-bordered">
                            <thead class="bg-gd">
                                <tr>
                                    <th>No</th>
                                    <th>Module</th>
                                    <th>Role</th>
                                    <th>Sequence</th>
                                    <th>Assigned User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
