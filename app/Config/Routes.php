<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('geojson/(:any)', 'Geojson::show/$1');
$routes->match(['get', 'post'], 'upload-api', 'UploadController::upload');
$routes->get('dbtest', 'DatabaseTest::index');

$routes->get('/api/last-awlr', 'TelemetryApi::updateAwlrToDB');

$routes->post('api/bulk-update-data', 'Home::bulkUpdate');
$routes->get('api/telemetri', 'Home::getTelemetriGeoJSON');
$routes->get('api/grafik/(:num)', 'Home::grafik/$1');
$routes->get('laporanrtd', 'LaporanRTD::index');
$routes->post('laporanrtd/submit', 'LaporanRTD::submit');
$routes->get('laporanrtd/download', 'LaporanRTD::download');

$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

$routes->get('dashboard', 'Dashboard::index');

$routes->get('/telemetri/fetch', 'TelemetryController::fetchAndStore');
$routes->get('telemetri/latest', 'TelemetryController::getBintangBano');
$routes->get('telemetri/tiusuntuk', 'TelemetryController::getTiuSuntuk');


// simpan tma manual
$routes->get('manual-tma', 'ManualTMAController::index');
$routes->match(['get', 'post', 'put'], 'manual-tma/update/(:num)', 'ManualTMAController::update/$1');



//admin
$routes->get('admin', 'Admin::index');
$routes->get('admin/data', 'Admin::data'); // ← endpoint untuk dashboard AJAX


//data api
$routes->get('logger-range', 'Data_api::index');
$routes->get('data-awlr', 'AwlrController::index');


//upload simulasi
$routes->post('api/update-simulasi', 'ApiSimulasi::updateSimulasi');
$routes->post('api/update-simulasi-gabungan', 'ApiSimulasi::updateSimulasiGabungan');
$routes->post('api/update-simulasi-awlr', 'ApiSimulasi::updateGabunganAwlr');

$routes->get('/simulasi-awlr', 'SimulasiAwlrController::index');


$routes->get('simulasi', 'SimulasiController::index');












