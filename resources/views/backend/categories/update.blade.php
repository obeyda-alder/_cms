@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('categories') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.categories.update', ['name' => $categories->name]) }}</div>
    </div>
@endsection

@section('content')

<form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('categories::e-store') }}">
    @csrf
    <input type="hidden" name="cat_id" value="{{ $categories->id }}">
    <div class="row">
        <div class="col-md-6">

            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'name',
                    'name'        => 'name',
                    'label'       => __('base.categories.fields.name.label'),
                    'placeholder' => __('base.categories.fields.name.placeholder'),
                    'help'        => __('base.categories.fields.name.help'),
                    'value'       => old('name', $categories->name)
                ]
            ])

            <div class="row">
                <div class="col-9 pr-0">
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'code',
                            'name'        => 'code',
                            'label'       => __('base.categories.fields.code.label'),
                            'placeholder' => __('base.categories.fields.code.placeholder'),
                            'help'        => __('base.categories.fields.code.help'),
                            'value'       => old('code', $categories->code)
                        ]
                    ])
                </div>
                <div class="col-3 code-gen">
                    <button class="btn btn-info btn-genrate-code" id="genrate_code" >{{  __('base.categories.genrate_code') }}</button>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'from',
                            'name'        => 'from',
                            'type'        => 'number',
                            'label'       => __('base.categories.fields.from.label'),
                            'placeholder' => __('base.categories.fields.from.placeholder'),
                            // 'help'        => __('base.categories.fields.from.help'),
                            'value'       => old('from', $categories->from == 0 ? '0.00' : $categories->from)
                        ]
                    ])
                </div>
                <div class="col-6">
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'to',
                            'name'        => 'to',
                            'type'        => 'number',
                            'label'       => __('base.categories.fields.to.label'),
                            'placeholder' => __('base.categories.fields.to.placeholder'),
                            // 'help'        => __('base.categories.fields.to.help'),
                            'value'       => old('to', $categories->to)
                        ]
                    ])
                </div>
            </div>

            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'price',
                    'name'        => 'price',
                    'type'        => 'number',
                    'step'        => '0.01',
                    'label'       => __('base.categories.fields.price.label'),
                    'placeholder' => __('base.categories.fields.price.placeholder'),
                    // 'help'        => __('base.categories.fields.price.help'),
                    'value'       => old('price', $categories->price)
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
                    'data'        => ["ACTIVE", "NOT_ACTIVE"],
                    'selected'    => old('status', $categories->status),
                    'value'       => function($data, $key, $value){ return $value; },
                    'text'        => function($data, $key, $value){ return __('base.categories.fields.status.'.$value); },
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
</style>
@endpush

@push('scripts')
<script>
    $('#genrate_code').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            method     : 'GET',
            url        : "{!! route('categories::generateCode') !!}",
            data       : {},
            statusCode : {
                200 : function(data) {
                    $('#code').val(data);
                }
            }
        });
    })
</script>
@endpush
