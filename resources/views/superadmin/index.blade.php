@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Super Admin Dashboard') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Admin Unit -->
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('superadmin.units') }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 border rounded bg-light menu-item">
                                        <i class="bi bi-box-seam fs-3 me-3"></i>
                                        <div>
                                            <h4 class="mb-0">Unit</h4>
                                            <p class="mb-0 text-muted">Manage units</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Admin User -->
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('admin.users') }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 border rounded bg-light menu-item">
                                        <i class="bi bi-person-circle fs-3 me-3"></i>
                                        <div>
                                            <h4 class="mb-0">User</h4>
                                            <p class="mb-0 text-muted">Manage users</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Roles -->
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('roles') }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 border rounded bg-light menu-item">
                                        <i class="bi bi-shield-lock fs-3 me-3"></i>
                                        <div>
                                            <h4 class="mb-0">Roles</h4>
                                            <p class="mb-0 text-muted">Manage roles and permissions</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-css')
    <style>
        .menu-item {
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .menu-item:hover {
            background-color: #e9ecef;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
