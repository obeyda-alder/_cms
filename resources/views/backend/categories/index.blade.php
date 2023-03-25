@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('categories') }}
@endsection
@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.categories.label') }}</div>
        <div class="actions-component">
            <a class="btn btn-info" href="{{ route('categories::create') }}">{{ __('base.categories.create') }}</a>
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table" id="data-table">
    <thead>
        <tr>
            <th>{{ __('base.categories.id') }}</th>
            <th>{{ __('base.categories.name') }}</th>
            <th>{{ __('base.categories.code') }}</th>
            <th>{{ __('base.categories.unit_min_limit') }}</th>
            <th>{{ __('base.categories.unit_max_limit') }}</th>
            <th>{{ __('base.categories.value_in_price') }}</th>
            <th>{{ __('base.categories.status') }}</th>
            <th>{{ __('base.categories.percentage') }}</th>
            <th>{{ __('base.categories.add_by_user_id') }}</th>
            <th>{{ __('base.categories.created_at') }}</th>
            <th>{{ __('base.categories.actions') }}</th>
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
.percentage{
    background-color: #FC2947;
    color: #fff;
    padding: 5px 7px ;
    border-radius: 15px;
}
</style>
@endpush
@push('scripts')
<script>
    $(function() {
        $.extend(options, {
            ajax: {
                url : "{!! route('categories::data') !!}",
                method: "GET",
                data : {},
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'unit_min_limit',
                    name: 'unit_min_limit'
                },
                {
                    data: 'unit_max_limit',
                    name: 'unit_max_limit'
                },
                {
                    data: 'value_in_price',
                    name: 'value_in_price'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function ( data, type, row, meta ) {
                        return `<span class="${data}">${data}</span>`
                    }
                },
                {
                    data: 'percentage',
                    name: 'percentage',
                    render: function ( data, type, row, meta ) {
                        return `<span class="percentage">${data}</span>`
                    }
                },
                {
                    data: 'add_by_user_id',
                    name: 'add_by_user_id'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    orderable:  false,
                    render: function ( data, type, row, meta ) {
                        return dataTableActions(data,type,row,meta);
                    }
                }
            ],
        });
        var table = $('.data-table').DataTable(options);
        $("#refreshDataTable").on("click", function (e) {
            e.preventDefault(), table.ajax.reload();
        });
    });
  </script>
@endpush
