<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Public ──────────────────────────────────
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');
$routes->post('contact/submit', 'Home::submitContact');
$routes->get('emergency', 'Home::emergency');

$routes->get('services', 'Services::index');
$routes->get('services/search', 'Services::search');
$routes->get('services/(:segment)', 'Services::detail/$1');

$routes->get('news', 'News::index');
$routes->get('news/(:segment)', 'News::detail/$1');

$routes->get('reports', 'Reports::index');
$routes->post('reports/submit', 'Reports::submit');
$routes->get('track', 'UserDashboard::trackReport');
$routes->post('track/lookup', 'UserDashboard::trackLookup');

$routes->get('transparency', 'Transparency::index');

// ── API (JSON) ──────────────────────────────
$routes->get('api/services/search', 'Services::apiSearch');
$routes->get('api/regions', 'Services::apiRegions');

// ── Citizen Auth ────────────────────────────
$routes->get('login', 'UserAuth::login');
$routes->post('login/authenticate', 'UserAuth::doLogin');
$routes->get('register', 'UserAuth::register');
$routes->post('register/create', 'UserAuth::doRegister');
$routes->get('logout', 'UserAuth::logout');

// ── Citizen Dashboard ───────────────────────
$routes->group('user', ['filter' => 'user_auth'], static function ($routes) {
    $routes->get('dashboard', 'UserDashboard::index');
    $routes->get('profile', 'UserDashboard::profile');
    $routes->post('profile/update', 'UserDashboard::updateProfile');
    $routes->post('profile/password', 'UserDashboard::changePassword');
    $routes->post('feedback/submit', 'UserDashboard::submitFeedback');
    $routes->get('reports', 'UserDashboard::myReports');
});

// ── Admin Auth ──────────────────────────────
$routes->get('admin-login', 'Auth::login');
$routes->post('admin-login/authenticate', 'Auth::authenticate');
$routes->get('admin-logout', 'Auth::logout');

// ── Admin Panel ─────────────────────────────
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::index');

    // Services CRUD
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->get('services/delete/(:num)', 'Admin\Services::delete/$1');

    // News CRUD
    $routes->get('news', 'Admin\News::index');
    $routes->get('news/create', 'Admin\News::create');
    $routes->post('news/store', 'Admin\News::store');
    $routes->get('news/edit/(:num)', 'Admin\News::edit/$1');
    $routes->post('news/update/(:num)', 'Admin\News::update/$1');
    $routes->get('news/delete/(:num)', 'Admin\News::delete/$1');

    // Reports
    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/view/(:num)', 'Admin\Reports::view/$1');
    $routes->post('reports/update-status/(:num)', 'Admin\Reports::updateStatus/$1');

    // Regions
    $routes->get('regions', 'Admin\Regions::index');
    $routes->get('regions/create', 'Admin\Regions::create');
    $routes->post('regions/store', 'Admin\Regions::store');
    $routes->get('regions/edit/(:num)', 'Admin\Regions::edit/$1');
    $routes->post('regions/update/(:num)', 'Admin\Regions::update/$1');

    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/view/(:num)', 'Admin\Users::view/$1');
    $routes->post('users/toggle/(:num)', 'Admin\Users::toggle/$1');
});
