<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('label.dashboard'), route('dashboard.index'));
});


Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('label.user'), route('user.index'));
});

// Breadcrumbs::for('user/create', function (BreadcrumbTrail $trail) {
//     $trail->parent('user');
//     $trail->push(__('label.create'), route('user.create'));
// });

// Breadcrumbs::for('user/edit', function (BreadcrumbTrail $trail, $id) {
//     $trail->parent('user');
//     $trail->push(__('label.edit'), route('user.edit', $id));
// });

// Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
//     $trail->parent('dashboard');
//     $trail->push(__('label.profile'), route('user.profile'));
// });
