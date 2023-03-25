<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
      <a class="navbar-brand brand-logo" href="javascript:;">
        <img src="{{ asset('images/faces/money-transfer-icon-16.jpg') }}" alt="logo" class="logo-dark pt-3" style="height:83px;width: 100px"/>
      </a>
      <a class="navbar-brand brand-logo-mini" href="javascript:;"><img src="{{ asset('images/faces/money-transfer-icon-16.jpg') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
      <ul class="navbar-nav navbar-nav-right ml-auto">
        <li class="nav-item order_count"><i class="icon-bell" id="icon-bell"></i></li>
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
                <a href="{!! LaravelLocalization::getLocalizedURL($lang_code, request()->fullUrl(), []) !!}" class="dropdown-item m-nav__link{!! ( $lang_code == $current_lang ) ? ' m-nav__link--active' : '' !!}">
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
