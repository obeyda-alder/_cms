<?php
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

$locale = LaravelLocalization::setLocale();

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail): void {
    $trail->push('', '');
});

Breadcrumbs::for('users', function (BreadcrumbTrail $trail) : void {
    $type = request()->route()->parameter('type');
    $trail->push('users', route('users', $type));
    $trail->push($type, route('users', $type));
});

Breadcrumbs::for('actions', function (BreadcrumbTrail $trail) : void {
    $actions = request()->route()->parameter('type');
    $trail->push('actions', route('actions', $actions));
    $trail->push( __('base.rout_start.actions.'.$actions) , route('actions', $actions));
});

Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) : void {
    $trail->push('categories', route('categories'));
});

Breadcrumbs::for('units', function (BreadcrumbTrail $trail) : void {
    $trail->push('units', route('units'));
});
