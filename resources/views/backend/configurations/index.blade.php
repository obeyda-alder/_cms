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
            'title' => __('config.'.$type),
            'icon' => 'fas fa-info'
        ]
    ])
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('configurations') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('config.configurations.'.$type) }}</div>
        <div class="actions-component">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#CreateConfigByType">{{ __('config.configurations.create') }}</button>
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table display nowrap" id="data-table" cellspacing="0" width="100%">
    <thead>
        <tr>
            @if ($type == "relations_type")
                <th>{{ __('config.configurations.table.relation_type') }}</th>
                <th>{{ __('config.configurations.table.user_type') }}</th>
            @elseif($type == "operations")
                <th>{{ __('config.configurations.table.type_en') }}</th>
                <th>{{ __('config.configurations.table.type_ar') }}</th>
                <th>{{ __('config.configurations.table.relation') }}</th>
                <th>{{ __('config.configurations.table.user_type') }}</th>
            @elseif($type == "unit_type")
                <th>{{ __('config.configurations.table.type') }}</th>
                <th>{{ __('config.configurations.table.continued') }}</th>
            @elseif($type == "relation_unit_type_with_operations")
            <th>{{ __('config.configurations.table.relation_type') }}</th>
            <th>{{ __('config.configurations.table.user_type') }}</th>
            <th>{{ __('config.configurations.table.operation_en') }}</th>
            <th>{{ __('config.configurations.table.operation_ar') }}</th>
                <th>{{ __('config.configurations.table.from_unit_type') }}</th>
                <th>{{ __('config.configurations.table.from_continued') }}</th>
                <th>{{ __('config.configurations.table.to_unit_type') }}</th>
                <th>{{ __('config.configurations.table.to_continued') }}</th>
            @endif
                <th>{{ __('config.configurations.table.actions') }}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>

    <div class="modal fade" id="CreateConfigByType" tabindex="-1" role="dialog" aria-labelledby="CreateTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content back-color">
        <div class="modal-header">
            <h5 class="modal-title" id="CreateTitle">{{ __('config.model.create_config') }}</h5>
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
                        @if ($type == "relations_type")
                            <div class="row">
                                <div class="col-md-5">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'from_users_type',
                                            'name'        => 'from_users_type',
                                            'label'       => __('config.model.relations_type.from_users_type.label'),
                                            'placeholder' => __('config.model.relations_type.from_users_type.placeholder'),
                                            'data'        => config('custom.users_type_validation'),
                                            'selected'    => old('from_users_type'),
                                            'value'       => function($data, $key, $value){ return $value; },
                                            'text'        => function($data, $key, $value){ return  __('base.users.'.$value); },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                                        ]
                                    ])
                                </div>
                                <div class="col-md-2">
                                    @include('backend.includes.inputs.text', [
                                        'options' => [
                                            'id'          => '_to_',
                                            'name'        => '_to_',
                                            'label'       => __('config.model.relations_type._to_.label'),
                                            'placeholder' => __('config.model.relations_type._to_.placeholder'),
                                            'value'       => '_TO_',
                                            'disabled'    => true
                                        ]
                                    ])
                                </div>
                                <div class="col-md-5">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'to_user_type',
                                            'name'        => 'to_user_type',
                                            'label'       => __('config.model.relations_type.to_user_type.label'),
                                            'placeholder' => __('config.model.relations_type.to_user_type.placeholder'),
                                            'data'        => config('custom.users_type_validation'),
                                            'selected'    => old('to_user_type'),
                                            'value'       => function($data, $key, $value){ return $value; },
                                            'text'        => function($data, $key, $value){ return $value != "ALL" ? __('base.users.'.$value) : ''; },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                                        ]
                                    ])
                                </div>
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'user_type',
                                            'nullable'    => false,
                                            'name'        => 'user_type',
                                            'label'       => __('config.model.relations_type.user_type.label'),
                                            'placeholder' => __('config.model.relations_type.user_type.placeholder'),
                                            'data'        => config('custom.users_type_validation'),
                                            'selected'    => old('user_type'),
                                            'value'       => function($data, $key, $value){ return $value; },
                                            'text'        => function($data, $key, $value){ return $value != "ALL" ? __('base.users.'.$value) : ''; },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                                        ]
                                    ])
                                </div>
                            </div>
                        @elseif($type == "operations")
                            <div class="row">
                                <div class="col-md-6">
                                    @include('backend.includes.inputs.text', [
                                        'options' => [
                                            'id'          => 'type_en',
                                            'name'        => 'type_en',
                                            'label'       => __('config.model.operations.type_en.label'),
                                            'placeholder' => __('config.model.operations.type_en.placeholder'),
                                            'value'       => old('type_en'),
                                        ]
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('backend.includes.inputs.text', [
                                        'options' => [
                                            'id'          => 'type_ar',
                                            'name'        => 'type_ar',
                                            'label'       => __('config.model.operations.type_ar.label'),
                                            'placeholder' => __('config.model.operations.type_ar.placeholder'),
                                            'value'       => old('type_ar'),
                                        ]
                                    ])
                                </div>
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'relation_id',
                                            'name'        => 'relation_id',
                                            'label'       => __('config.model.operations.relation_id.label'),
                                            'placeholder' => __('config.model.operations.relation_id.placeholder'),
                                            'data'        => $relations_type,
                                            'selected'    => old('relation_id'),
                                            'value'       => function($data, $key, $value){ return $value['id']; },
                                            'text'        => function($data, $key, $value){ return $value['relation_type']; },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                                        ]
                                    ])
                                </div>
                            </div>
                        @elseif($type == "unit_type")
                            <div class="row">
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.text', [
                                        'options' => [
                                            'id'          => 'type',
                                            'name'        => 'type',
                                            'label'       => __('config.model.unit_type.type.label'),
                                            'placeholder' => __('config.model.unit_type.type.placeholder'),
                                            'value'       => old('type'),
                                        ]
                                    ])
                                </div>
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'continued',
                                            'name'        => 'continued',
                                            'label'       => __('config.model.unit_type.continued.label'),
                                            'placeholder' => __('config.model.unit_type.continued.placeholder'),
                                            'data'        => config('custom.users_type_validation'),
                                            'selected'    => old('continued'),
                                            'value'       => function($data, $key, $value){ return $value; },
                                            'text'        => function($data, $key, $value){ return  __('base.users.'.$value); },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                                        ]
                                    ])
                                </div>
                            </div>
                        @elseif($type == "relation_unit_type_with_operations")
                            <div class="row">
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'operation_id',
                                            'name'        => 'operation_id',
                                            'label'       => __('config.model.relation_unit_type_with_operations.operation_id.label'),
                                            'placeholder' => __('config.model.relation_unit_type_with_operations.operation_id.placeholder'),
                                            'data'        => $operations,
                                            'selected'    => old('operation_id'),
                                            'value'       => function($data, $key, $value){ return $value['id']; },
                                            'text'        => function($data, $key, $value){ return $value['type_'.app()->getLocale()] .' ( '.$value['relation']['user_type'].' )' ; },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                                        ]
                                    ])
                                </div>
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'from_unit_type_id',
                                            'name'        => 'from_unit_type_id',
                                            'label'       => __('config.model.relation_unit_type_with_operations.from_unit_type_id.label'),
                                            'placeholder' => __('config.model.relation_unit_type_with_operations.from_unit_type_id.placeholder'),
                                            'data'        => $unit_type,
                                            'selected'    => old('from_unit_type_id'),
                                            'value'       => function($data, $key, $value){ return $value['id']; },
                                            'text'        => function($data, $key, $value){ return $value['type'] .' ( '.$value['continued'].' )'; },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                                        ]
                                    ])
                                </div>
                                <div class="col-md-12">
                                    @include('backend.includes.inputs.select', [
                                        'options' => [
                                            'id'          => 'to_unit_type_id',
                                            'name'        => 'to_unit_type_id',
                                            'label'       => __('config.model.relation_unit_type_with_operations.to_unit_type_id.label'),
                                            'placeholder' => __('config.model.relation_unit_type_with_operations.to_unit_type_id.placeholder'),
                                            'data'        => $unit_type,
                                            'selected'    => old('to_unit_type_id'),
                                            'value'       => function($data, $key, $value){ return $value['id']; },
                                            'text'        => function($data, $key, $value){ return $value['type'] .' ( '.$value['continued'].' )'; },
                                            'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                                        ]
                                    ])
                                </div>
                            </div>
                        @endif
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
    .modal-dialog {
        max-width: 700px;
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
                        data: 'relation_type',
                        name: 'relation_type',
                    },
                    {
                        data: 'user_type',
                        name: 'user_type',
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
