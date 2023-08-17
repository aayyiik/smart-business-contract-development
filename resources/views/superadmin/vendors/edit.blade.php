@extends('layouts.master-dashboard')
@section('page-title', 'Detail Kontrak')
@section('active-contract', 'active')
@section('address')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Detail Vendor</li>
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
                <h6 class="card-title pt-1">Edit Data Vendor</h6>
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
                <form action="{{ route('superadmin.vendors-update', ['id' => $vendors->id]) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Nama PIC</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="text"
                                value="{{ $vendors->userDetail->user->name }}" readonly>
                            <input type="hidden" name="user_detail_id" value="{{ $vendors->user_detail_id }}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Vendor</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="text" value="{{ $vendors->vendor }}"
                                name="vendor">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="director" class="col-sm-2 col-form-label">No Eproc</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="director" value="{{ $vendors->no_eproc }}"
                                name="no_eproc">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">No SAP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" value="{{ $vendors->no_sap }}"
                                name="no_sap">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="director" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="director" value="{{ $vendors->address }}"
                                name="address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" value="{{ $vendors->phone }}"
                                name="phone">
                        </div>
                    </div>
                    <div class="row justify-content-end mr-0">
                        <button type="submit" class="btn btn-success btn-xs text-right" data-toggle="confirmation"
                            data-placement="left">Update</button>
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
