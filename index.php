<?php
/**
 * Bootstraps the application
 */

date_default_timezone_set('UTC');

# Load composer libraries
require_once 'vendor/autoload.php';

# Settings
define('__MYSQL_HOST__', 'mysql://user:password@host/database'); // mysql://user:password@host/database
define("__CACHE_DIR__", __DIR__ . '/cache/'); // Set to false or directory path WITH trailing slash
define("__TEMPLATE_DIR__", __DIR__ . '/templates/'); // Path to templates, WITH trailing slash
define("__MODEL_DIR__", __DIR__ . '/lib/models/'); // Path to activerecord models, WITH trailing slash


ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_model_directory(__MODEL_DIR__);    
    $cfg->set_connections(array(
        'development' => __MYSQL_HOST__));    
 	}
);

# Load our handlers
require_once __DIR__ . '/lib/handlers/ShowHandler.php';
require_once __DIR__ . '/lib/handlers/ShowsHandler.php';
require_once __DIR__ . '/lib/handlers/ShowsXMLHandler.php';
require_once __DIR__ . '/lib/handlers/ShowXHRHandler.php';
require_once __DIR__ . '/lib/routes.php';

Toro::serve($routes);