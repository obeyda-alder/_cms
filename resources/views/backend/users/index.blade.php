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

<table class="table table-bordered data-table display nowrap" id="data-table"  cellspacing="0" width="100%">
    <thead>
        <tr>
            {{-- <th>{{ __('base.users.table.id') }}</th> --}}
            <th>{{ __('base.users.table.image') }}</th>
            <th>{{ __('base.users.table.name') }}</th>
            <th>{{ __('base.users.table.type') }}</th>
            <th>{{ __('base.users.table.username') }}</th>
            <th>{{ __('base.users.table.phone_number') }}</th>
            <th>{{ __('base.users.table.email') }}</th>
            <th>{{ __('base.users.table.verification_code') }}</th>
            <th>{{ __('base.users.table.status') }}</th>
            <th>{{ __('base.users.table.registration_type') }}</th>
            <th>{{ __('base.users.table.created_at') }}</th>
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
.SUSPENDED{
    background-color: #DF2E38;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.ACTIVE{
    background-color: #5D9C59;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.PENDING{
    background-color: #EBB02D;
    color: #fff;
    padding: 5px;
    border-radius: 15px;
}
.FROZEN{
    background-color: #57C5B6;
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
                url : "{!! route('users::data') !!}",
                method: "GET",
                data : {
                    'type' : "{{$type}}"
                },
            },
            columns: [
                // { data: null, defaultContent: "", width: "0%" },
                // {
                //     data: 'id',
                //     name: 'id'
                // },
                {
                    data: 'image',
                    width: "15%",
                    name: 'image',
                    render: function ( data, type, row, meta ) {
                        return `<img src="${data}" />`;
                    }
                },
                {
                    data: 'name',
                    width: "15%",
                    name: 'name',
                },
                {
                    data: 'type',
                    width: "15%",
                    name: 'type',
                },
                {
                    data: 'username',
                    width: "15%",
                    name: 'username',
                },
                {
                    data: 'phone_number',
                    width: "15%",
                    name: 'phone_number',
                },
                {
                    data: 'email',
                    width: "15%",
                    name: 'email',
                },
                {
                    data: 'verification_code',
                    width: "15%",
                    name: 'verification_code',
                },
                {
                    data: 'status',
                    width: "15%",
                    name: 'status',
                    render: function ( data, type, row, meta ) {
                        return `<span class="${data}">${data}</span>`;
                    }
                },
                {
                    data: 'registration_type',
                    name: 'registration_type',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
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
