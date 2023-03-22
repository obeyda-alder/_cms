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

Breadcrumbs::for('agencies', function (BreadcrumbTrail $trail) : void {
    $agencies_type = request()->route()->parameter('agencies_type');
    $trail->push('agencies', route('agencies', $agencies_type));
    $trail->push( __('base.rout_start.agencies.agencies_types.'.$agencies_type) , route('agencies', $agencies_type));
});

Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) : void {
    $trail->push('categories', route('categories'));
});

Breadcrumbs::for('units', function (BreadcrumbTrail $trail) : void {
    $trail->push('units', route('units'));
});
