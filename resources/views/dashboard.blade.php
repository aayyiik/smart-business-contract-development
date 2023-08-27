@extends('layouts.master-dashboard')
@section('page-title', 'Dashboard')
@section('active-dashboard', 'active')
@section('address')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection
@section('dashboard')
    @if (Auth::user()->userDetail->role->role == 'Super Admin')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Pengguna</h4>
                        </div>
                        <div class="card-body">
                            {{ $users }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Unit</h4>
                        </div>
                        <div class="card-body">
                            {{ $units }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Departemen</h4>
                        </div>
                        <div class="card-body">
                            {{ $departments }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Role</h4>
                        </div>
                        <div class="card-body">
                            {{ $roles }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Template</h4>
                        </div>
                        <div class="card-body">
                            {{ $templates }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Vendor</h4>
                        </div>
                        <div class="card-body">
                            {{ $vendors }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Status</h4>
                        </div>
                        <div class="card-body">
                            {{ $statuses }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'Buyer')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $contract }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Review Vendor</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_vendor }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Review Hukum</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_hukum }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Approval</h4>
                        </div>
                        <div class="card-body">
                            {{ $approval }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Final</h4>
                        </div>
                        <div class="card-body">
                            {{ $final }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'Vendor')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tender Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $active_tender }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tanda Tangan</h4>
                        </div>
                        <div class="card-body">
                            {{ $sign_vendor }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Final</h4>
                        </div>
                        <div class="card-body">
                            {{ $final_vendor }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Undangan Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $review }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'Legal')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Review Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_hukum }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'AVP')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Tender Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $contracts_avp }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Belum DiReview Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_avp }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'VP')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Tender Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $contracts_vp }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Belum DiReview Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_vp }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'SVP')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Tender Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $contracts_svp }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Belum DiReview Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_svp }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->userDetail->role->role == 'DKU')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Tender Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $contracts_dku }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Belum DiReview Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{ $review_dku }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
