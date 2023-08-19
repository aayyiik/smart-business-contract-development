@extends('layouts.master-dashboard')
@section('page-title', 'Monitoring Kontrak')
@section('superadmin-vendors', 'active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Vendor</li>
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
            <h6 class="card-title pt-1">Data Vendor</h6>
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
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Nama Vendor</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No SAP</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No EPROC</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">Kontak</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Alamat</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">PIC Vendor</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $v)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $v->vendor }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $v->no_sap }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $v->no_eproc }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $v->phone }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $v->address }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $v->userDetail->user->name }}</td>
                            <td class="text-center" style="vertical-align: middle;"> 
                                <a href="{{ route('superadmin.vendors-edit', $v->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                            </td>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="d-inline" action="{{ route('superadmin.vendors-store') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group row">
                        <label for="vendor" class="col-sm-2 col-form-label">Vendor</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="vendor" name="vendor">
                        </div>
                        @error('vendor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="vendor" class="col-sm-2 col-form-label">No SAP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_sap" name="no_sap">
                        </div>
                        @error('no_sap')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="vendor" class="col-sm-2 col-form-label">No Eproc</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_eproc" name="no_eproc">
                        </div>
                        @error('no_eproc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="vendor" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="vendor" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">PIC Vendor</label>      
                        <div class="col-sm-10">
                          <select id="user_detail_id" name="user_detail_id" data-reorder="1" class="form-control form-control-sm select2bs4 @error('user_detail_id') is-invalid @enderror" style="width: 100%;" data-placeholder="-- Pilih --">
                            <option value=''></option>
                            @foreach($usersdetail as $ud)   
                                <option value="{{ $ud->id }}">{{ $ud->user->nik }} - {{ $ud->user->name}}</option>
                            @endforeach
                        </select>  
                        </div>                  
                        @error('user_detail_id')
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