<?php

/**
 * TWITTER BOOTSTRAP
 * JQUERY
 * JQUERY TEMPLATE
 * REQUIRE JS
 * MONOLOG
 */

namespace Fuska;

class App {

    public static function init() {
        try {
            self::defineSystemConfigs();
            self::setConstants();
            self::loadVendors();
            xd('foi', APP_PATH, APP_ENV, APP_VERSION);
        } catch (\Exception $ex) {
            xd($ex);
        }
    }

    public static function defineSystemConfigs() {
        date_default_timezone_set('America/Sao_Paulo');
        session_start();
        chdir(dirname(__DIR__));
        set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
        spl_autoload_register(function($className) {
//            $router = Kernel::$router;
//            if ($router) {
//                $realPath = $router::getRealPath($className);
//                if ($realPath) {
//                    require_once($realPath);
//                }
//            }
        });
    }

    public static function setConstants() {
        define('APP_PATH', dirname(__DIR__) . '/');
        define('VENDOR_PATH', dirname(__DIR__) . '/vendor/');
        define('PUBLIC_PATH', dirname(__DIR__) . '/public/');
        define('TMP_PATH', dirname(__DIR__) . '/public/tmp/');
        define('LOG_PATH', dirname(__DIR__) . '/logs/');
        defined('APP_ENV') || define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'prod'));
        defined('APP_VERSION') || define('APP_VERSION', (getenv('APP_VERSION') ? getenv('APP_VERSION') : 'v0.0.0'));
    }

    public static function loadVendors() {
        require_once(VENDOR_PATH . 'autoload.php');
    }

}

\Fuska\App::init();
