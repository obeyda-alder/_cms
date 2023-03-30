<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
      <a class="navbar-brand brand-logo" href="javascript:;">
        <img src="{{ asset('images/faces/money-transfer-icon-16.jpg') }}" alt="logo" class="logo-dark pt-3" style="height:83px;width: 100px"/>
      </a>
      <a class="navbar-brand brand-logo-mini" href="javascript:;"><img src="{{ asset('images/faces/money-transfer-icon-16.jpg') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
        <div class="header-statistic d-flex">
            @if ($_user['unit'])
                <div class="units">{{ __('base.header_statistic.units_statistic') }} : {{ $_user['unit']['unit_count'] }}</div>
            @endif
            @if ($_user['money'])
                <div class="money">
                    <div class="dropdown">
                        <button class="dropbtn">{{ __('base.header_statistic.money_statistic') }}</button>
                        <div class="dropdown-content">
                            @foreach ($_user['money'] as $item)
                                <p class="money_stat">{{ $item['config_currency']['currency'] }} : {{ $item['amount'] }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if ($_user['user_units'])
                <div class="user_units">
                    <div class="dropdown">
                        <button class="dropbtn">{{__('base.header_statistic.unit_type_statistic') }}</button>
                        <div class="dropdown-content">
                            @foreach ($_user['user_units'] as $key => $item)
                                <p class="user_units_stat">{{ __('base.unit_type.'.$_user['type_unit_type'][$key]['type']) }} : {{ $item['unit_type_safe']['unit_type_count'] }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
      <ul class="navbar-nav navbar-nav-right ml-auto">
        <li class="nav-item order_count"><a href="{{ route('show_order') }}"><i class="icon-bell" id="icon-bell"></i></a></li>
        @if(count($supported_langs) > 1)
        <li class="nav-item dropdown language-dropdown d-none d-sm-flex align-items-center">
          <a class="nav-link d-flex align-items-center dropdown-toggle" id="LanguageDropdown" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
            <div class="d-inline-flex mr-3">
              <img class="flag-icon flag-icon-{{$current_lang}}" src="{!! asset('images/flags/'.$current_lang.'.svg') !!}" />
            </div>
            <span class="profile-text font-weight-normal">{{$lang_name}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2" aria-labelledby="LanguageDropdown">
            @foreach($supported_langs as $lang_code => $lang)
            {{-- {!! LaravelLocalization::getLocalizedURL($lang_code, request()->fullUrl(), []) !!}   {!! route('configurations::config::trans', $lang_code) !!} --}}
                <a href="{!! LaravelLocalization::getLocalizedURL($lang_code, request()->fullUrl(), [], true) !!}" class="dropdown-item m-nav__link{!! ( $lang_code == $current_lang ) ? ' m-nav__link--active' : '' !!}">
                    <img class="flag-icon m-2 flag-icon-{{$lang_code}}" src="{!! asset('images/flags/'.$lang_code.'.svg') !!}" />
                     {{ $lang['native'] }}
                </a>
            @endforeach
          </div>
        </li>
        @endif

        <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
          <a class="nav-link dropdown-toggle" id="UserDropdown" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
            <img class="img-xs rounded-circle ml-2 w-100 h-100" src="{{ $_user['image'] }}" alt="Profile image"> <span class="font-weight-normal">
                {{ $_user['name'] ?? 'not found'}}
             </span></a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <div class="dropdown-header text-center">
              <img class="img-md rounded-circle w-50 h-50" src="{{ $_user['image'] }}" alt="Profile image">
              <p class="mb-1 mt-3">
                {{ $_user['name'] ?? 'not found' }}
            </p>
              <p class="font-weight-light text-muted mb-0">
                {{ $_user['email'] ?? 'not found' }}
            </p>
            </div>
            <a class="dropdown-item" href="{{ route('users::edit', ['id' => $_user['id'], 'type' => $_user['type'] ]) }}">
              <i class="dropdown-item-icon icon-user text-primary"></i>
              {{ __('base.profile') }}
            </a>
            <a class="dropdown-item" href="javascript:;">
              <i class="dropdown-item-icon icon-energy text-primary"></i>
              {{ $_user['type'] ?? 'not found' }}
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                <i class="dropdown-item-icon icon-power text-primary"></i> {{ __('base.logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
               {{csrf_field()}}
            </form>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
  </nav>
