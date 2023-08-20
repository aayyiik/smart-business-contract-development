@extends('layouts.master-dashboard')
@section('page-title', 'Detail Kontrak')
@section('active-contract', 'active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Detail Kontrak</li>
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
            <h6 class="card-title pt-1">Detail Kontrak</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group row">
                    <label for="number" class="col-sm-2 col-form-label">Nomor Kontrak</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="number" value="{{ $contracts->pivot->no_dof }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="number" class="col-sm-2 col-form-label">Nama Pekerjaan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="number" value="{{ $contract->name }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="prosentase" class="col-sm-2 col-form-label">Prosentase</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="prosentase" value="{{ $contracts->pivot->prosentase }}%" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nilai_kontrak" class="col-sm-2 col-form-label">Nilai Kontrak</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nilai_kontrak" value="@currency($contracts->pivot->contract_amount)" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="director" class="col-sm-2 col-form-label">Direktur</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="director" value="{{ $contracts->pivot->director }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Kontak</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="phone" value="{{ $contracts->pivot->phone }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" value="{{ $contracts->pivot->address }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Posisi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="status" @if ($contracts->pivot->status_id == 1) value="REVIEW VENDOR"
                        @elseif ($contracts->pivot->status_id == 2)value="REVIEW BUYER"
                        @elseif ($contracts->pivot->status_id == 3)value="REVIEW HUKUM"
                        @elseif ($contracts->pivot->status_id == 4)value="APPROVE HUKUM"
                        @elseif ($contracts->pivot->status_id == 5)value="REVIEW ASSISTANT VICE PRESIDENT"
                        @elseif ($contracts->pivot->status_id == 6)value="REVIEW VICE PRESIDENT"
                        @elseif ($contracts->pivot->status_id == 7)value="REVIEW SENIOR VICE PRESIDENT"
                        @elseif ($contracts->pivot->status_id == 8)value="REVIEW DIREKTUR KEUNGAN DAN UMUM"
                        @elseif ($contracts->pivot->status_id == 9)value="APPROVED"
                        @elseif ($contracts->pivot->status_id == 10)value="REVIEW REKANAN DAN TTD"
                        @elseif ($contracts->pivot->status_id == 11)value="FINAL KONTRAK" @endif
                        readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header card-forestgreen">
            <h6 class="card-title pt-1">Review Hukum</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-sm table-hovered table-bordered table-hover table-striped datatable2">
                    <thead>
                        <tr>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 5%;">No.</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 20%;">Nama Reviewer</th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 65%;">Hasil Review
                            </th>
                            <th class="text-center pr-0" style="vertical-align: middle; width: 10%;">Tanggal Dibuat
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($review_hukum as $hukum)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                            <td style="vertical-align: middle;">{{ $hukum->name }}</td>
                            <td style="vertical-align: middle;">{{ $hukum->review_contract }}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                {{ date('d/m/Y', strtotime($hukum->created_at)) }}
                            </td>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header card-forestgreen">
            <h6 class="card-title pt-1">Draft Kontrak</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <embed src="{{ asset($contracts->pivot->filename) }}.pdf" width="100%" height="600px" type="application/pdf">
        </div>
    </div>
</div>

<!-- Kembalikan -->
<div class="modal fade" id="kembalikan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kembalikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="d-inline" action="{{ route('legal.contract-return', ['contract' => $contracts->pivot->contract_id, 'vendor' => $contracts->pivot->vendor_id]) }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label for="review_contract">Deskripsi</label>
                        <textarea class="form-control z-depth-1" name="review_contract" id="review_contract" rows="3"></textarea>
                        @error('review_contract')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                <button class="btn btn-danger btn-xs" type="submit">Kembalikan</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
