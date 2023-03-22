<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @foreach(app()->make('app\Classes\Core')->asideMenu->sortBy('ordering') as $key => $menu_item)
            @if($menu_item['header'])
                <li class="nav-item nav-category">
                    <span class="nav-link">{{ $menu_item['header'] }}</span>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{!! isset($menu_item['items']) ? '#'.$menu_item['label'] : $menu_item['link'] !!}" {!! isset($menu_item['items']) ? 'data-toggle="collapse" aria-controls="$menu_item["label"]" aria-expanded="false"' : '' !!}>
                    <span class="menu-title">{{ $menu_item['label'] }}</span>
                    <i class="{{ $menu_item['icon_class'] }} menu-icon"></i>
                </a>
                @if(isset($menu_item['items']))
                    <div class="collapse" id="{{ $menu_item['label'] }}">
                        <ul class="nav flex-column sub-menu">
                            @foreach($menu_item['items'] as $ke => $val)
                                <li class="nav-item"> <a class="nav-link" href="{{ $val['link'] }}">{{ $val['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
