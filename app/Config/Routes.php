<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('login', 'LoginController::index');
$routes->post('login/login', 'LoginController::login');
$routes->get('register', 'RegisterController::index');
$routes->post('register/process', 'RegisterController::process');
$routes->post('register/add_new_org', 'RegisterController::add_new_org');