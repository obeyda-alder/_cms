@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
@endsection

@section('content')
<div class="dashboard">
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sessions by channel</h4>
                <div class="aligner-wrapper">
                <canvas id="sessionsDoughnutChart" height="210"></canvas>
                <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                    <h2 class="text-center mb-0 font-weight-bold">8.234</h2>
                    <small class="d-block text-center text-muted  font-weight-semibold mb-0">Total Leads</small>
                </div>
                </div>
                <div class="wrapper mt-4 d-flex flex-wrap align-items-cente">
                <div class="d-flex">
                    <span class="square-indicator bg-danger ml-2"></span>
                    <p class="mb-0 ml-2">Assigned</p>
                </div>
                <div class="d-flex">
                    <span class="square-indicator bg-success ml-2"></span>
                    <p class="mb-0 ml-2">Not Assigned</p>
                </div>
                <div class="d-flex">
                    <span class="square-indicator bg-warning ml-2"></span>
                    <p class="mb-0 ml-2">Reassigned</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
            <div class="card-body performane-indicator-card">
                <div class="d-sm-flex">
                <h4 class="card-title flex-shrink-1">Performance Indicator</h4>
                <p class="m-sm-0 ml-sm-auto flex-shrink-0">
                    <span class="data-time-range ml-0">7d</span>
                    <span class="data-time-range active">2w</span>
                    <span class="data-time-range">1m</span>
                    <span class="data-time-range">3m</span>
                    <span class="data-time-range">6m</span>
                </p>
                </div>
                <div class="d-sm-flex flex-wrap">
                <div class="d-flex align-items-center">
                    <span class="dot-indicator bg-primary ml-2"></span>
                    <p class="mb-0 ml-2 text-muted font-weight-semibold">Complaints (2098)</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="dot-indicator bg-info ml-2"></span>
                    <p class="mb-0 ml-2 text-muted font-weight-semibold"> Task Done (1123)</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="dot-indicator bg-danger ml-2"></span>
                    <p class="mb-0 ml-2 text-muted font-weight-semibold">Attends (876)</p>
                </div>
                </div>
                <div id="performance-indicator-chart" class="ct-chart mt-4"></div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard{
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 100px
}
</style>
@endpush
