<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\Classes\Core;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Traits\CmsTrait;

class AppServiceProvider extends ServiceProvider
{
    use CmsTrait;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::share('current_lang', \LaravelLocalization::getCurrentLocale());
        \View::share('supported_langs', \LaravelLocalization::getLocalesOrder());
        \View::share('lang_name', \LaravelLocalization::getCurrentLocaleName());
        \View::share('lang_direction', \LaravelLocalization::getCurrentLocaleDirection());

        view()->composer('*',function($view) {
            if(session()->get('_user') != null && session()->get('_token') != null){
                $view->with('_user', session()->get('_user'));
                $view->with('_token', session()->get('_token'));
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('app\Classes\Core', function ($app) {
            return new Core();
        });
        $this->ComposerMenu();
    }
    public function ComposerMenu()
    {
        view()->composer('backend.includes.main_menu', function($view){

            //dashboard
            app()->make('app\Classes\Core')->asideMenu([
                'header'     => __('base.rout_start.dashboard'),
                'label'      => __('base.rout_start.dashboard'),
                'link'       => route('dashboard'),
                'icon_class' => 'icon-screen-desktop',
                'ordering'   => 0
            ]);

            if(in_array($this->userType(), ["ROOT", "ADMIN"]))
            {
                //users
                $items = [];
                foreach(config('custom.users_type') as $key => $user)
                {
                    $items[] = [
                        'label'  => __('base.rout_start.users.types.'.$user),
                        'link'   => route('users', ['type' => strtolower($user)]),
                    ];
                }

                app()->make('app\Classes\Core')->asideMenu([
                    'header'     => __('base.rout_start.users.label'),
                    'label'      => __('base.rout_start.users.label'),
                    'link'       => '',
                    'icon_class' => 'icon-user',
                    'ordering'   => 1,
                    'items'      => $items
                ]);


                //categories
                app()->make('app\Classes\Core')->asideMenu([
                    'header'     => __('base.rout_start.categories.label'),
                    'label'      => __('base.rout_start.categories.label'),
                    'link'       => route('categories'),
                    'icon_class' => 'icon-list',
                    'ordering'   => 3,
                ]);

                //units
                app()->make('app\Classes\Core')->asideMenu([
                    'header'     => __('base.rout_start.units.label'),
                    'label'      => __('base.rout_start.units.label'),
                    'link'       => route('units'),
                    'icon_class' => 'icon-list',
                    'ordering'   => 4,
                ]);
            }
            //actions
            $actions = [];
            foreach($this->actions() as $key => $action)
            {
                $actions[] = [
                    'label'  => __('base.rout_start.actions.'.$action['relation_type']),
                    'link'   => route('actions', ['type' => $action['relation_type']]),
                ];
            }

            // actions
            app()->make('app\Classes\Core')->asideMenu([
                'header'     => __('base.rout_start.actions.label'),
                'label'      => __('base.rout_start.actions.label'),
                'link'       => '',
                'icon_class' => 'icon-user',
                'ordering'   => 2,
                'items'      => $actions
            ]);
        });
    }
}
