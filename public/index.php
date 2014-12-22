<?php

/**
 * W2UI
 * JQUERY
 * REQUIRE JS
 * MONOLOG
 */

namespace Fuska;

class App {

    /**
     * @var array
     */
    public static $config = [];

    /**
     * @var View\Layout
     */
    public static $layout;

    /**
     * @var \Monolog\Logger
     */
    public static $logger;

    /**
     * @var Http\Request
     */
    public static $request;

    /**
     * @var System\Router
     */
    public static $router;

    /**
     * @var Database\Pdo
     */
    public static $db;

    /**
     * @var boolean
     */
    public static $logged = false;

    public static function init() {
        try {
            self::defineSystemConfigs();
            self::setConstants();
            self::loadVendors();
            self::startSession();
            self::startLogger();
            self::loadSystemConfigs();
            self::parseAndProcessRequest();
            self::parseAndProcessResponse();
            self::callAction(self::$router->getController(), self::$router->getAction(), self::$request);
        } catch (\Exception $ex) {
            die($ex->getMessage());
            xd($ex);
        }
    }

    public static function defineSystemConfigs() {
        date_default_timezone_set('America/Sao_Paulo');
        chdir(dirname(__DIR__));
        set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
        spl_autoload_register(function($className) {
            $router = App::$router;
            if ($router) {
                $realPath = $router::getRealPath($className);
                if ($realPath) {
                    require_once($realPath);
                }
            }
        });
    }

    public static function setConstants() {
        define('APP_PATH', dirname(__DIR__) . '/');
        define('VENDOR_PATH', dirname(__DIR__) . '/vendor/');
        define('PUBLIC_PATH', dirname(__DIR__) . '/public/');
        define('TMP_PATH', dirname(__DIR__) . '/public/tmp/');
        define('LOGS_PATH', dirname(__DIR__) . '/logs/');
        defined('APP_ENV') || define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'prod'));
        defined('APP_VERSION') || define('APP_VERSION', (getenv('APP_VERSION') ? getenv('APP_VERSION') : 'v0.0.0'));
    }

    public static function loadVendors() {
        require_once(VENDOR_PATH . 'autoload.php');
    }

    public static function startSession() {
        System\Session::create();
    }

    public static function startLogger() {
        self::$logger = new \Monolog\Logger(APP_ENV . '|' . APP_VERSION);
        self::$logger->pushHandler(new \Monolog\Handler\StreamHandler(LOGS_PATH . 'debug.log', \Monolog\Logger::DEBUG));
        self::$logger->pushHandler(new \Monolog\Handler\StreamHandler(LOGS_PATH . 'db.log', \Monolog\Logger::INFO));
        self::$logger->pushHandler(new \Monolog\Handler\StreamHandler(LOGS_PATH . 'errors.log', \Monolog\Logger::WARNING));
        self::$logger->pushHandler(new \Monolog\Handler\StreamHandler(LOGS_PATH . 'critical.log', \Monolog\Logger::CRITICAL));
    }

    public static function loadSystemConfigs() {
        $envs = ['dev', 'hom', 'prod'];
        $filesIgnore = [];
        $dir = new System\Dir(APP_PATH . 'config');
        $files = $dir->getFiles()->getArrayCopy();
        sort($files);

        foreach ($files as $file) {
            $filename = "{$dir->dirName}/{$file}";
            if (in_array($filename, $filesIgnore)) {
                continue;
            }
            if (System\File::fileExists($filename, APPLICATION_ENV)) {
                $filesIgnore[] = $filename;
                $filename = System\File::getFileName($filename, APPLICATION_ENV);
                $filesIgnore[] = $filename;
            } else {
                foreach ($envs as $env) {
                    if ($env == APPLICATION_ENV) {
                        continue;
                    }
                    if (System\File::fileExists($filename, $env)) {
                        $filesIgnore[] = $filename;
                        $filesIgnore[] = System\File::getFileName($filename, $env);
                    }
                }
            }
            $config = System\File::loadFile($filename);
            self::$config = array_merge_recursive(self::$config, $config);
        }
        self::loadModulesConfigs();
    }

    public static function loadModulesConfigs() {
        $envs = ['dev', 'hom', 'prod'];
        $modules = [];
        foreach (self::$config['system']['module'] as $module) {
            $path = null;
            if (is_array($module)) {
                $path = current($module);
                $module = key($module);
            }
            switch (true) {
                case $path && is_dir(APP_PATH . "modules/{$path}/{$module}"):
                    $modules[$module] = APP_PATH . "modules/{$path}/{$module}/";
                    break;
                case $path && is_dir(VENDOR_PATH . "{$path}/src/{$module}"):
                    $modules[$module] = VENDOR_PATH . "{$path}/src/{$module}/";
                    break;
                case $path && is_dir(VENDOR_PATH . "{$path}/{$module}/src/{$module}/"):
                    $modules[$module] = VENDOR_PATH . "{$path}/{$module}/src/{$module}/";
                    break;
                case is_dir(APP_PATH . "modules/{$module}"):
                    $modules[$module] = APP_PATH . "modules/{$module}/";
                    break;
                case is_dir(VENDOR_PATH . "{$module}/src/{$module}"):
                    $modules[$module] = VENDOR_PATH . "{$module}/src/{$module}/";
                    break;
                case is_dir(VENDOR_PATH . "{$module}/{$module}/src/{$module}"):
                    $modules[$module] = VENDOR_PATH . "{$module}/{$module}/src/{$module}/";
                    break;
            }
        }

        self::$config['modulesPath'] = $modules;

        foreach ($modules as $module) {
            if (is_dir("{$module}config")) {
                $filesIgnore = [];
                $dir = new System\Dir("{$module}config");
                $files = $dir->getFiles()->getArrayCopy();
                sort($files);
                foreach ($files as $file) {
                    $filename = "{$dir->dirName}/{$file}";
                    if (in_array($filename, $filesIgnore)) {
                        continue;
                    }
                    if (System\File::fileExists($filename, APPLICATION_ENV)) {
                        $filesIgnore[] = $filename;
                        $filename = System\File::getFileName($filename, APPLICATION_ENV);
                        $filesIgnore[] = $filename;
                    } else {
                        foreach ($envs as $env) {
                            if ($env == APPLICATION_ENV) {
                                continue;
                            }
                            if (System\File::fileExists($filename, $env)) {
                                $filesIgnore[] = $filename;
                                $filesIgnore[] = System\File::getFileName($filename, $env);
                            }
                        }
                    }
                    $config = System\File::loadFile($filename);
                    self::$config = array_merge_recursive(self::$config, $config);
                }
            }
        }
    }

    public static function parseAndProcessRequest() {
        self::$request = new Http\Request;
        self::$router = new System\Router(self::$config['system']['router']);
    }

    public static function parseAndProcessResponse() {
        switch (true) {
            case (!self::$request->get->type || (self::$request->get->type && !in_array(self::$request->get->type, ['html', 'json']))):
                self::createLayout();
                break;
            default:
                self::$request->isAjax = true;
        }
    }

    public static function createLayout() {
        self::$layout = new View\Layout('public/themes/' . self::$config['system']['view']['theme'] . '/view/' . self::$config['system']['view']['layout']);
        self::$layout->success = View\Messenger::getSuccess();
        self::$layout->error = View\Messenger::getError();
        self::$layout->userLogged = self::$logged;
        self::$layout->config = self::$config;
        self::$layout->basePath = self::$router->basePath;
        self::$layout->theme = self::$config['system']['view']['theme'];
        self::$layout->themePath = self::$router->basePath . 'themes/' . self::$config['system']['view']['theme'] . '/';
        self::$layout->env = APP_ENV;
        self::$layout->version = APP_VERSION;
    }

    public static function callAction($controller, $action, $request) {
        if (self::$layout) {
            if (isset(self::$config['system']['view']['afterRenderLayout'])) {
                foreach (self::$config['system']['view']['afterRenderLayout'] as $method) {
                    $method->render(self::$layout);
                }
            }
            $cssAndJs = self::$layout->loadJsAndCssFiles($controller, $action);
            $cssAndJs['css'] = array_merge(self::$layout->css, $cssAndJs['css']);
            $cssAndJs['js'] = array_merge(self::$layout->js, $cssAndJs['js']);
            self::$layout->css = $cssAndJs['css'];
            self::$layout->js = $cssAndJs['js'];
        }

        $controller = '\\' . $controller;
        if (!class_exists($controller)) {
            throw new \Exception("Controller {$controller} not found.", 404);
        }
        // Instance controller
        $obj = new $controller($action, $request);
        if (!method_exists($obj, $action)) {
            throw new \Exception("Action {$controller}::{$action} not found.", 404);
        }

        // Call action
        $view = $obj->$action($request);
        if ($view instanceof View\Json || $view instanceof View\Ria || ($view instanceof View\Html && !self::$layout)) {
            // Render Json output
            echo $view->render();
        } elseif (self::$layout) {
            // Set content var
            self::$layout->content = $view ? $view->render() : $obj->view->render();
            // Render layout with html headers
            echo self::$layout->renderWithHeader();
        }
        die;
    }

}

\Fuska\App::init();
