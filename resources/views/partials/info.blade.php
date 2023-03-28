@isset($info)
    <div class="cms-info">
        @isset($info['icon'])
            <i class="icon {{ $info['icon'] }}"></i>
        @endisset
        <span class="info"> {{ ucfirst($info['title']) }} </span>
    </div>
@endisset

@push('styles')
<style>
    .cms-info {
        margin: 20px;
        display: flex;
        justify-content: start;
        align-items: center;
        align-content: center;
        padding: 20px;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
    }
    .cms-info .icon{
        background-color: #E21818;
        color: #fff;
        padding: 10px;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin: 0 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: pulse 1s 1s ease-in-out infinite;
    }
    .info {
        color: #413543;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }
    @keyframes pulse {
      0% {
        opacity: 1;
      }
      50% {
        opacity: 0.5;
      }
      100% {
        opacity: 1;
      }
    }
</style>
@endpush
