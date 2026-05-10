<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

if (PHP_SAPI === 'cli-server') {
    $assetPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $assetFile = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $assetPath);

    if ($assetPath !== '/' && is_file($assetFile)) {
        return false;
    }
}

$sessionPath = BASE_PATH . '/storage/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0775, true);
}
ini_set('session.save_path', $sessionPath);
session_start();

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$basePath = rtrim($scriptDir, '/');
if ($basePath === '/' || $basePath === '.') {
    $basePath = '';
}
define('APP_BASE', $basePath);

require APP_PATH . '/helpers.php';
require APP_PATH . '/Core/Database.php';
require APP_PATH . '/Core/Router.php';
require APP_PATH . '/Core/View.php';
require APP_PATH . '/Models/TravelRepository.php';
require APP_PATH . '/Controllers/PageController.php';

$controller = new PageController(new TravelRepository());
$router = new Router();

$router->get('/', [$controller, 'dashboard']);
$router->get('/dashboard', [$controller, 'dashboard']);

$router->get('/login', [$controller, 'login']);
$router->post('/login', [$controller, 'handleLogin']);
$router->get('/register', [$controller, 'register']);
$router->post('/register', [$controller, 'handleRegister']);
$router->get('/forgot-password', [$controller, 'forgot']);

$router->get('/trips', [$controller, 'trips']);
$router->get('/trips/create', [$controller, 'createTrip']);
$router->post('/trips', [$controller, 'storeTrip']);
$router->get('/trips/{id}', [$controller, 'itinerary']);
$router->get('/trips/{id}/builder', [$controller, 'builder']);
$router->get('/trips/{id}/budget', [$controller, 'budget']);
$router->get('/trips/{id}/checklist', [$controller, 'checklist']);
$router->post('/trips/{id}/checklist', [$controller, 'storeChecklist']);
$router->get('/trips/{id}/notes', [$controller, 'notes']);
$router->post('/trips/{id}/notes', [$controller, 'storeNote']);
$router->get('/trips/{id}/invoice', [$controller, 'invoice']);

$router->get('/search/cities', [$controller, 'citySearch']);
$router->get('/search/activities', [$controller, 'activitySearch']);
$router->get('/community', [$controller, 'community']);
$router->get('/share/{code}', [$controller, 'share']);
$router->get('/profile', [$controller, 'profile']);
$router->get('/admin', [$controller, 'admin']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
