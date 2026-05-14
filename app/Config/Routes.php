<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ── Public routes ──────────────────────────────────────────────
$routes->get('/',           'GuideController::index/es');
$routes->get('lang/(:segment)', 'GuideController::switchLang/$1');

foreach (['es', 'en', 'fr'] as $lang) {
    $routes->get($lang,                      "GuideController::index/{$lang}");
    $routes->get("{$lang}/stop/(:segment)",  "GuideController::stop/{$lang}/$1");
}

// ── Admin auth (no filter) ──────────────────────────────────────
$routes->get( 'admin',         'Admin\AuthController::login');
$routes->get( 'admin/login',   'Admin\AuthController::login');
$routes->post('admin/login',   'Admin\AuthController::doLogin');
$routes->get( 'admin/logout',  'Admin\AuthController::logout');

// ── Admin protected routes ──────────────────────────────────────
$routes->group('admin', ['filter' => 'adminauth', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    // Stops CRUD
    $routes->get( 'stops',                    'StopsController::index');
    $routes->get( 'stops/create',             'StopsController::create');
    $routes->post('stops/store',              'StopsController::store');
    $routes->get( 'stops/edit/(:num)',        'StopsController::edit/$1');
    $routes->post('stops/update/(:num)',      'StopsController::update/$1');
    $routes->post('stops/delete/(:num)',      'StopsController::delete/$1');
    $routes->post('stops/delete-image/(:num)','StopsController::deleteImage/$1');

    // Users CRUD (superadmin only — checked in controller)
    $routes->get( 'users',               'UsersController::index');
    $routes->get( 'users/create',        'UsersController::create');
    $routes->post('users/store',         'UsersController::store');
    $routes->get( 'users/edit/(:num)',   'UsersController::edit/$1');
    $routes->post('users/update/(:num)', 'UsersController::update/$1');
    $routes->post('users/delete/(:num)', 'UsersController::delete/$1');
});
