@extends('layouts.master-dashboard')
@section('page-title', 'Monitoring Kontrak')
@section('monitoring-contract', 'active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Pegawai</li>
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
            <h6 class="card-title pt-1">Data Pegawai</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add">Tambah Data</a>
            </div>
            <div class="table-responsive">
                <table id="pekerjaanTable" class="table table-sm table-hovered table-bordered table-hover table-striped datatable2">
                    <thead>
                        <tr>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No.</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">NIK</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Nama</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">Status</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $user->nik }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $user->name }}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if ($user->status == 1)
                                <span class="badge badge-success">Aktif</span>
                                @elseif ($user->status_id == 2)
                                <span class="badge badge-danger">Non-aktif</span>
                                @endif
                            </td>
                            <td class="text-center" style="vertical-align: middle;"> <a href="{{ route('superadmin.users-detail', ['id' => $user->id]) }}" class="btn btn-primary btn-xs"><b>Detail</b></a>
                        </tr>
                        @endforeach
                    </tbody>
                </table><br>
            </div>
        </div>
    </div>
</div>

<!-- CREATE -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="d-inline" action="{{ route('superadmin.users-store') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>
                        @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>      
                        <div class="col-sm-10">
                          <select id="role_id" name="role_id" data-reorder="1" class="form-control form-control-sm select2bs4 @error('role_id') is-invalid @enderror" style="width: 100%;" data-placeholder="-- Pilih --">
                            <option value=''></option>
                            @foreach($roles as $role)   
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>  
                        </div>                  
                        @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Departemen</label>      
                        <div class="col-sm-10">
                          <select id="department_id" name="department_id" data-reorder="1" class="form-control form-control-sm select2bs4 @error('department_id') is-invalid @enderror" style="width: 100%;" data-placeholder="-- Pilih --">
                            <option value=''></option>
                            @foreach($departments as $department)   
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>  
                        </div>                  
                        @error('department_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-2 col-form-label">Unit</label>      
                        <div class="col-sm-10">
                          <select id="unit_id" name="unit_id" data-reorder="1" class="form-control form-control-sm select2bs4 @error('unit_id') is-invalid @enderror" style="width: 100%;" data-placeholder="-- Pilih --">
                            <option value=''></option>
                            @foreach($units as $unit)   
                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                            @endforeach
                        </select>  
                        </div>                  
                        @error('unit_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        @error('phone')
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
@push('script')
<script type="text/javascript">
    // DataTable
    $(function() {
        $('#pekerjaanTable .second-row th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text"  class="form-control" placeholder="" />');
        });
        $(document).ready(function() {
            $('.datatable2').DataTable({
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10', '25', '50', '100', 'All']
                ],
                ordering: false,
                scrollY: '500px',
                scrollCollapse: true,
                pageLength: 100,
                initComplete: function() {
                    this.api().columns([0, 1, 2, 3, 4, 5]).every(function() {
                        var that = this;

                        $('input', this.header()).on('keyup change clear',
                            function() {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            });
                    });
                },
            });
        });
    });
</script>
@endpush