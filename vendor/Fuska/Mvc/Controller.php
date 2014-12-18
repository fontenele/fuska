<?php

namespace Fuska\Mvc;

abstract class Controller {

    /**
     * @var \Fuska\View\Html
     */
    public $view;

    /**
     * @var string
     */
    public $action;

    /**
     * @var \Fuska\Http\Request
     */
    public $request;

    public function __construct($action, $request) {
        $this->action = $action;
        $this->request = $request;
        $this->createView();
        $this->init();
    }

    public function init() {
        
    }

    public function createView() {
        // Template name
        $template = strpos($this->action, '-') === false ? \Fuska\System\String::camelToDash($this->action) : $this->action;
        $arrClass = explode('\\', get_class($this));
        $_controller = substr(\Fuska\System\String::camelToDash($arrClass[2]), 0, -11);
        if (!isset(\Fuska\App::$config['modulesPath'][$arrClass[0]])) {
            throw new \Exception\FileNotFoundException("Path from module {$arrClass[0]} not found.");
        }
        $modulePath = \Fuska\App::$config['modulesPath'][$arrClass[0]];
        if (is_dir("{$modulePath}/view/{$_controller}")) {
            $appPath = str_replace('/', '\/', APP_PATH);
            $moduleBasePath = preg_replace("/{$appPath}/", '', $modulePath, 1);

            switch (true) {
                case \Fuska\App::$request->isAjax() && \Fuska\App::$request->get->type == 'html':
                    $this->view = new \Fuska\View\Html("{$moduleBasePath}view/{$_controller}/{$template}.phtml", ['request' => $this->request]);
                    break;
                case \Fuska\App::$request->isAjax() && \Fuska\App::$request->get->type == 'json':
                    $this->view = new \Fuska\View\Ria(['request' => $this->request]);
                    break;
                default:
                    $this->view = new \Fuska\View\Html("{$moduleBasePath}view/{$_controller}/{$template}.phtml", ['request' => $this->request]);
            }

//            if (\Fuska\App::$request->isAjax()) {
//                $this->view = new \Fuska\View\Ria(['request' => $this->request]);
//            } else {
//                $this->view = new \Fuska\View\Html("{$moduleBasePath}view/{$_controller}/{$template}.phtml", ['request' => $this->request]);
//            }
        }
    }

    public function callAction($action = null) {
        $arrClass = explode('\\', get_class($this));
        $this->action = $action ? $action : $this->action;
        $template = \strpos($this->action, '-') === false ? \Fuska\System\String::camelToDash($this->action) : $this->action;
        $_module = \Fuska\System\String::camelToDash($arrClass[0]);
        $_controller = \Fuska\System\String::camelToDash($arrClass[2]);
        $_action = \Fuska\System\String::camelToDash($this->action);
        $cssAndJs = \Fuska\App::loadJsAndCssFiles(get_class($this), $this->action);
        if (!isset(\Fuska\App::$config['modulesPath'][$arrClass[0]])) {
            throw new \Exception\FileNotFoundException("Path from module {$arrClass[0]} not found.");
        }
        $modulePath = \Fuska\App::$config['modulesPath'][$arrClass[0]];
        if (is_dir("{$modulePath}/view/{$_controller}")) {
            $appPath = str_replace('/', '\/', APP_PATH);
            $moduleBasePath = preg_replace("/{$appPath}/", '', $modulePath, 1);
            $this->view = new \Fuska\View\Html("{$moduleBasePath}view/{$_controller}/{$template}.phtml", ['request' => $this->request]);
        }
        \Fuska\App::$layout->css = $cssAndJs['css'];
        \Fuska\App::$layout->js = $cssAndJs['js'];
        return $this->{$this->action}();
    }

    public function addJsFile($file) {
        try {
            \Fuska\App::$layout->addJsFile($file);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function addCssFile($file) {
        try {
            \Fuska\App::$layout->addCssFile($file);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function addExtraJsFile($file) {
        try {
            \Fuska\App::$layout->addExtraJsFile($file);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function addExtraCssFile($file) {
        try {
            \Fuska\App::$layout->addExtraCssFile($file);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function addViewComponent($name) {
        try {
            if (!isset(\Fuska\App::$config['view']['components'][$name])) {
                return;
            }
            foreach (\Fuska\App::$config['view']['components'][$name]['css'] as $file) {
                $this->addExtraCssFile($file);
            }
            foreach (\Fuska\App::$config['view']['components'][$name]['js'] as $file) {
                $this->addExtraJsFile($file);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function redirect($path = null) {
        if ($path && substr($path, 0, 1) == '/') {
            $path = substr($path, 1);
        }
        \Fuska\App::$router->redirect($path);
    }

}
