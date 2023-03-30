@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('unit_movement') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.units_movement.label') }}</div>
        <div class="actions-component">
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table" id="data-table">
    <thead>
        <tr>
            <th>{{ __('base.units_movement.id') }}</th>
            <th>{{ __('base.units_movement.unit_code') }}</th>
            <th>{{ __('base.units_movement.transfer_type') }}</th>
            <th>{{ __('base.units_movement.quantity') }}</th>
            <th>{{ __('base.units_movement.status') }}</th>
            <th>{{ __('base.units_movement.to_user') }}</th>
            <th>{{ __('base.units_movement.from_user') }}</th>
            <th>{{ __('base.units_movement.created_at') }}</th>
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
.INCREASE{
    background-color: #57C5B6;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.DECREASE{
    background-color: #159895;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.ADD{
    background-color: #1A5F7A;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
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
                url : "{!! route('users::unit_movement') !!}",
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
                    data: 'transfer_type',
                    name: 'transfer_type'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function ( data, type, row, meta ) {
                        return `<span class="${data}">${data}</span>`
                    }
                },
                {
                    data: 'to_user',
                    name: 'to_user'
                },
                {
                    data: 'from_user',
                    name: 'from_user'
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
