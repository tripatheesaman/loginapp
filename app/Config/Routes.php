<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->get('/register', 'Register::index');
$routes->get('/profile', 'Login::profilePage');
$routes->get('/loginWithGoogle', 'Login::loginWithGoogle');
$routes->get('/loginWithFacebook', 'Login::loginWithFacebook');
$routes->get('/logout', 'Login::logout');
$routes->post('/login/loginWithForm', 'Login::loginWithForm');
$routes->post('/register/registerConfirmation', 'Register::registerConfirmation');
$routes->get('/payment', 'Payment::index');
$routes->get('/verify', 'Payment::verify');

