@extends('layouts.dashboard')

@php
    $page = 'setting/menu';
    $action = 'index';
@endphp

@section('dashboard-content')
    <x-breadcrumbs>
        @if (Auth::user()->hasMenuPermission($menu_id->id, 'create'))
            <a class="btn btn-sm rounded-4 btn-primary shadow-sm" href="{{ route('menus.create') }}">
                <i class="bi bi-plus-circle-fill"></i> Tambah Data
            </a>
        @endif
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12 d-flex">
            <div class="card rounded-4 w-100 m-0">
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="datatables" class="table table-sm align-middle table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>title</th>
                                    <th>Route</th>
                                    <th>Icon</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $key => $menu)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $menu->title }}</td>
                                        <td>{{ $menu->route }}</td>
                                        <td>{{ $menu->icon }}</td>
                                        <td>{{ $menu->order }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-nowrap gap-1">
                                                {{-- <div class="btn btn-sm rounded-4 btn-group" role="group"> --}}
                                                @if (Auth::user()->hasMenuPermission($menu_id->id, 'edit'))
                                                    <a href="{{ route('menus.edit', $menu->id) }}"
                                                        class="btn btn-sm rounded-4 btn-warning" data-bs-toggle="tooltip"
                                                        data-bs-title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->hasMenuPermission($menu_id->id, 'destroy'))
                                                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST"
                                                        class="form-delete d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm rounded-4 btn-danger btn-delete"
                                                            data-bs-toggle="tooltip" data-bs-title="Hapus">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
