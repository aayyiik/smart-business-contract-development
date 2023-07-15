@extends('layouts.master-dashboard')
@section('page-title', 'Detail Kontrak')
@section('active-contract', 'active')
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
                <h6 class="card-title pt-1">Edit Data Pengguna</h6>
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
                <form action="{{ route('superadmin.users-update', ['id' => $usersdetail->id]) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="text" value="{{ $usersdetail->user->name }}">
                            <input type="hidden" name="user_id" value="{{ $usersdetail->user->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="text" value="{{ $usersdetail->role->role }}" name="role_id">
                            <input type="hidden"value="{{ $usersdetail->role->id }}" name="role_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="prosentase" class="col-sm-2 col-form-label">Departemen</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="prosentase" value="{{ $usersdetail->department ? $usersdetail->department->department : ' - ' }}">
                            <input type="hidden" value="{{ $usersdetail->department ? $usersdetail->department->id : null }}" name="department_id">
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Unit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="number" value="{{ $usersdetail->unit ? $usersdetail->unit->unit : ' - ' }}">
                            <input type="hidden" value="{{ $usersdetail->unit ? $usersdetail->unit->unit : null }}" name="unit_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="director" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="director" value="{{ $usersdetail->email }}" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" value="{{ $usersdetail->phone }}" name="phone">
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
