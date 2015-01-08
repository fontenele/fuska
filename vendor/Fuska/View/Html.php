<?php

namespace Fuska\View;

class Html extends \Fuska\System\ArrayObject {

    /**
     *
     * @var array
     */
    public $js = [];

    /**
     *
     * @var array
     */
    public $css = [];

    /**
     * @var string
     */
    public $template;

    public function __construct($template = null, $vars = array()) {
        parent::__construct($vars);
        //$this->this = $this;
        //$this->basePath = \Fuska\App::$router->basePath;
        //$this->theme = \Fuska\App::$config['system']['view']['theme'];
        //$this->themePath = \Fuska\App::$router->basePath . 'themes/' . \Fuska\App::$config['system']['view']['theme'] . '/';
        $this->template = $template;
    }

    public function render() {
        try {
            if ($this->template instanceof \Kf\System\File) {
                $this->template = str_replace(APP_PATH, '', $this->template->getName());
            }
            if (!$this->template || !file_exists(APP_PATH . $this->template)) {
                throw new \Exception;
            }
            ob_start();
            require APP_PATH . $this->template;
            $html = ob_get_clean();
            return $html;
        } catch (\Exception $ex) {
            throw new \Exception("Template {$this->template} not found.", 400);
        }
    }

    public function renderWithHeader() {
        try {
            header('Content-type: text/html; charset=UTF-8');
            return $this->render();
        } catch (\Exception $ex) {
            throw new \Exception("Template {$this->template} not found.", 400);
        }
    }

    public function __get($name) {
        return $this->offsetExists($name) ? $this->offsetGet($name) : '';
    }

    public function __set($name, $value = null) {
        $this->offsetSet($name, $value);
    }

    public function __call($name, $arguments) {
        $name = 'Fuska\View\Helper\\' . ucfirst($name);
        if (class_exists($name)) {
            $class = new $name();
            return call_user_func_array(array($class, "__invoke"), $arguments);
        }
    }

    public function partial($template, $vars = array()) {
        $partial = new Html($template, $vars);
        return $partial->render();
    }

    public function loadJsAndCssFiles($controller, $action) {
        $jsAndCss = ['css' => $this->css, 'js' => $this->js];
        $arrController = explode('\\', $controller);
        $_module = \Fuska\System\String::camelToDash($arrController[0]);
        $_controller = substr(\Fuska\System\String::camelToDash($arrController[2]), 0, -11);
        $_action = \Fuska\System\String::camelToDash($action);
        $modulePath = isset(\Fuska\App::$config['modulesPath'][$arrController[0]]) ? \Fuska\App::$config['modulesPath'][$arrController[0]] : null;

        // CSS
        if (file_exists(sprintf(APP_PATH . "public/%s/modules/{$_module}/{$_controller}/{$_action}.%s", 'css', 'css'))) {
            $jsAndCss['css'][] = sprintf(\Fuska\App::$router->basePath . "%s/modules/{$_module}/{$_controller}/{$_action}.%s", 'css', 'css');
        } elseif (file_exists(sprintf("{$modulePath}public/%s/{$_controller}/{$_action}.%s", 'css', 'css'))) {
            $file = base64_encode(\Fuska\System\Crypto::encode(sprintf("{$modulePath}public/%s/{$_controller}/{$_action}.%s", 'css', 'css')));
            $jsAndCss['css'][] = \Fuska\App::$router->basePath . "admin/file/css/file/{$file}";
        }

        // JS
        if (file_exists(sprintf(APP_PATH . "public/%s/modules/{$_module}/{$_controller}/{$_action}.%s", 'js', 'js'))) {
            $jsAndCss['js'][] = sprintf(\Fuska\App::$router->basePath . "%s/modules/{$_module}/{$_controller}/{$_action}.%s", 'js', 'js');
        } elseif (file_exists(sprintf("{$modulePath}public/%s/{$_controller}/{$_action}.%s", 'js', 'js'))) {
            $file = base64_encode(\Fuska\System\Crypto::encode(sprintf("{$modulePath}public/%s/{$_controller}/{$_action}.%s", 'js', 'js')));
            $jsAndCss['js'][] = \Fuska\App::$router->basePath . "admin/file/js/file/{$file}";
        }

//        $jsAndCss['js'] = array_merge($jsAndCss['js'], $this->js);
//        $jsAndCss['css'] = array_merge($jsAndCss['css'], $this->css);
        return $jsAndCss;
    }

    public function addJsFile($file) {
//        if (!file_exists(APP_PATH . 'public/js/' . $file)) {
//            throw new \Exception('Javascript File not found. ' . $file);
//        }
        $this->js = array_merge($this->js, [\Fuska\App::$router->basePath . 'js/' . $file]);
    }

    public function addCssFile($file) {
//        if (!file_exists(APP_PATH . 'public/css/' . $file)) {
//            throw new \Exception('Style File not found. ' . $file);
//        }
        $this->css = array_merge($this->css, [\Fuska\App::$router->basePath . 'css/' . $file]);
    }

}
