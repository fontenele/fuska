<?php

namespace Admin\Controller;

class IndexController extends \Fuska\Mvc\Controller {

    public function index() {
        return $this->view;
    }

    public function segundaTela() {
        $this->view->dadosPessoais = [
            'name' => 'Guilherme Fontenele',
            'country' => 'Brasil',
            'state' => 'DF',
            'city' => 'Brasília'
        ];
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
