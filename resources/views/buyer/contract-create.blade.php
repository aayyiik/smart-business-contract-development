@extends('layouts.master-dashboard')
@section('page-title', 'Tambah Pekerjaan')
@section('active-contract','active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tambah Pekerjaan</li>
</ol>
@endsection
@section('dashboard')
<div>
    <div class="card">
        <div class="card-header card-forestgreen">
            <h6 class="card-title">Tambah Pekerjaan</h6>
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
            <form action="{{route('buyer.contract-monitoring-store')}}" method="POST">
                @csrf
                @method('post')
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="name">Nama Pekerjaan<span class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{old('name')}}" id="name" name="name" >
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="oe">Nilai Kontrak<span class="required">*</span></label>
                    <input type="int" class="form-control form-control-sm @error('oe') is-invalid @enderror" value="{{old('oe')}}" id="oe" name="oe">
                    @error('oe')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="template_id">Template<span class="required">*</span></label>
                    <select id="template_id" name="template_id" class="form-control form-control-sm select2bs4 @error('template_id') is-invalid @enderror" style="width: 100%;" data-placeholder="-- Pilih --">
                        <option value=''></option>
                        @foreach($templates as $template)
                        @if(old('template_id'))
                        <option value="{{ $template->id }}" {{ old('template_id') ? 'selected' : '' }}>{{ $template->template }}</option>
                        @else
                        <option value="{{ $template->id }}">{{ $template->template}}</option>
                        @endif
                        @endforeach
                    </select>
                    @error('template_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="vendor">Vendor<span class="required">*</span></label>
                    <select id="vendor" name="vendor[]" multiple data-reorder="1" class="form-control form-control-sm select2bs4 @error('vendor') is-invalid @enderror" style="width: 100%;" data-placeholder="-- Pilih --">
                        <option value=''></option>
                        @foreach($vendor as $rekanan)   
                        @if(old('vendor'))
                        <option value="{{ $rekanan->id }}" {{ in_array($rekanan->id, old('vendor')) ? 'selected' : '' }}>{{ $rekanan->vendor }} ({{$rekanan->no_sap}})</option>
                        @else
                        <option value="{{ $rekanan->id }}">{{ $rekanan->vendor }} ({{$rekanan->no_sap}})</option>
                        @endif
                        @endforeach
                    </select>
                    @error('vendor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="row justify-content-end mr-0">
                    <button type="submit" class="btn btn-success btn-xs text-right" data-toggle="confirmation" data-placement="left">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    jQuery("select").each(function() {
        $this = jQuery(this);
        if ($this.attr('data-reorder')) {
            $this.on('select2:select', function(e) {
                var elm = e.params.data.element;
                $elm = jQuery(elm);
                $t = jQuery(this);
                $t.append($elm);
                $t.trigger('change.select2');
            });
        }
        $this.select2();
    });
</script>
@endpush