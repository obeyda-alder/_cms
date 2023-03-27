@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('info')
    @include('partials.info',[
        'info' => [
            'title' => __('info.'.$type),
            'icon' => 'fas fa-info'
        ]
    ])
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('configurations') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.configurations.'.$type) }}</div>
        <div class="actions-component">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#CreateConfigByType">{{ __('base.configurations.create') }}</button>
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table display nowrap" id="data-table" cellspacing="0" width="100%">
    <thead>
        <tr>
            @if ($type == "relations_type")
                <th>{{ __('base.configurations.table.relation_type') }}</th>
                <th>{{ __('base.configurations.table.user_type') }}</th>
            @elseif($type == "operations")
                <th>{{ __('base.configurations.table.type_en') }}</th>
                <th>{{ __('base.configurations.table.type_ar') }}</th>
                <th>{{ __('base.configurations.table.relation') }}</th>
                <th>{{ __('base.configurations.table.user_type') }}</th>
            @elseif($type == "unit_type")
                <th>{{ __('base.configurations.table.type') }}</th>
                <th>{{ __('base.configurations.table.continued') }}</th>
            @elseif($type == "relation_unit_type_with_operations")
                <th>{{ __('base.configurations.table.from_unit_type') }}</th>
                <th>{{ __('base.configurations.table.from_continued') }}</th>
                <th>{{ __('base.configurations.table.to_unit_type') }}</th>
                <th>{{ __('base.configurations.table.to_continued') }}</th>
                <th>{{ __('base.configurations.table.operation_en') }}</th>
                <th>{{ __('base.configurations.table.operation_ar') }}</th>
                <th>{{ __('base.configurations.table.relation_type') }}</th>
                <th>{{ __('base.configurations.table.user_type') }}</th>
            @endif
                <th>{{ __('base.configurations.table.actions') }}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>

    <div class="modal fade" id="CreateConfigByType" tabindex="-1" role="dialog" aria-labelledby="CreateTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content back-color">
        <div class="modal-header">
            <h5 class="modal-title" id="CreateTitle">{{ __('base.model.create_config') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('configurations::create', $type) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="{{$type}}">
                <div class="row">
                    <div class="col-md-12">
                        @include('backend.includes.inputs.text', [
                            'options' => [
                                'id'          => 'name',
                                'name'        => 'name',
                                'label'       => __('base.users.fields.name.label'),
                                'placeholder' => __('base.users.fields.name.placeholder'),
                                'help'        => __('base.users.fields.name.help'),
                                'value'       => old('name')
                            ]
                        ])
                            @include('backend.includes.inputs.select', [
                            'options' => [
                                'id'          => 'status',
                                'nullable'    => false,
                                'name'        => 'status',
                                'label'       => __('base.categories.fields.status.label'),
                                'placeholder' => __('base.categories.fields.status.placeholder'),
                                'help'        => __('base.categories.fields.status.help'),
                                'data'        => ["SUSPENDED","ACTIVE","PENDING","FROZEN"],
                                'selected'    => old('status'),
                                'value'       => function($data, $key, $value){ return $value; },
                                'text'        => function($data, $key, $value){ return __('base.users.fields.status.'.$value); },
                                'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                            ]
                        ])
                    </div>
                </div>
                <div class="w-100 text-center d-flex justify-content-center">
                    @include('backend.includes.buttons', ['type' => 'create'])
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
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
    .back-color{
        background-color: #fff;
    }
</style>
@endpush
@push('scripts')
<script>
    $(function() {
        $.extend(options, {
            ajax: {
                url : "{!! route('configurations::data') !!}",
                method: "GET",
                data : { 'type' : "{{$type}}" },
            },
            columns: [
                @if ($type == "relations_type")
                {
                    data: 'relation_type',
                    name: 'relation_type',
                },
                {
                    data: 'user_type',
                    name: 'user_type',
                },
                @elseif($type == "operations")
                {
                    data: 'type_en',
                    name: 'type_en',
                },
                {
                    data: 'type_ar',
                    name: 'type_ar',
                },
                {
                    data: 'relation',
                    name: 'relation',
                },
                {
                    data: 'user_type',
                    name: 'user_type',
                },
                @elseif($type == "unit_type")
                {
                    data: 'type',
                    name: 'type',
                },
                {
                    data: 'continued',
                    name: 'continued',
                },
                @elseif($type == "relation_unit_type_with_operations")
                {
                    data: 'from_unit_type',
                    name: 'from_unit_type',
                },
                {
                    data: 'from_continued',
                    name: 'from_continued',
                },
                {
                    data: 'to_unit_type',
                    name: 'to_unit_type',
                },
                {
                    data: 'to_continued',
                    name: 'to_continued',
                },
                {
                    data: 'operation_en',
                    name: 'operation_en',
                },
                {
                    data: 'operation_ar',
                    name: 'operation_ar',
                },
                {
                    data: 'relation_type',
                    name: 'relation_type',
                },
                {
                    data: 'user_type',
                    name: 'user_type',
                },
                @endif
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
