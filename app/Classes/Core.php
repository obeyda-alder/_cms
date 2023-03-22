<?php

namespace App\Classes;

class Core
{
    public $asideMenu;

    public function __construct()
    {
        $this->asideMenu = collect();
    }

    public function asideMenu( $menu = [] )
    {
        $default = [
            'header'      => null,
            'label'       => 'No Name Item',
            'link'        => 'javascript:;',
            'icon_class'  => null,
            'badge_count' => 0,
            'badge_type'  => 'danger',
            'items'       => null,
            'is_active'   => false,
            'ordering'    => 0
        ];

        $menu = array_merge( $default, $menu );

        if( request()->fullUrl() ==  $menu['link']) {
            $menu['is_active'] = true;
        }

        if( is_array( $menu['items'] ) )
        {
            foreach ($menu['items'] as $key => $item)
            {
                $menu['items'][ $key ] = array_merge($default, $item);
                if( request()->fullUrl() ==  $menu['items'][ $key ]['link']) {
                    $menu['items'][ $key ]['is_active'] = true;
                    $menu['is_active'] = true;
                }
            }
        }

        $this->asideMenu->push( $menu );
    }
}
