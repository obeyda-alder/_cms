@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('users') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.users.'.strtoupper($type)) }}</div>
        <div class="actions-component">
            @if(!in_array($type, ['ALL', 'ROOT']))
              <a class="btn btn-info" href="{{ route('users::create', $type) }}">{{ __('base.users.create') }}</a>
            @endif
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table" id="data-table">
    <thead>
        <tr>
            <th>{{ __('base.users.table.id') }}</th>
            <th>{{ __('base.users.table.name') }}</th>
            <th>{{ __('base.users.table.type') }}</th>
            <th>{{ __('base.users.table.username') }}</th>
            <th>{{ __('base.users.table.phone_number') }}</th>
            <th>{{ __('base.users.table.email') }}</th>
            <th>{{ __('base.users.table.verification_code') }}</th>
            <th>{{ __('base.users.table.status') }}</th>
            <th>{{ __('base.users.table.registration_type') }}</th>
            <th>{{ __('base.users.table.actions') }}</th>
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

</style>
@endpush
@push('scripts')
<script>
    $(function() {
        $.extend(options, {
            ajax: {
                url : "{!! route('users::data') !!}",
                method: "GET",
                data : {
                    'type' : "{{$type}}"
                },
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
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'verification_code',
                    name: 'verification_code'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'registration_type',
                    name: 'registration_type'
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
