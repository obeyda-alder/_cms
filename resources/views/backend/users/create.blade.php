@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('users') }}
@endsection

@section('cms-component')
    <div class="cms-buttons-">
        <div class="page-title">{{ __('base.users.new', [ 'type' => __('base.users.'.strtoupper($type)) ]) }}</div>
    </div>
@endsection

@section('content')

<form class="forms-sample" method="POST" onsubmit="OnFormSubmit(event)" action="{{ route('users::store', ['type' => $type]) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="{{$type}}">
    <div class="row">
        <div class="col-md-6">
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

            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'username',
                    'name'        => 'username',
                    'label'       => __('base.users.fields.username.label'),
                    'placeholder' => __('base.users.fields.username.placeholder'),
                    'help'        => __('base.users.fields.username.help'),
                    'value'       => old('username')
                ]
            ])

            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'email',
                    'name'        => 'email',
                    'type'        => 'email',
                    'label'       => __('base.users.fields.email.label'),
                    'placeholder' => __('base.users.fields.email.placeholder'),
                    'help'        => __('base.users.fields.email.help'),
                    'value'       => old('email')
                ]
            ])

            <div class="form-group m-form__group phone_number">
                <label>
                    @lang('base.users.fields.phone_number.label')
                </label>
                <div class="input-group">
                    <input id="search_for_user_input" dir="ltr" type="number" name="phone_number" class="form-control text-left" placeholder="@lang('base.users.fields.phone_number.placeholder')" value="">
                    <div class="input-group-prepend w-25" id="phone_country_code_input_group">
                        <select class="btn-group bootstrap-select input-group-btn form-control m-bootstrap-select m_selectpicker" name="phone_country_code" id="phone_country_code"
                        data-live-search="true"
                        data-none-results-text="لا يوجد نتائج مطابقة"
                        data-none-selected-text="غير محدد"
                        width="400">
                            @foreach($countries as $country)
                            {{--  <img src='{!! $country->flag !!}' width='20' height='16'> --}}
                            <option value="{{ $country['code'] }}" data-content="
                                <div>
                                    <span class='mx-2' dir='ltr'>{{ $country['code'] }}</span> ({{ $country['name_'.app()->getLocale()] }})
                                </div>"
                                {!! $country['code'] == old('phone_country_code', '+905') ? 'selected' : '' !!}>
                                <div>
                                    <span class='mx-2' dir='ltr'>{{ $country['code'] }}</span> ({{ $country['name_'.app()->getLocale()] }})
                                </div>
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ( $errors->has('phone_number') )
                    <div class="form-control-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="m-form__help">
                    @lang('base.users.fields.phone_number.help')
                </span>
            </div>

            @include('backend.includes.inputs.text', [
                'options' => [
                    'id'          => 'password',
                    'name'        => 'password',
                    'type'        => 'password',
                    'step'        => '1',
                    'label'       => __('base.users.fields.password.label'),
                    'placeholder' => __('base.users.fields.password.placeholder'),
                    'help'        => __('base.users.fields.password.help'),
                    'value'       => old('password')
                ]
            ])

            <div class="form-group m-form__group{{ $errors->has('confirm_password') ? ' has-danger' : '' }}">
                <label for="confirm_password">
                    {{ __('base.users.fields.confirm_password.label') }}
                </label>
                <div class="input-group input-group input-group">
                    <input name="confirm_password" type="password" class="form-control m-input m-input--air" id="confirm_password" placeholder="{{ __('base.users.fields.confirm_password.placeholder') }}" value="">
                </div>
                @if ( $errors->has('confirm_password') )
                    <div class="form-control-feedback">
                        {{ $errors->first('confirm_password') }}
                    </div>
                @endif
                <span class="m-form__help">
                    {{ __('base.users.fields.confirm_password.help') }}
                </span>
            </div>
            @include('backend.includes.inputs.select', [
                'options' => [
                    'id'          => 'country_selector',
                    'nullable'    => true,
                    'name'        => 'country_id',
                    'label'       => __('base.countries.label'),
                    'placeholder' => __('base.countries.placeholder'),
                    'help'        => null,
                    'data'        => $countries,
                    'selected'    => old('country_id'),
                    'value'       => function($data, $key, $value){ return $value['id']; },
                    'text'        => function($data, $key, $value){ return $value['name_'.app()->getLocale()]; },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                ]
            ])
            @include('backend.includes.inputs.select', [
                'options' => [
                    'id'          => 'cities_selector',
                    'nullable'    => true,
                    'name'        => 'city_id',
                    'label'       => __('base.cities.label'),
                    'placeholder' => __('base.cities.placeholder'),
                    'help'        => null,
                    'data'        => [],
                    'selected'    => old('city_id'),
                    'value'       => function($data, $key, $value){ return $value['id']; },
                    'text'        => function($data, $key, $value){ return $value['name_'.app()->getLocale()]; },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                ]
            ])
            @include('backend.includes.inputs.select', [
                'options' => [
                    'id'          => 'municipalities_selector',
                    'nullable'    => true,
                    'name'        => 'municipality_id',
                    'label'       => __('base.municipalities.label'),
                    'placeholder' => __('base.municipalities.placeholder'),
                    'help'        => null,
                    'data'        => [],
                    'selected'    => old('municipality_id'),
                    'value'       => function($data, $key, $value){ return $value['id']; },
                    'text'        => function($data, $key, $value){ return $value['name_'.app()->getLocale()]; },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                ]
            ])
            @include('backend.includes.inputs.select', [
                'options' => [
                    'id'          => 'neighborhoodes_selector',
                    'nullable'    => true,
                    'name'        => 'neighborhood_id',
                    'label'       => __('base.neighborhoodes.label'),
                    'placeholder' => __('base.neighborhoodes.placeholder'),
                    'help'        => null,
                    'data'        => [],
                    'selected'    => old('neighborhood_id'),
                    'value'       => function($data, $key, $value){ return $value['id']; },
                    'text'        => function($data, $key, $value){ return $value['name_'.app()->getLocale()]; },
                    'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
                ]
            ])
        </div>
        <div class="col-md-6">
            <div class="col-6">
                @include('backend.includes.inputs.singleImage', [
                    'options' => [
                        'name'        => 'image',
                        'label'       => __('base.users.fields.image.label'),
                        'placeholder' => null,
                        'default'     => $default,
                        'value'       => null,
                        'select_label'=> __('base.select'),
                        'change_label'=> __('base.change'),
                        'remove_label'=> __('base.remove'),
                    ]
                ])
            </div>
        </div>
    </div>
    @include('backend.includes.buttons', ['type' => 'create'])
</form>
@endsection

@push('scripts')
<script>
    $("#country_selector").change(function(){
        let country_id = $(this).children("option:selected").val();
        getCitiy(country_id);
    });
    $("#cities_selector").change(function(){
        let city_id = $(this).children("option:selected").val();
        getMunicipalites(city_id);
    });
    $("#municipalities_selector").change(function(){
        let municipality_id = $(this).children("option:selected").val();
        getNeighborhoodes(municipality_id);
    });
    function getCitiy(country_id) {
        $.ajax({
            method     : 'GET',
            url        : "{!! route('addresses::cities') !!}",
            data       : {
                name        : 'city_id',
                label       : '{{ __('base.cities.label') }}',
                placeholder : '{{ __('base.cities.placeholder') }}',
                help        : null,
                country_id  : country_id
            },
            statusCode : {
                200 : function(data) {
                    $('#cities_selector').html(data);
                }
            }
        });
    }
    function getMunicipalites(city_id) {
        $.ajax({
            method     : 'GET',
            url        : "{!! route('addresses::municipalites') !!}",
            data       : {
                name        : 'city_id',
                label       : '{{ __('base.municipalites.label') }}',
                placeholder : '{{ __('base.municipalites.placeholder') }}',
                help        : null,
                city_id     : city_id,
            },
            statusCode : {
                200 : function(data) {
                    $('#municipalities_selector').html(data);
                }
            }
        });
    }
    function getNeighborhoodes(municipality_id) {
        $.ajax({
            method     : 'GET',
            url        : "{!! route('addresses::neighborhoodes') !!}",
            data       : {
                name             : 'city_id',
                label            : '{{ __('base.neighborhoodes.label') }}',
                placeholder      : '{{ __('base.neighborhoodes.placeholder') }}',
                help             : null,
                municipality_id  : municipality_id,
            },
            statusCode : {
                200 : function(data) {
                    console.log(data);
                    $('#neighborhoodes_selector').html(data);
                }
            }
        });
    }
</script>
@endpush
