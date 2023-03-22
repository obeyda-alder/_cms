@unless($breadcrumbs->isEmpty())
    <div class="cms-breadcrumb">
        <ol class="breadcrumb">
            <li class="cms-breadcrumb-item breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i> <span class="mx-1"> - </span>
                    @if (Request::url() == route('dashboard'))
                        {{ __('base.dashboard') }}
                    @endif
                </a>
            </li>

            @foreach($breadcrumbs as $breadcrumb)
                @if(!is_null($breadcrumb->url) && !$loop->last)
                    <li class="cms-breadcrumb-item breadcrumb-item"><a href="{!! $breadcrumb->url !!}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="cms-breadcrumb-item breadcrumb-item active"> {{ $breadcrumb->title }} </li>
                @endif
            @endforeach
        </ol>
    </div>
@endunless

@push('styles')
<style>
    .cms-breadcrumb {
        margin: 20px;
        display: flex;
        justify-content: start;
        align-items: center;
        align-content: center;
        padding: 20px;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
    }

    .breadcrumb {
        font-size: 14px;
        margin: 0;
        padding: 0;
    }
    .breadcrumb-item.active {
        color: #38ce3c;
    }
    .breadcrumb-item a {
        color: #38ce3c;
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        color: #38ce3da8;
        text-decoration: none;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #38ce3c !important;
    }
    .breadcrumb-item:first-child + .breadcrumb-item::before {
        display: inline-block;
        color: #38ce3c !important;
        padding: 0;
        margin: 0;
        content: " ";
    }

</style>
@endpush
