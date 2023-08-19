@extends('layouts.master-dashboard')
@section('page-title', 'Rincian Kontrak')
@section('active-contract', 'active')
@section('dashboard')
    <div>
        <div class="card">
            <div class="card-header card-forestgreen">
                <h6 class="card-title">Tambah Data Kontrak</h6>
                <!-- tool -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i
                            class="fas fa-expand fa-xs icon-border-default"></i>
                    </button>
                    <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i
                            class="fas fa-minus fa-xs icon-border-yellow"></i>
                    </button>
                </div>
                <!-- /tool -->
            </div>
            <div class="card-body">
                <form
                    action="{{ route('vendor.contract-update', ['contract' => $contract->pivot->contract_id, 'vendor' => $contract->pivot->vendor_id]) }}"
                    method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="number">Nomor DOF<span
                                class="required">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('number') is-invalid @enderror"
                            value="{{ $contract->pivot->number ?? old('number') }}" id="number" name="number">
                        @error('number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="date_dof">Tanggal Terbit No DOF<span
                                class="required">*</span></label>
                        <input type="date" class="form-control form-control-sm @error('date_dof') is-invalid @enderror"
                            id="date_dof" name="date_dof">
                        @error('date_dof')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="date_name">Terbilang Tanggal DOF<span
                                class="required">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('date_name') is-invalid @enderror"
                            id="date_name" name="date_name">
                        @error('date_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="no_sp">Nomor SP</label>
                        <input type="text" class="form-control form-control-sm @error('no_sp') is-invalid @enderror"
                            value="{{ $contracts->no_sp }}" id="no_sp" name="no_sp" readonly>
                        @error('no_sp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="date_sp">Tanggal Terbit No SP</label>
                        <input type="text" class="form-control form-control-sm @error('date_sp') is-invalid @enderror"
                            value="{{ $contracts->date_sp }}" id="date_sp" name="date_sp" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="prosentase">Prosentase<span
                                class="required">*</span></label>
                        <input type="number" class="form-control form-control-sm @error('prosentase') is-invalid @enderror"
                            value="{{ $contract->pivot->prosentase ?? old('prosentase') }}" id="prosentase"
                            name="prosentase">
                        @error('prosentase')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="nilai_kontrak">Nilai Kontrak<span
                                class="required">*</span></label>
                        <input type="number"
                            class="form-control form-control-sm @error('nilai_kontrak') is-invalid @enderror"
                            value="{{ $contract->pivot->nilai_kontrak ?? old('nilai_kontrak') }}" id="nilai_kontrak"
                            name="nilai_kontrak">
                        @error('nilai_kontrak')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="director">Direktur<span
                                class="required">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('director') is-invalid @enderror"
                            value="{{ $contract->pivot->director ?? old('director') }}" id="director" name="director">
                        @error('director')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="phone">Kontak<span
                                class="required">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror"
                            value="{{ $contract->pivot->phone ?? old('phone') }}" id="phone" name="phone">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-xs" for="address">Alamat<span
                                class="required">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('address') is-invalid @enderror"
                            value="{{ $contract->pivot->address ?? old('address') }}" id="address" name="address">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-forestgreen">
                <h6 class="card-title">Tambah Data Kontrak</h6>
                <!-- tool -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i
                            class="fas fa-expand fa-xs icon-border-default"></i>
                    </button>
                    <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i
                            class="fas fa-minus fa-xs icon-border-yellow"></i>
                    </button>
                </div>
                <!-- /tool -->
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="start_rute">Rute Pekerjaan (Asal)<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('start_rute') is-invalid @enderror"
                        id="start_rute" name="start_rute">
                    @error('start_rute')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="end_rute">Rute Pekerjaan (Tujuan)<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('end_rute') is-invalid @enderror"
                        id="end_rute" name="end_rute">
                    @error('end_rute')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="state_rate">Wilayah Rate Pemuatan<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('state_rate') is-invalid @enderror"
                        id="state_rate" name="state_rate">
                    @error('state_rate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="performance_bond">Jaminan Pelaksanaan<span
                            class="required">*</span></label>
                    <input type="number"
                        class="form-control form-control-sm @error('performance_bond') is-invalid @enderror"
                        id="performance_bond" name="performance_bond">
                    @error('performance_bond')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="terbilang_rupiah">Terbilang Rupiah<span
                            class="required">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm @error('terbilang_rupiah') is-invalid @enderror"
                        id="terbilang_rupiah" name="terbilang_rupiah">
                    @error('terbilang_rupiah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- mulai --}}

                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="management_executives">Pejabat PG Yang Bertanda
                        Tangan<span class="required">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm @error('management_executives') is-invalid @enderror"
                        id="management_executives" name="management_executives"
                        value="{{ $contracts->oe < 100000000 ? 'Haris Sulistiyana' : ($contracts->oe > 100000000 && $contracts->oe < 500000000 ? 'I Gusti Manacika' : ($contracts->oe > 500000000 ? 'Budi Wahyu Soesilo' : 'DEFAULT')) }}"
                        readonly>
                    @error('management_executives')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="management_job">Jabatan Manajemen<span
                            class="required">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm @error('management_job') is-invalid @enderror"
                        id="management_job" name="management_job"
                        value="{{ $contracts->oe < 100000000 ? 'VP Pengadaan Jasa' : ($contracts->oe > 100000000 && $contracts->oe < 500000000 ? 'SVP Teknik' : ($contracts->oe > 500000000 ? 'Direktur Keuangan dan Umum' : 'DEFAULT')) }}"
                        readonly>
                    @error('management_job')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="vendor_upper">Nama Vendor (huruf besar)<span
                            class="required">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm @error('vendor_upper') is-invalid @enderror"
                        id="vendor_upper" name="vendor_upper">
                    @error('vendor_upper')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="vendor_capital">Nama Vendor (huruf capital)<span
                            class="required">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm @error('vendor_capital') is-invalid @enderror"
                        id="vendor_capital" name="vendor_capital">
                    @error('vendor_capital')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="start_date">Waktu Mulai<span
                            class="required">*</span></label>
                    <input type="date" class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                        id="start_date" name="start_date">
                    @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="date_sname">Terbilang Tanggal<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('date_sname') is-invalid @enderror"
                        id="date_sname" name="date_sname">
                    @error('date_sname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="end_date">Waktu Selesai<span
                            class="required">*</span></label>
                    <input type="date" class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                        id="end_date" name="end_date">
                    @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="date_ename">Terbilang Tanggal<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('date_ename') is-invalid @enderror"
                        id="date_ename" name="date_ename">
                    @error('date_ename')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="delivery_date">Berlaku Sampai<span
                            class="required">*</span></label>
                    <input type="int"
                        class="form-control form-control-sm @error('delivery_date') is-invalid @enderror"
                        id="delivery_date" name="delivery_date">
                    @error('delivery_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="name_devdate">Terbilang Berlaku<span
                            class="required">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm @error('name_devdate') is-invalid @enderror"
                        id="name_devdate" name="name_devdate">
                    @error('name_devdate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-forestgreen">
                <h6 class="card-title">Tambah Data Rekanan</h6>
                <!-- tool -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-xs pr-0" data-card-widget="maximize"><i
                            class="fas fa-expand fa-xs icon-border-default"></i>
                    </button>
                    <button type="button" class="btn btn-tool btn-xs" data-card-widget="collapse"><i
                            class="fas fa-minus fa-xs icon-border-yellow"></i>
                    </button>
                </div>
                <!-- /tool -->
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="place">Domisili Perusahaan<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('place') is-invalid @enderror"
                        id="place" name="place_vendor">
                    @error('place')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-xs" for="email">Email Perusahaan<span
                            class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('email') is-invalid @enderror"
                        id="email" name="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
               
                {{-- <input type="file" name="file[]" multiple="true"> --}}
                <div class="row justify-content-end mr-0">
                    <button type="submit" class="btn btn-success btn-xs text-right" data-toggle="confirmation"
                        data-placement="left">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- @push('script')
<script>
    $(document).ready(function() {
        $('#end_date').on('change', function() {
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($(this).val());

            if (endDate < startDate) {
                alert(
                    'Tanggal Selesai tidak bisa dipilih sebelum Tanggal Mulai. Pilih tanggal dengan benar!'
                    );
                $(this).val(''); // Menghapus nilai end date yang tidak valid
            }
        });
    });
</script>
@endpush --}}
