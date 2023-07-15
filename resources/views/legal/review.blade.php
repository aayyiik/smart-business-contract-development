@extends('layouts.master-dashboard')
@section('page-title', 'Rincian Kontrak')
@section('active-contract', 'active')
@section('dashboard')
    <div>
        <div class="card">
            <div class="card-header card-forestgreen">
                <h6 class="card-title">Detail Kontrak</h6>
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
                    <form action="{{ route('contract.legal-approval', ['contract' => $contracts->first()->id, 'vendor' => $vendor->first()->id]) }}"
                        method="POST">
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_id" id="exampleRadios1"
                                value="5" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Accept
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_id" id="exampleRadios2"
                                value="3">
                            <label class="form-check-label" for="exampleRadios2">
                                Reject
                            </label>
                        </div>
                        <div class="form-group shadow-textarea">
                            <label for="exampleFormControlTextarea6">Review</label>
                            <textarea class="form-control z-depth-1" name="review_contract" id="exampleFormControlTextarea6" rows="3"
                                placeholder="Write something here..."></textarea>
                        </div>
                        <div class="row justify-content-end mr-0">
                            <button type="submit" class="btn btn-success btn-xs text-right" data-toggle="confirmation"
                                data-placement="left">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
