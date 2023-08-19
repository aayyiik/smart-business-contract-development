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
                    <label class="col-form-label col-form-label-xs" for="no_sp">No SP<span class="required">*</span></label>
                    <input type="int" class="form-control form-control-sm @error('no_sp') is-invalid @enderror" value="{{old('no_sp')}}" id="no_sp" name="no_sp">
                    @error('no_sp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="date_sp">Tanggal Penerbitan SP<span class="required">*</span></label>
                    <input type="date" class="form-control form-control-sm @error('date_sp') is-invalid @enderror" value="{{old('date_sp')}}" id="date_sp" name="date_sp">
                    @error('date_sp')
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
                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label class="col-form-label col-form-label-xs" for="vendor_id">Vendor<span
                                class="required">*</span></label>
                        <select class="form-control form-control-sm" name="vendor_id[]"
                            data-placeholder="-- Pilih --">
                            <option value=''></option>
                            @foreach ($vendor as $rekanan)
                                <option value="{{ $rekanan->id }}">{{ $rekanan->vendor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-xs" for="prosentase">Prosentase<span
                                class="required">*</span></label>
                        <input type="double" class="form-control form-control-sm" id="prosentase"
                            name="prosentase[]">
                    </div>
                    <div class="col-md-1">
                        <label class="col-form-label col-form-label-xs" for="">Tambah</label>
                        <button type="button" id="tambah" class="btn btn-primary btn-sm"><i class="fa fa-plus">
                            </i>
                        </button>
                    </div>
                </div>

                <div id="form_dinamis">

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
    $(document).ready(function() {
        var id = 0;

        $('#tambah').click(function() {
            id++;
            var formRow = $('<div class="form-row"></div>');

            var vendorGroup = $('<div class="form-group col-md-7"></div>');
            vendorGroup.append(
                '<label class="col-form-label col-form-label-xs" for="vendor_id">Vendor<span class="required">*</span></label>'
            );
            vendorGroup.append(
                '<select class="form-control form-control-sm" name="vendor_id[]" data-placeholder="-- Pilih --"><option value=""></option>@foreach ($vendor as $rekanan)<option value="{{ $rekanan->id }}">{{ $rekanan->vendor }}</option>@endforeach</select>'
            );

            var prosentaseGroup = $('<div class="form-group col-md-2"></div>');
            prosentaseGroup.append(
                '<label class="col-form-label col-form-label-xs" for="prosentase">Prosentase<span class="required">*</span></label>'
            );
            prosentaseGroup.append(
                '<input type="double" class="form-control form-control-sm" id="prosentase" name="prosentase[]">'
            );

            var buttonGroup = $('<div class="col-md-1"></div>');
            buttonGroup.append(
                '<label class="col-form-label col-form-label-xs" for="">Kosongkan </label>');
            buttonGroup.append(
                '<button type="button" class="btn btn-danger btn-sm hapus"><i class="fa fa-minus"></i></button>'
            );

            formRow.append(vendorGroup);
            formRow.append(prosentaseGroup);
            formRow.append(buttonGroup);

            $('#form_dinamis').append(formRow);
        });

        $('#form_dinamis').on('click', '.hapus', function() {
            $(this).closest('.form-row').remove();
            id--;
        });
    });
</script>

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