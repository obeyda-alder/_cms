@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('unit_history') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.unit_history.label') }}</div>
        <div class="actions-component">
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table" id="data-table">
    <thead>
        <tr>
            <th>{{ __('base.unit_history.id') }}</th>
            <th>{{ __('base.unit_history.unit_code') }}</th>
            <th>{{ __('base.unit_history.unit_value') }}</th>
            <th>{{ __('base.unit_history.status') }}</th>
            <th>{{ __('base.unit_history.price') }}</th>
            <th>{{ __('base.unit_history.add_by') }}</th>
            <th>{{ __('base.unit_history.unit_type') }}</th>
            <th>{{ __('base.unit_history.created_at') }}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/datatables/datatables.bundle.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('vendors/datatables/datatables.bundle.js') }}"></script>
@endpush

@endsection

@push('styles')
<style>
.NOT_ACTIVE{
    background-color: red;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.ACTIVE{
    background-color: green;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
</style>
@endpush
@push('scripts')
<script>
    $(function() {
        $.extend(options, {
            ajax: {
                url : "{!! route('users::units_history') !!}",
                method: "GET",
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'unit_code',
                    name: 'unit_code'
                },
                {
                    data: 'unit_value',
                    name: 'unit_value'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function ( data, type, row, meta ) {
                        return `<span class="${data}">${data}</span>`
                    }
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'add_by',
                    name: 'add_by'
                },
                {
                    data: 'unit_type',
                    name: 'unit_type'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ],
        });
        var table = $('.data-table').DataTable(options);
        $("#refreshDataTable").on("click", function (e) {
            e.preventDefault(), table.ajax.reload();
        });
    });
  </script>
@endpush
