<?php

namespace Admin\Controller;

class IndexController extends \Fuska\Mvc\Controller {

    public static function getTotals($view) {
        $queryUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\Usuario u');
        $queryGrupoUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\GrupoUsuarios u');
        $view->totals = ['grupoUsuarios' => $queryGrupoUsuarios->getSingleScalarResult(), 'usuarios' => $queryUsuarios->getSingleScalarResult()];
    }

    public function index() {
        self::getTotals($this->view);
        return $this->view;
    }

    public function autenticacao() {
        return $this->view;
    }

    public function autenticar() {
        $post = $this->request->post;
        $service = new \Admin\Service\UsuarioService;
        $usuario = new \Admin\Model\Usuario(['login' => $post->login, 'senha' => $post->senha]);
        $logado = $service->autenticar($usuario);
        if ($logado) {
            $sessionContainer = new \Fuska\System\Session('__Fu5k4-usr__');
            $sessionContainer->user = $logado;
        }
        $this->view->logado = $logado ? true : false;
        return $this->view;
    }

    public function sair() {
        $sessionContainer = new \Fuska\System\Session('__Fu5k4-usr__');
        $sessionContainer->clear();
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
