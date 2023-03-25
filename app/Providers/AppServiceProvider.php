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
                    'icon_class' => 'icon-control-pause',
                    'ordering'   => 7,
                ]);

                //units history
                app()->make('app\Classes\Core')->asideMenu([
                    'header'     => __('base.rout_start.units_history.label'),
                    'label'      => __('base.rout_start.units_history.label'),
                    'link'       => route('units_history'),
                    'icon_class' => 'fas fa-coins',
                    'ordering'   => 5,
                ]);

                //money history
                app()->make('app\Classes\Core')->asideMenu([
                    'header'     => __('base.rout_start.money_history.label'),
                    'label'      => __('base.rout_start.money_history.label'),
                    'link'       => route('money_history'),
                    'icon_class' => 'fas fa-wallet',
                    'ordering'   => 6,
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
                'icon_class' => 'icon-list',
                'ordering'   => 2,
                'items'      => $actions
            ]);

            // actions
            app()->make('app\Classes\Core')->asideMenu([
                'header'     => __('base.rout_start.packing_order.label'),
                'label'      => __('base.rout_start.packing_order.label'),
                'link'       => route('show_order'),
                'icon_class' => 'icon-volume-2',
                'ordering'   => 3,
            ]);
        });
    }
}
