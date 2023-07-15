@extends('layouts.master-dashboard')
@section('page-title', 'Monitoring Pekerjaan')
@section('active-contract','active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Monitoring Pekerjaan</li>
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
            <h6 class="card-title pt-1">Monitoring Pekerjaan</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <a href="{{route('buyer.contract-monitoring-create')}}" class="btn btn-success btn-xs mb-4">Tambah Pekerjaan</a>
            <div class="table-responsive">
                <table id="pekerjaanTable" class="table table-sm table-hovered table-bordered table-hover table-striped datatable2">
                    <thead>
                        <tr>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No.</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 50%;">Nama Pekerjaan</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 25%;">Nilai Pekerjaan (Rp)</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Tanggal Dibuat</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contracts as $contract)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
                            <td style="vertical-align: middle;">{{$contract->name}}</td>
                            <td class="text-right" style="vertical-align: middle;">@currency($contract->oe)</td>
                            <td class="text-center" style="vertical-align: middle;">{{date('d/m/Y', strtotime($contract->created_at))}}</td>
                            <td class="text-center" style="vertical-align: middle;"> <a href="{{route('buyer.contract-monitoring', $contract->id)}}" class="btn btn-primary btn-xs"><b>Rincian</b></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table><br>
            </div>
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

                        $('input', this.header()).on('keyup change clear', function() {
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