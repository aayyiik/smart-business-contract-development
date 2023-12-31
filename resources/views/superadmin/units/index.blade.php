@extends('layouts.master-dashboard')
@section('page-title', 'Daftar Units')
@section('superadmin-units', 'active')
@section('address')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Units</li>
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
                <h6 class="card-title pt-1">Data Unit</h6>
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
                <div class="mb-3">
                    <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add">Tambah Data</a>
                </div>
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-sm table-hovered table-bordered table-hover table-striped datatable2">
                        <thead>
                            <tr>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No.</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Nama</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $u)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $u->unit }}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <a href="{{ route('superadmin.units-edit', $u->id) }}" class="btn btn-warning"><i
                                                class="fa fa-edit"></i></a>
                                        {{-- <a href="{{ route('superadmin.units-delete', $u->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table><br>
                </div>
            </div>
        </div>
    </div>

    {{-- CREATE --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="d-inline" action="{{ route('superadmin.units-store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="form-group row">
                            <label for="unit" class="col-sm-2 col-form-label">Unit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="unit" name="unit">
                            </div>
                            @error('unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                    <button class="btn btn-warning btn-xs" type="submit">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
