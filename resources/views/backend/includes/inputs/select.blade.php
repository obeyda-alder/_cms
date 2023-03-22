@if ( isset( $options ) )
    @php
        $opt = array_merge([
            'id'          => null,
            'nullable'    => false,
            'searchable'  => true,
            'name'        => 'select',
            'data'        => [],
            'selected'    => null,
            'help'        => null,
            'label'       => null,
            'placeholder' => null,
            'value'       => function($data, $key, $value){ return null; },
            'text'        => function($data, $key, $value){ return null; },
            'image'       => function($data, $key, $value){ return null; },
            'type'        => function($data, $key, $value){ return null; },
            'sub_text'    => function($data, $key, $value){ return null; },
            'select'      => function($data, $selected, $key, $value){ return false; },
            'disabled'    => false,
            'multiple'    => false
        ], $options);

        if( ! $opt['id'] ) $opt['id'] = $opt['name'];
    @endphp
    <div class="form-group form__group{{ $errors->has($opt['name']) ? ' has-danger' : '' }}">
        @if ( ! is_null( $opt['label'] ) )
            <label for="{{ $opt['name'] }}">
                {{ $opt['label'] }}
            </label>
        @endif
        <select class="form-control bootstrap-select m_selectpicker input--air" id="{{ $opt['id'] }}" data-live-search="{{ ($opt['searchable']) ? 'true' : 'false' }}" name="{{ $opt['name'] }}" {!! ($opt['disabled']) ? ' disabled=""' : '' !!} {!! ($opt['multiple']) ? ' multiple=""' : '' !!}
            data-live-search="true"
            data-none-results-text="لا يوجد نتائج مطابقة"
            data-none-selected-text="غير محدد"
            data-select-all-text="تحديد الكل"
            data-deselect-all-text="إلغاء التحديد"
            data-count-selected-text="{0} عنصر محدد"
            data-actions-box="true"
            data-selected-text-format="count > 4">
            @if($opt['nullable'] && !$opt['multiple'])
                <option name="{{$opt['name']}}" value="" selected=""> -- </option>
            @endif
            @foreach ($opt['data'] as $key => $value)
                <option
                    name="{{$opt['name']}}"
                    {!! ( !is_null( $sub = $opt['sub_text']($opt['data'], $key, $value) ) ) ? 'data-subtext="'. e($sub) .'" ' : '' !!}
                    {!! ( !is_null( $sub = $opt['image']($opt['data'], $key, $value) ) ) ? 'data-image="'. e($sub) .'" ' : '' !!}
                    {!! ( !is_null( $sub = $opt['type']($opt['data'], $key, $value) ) ) ? 'data-type="'. e($sub) .'" ' : '' !!}
                    value="{{ $opt['value']($opt['data'], $key, $value) }}"
                    {!! $opt['select']($opt['data'], $opt['selected'], $key, $value) ? ' selected=""' : '' !!}>
                    {{ $opt['text']($opt['data'], $key, $value) }}
                </option>
            @endforeach
        </select>
        @if($opt['disabled'])
            @foreach ($opt['data'] as $key => $value)
                @if( $selected = $opt['select']($opt['data'], $opt['selected'], $key, $value) )
                    <input name="{{$opt['name']}}" type="hidden" value="{{ $opt['value']($opt['data'], $key, $value) }}">
                @endif
            @endforeach
        @endif
        @if ( $errors->has( $opt['name'] ) )
            <div class="form-control-feedback">
                {{ $errors->first($opt['name']) }}
            </div>
        @endif
        @if ( ! is_null( $opt['help'] ) )
            <span class="form-help">
                {{ $opt['help'] }}
            </span>
        @endif
    </div>
@endif
