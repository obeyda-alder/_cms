@isset($type)
    <div class="form__actions cms-buttons-bottom">
        <button type="submit" class="btn m-btn--air btn-success mx-1">
            @if($type == 'create')
                {{ __('base.create') }}
            @elseif($type == 'update')
                {{ __('base.update') }}
            @endif
        </button>
        <a href="{{ URL::previous() }}" class="btn btn-outline-danger mx-1">
            {{ __('base.cancel') }}
        </a>
    </div>
@endisset
