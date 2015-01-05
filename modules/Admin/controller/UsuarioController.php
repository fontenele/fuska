<?php

namespace Admin\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class UsuarioController extends \Fuska\Mvc\Controller {

    public function relatorio() {
        $em = \Fuska\Mvc\Service::getManager();
        $user = $em->getRepository('Admin\Model\Usuario');

        $service = new \Admin\Service\UsuarioService;
        $collection = new \Fuska\System\Collection($service->findBy([], ['login' => 'ASC']));
        $this->view->list = $collection->normalizeDataToGrid()->toArray();
        return $this->view;
    }

    public function cadastro() {
        if ($this->request->get->id) {
            $service = new \Admin\Service\UsuarioService;
            $this->view->usuario = $service->find($this->request->get->id)->normalizeDataToView();
        }
        return $this->view;
    }

    public function salvar() {
        $service = new \Admin\Service\UsuarioService;
        $usuario = new \Admin\Model\Usuario;

        if ($this->request->isDelete()) {
            $usuario->id = $this->request->get->id;
            return \Fuska\View\Json::createWithArrayOrObject($service->delete($usuario));
        }

        $post = $this->request->post;
        $usuario->setLogin($post->login)
                ->setSenha($post->senha)
                ->setUltimoLogin(new \Fuska\System\DateTime())
                ->setId($post->id);

        return \Fuska\View\Json::createWithArrayOrObject($service->save($usuario));
    }

}
