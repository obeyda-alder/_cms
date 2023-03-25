@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('categories') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.categories.new') }}</div>
    </div>
@endsection

@section('content')

<form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('categories::store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'name',
                    'name'        => 'name',
                    'label'       => __('base.categories.fields.name.label'),
                    'placeholder' => __('base.categories.fields.name.placeholder'),
                    'help'        => __('base.categories.fields.name.help'),
                    'value'       => old('name')
                ]
            ])
            <div class="row">
                <div class="col-6">
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'unit_min_limit',
                            'name'        => 'unit_min_limit',
                            'type'        => 'number',
                            'label'       => __('base.categories.fields.unit_min_limit.label'),
                            'placeholder' => __('base.categories.fields.unit_min_limit.placeholder'),
                            'value'       => old('unit_min_limit')
                        ]
                    ])
                </div>
                <div class="col-6">
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'unit_max_limit',
                            'name'        => 'unit_max_limit',
                            'type'        => 'number',
                            'label'       => __('base.categories.fields.unit_max_limit.label'),
                            'placeholder' => __('base.categories.fields.unit_max_limit.placeholder'),
                            'value'       => old('unit_max_limit')
                        ]
                    ])
                </div>
            </div>
            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'value_in_price',
                    'name'        => 'value_in_price',
                    'type'        => 'number',
                    'step'        => '0.01',
                    'label'       => __('base.categories.fields.value_in_price.label'),
                    'placeholder' => __('base.categories.fields.value_in_price.placeholder'),
                    'value'       => old('value_in_price')
                ]
            ])
            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'percentage',
                    'name'        => 'percentage',
                    'type'        => 'number',
                    'label'       => __('base.categories.fields.percentage.label'),
                    'placeholder' => __('base.categories.fields.percentage.placeholder'),
                    'value'       => old('percentage')
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
                    'selected'    => old('status'),
                    'value'       => function($data, $key, $value){ return $value; },
                    'text'        => function($data, $key, $value){ return __('base.categories.fields.status.'.$value); },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value; },
                ]
            ])
        </div>
    </div>
    @include('backend.includes.buttons', ['type' => 'create'])
</form>
@endsection

@push('styles')
<style>
    /*  */
</style>
@endpush

@push('scripts')
<script>
    //
</script>
@endpush
