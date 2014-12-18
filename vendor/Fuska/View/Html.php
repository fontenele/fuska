<?php

namespace Fuska\View;

class Html extends \Fuska\System\ArrayObject {

    /**
     * @var string
     */
    public $template;

    public function __construct($template = null, $vars = array()) {
        parent::__construct($vars);
        //$this->this = $this;
        //$this->basePath = \Kf\Kernel::$router->basePath;
        //$this->theme = \Kf\Kernel::$config['system']['view']['theme'];
        //$this->themePath = \Kf\Kernel::$router->basePath . 'themes/' . \Kf\Kernel::$config['system']['view']['theme'] . '/';
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

    public static function loadJsAndCssFiles($controller, $action) {
        $jsAndCss = ['css' => [], 'js' => []];
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

        return $jsAndCss;
    }

}
