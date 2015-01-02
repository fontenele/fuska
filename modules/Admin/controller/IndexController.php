<?php

namespace Admin\Controller;

class IndexController extends \Fuska\Mvc\Controller {

    public function index() {
        $queryUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\Usuario u');
        $this->view->totals = ['usuarios' => $queryUsuarios->getSingleScalarResult()];
        return $this->view;
    }

    public function segundaTela() {
        $this->view->dadosPessoais = [
            'name' => 'Guilherme Fontenele',
            'country' => 'Brasil',
            'state' => 'DF',
            'city' => 'Brasília'
        ];
        $this->view->lista = [
            'lala',
            'lele',
            'lili',
            'lolo',
            'lulu'
        ];

        $this->view->usuarios = [
            ['nome' => 'Guilherme', 'sobrenome' => 'Fontenele'],
            ['nome' => 'Tereza', 'sobrenome' => 'Marques'],
            ['nome' => 'Ana', 'sobrenome' => 'Caroliny'],
            ['nome' => 'Juliana', 'sobrenome' => 'Souza'],
            ['nome' => 'Marcela', 'sobrenome' => 'Brawn']
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
