<?php

define('BASE_PATH', dirname(__DIR__));

define('SRC_PATH', BASE_PATH . '/src');
define('LIB_PATH', SRC_PATH . '/lib');

define('APP_PATH', BASE_PATH . '/App');
define('MODELS_PATH', APP_PATH . '/Models');
define('VIEWS_PATH', APP_PATH . '/Views');
define('CONTROLLERS_PATH', APP_PATH . '/Controllers');

define('ENV_FILE', BASE_PATH . '/.env');
define('CONFIG', parse_ini_file(ENV_FILE));


ini_set('display_errors', '1');
ini_set('session.gc_maxlifetime', 7200);


require_once SRC_PATH . '/Router.php';
require_once SRC_PATH . '/Session.php';

require_once LIB_PATH . '/Processor.php';
require_once LIB_PATH . '/Utils.php';

require_once APP_PATH . '/Controllers/BaseController.php';
require_once APP_PATH . '/Controllers/HomeController.php';
require_once APP_PATH . '/Controllers/AuthController.php';
require_once APP_PATH . '/Models/MySQL.php';


use App\Controllers\HomeController;
use App\Controllers\AuthController;


$router = new Router(BASE_PATH);

// TODO: method list, like 'GET,POST,...'
$router->route('GET', '', HomeController::class, 'index');
$router->route('GET', 'register', AuthController::class, 'registerForm');
$router->route('POST', 'register', AuthController::class, 'register');
$router->route('GET', 'login', AuthController::class, 'loginForm');
$router->route('POST', 'login', AuthController::class, 'login');
$router->route('GET', 'logout', AuthController::class, 'logout');
$router->route('GET', 'session', HomeController::class, 'session');


echo $router->resolve($_SERVER['REQUEST_URI']);
