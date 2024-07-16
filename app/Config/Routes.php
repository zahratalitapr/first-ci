<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');
$routes->get('/pages/about', 'Pages::about');
$routes->get('/pages/contact', 'Pages::contact');
$routes->get('/komik', 'Komik::index');
$routes->get('/komik/create', 'Komik::create');
$routes->post('/komik/save', 'Komik::save');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');
$routes->get('/komik/edit/(:segment)', 'Komik::edit/$1');
$routes->post('/komik/update/(:segment)', 'Komik::update/$1');


$routes->get('/komik/(:any)', 'Komik::detail/$1');
