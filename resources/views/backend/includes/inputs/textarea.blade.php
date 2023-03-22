
@if(isset($options))
@php
    $opt = array_merge([
        'rows'        => 3,
        'id'          => null,
        'type'        => 'text',
        'name'        => 'text',
        'label'       => 'Text Input',
        'placeholder' => null,
        'help'        => null,
        'errorBag'    => null,
        'input_class' => 'm-input--air',
        'value'       => null,
    ], $options);

    if( ! $opt['id'] ) $opt['id'] = $opt['name'];

    $error_name = str_replace('][', '.', $opt['name']);
    $error_name = str_replace('[', '.', $error_name);
    $error_name = str_replace(']', '', $error_name);

    $opt['errorBag'] = ( ! $opt['errorBag'] ) ? $errors : $errors->{$opt['errorBag']};
@endphp
<div class="form-group m-form__group{{ $opt['errorBag']->has( $opt['name'] ) ? ' has-danger' : '' }}">
    @if( $opt['label'] )
        <label for="{{ $opt['id'] }}"> {{ $opt['label'] }} </label>
    @endif
    <textarea
        name="{{ $opt['name'] }}"
        rows="{{ $opt['rows'] }}"
        type="{{ $opt['type'] }}"
        class="form-control m-input {{ $opt['input_class'] }}"
        id="{{ $opt['id'] }}"
        placeholder="{{ ($opt['placeholder']) ? $opt['placeholder'] : '' }}">{!! ($opt['value']) ? $opt['value'] : '' !!}</textarea>


    @if( $opt['errorBag']->has( $error_name ) )
        <div class="form-control-feedback">
            {{ $opt['errorBag']->first( $error_name ) }}
        </div>
    @endif

    @if( $opt['help'] )
        <span class="m-form__help"> {{ $opt['help'] }} </span>
    @endif
</div>
@endif
