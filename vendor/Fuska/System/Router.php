<?php

namespace Fuska\System;

class Router {

    /**
     * @var array
     */
    public static $sslPorts = ['443'];

    /**
     * @var boolean
     */
    public $isSSL = false;

    /**
     * @var string
     */
    public $basePath;

    /**
     * @var string
     */
    public $jsBasePath;

    /**
     * @var string
     */
    public $serverName;

    /**
     * @var string
     */
    public $appName;

    /**
     * @var string
     */
    public $requestUri;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $default;

    /**
     * @var string
     */
    public $defaultAuth;

    /**
     * @param array $config
     */
    public function __construct($config) {
        $this->config($config);
        $this->defineControllerAndAction();
    }

    /**
     * @param array $config
     */
    public function config($config = []) {
        if (!\Fuska\App::$isCLI) {
            switch (true) {
                case isset($_SERVER['HTTPS']) && in_array($_SERVER['HTTPS'], ['on', '1', 1]):
                case isset($_SERVER['SERVER_PORT']) && in_array($_SERVER['SERVER_PORT'], self::$sslPorts):
                    $this->isSSL = true;
                    break;
                default:
                    $this->isSSL = false;
                    break;
            }

            $httpScheme = $this->isSSL ? 'https' : 'http';
            $this->serverName = "{$httpScheme}://{$_SERVER['SERVER_NAME']}";

            if ($_SERVER['SCRIPT_NAME'] == '/index.php') {
                $this->basePath = "{$httpScheme}://{$_SERVER['SERVER_NAME']}/";
                $this->jsBasePath = $this->basePath;
            } else {
                $host = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
                $this->basePath = "{$httpScheme}://{$_SERVER['HTTP_HOST']}{$host}/";
                $this->jsBasePath = $this->basePath . 'public/';
            }
            $appName = str_replace(array('/public', '/index.php'), '', $_SERVER['SCRIPT_NAME']);
            if (!$appName) {
                $appName = $_SERVER['SERVER_NAME'];
            }
            $this->appName = str_replace('/', '', $appName);
            $this->requestUri = preg_replace('/\\' . $appName . '/', '', $_SERVER['REQUEST_URI'], 1);
        }
        $this->default = $config['default'];
        $this->defaultAuth = $config['defaultAuth'];
    }

    /**
     */
    public function defineControllerAndAction() {
        if (\Fuska\App::$isCLI) {
            $_uri = $_SERVER['argv'][1];
            $uri = $this->parseRoute($_uri);
            $this->controller = $uri['controller'];
            $this->action = $uri['action'];
            if ($uri['params']) {
                \Fuska\App::$request->setQuery($uri['params']);
            }
            return;
        }

        $_uri = $this->default;
        if ($this->requestUri && $this->requestUri != '/') {
            $_uri = $this->requestUri;
        }
        $uri = $this->parseRoute($_uri);
        $this->controller = $uri['controller'];
        $this->action = $uri['action'];
        if ($uri['params']) {
            \Fuska\App::$request->setQuery($uri['params']);
        }
    }

    /**
     */
    public function getController() {
        return $this->controller;
    }

    /**
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @param string $className
     * @return string
     */
    public static function getRealPath($className) {
        $arrClassName = \explode('\\', $className);
        $_module = String::camelToDash($arrClassName[0]);
        $_class = $arrClassName[2];
        $path = "modules/{$arrClassName[0]}/" . strtolower($arrClassName[1]) . "/{$_class}.php";
        $realPath = file_exists(APP_PATH . $path) ? APP_PATH . $path : null;
        return $realPath;
    }

    /**
     * @param string $route
     * @return array
     */
    public function parseRoute($route) {
        if (substr($route, 0, 1) === '/') {
            $route = substr($route, 1);
        }
        $arrRoute = \explode('/', $route);
        $_module = ucfirst(String::dashToCamel(array_shift($arrRoute)));
        $_controller = ucfirst(String::dashToCamel(array_shift($arrRoute)));
        $_arrAction = explode('?', String::dashToCamel(array_shift($arrRoute)));
        $_action = $_arrAction[0];
        $_params = null;
        if (isset($arrRoute[count($arrRoute) - 1])) {
            $_params = explode('?', $arrRoute[count($arrRoute) - 1]);
            $arrRoute[count($arrRoute) - 1] = array_shift($_params);
        }
        $_params = count($_params) ? array_shift($_params) : null;
        for ($i = 0; $i < count($arrRoute); $i = $i + 2) {
            if (isset($arrRoute[$i + 1])) {
                if ($_params) {
                    $_params.= '&';
                }
                $_params.= "{$arrRoute[$i]}={$arrRoute[$i + 1]}";
            }
        }
        return array(
            'controller' => "{$_module}\Controller\\{$_controller}Controller",
            'action' => $_action,
            'params' => $_params
        );
    }

    /**
     * @param string $path
     */
    public function redirect($path = null) {
        $path = $this->basePath . $path;
        header("Location: {$path}");
        exit;
    }

}
