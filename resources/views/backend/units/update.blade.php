@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('units') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.units.update', ['name' => $data->name]) }}</div>
    </div>
@endsection

@section('content')

<form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('units::e-store') }}">
    @csrf
    <input type="hidden" name="units_type" id="units_type" value="">
    <input type="hidden" name="unit_id" id="unit_id" value="{{ $data->id }}">
    <div class="row">
        <div class="col-md-6">
            @include('backend.includes.inputs.select', [
                'options' => [
                    'id'          => 'user_id',
                    'nullable'    => true,
                    'name'        => 'user_id',
                    'label'       => __('base.units.fields.user_id.label'),
                    'placeholder' => __('base.units.fields.user_id.placeholder'),
                    'help'        => __('base.units.fields.user_id.help'),
                    'data'        => $users,
                    'selected'    => old('user_id', $data->user_id ),
                    'value'       => function($data, $key, $value){ return $value->id; },
                    'text'        => function($data, $key, $value){ return $value->name; },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value->id; },
                ]
            ])
            {{-- <ul class="nav nav-tabs cms-tabs mb-4">
                <li class="nav-item btn btn-info mx-1" id="create_by_category">{{ __('base.units.create_by_category') }}</li>
                <li class="nav-item btn btn-info mx-1" id="create_new_unit">{{ __('base.units.create_new_unit') }}</li>
            </ul> --}}

            <div id="select_category">
                @include('backend.includes.inputs.select', [
                    'options' => [
                        'id'          => 'category_id',
                        'nullable'    => true,
                        'name'        => 'category_id',
                        'label'       => __('base.units.fields.category_id.label'),
                        'placeholder' => __('base.units.fields.category_id.placeholder'),
                        'data'        => $categories,
                        'selected'    => old('category_id', $data->category_id ),
                        'value'       => function($data, $key, $value){ return $value->id; },
                        'text'        => function($data, $key, $value){ return $value->name; },
                        'select'      => function($data, $selected, $key, $value){ return $selected == $value->id; },
                    ]
                ])
            </div>

            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'name',
                    'name'        => 'name',
                    'label'       => __('base.units.fields.name.label'),
                    'placeholder' => __('base.units.fields.name.placeholder'),
                    'help'        => __('base.units.fields.name.help'),
                    'value'       => old('name', $data->name)
                ]
            ])
            <div class="row">
                <div class="col-9 pr-0">
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'code',
                            'name'        => 'code',
                            'label'       => __('base.units.fields.code.label'),
                            'placeholder' => __('base.units.fields.code.placeholder'),
                            'help'        => __('base.units.fields.code.help'),
                            'value'       => old('code', $data->code)
                        ]
                    ])
                </div>
                <div class="col-3 code-gen">
                    <button class="btn btn-info btn-genrate-code" id="genrate_code" >{{  __('base.units.genrate_code') }}</button>
                </div>
            </div>
            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'price',
                    'name'        => 'price',
                    'type'        => 'number',
                    'step'        => '0.01',
                    'label'       => __('base.units.fields.price.label'),
                    'placeholder' => __('base.units.fields.price.placeholder'),
                    'value'       => old('price', $data->price)
                ]
            ])
            @include('backend.includes.inputs.select', [
                'options' => [
                    'id'          => 'status',
                    'nullable'    => false,
                    'name'        => 'status',
                    'label'       => __('base.units.fields.status.label'),
                    'placeholder' => __('base.units.fields.status.placeholder'),
                    'help'        => __('base.units.fields.status.help'),
                    'data'        => ["ACTIVE", "NOT_ACTIVE"],
                    'selected'    => old('status', $data->status),
                    'value'       => function($data, $key, $value){ return $value; },
                    'text'        => function($data, $key, $value){ return __('base.units.fields.status.'.$value); },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                ]
            ])
        </div>
    </div>
    @include('backend.includes.buttons', ['type' => 'update'])
</form>
@endsection

@push('styles')
<style>
    .code-gen{
        padding: 0;
        margin-top: 23px;
    }
    .btn-genrate-code{
        width: 100%;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cms-tabs{
        width: 100% !important;
        display: flex;
        align-items: center;
        justify-content: space-around;
        border: unset !important;
    }
    #select_category{
        display: none
    }
</style>
@endpush

@push('scripts')
<script>
    $('#genrate_code').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            method     : 'GET',
            url        : "{!! route('units::generateCode') !!}",
            data       : {},
            statusCode : {
                200 : function(data) {
                    $('#code').val(data);
                }
            }
        });
    });

    $('#category_id').change(function (e) {
        $.ajax({
            method     : 'GET',
            url        : "{!! route('units::getCategory') !!}",
            data       : {
                category_id : $(this).children("option:selected").val(),
            },
            statusCode : {
                200 : function(data) {
                    $('#name').val(data.name);$('#code').val(data.code);$('#price').val(data.price);$('#status').val(data.status);
                    $('#genrate_code').prop("disabled",true);$('#name').prop("disabled",true);$('#code').prop("disabled",true);$('#price').prop("disabled",true);$('#status').prop("disabled",true);
                }
            }
        });
    });

    $('#create_by_category').click(function() {
        $('#select_category').fadeIn();
        $('#units_type').val('from_categories');
    });
    $('#units_type').val('new');
    $('#create_new_unit').click(function() {
        $('#select_category').fadeOut();
        $('#units_type').val('new');
        $('#name').val('');$('#code').val('');$('#price').val('');$('#status').val('');
        $('#genrate_code').prop("disabled",false);$('#name').prop("disabled",false);$('#code').prop("disabled",false);$('#price').prop("disabled",false);$('#status').prop("disabled",false);
    });
</script>
@endpush
