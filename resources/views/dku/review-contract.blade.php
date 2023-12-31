@extends('layouts.master-dashboard')
@section('page-title', 'Review Kontrak')
@section('review-contract', 'active')
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
                    <a href="#" class="btn btn-danger btn-xs" data-toggle="modal"
                        data-target="#kembalikan">Kembalikan</a>
                    <a href="#" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#acc">ACC Draft
                        Kontrak</a>
                </div>
                <form>
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Nomor Kontrak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="number"
                                value="{{ $contracts->pivot->number }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Nama Pekerjaan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="number" value="{{ $contract->name }}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="prosentase" class="col-sm-2 col-form-label">Prosentase</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="prosentase"
                                value="{{ $contracts->pivot->prosentase }}%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nilai_kontrak" class="col-sm-2 col-form-label">Nilai Kontrak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nilai_kontrak" value="@currency($contracts->pivot->nilai_kontrak)"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="director" class="col-sm-2 col-form-label">Direktur</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="director"
                                value="{{ $contracts->pivot->director }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" value="{{ $contracts->pivot->phone }}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address"
                                value="{{ $contracts->pivot->address }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Posisi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="status"
                                @if ($contracts->pivot->status_id == 1) value="REVIEW VENDOR"
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
                <embed src="{{ asset($contracts->pivot->filename) }}.pdf" width="100%" height="600px"
                    type="application/pdf">
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
                    <form class="d-inline"
                        action="{{ route('avp.contract-return', ['contract' => $contracts->pivot->contract_id, 'vendor' => $contracts->pivot->vendor_id]) }}"
                        method="POST">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control z-depth-1" name="description" id="description" rows="3"></textarea>
                            @error('description')
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

    <!-- ACC FINAL -->
    <div class="modal fade" id="acc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ACC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="d-inline"
                        action="{{ route('dku.contract-approval', ['contract' => $contracts->pivot->contract_id, 'vendor' => $contracts->pivot->vendor_id]) }}"
                        method="POST">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control z-depth-1" name="description" id="description" rows="3"></textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                    <button class="btn btn-warning btn-xs" type="submit">ACC</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
