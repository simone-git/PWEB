<?php

define('BASE_PATH', dirname(__DIR__));

define('SRC_PATH', BASE_PATH . '/src');
define('LIB_PATH', SRC_PATH . '/lib');

define('APP_PATH', BASE_PATH . '/app');
define('MODELS_PATH', APP_PATH . '/Models');
define('VIEWS_PATH', APP_PATH . '/Views');
define('CONTROLLERS_PATH', APP_PATH . '/Controllers');

define('ENV_FILE', BASE_PATH . '/.env');
define('CONFIG', parse_ini_file(ENV_FILE));


// ini_set('display_errors', '0');


require_once SRC_PATH . '/Router.php';

require_once LIB_PATH . '/Processor.php';

require_once APP_PATH . '/Controllers/BaseController.php';
require_once APP_PATH . '/Controllers/HomeController.php';
require_once APP_PATH . '/Controllers/LoginController.php';
require_once APP_PATH . '/Models/MySQL.php';


use App\Controllers\HomeController;
use App\Controllers\LoginController;


$router = new Router(BASE_PATH);

$router->route('GET', '', HomeController::class, 'index');
$router->route('GET', 'login', LoginController::class, 'loginForm');
$router->route('POST', 'login', LoginController::class, 'login');


echo $router->resolve($_SERVER['REQUEST_URI']);
