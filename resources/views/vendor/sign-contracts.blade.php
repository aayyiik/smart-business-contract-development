@extends('layouts.master-dashboard')
@section('page-title', 'Review Kontrak')
@section('review-contract', 'active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tanda Tangan Kontrak</li>
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
            <h6 class="card-title pt-1">Tanda Tangan Kontrak</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pekerjaanTable" class="table table-sm table-hovered table-bordered table-hover table-striped datatable2">
                    <thead>
                        <tr>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No.</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Nomor Kontrak</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 30%;">Nama Pekerjaan</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Prosentase
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Nilai Kontrak (Rp)
                            </th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 15%;">Posisi</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $contract)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $contract->pivot->number }}</td>
                            <td style="vertical-align: middle;">{{ $contract->name }}</td>
                            <td class="text-center" style="vertical-align: middle;">{{ $contract->pivot->prosentase }}%
                            </td>
                            <td class="text-right" style="vertical-align: middle;">@currency($contract->pivot->nilai_kontrak)
                            </td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if ($contract->pivot->status_id == 1)
                                <span class="badge badge-success">VENDOR</span>
                                @elseif ($contract->pivot->status_id == 2)
                                <span class="badge badge-success">BUYER</span>
                                @elseif ($contract->pivot->status_id == 3)
                                <span class="badge badge-success">HUKUM</span>
                                @elseif ($contract->pivot->status_id == 4)
                                <span class="badge badge-success">APPROVE HUKUM</span>
                                @elseif ($contract->pivot->status_id == 5)
                                <span class="badge badge-success">ASSISTANT VICE PRESIDENT</span>
                                @elseif ($contract->pivot->status_id == 6)
                                <span class="badge badge-success">VICE PRESIDENT</span>
                                @elseif ($contract->pivot->status_id == 7)
                                <span class="badge badge-success">SENIOR VICE PRESIDENT</span>
                                @elseif ($contract->pivot->status_id == 8)
                                <span class="badge badge-success">DIREKTUR KEUANGAN DAN UMUM</span>
                                @elseif ($contract->pivot->status_id == 9)
                                <span class="badge badge-success">APPROVE</span>
                                @elseif ($contract->pivot->status_id == 10)
                                <span class="badge badge-success">VENDOR TANDA TANGAN KONTRAK</span>
                                @elseif ($contract->pivot->status_id == 11)
                                <span class="badge badge-success">FINAL KONTRAK</span>
                                @endif
                            </td>
                            <td class="text-center" style="vertical-align: middle;"> <a href="{{ route('vendor.sign-contract', ['contract' => $contract->pivot->contract_id, 'vendor' => $contract->pivot->vendor_id]) }}" class="btn btn-primary btn-xs"><b>Rincian</b></a>
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