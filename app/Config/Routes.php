<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('geojson/(:any)', 'Geojson::show/$1');
$routes->match(['get', 'post'], 'upload-api', 'UploadController::upload');



