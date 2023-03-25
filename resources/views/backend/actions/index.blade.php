@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('actions') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.actions.label') }}</div>
        <div class="actions-component">
            @foreach ($operations['operations'] as $item)
                <span class="btn btn-danger m-1 font-size">{{  str_replace('_',' ',$item['type_'.$current_lang]) }}</span>
            @endforeach
        </div>
    </div>
@endsection

@section('content')
    @empty(!$operations['operations'])
        <form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('make_operations') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{$type}}">
            <div class="row">
                <div class="col-md-12">
                    @include('backend.includes.inputs.select', [
                        'options' => [
                            'id'          => 'operations',
                            'nullable'    => false,
                            'name'        => 'operations',
                            'label'       => __('base.actions.operations.label'),
                            'placeholder' => __('base.actions.operations.placeholder'),
                            'help'        => __('base.actions.operations.help'),
                            'data'        => $operations['operations'],
                            'selected'    => old('operations'),
                            'value'       => function($data, $key, $value){ return $value['type_en']; },
                            'text'        => function($data, $key, $value){ return $value['type_'.app()->getLocale()]; },
                            'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                        ]
                    ])
                    <div id="to_user_id">
                        @include('backend.includes.inputs.select', [
                            'options' => [
                                'nullable'    => false,
                                'name'        => 'to_user_id',
                                'label'       => __('base.actions.to_user.label'),
                                'placeholder' => __('base.actions.to_user.placeholder'),
                                'help'        => __('base.actions.to_user.help'),
                                'data'        => $all_user['data'],
                                'selected'    => old('to_user_id'),
                                'value'       => function($data, $key, $value){ return $value['id']; },
                                'text'        => function($data, $key, $value){ return $value['name']; },
                                'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                            ]
                        ])
                    </div>
                    <div id="price">
                        @include('backend.includes.inputs.text', [
                            'options' => [
                                'name'        => 'price',
                                'type'        => 'number',
                                'step'        => '0.01',
                                'label'       => __('base.actions.price.label'),
                                'placeholder' => __('base.actions.price.placeholder'),
                                'help'        => __('base.actions.price.help'),
                                'value'       => old('price')
                            ]
                        ])
                    </div>
                    @include('backend.includes.inputs.text', [
                        'options' => [
                            'id'          => 'unit_value',
                            'name'        => 'unit_value',
                            'label'       => __('base.actions.unit_value.label'),
                            'placeholder' => __('base.actions.unit_value.placeholder'),
                            'help'        => __('base.actions.unit_value.help'),
                            'value'       => old('unit_value')
                        ]
                    ])
                </div>
            </div>
            @include('backend.includes.buttons', ['type' => 'create'])
        </form>
    @else
        <span class="no_data">{{ __('base.no_data_operations') }}</span>
    @endempty
@endsection

@push('styles')
<style>
    .no_data{
        display: flex !important;
        justify-content: center;
        align-items: center;
        font-size: 20px;
    }
    .dispaly{
        display: grid ;
        justify-content: start !important;
        justify-content: center;
        align-items: center;
    }
    .font-size{
        font-size: 12px;
    }
</style>
@endpush
@push('scripts')
<script>
    $(function() {
        let operation = $('#operations').val();

        if(operation == "CENTRAL_OBSTETRICS"){
            $('#to_user_id').hide();
        }else{
            $('#to_user_id').show();
        }

        if(operation == "PACKING"){
            $('#to_user_id').hide();
            $('#price').hide();
        }else{
            $('#to_user_id').show();
            $('#price').show();
        }

        $('#operations').on('change', function(){
            let val = $(this).val();
            if(val == "CENTRAL_OBSTETRICS"){
                $('#to_user_id').hide();
            }else{
                $('#to_user_id').show();
            }

            if(val == "PACKING") {
                $('#to_user_id').hide();
                $('#price').hide();
            }else{
                $('#to_user_id').show();
                $('#price').show();
            }
        })
    });
  </script>
@endpush
