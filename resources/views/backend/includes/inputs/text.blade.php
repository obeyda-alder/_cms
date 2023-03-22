@if(isset($options))
    @php
        $opt = array_merge([
            'id'          => null,
            'type'        => 'text',
            'step'        => '1',
            'name'        => 'text',
            'label'       => 'Text Input',
            'placeholder' => null,
            'help'        => null,
            'errorBag'    => null,
            'input_class' => 'input-group input-group',
            'value'       => null,
            'disabled'    => false,
            'readonly'    => false,
        ], $options);

        if( ! $opt['id'] ) $opt['id'] = $opt['name'];

        $error_name = str_replace('][', '.', $opt['name']);
        $error_name = str_replace('[', '.', $error_name);
        $error_name = str_replace(']', '', $error_name);

        $opt['errorBag'] = ( ! $opt['errorBag'] ) ? $errors : $errors->{$opt['errorBag']};
    @endphp
    <div class="form-group form__group{{ $opt['errorBag']->has( $opt['name'] ) ? ' has-danger' : '' }}">
        @if( $opt['label'] )
            <label for="{{ $opt['id'] }}"> {{ $opt['label'] }} </label>
        @endif
        <div class="input-group {{ $opt['input_class'] }}">
            @if($opt['type'] == 'password')
            <div class="input-group-append">
                <button class="btn btn-secondary input-group-button-password toggle-password" type="button"><i class="fa fa-lg fa-eye"></i></button>
            </div>
            @endif
            <input name="{{ $opt['name'] }}" type="{{ $opt['type'] }}" class="form-control input" id="{{ $opt['id'] }}" step="{{ $opt['step'] }}" placeholder="{{ ($opt['placeholder']) ? $opt['placeholder'] : '' }}" value="{{ ($opt['value']) ? $opt['value'] : '' }}" {!! ($opt['disabled']) ? ' disabled=""' : '' !!} {!! ($opt['readonly']) ? ' readonly=""' : '' !!} autocomplete="off">
        </div>
        @if( $opt['errorBag']->has( $error_name ) )
            <div class="form-control-feedback">
                {{ $opt['errorBag']->first( $error_name ) }}
            </div>
        @endif

        @if( $opt['help'] )
            <span class="form__help"> {{ $opt['help'] }} </span>
        @endif
    </div>

    @if( $opt['type'] == 'password' )
        @push('scripts')
        <script>
            $(".toggle-password").on('click', function() {
                $(this).children('i').toggleClass("fa-eye fa-eye-slash");
                var input = $(this).parent('div').siblings('input');
                if(input.attr("type") == "password")
                {
                    input.attr("type", "text");
                }
                else
                {
                    input.attr("type", "password");
                }
            });
        </script>
        @endpush
    @endif
@endif
