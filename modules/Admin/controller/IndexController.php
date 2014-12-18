<?php

namespace Admin\Controller;

class IndexController extends \Fuska\Mvc\Controller {

    public function index() {
        return $this->view;
    }

    public function segundaTela() {
        $this->view->teste = [1, 2, 3];
        return $this->view;
    }

    public function terceiraTela() {
        $this->view->teste = [4, 5, 6];
        return $this->view;
    }

    public function error404() {
        return $this->view;
    }

    public function errorDefault() {
        return $this->view;
    }

}
