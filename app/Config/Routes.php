<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes for landing page
$routes->get('/', 'QuickOrderController::index');

// Routes for login
$routes->get('/login', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/login/callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/logout', 'Auth::logout');

// Routes for admin
$routes->group('admin_page', function($routes) {
    $routes->get('/', 'QuickOrderController::admin_page');
    $routes->match(['get', 'post'], 'addedit', 'QuickOrderController::addedit');
    $routes->match(['get', 'post'], 'addedit/(:num)', 'QuickOrderController::addedit/$1');
    $routes->get('delete/(:num)', 'QuickOrderController::delete/$1');
});

// Routes for menu page
$routes->get('/menu/(:num)', 'QuickOrderController::menu/$1');

// Routes for user page
$routes->get('/restaurant_user/(:num)', 'QuickOrderController::restaurant_user/$1');

$routes->resource('order');
$routes->resource('item');
$routes->resource('menu');



