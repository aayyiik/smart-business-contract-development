@extends('layouts.master-dashboard')
@section('page-title', 'Monitoring Pekerjaan')
@section('active-contract', 'active')
@section('address')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Detail Pekerjaan</li>
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
                <h6 class="card-title pt-1">Detail Pekerjaan</h6>
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
                <form>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Pekerjaan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" value="{{ $contract->name }}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="oe" class="col-sm-2 col-form-label">Nilai Pekerjaan (Rp)</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="oe" value="@currency($contract->oe)" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-sm-2 col-form-label">Tanggal Dibuat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="date"
                                value="{{ date('d/m/Y', strtotime($contract->created_at)) }}" readonly>
                        </div>
                    </div>
                    <a href="{{ route('buyer.contract-delete', $contract->id) }}" class="btn btn-danger btn-xs"><b>Batal
                            Kontrak</b></a>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-forestgreen">
                <h6 class="card-title pt-1">Kontrak</h6>
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
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-sm table-hovered table-bordered table-hover table-striped datatable2">
                        <thead>
                            <tr>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">No.</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 20%;">Vendor</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 20%;">Nomor Kontrak</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Prosentase</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Nilai Kontrak (Rp)
                                </th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 20%;">Posisi</th>
                                <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contract_vendor as $contract)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;" class="text-uppercase">{{ $contract->vendor }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $contract->pivot->no_dof }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        {{ $contract->pivot->prosentase }}%</td>
                                    <td class="text-center" style="vertical-align: middle;">@currency($contract->pivot->contract_amount)
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        @if ($contract->pivot->status_id == 1)
                                            <span class="badge badge-success">REVIEW VENDOR</span>
                                        @elseif ($contract->pivot->status_id == 2)
                                            <span class="badge badge-success">REVIEW BUYER</span>
                                        @elseif ($contract->pivot->status_id == 3)
                                            <span class="badge badge-success">REVIEW HUKUM</span>
                                        @elseif ($contract->pivot->status_id == 4)
                                            <span class="badge badge-success">APPROVE HUKUM</span>
                                        @elseif ($contract->pivot->status_id == 5)
                                            <span class="badge badge-success">REVIEW ASSISTANT VICE PRESIDENT</span>
                                        @elseif ($contract->pivot->status_id == 6)
                                            <span class="badge badge-success">VICE PRESIDENT</span>
                                        @elseif ($contract->pivot->status_id == 7)
                                            <span class="badge badge-success">REVIEW SENIOR VICE PRESIDENT</span>
                                        @elseif ($contract->pivot->status_id == 8)
                                            <span class="badge badge-success">REVIEW DIREKTUR KEUANGAN DAN UMUM</span>
                                        @elseif ($contract->pivot->status_id == 9)
                                            <span class="badge badge-success">APPROVED</span>
                                        @elseif ($contract->pivot->status_id == 10)
                                            <span class="badge badge-success">REVIEW REKANAN DAN TTD</span>
                                        @elseif ($contract->pivot->status_id == 11)
                                            <span class="badge badge-success">FINAL KONTRAK</span>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"> <a
                                            href="{{ route('buyer.contract-detail', ['contract' => $contract->pivot->contract_id, 'vendor' => $contract->pivot->vendor_id]) }}"
                                            class="btn btn-primary btn-xs"><b>Rincian</b></a>
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
