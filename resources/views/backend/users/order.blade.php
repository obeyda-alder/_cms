@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('orders') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.packing_order.label') }}</div>
        <div class="actions-component">
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table" id="data-table">
    <thead>
        <tr>
            <th>{{ __('base.packing_order.table.id') }}</th>
            <th>{{ __('base.packing_order.table.from_user') }}</th>
            <th>{{ __('base.packing_order.table.quantity') }}</th>
            <th>{{ __('base.packing_order.table.order_status') }}</th>
            <th>{{ __('base.packing_order.table.created_at') }}</th>
            @if (in_array($_user['type'], ["ROOT", "ADMIN"]))
                <th>{{ __('base.users.table.actions') }}</th>
            @endif
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
.Unfinished{
    background-color: red;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.Finished{
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
                url : "{!! route('users::packing_order') !!}",
                method: "GET",
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'from_user',
                    name: 'from_user'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'order_status',
                    name: 'order_status',
                    render: function ( data, type, row, meta ) {
                        return `<span class="${data}">${data}</span>`
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                @if (in_array($_user['type'], ["ROOT", "ADMIN"]))
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    orderable:  false,
                    render: function ( data, type, row, meta ) {
                        return dataTableActions(data,type,row,meta);
                    }
                }
                @endif
            ],
        });
        var table = $('.data-table').DataTable(options);
        $("#refreshDataTable").on("click", function (e) {
            e.preventDefault(), table.ajax.reload();
        });
    });
  </script>
@endpush
