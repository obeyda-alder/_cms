@if(isset($options))
    @php
        $opt = array_merge([
            'id'          => null,
            'type'        => 'text',
            'name'        => 'text',
            'label'       => 'Text Input',
            'placeholder' => null,
            'help'        => null,
            'errorBag'    => null,
            'input_class' => 'm-input--air',
            'default'     => null,
            'value'       => null,
            'select_label'=> 'Select',
            'change_label'=> 'Change',
            'remove_label'=> 'Remove',
            'remove_link' => 'javascript:;',
            'disable_add' => false,
            'load_scripts'=> true,
        ], $options);

        if( ! $opt['id'] ) $opt['id'] = $opt['name'];

        $opt['errorBag'] = ( ! $opt['errorBag'] ) ? $errors : $errors->{$opt['errorBag']};
    @endphp
    <div class="form-group m-form__group{{ $opt['errorBag']->has( $opt['name'] ) ? ' has-danger' : '' }}">
        @if( $opt['label'] )
            <label for="{{ $opt['id'] }}"> {{ $opt['label'] }} </label>
        @endif
        <div class="fileinput fileinput-{{ ($opt['value']) ? 'exists' : 'new' }} {{ $opt['input_class'] }} d-block" data-provides="fileinput">
            <div class="fileinput-new thumbnail">
                <img class="img-thumbnail" src="{!! $opt['default'] !!}" alt="" style="width: 100%;" />
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail img-thumbnail">
                @if($opt['value'])
                    <img class="" src="{!! $opt['value'] !!}" alt="" style="width: 100%;" />
                @endif
            </div>
            <div>
                @if(!$opt['disable_add'])
                    <span class="default btn-file">
                        <span class="fileinput-new btn m-btn--air btn-outline-success"> {{ $opt['select_label'] }} </span>
                        <span class="fileinput-exists btn m-btn--air btn-outline-primary"> {{ $opt['change_label'] }} </span>
                        <input type="file" name="{{ $opt['name'] }}">
                    </span>
                @endif
                <a href="{!! $opt['remove_link'] !!}" class="fileinput-exists btn m-btn--air btn-outline-danger" data-dismiss="fileinput">
                    {{ $opt['remove_label'] }}
                </a>
            </div>
        </div>
        @if( $opt['errorBag']->has( $opt['name'] ) )
            <div class="form-control-feedback">
                {{ $opt['errorBag']->first( $opt['name'] ) }}
            </div>
        @endif
        @if( $opt['help'] )
            <span class="m-form__help"> {{ $opt['help'] }} </span>
        @endif
    </div>
    @if($opt['load_scripts'])
        @push('styles')
            <link href="{{ asset('vendors/custom/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
        @endpush
        @push('scripts')
            <script src="{{ asset('vendors/custom/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
        @endpush
    @endif
@endif
