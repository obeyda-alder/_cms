@extends('backend.layouts.cms_http')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('global') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('config.global.'.$type) }}</div>
        <div class="actions-component">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#CreateConfigByType">{{ __('config.global.create') }}</button>
            <a class="btn btn-success" href="javascript:;" id="refreshDataTable">{{ __('base.refreshDataTable') }}</a>
        </div>
    </div>
@endsection

@section('content')

<table class="table table-bordered data-table display nowrap" id="data-table" cellspacing="0" width="100%">
    <thead>
        <tr>
            @if ($type == "currencies")
                <th>{{ __('config.global.table.flag') }}</th>
                <th>{{ __('config.global.table.name') }}</th>
                <th>{{ __('config.global.table.currency') }}</th>
                <th>{{ __('config.global.table.price') }}</th>
                <th>{{ __('config.global.table.created_at') }}</th>
                <th>{{ __('config.global.table.actions') }}</th>
            @endif
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
                <form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('global::create', $type) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="{{$type}}">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($type == "currencies")
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-2">
                                            <img id="currency_icon" src="{{ $currency[222]['currency_icon'] }}" alt="" />
                                        </div>
                                        <div class="col-md-10">
                                            @include('backend.includes.inputs.select', [
                                                'options' => [
                                                    'id'          => 'currency',
                                                    'name'        => 'currency',
                                                    'label'       => __('config.model.currencies.currency.label'),
                                                    'placeholder' => __('config.model.currencies.currency.placeholder'),
                                                    'data'        => $currency,
                                                    'selected'    => old('currency'),
                                                    'value'       => function($data, $key, $value){ return $value['id']; },
                                                    'text'        => function($data, $key, $value){ return  $value['currency'] . ' - ' . $value['name_'.app()->getLocale()]; },
                                                    // 'image'       => function($data, $key, $value){ return  $value['currency_icon']; },
                                                    'sub_text'    => function($data, $key, $value){ return  $value['name_'.app()->getLocale()]; },
                                                    'select'      => function($data, $selected, $key, $value){ return $selected ? $selected == $value['id'] : 223 == $value['id']; },
                                                ]
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @include('backend.includes.inputs.text', [
                                            'options' => [
                                                'id'          => 'name',
                                                'name'        => 'name',
                                                'label'       => __('config.model.currencies.name.label'),
                                                'placeholder' => __('config.model.currencies.name.placeholder'),
                                                'value'       => old('name', 'Turkey'),
                                                'disabled'    => true
                                            ]
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('backend.includes.inputs.text', [
                                            'options' => [
                                                'id'          => 'price',
                                                'name'        => 'price',
                                                'type'        => 'number',
                                                'step'        => '0.01',
                                                'label'       => __('config.model.currencies.price.label'),
                                                'placeholder' => __('config.model.currencies.price.placeholder'),
                                                'value'       => old('price')
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
    #currency_icon {
        border-radius: 37%;
        padding: 15px;
    }
    .cur_flag{
        border-radius: unset !important
    }
</style>
@endpush
@push('scripts')
<script>
    $(function() {
        $.extend(options, {
            ajax: {
                url : "{!! route('global::data') !!}",
                method: "GET",
                data : { 'type' : "{{$type}}" },
            },
            columns: [
                @if ($type == "currencies")
                    {
                        data: 'flag',
                        name: 'flag',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'currency',
                        name: 'currency',
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
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

    var selected_side_dishes = [];
    $('[name="currency"]').on('change', function () {
        $.each($(this)[0].options, function(i, e) {
            if(e.selected && $.inArray(e.value, selected_side_dishes) == -1){

                $.ajax({
                    data        : {
                        cur_id : e.value,
                    },
                    url         : "{!! route('global::get_flag') !!}",
                    type        : "GET",
                    success: function (data) {
                        $('#currency_icon').attr('src', data['currency_icon']); //e.attributes['data-image']['value']
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
                $('#name').val(e.attributes['data-subtext']['value']);
            }
        });
    });
  </script>
@endpush
