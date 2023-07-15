@extends('layouts.master-dashboard')
@section('page-title', 'Rincian Kontrak')
@section('active-contract','active')
@section('dashboard')
<div>
    <div class="card">
        <div class="card-header card-forestgreen">
            <h6 class="card-title">Detail Kontrak</h6>
            <!-- tool -->
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i class="fas fa-expand fa-xs icon-border-default"></i>
                </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i class="fas fa-minus fa-xs icon-border-yellow"></i>
                </button>
            </div>
            <!-- /tool -->
        </div>
        <div class="card-body">
            <form action="{{route('contract.vendor-store', ['tender' => $tender->id])}}" method="POST">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-xs" for="number">Nomor Kontrak<span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('number') is-invalid @enderror" value="{{old('number')}}" id="number" name="number" placeholder="Uraian number">
                            @error('number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-xs" for="director">Direktur<span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('director') is-invalid @enderror" value="{{old('director')}}" id="director" name="director" placeholder="director">
                            @error('director')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-xs" for="phone">Kontak<span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror" value="{{old('phone')}}" id="phone" name="phone" placeholder="phone">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-xs" for="address">Alamat<span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('address') is-invalid @enderror" value="{{old('address')}}" id="address" name="address" placeholder="address">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end mr-0">
                    <button type="submit" class="btn btn-success btn-xs text-right" data-toggle="confirmation" data-placement="left">Save</button>
                </div>
            </form>
        </div>
    </div>  
</div>
@endsection