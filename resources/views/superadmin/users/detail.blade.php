@extends('layouts.master-dashboard')
@section('page-title', 'Detail Pengguna')
@section('superadmin-user', 'active')
@section('address')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Detail Pengguna</li>
    </ol>
@endsection
@push('styles')
    <style>
        .dataTables_scroll {
            margin-bottom: 10px;
        }
    </style>
@endpush
@section('dashboard')
    <div>
        <div class="card">
            <div class="card-header card-forestgreen">
                <h6 class="card-title pt-1">Detail Pengguna</h6>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i
                            class="fas fa-expand fa-xs icon-border-default"></i>
                    </button>
                    <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i
                            class="fas fa-minus fa-xs icon-border-yellow"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if ($usersdetail)
                    <div class="mb-4">
                        <a href="{{ route('superadmin.users-edit', ['id' => $usersdetail->id]) }}"
                            class="btn btn-success btn-xs">Edit Data Pengguna</a>
                            <form>
                                <div class="form-group row">
                                    <label for="number" class="col-sm-2 col-form-label">Nama Pengguna</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="text" value="{{ $usersdetail->user->name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="number" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="number" value="{{ $usersdetail->role->role }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="prosentase" class="col-sm-2 col-form-label">Departemen</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="prosentase"
                                            value="{{ $usersdetail->department ? $usersdetail->department->department : ' - ' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="number" class="col-sm-2 col-form-label">Unit</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="number"
                                            value="{{ $usersdetail->unit ? $usersdetail->unit->unit : ' - ' }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="director" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="director" value="{{ $usersdetail->email }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">Kontak</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="phone" value="{{ $usersdetail->phone }}"
                                            readonly>
                                    </div>
                                </div>
                            </form>
                    </div>
                @else
                    <p>User detail not found.</p>
                @endif
                
            </div>
        </div>
    </div>
@endsection
