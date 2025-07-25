<?php

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Home;
use App\Controllers\Admin;

// Home routes
$routes->get('/', [Home::class, 'index']);

// Auth routes
// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('login', [Auth::class, 'login']);
    $routes->post('login', [Auth::class, 'login']);
    $routes->get('register', [Auth::class, 'register']);
    $routes->post('register', [Auth::class, 'register']);
    $routes->get('logout', [Auth::class, 'logout']);


    
    // Updated social login routes (no parameters needed)
    $routes->get('google', [Auth::class, 'socialLogin']);
    $routes->get('google/callback', [Auth::class, 'socialLoginCallback']);
});

// Login/Register aliases for better UX
$routes->get('login', [Auth::class, 'login']);
$routes->post('login', [Auth::class, 'login']);
$routes->get('register', [Auth::class, 'register']);
$routes->post('register', [Auth::class, 'register']);
$routes->get('logout', [Auth::class, 'logout']);



// Dashboard routes (protected by auth filter)
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', [Dashboard::class, 'index']);
});

// Admin routes (protected by auth and admin filters)
$routes->group('admin', ['filter' => 'auth|admin'], function($routes) {
    $routes->get('/', [Admin::class, 'index']);
    
    // User management
    $routes->group('users', function($routes) {
        $routes->get('/', [Admin::class, 'users']);
        $routes->get('create', [Admin::class, 'createUser']);
        $routes->post('create', [Admin::class, 'createUser']);
        $routes->get('edit/(:num)', [Admin::class, 'editUser']);
        $routes->post('edit/(:num)', [Admin::class, 'editUser']);
        $routes->get('delete/(:num)', [Admin::class, 'deleteUser']);
    });
    
    // Role management
    $routes->group('roles', function($routes) {
        $routes->get('/', [Admin::class, 'roles']);
        $routes->get('create', [Admin::class, 'createRole']);
        $routes->post('create', [Admin::class, 'createRole']);
        $routes->get('edit/(:num)', [Admin::class, 'editRole']);
        $routes->post('edit/(:num)', [Admin::class, 'editRole']);
        $routes->get('delete/(:num)', [Admin::class, 'deleteRole']);
    });
    
    // Permission management
    $routes->group('permissions', function($routes) {
        $routes->get('/', [Admin::class, 'permissions']);
        $routes->get('create', [Admin::class, 'createPermission']);
        $routes->post('create', [Admin::class, 'createPermission']);
        $routes->get('edit/(:num)', [Admin::class, 'editPermission']);
        $routes->post('edit/(:num)', [Admin::class, 'editPermission']);
        $routes->get('delete/(:num)', [Admin::class, 'deletePermission']);
    });
});