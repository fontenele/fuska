<?php

namespace Admin\Controller;

class UsuarioController extends \Fuska\Mvc\Controller {

    public function relatorio() {
        $service = new \Admin\Service\UsuarioService;
        $collection = new \Fuska\System\Collection($service->findBy([], ['login' => 'ASC']));

        $queryUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\Usuario u');
        $this->view->totals = ['usuarios' => $queryUsuarios->getSingleScalarResult()];
        $this->view->list = $collection->normalizeDataToGrid()->toArray();
        $this->view->addJsFile('modules/admin/index/index.js');
        return $this->view;
    }

    public function cadastro() {
        if ($this->request->get->id) {
            $service = new \Admin\Service\UsuarioService;
            $usuario = $service->findOneBy(['id' => $this->request->get->id]);
            $this->view->usuario = $usuario->normalizeDataToView();
        }
        $queryUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\Usuario u');
        $this->view->totals = ['usuarios' => $queryUsuarios->getSingleScalarResult()];
        $grupoUsuariosService = new \Admin\Service\GrupoUsuariosService;
        $gruposUsuarios = new \Fuska\System\Collection($grupoUsuariosService->findAll());
        $this->view->gruposUsuarios = $gruposUsuarios->normalizeDataToGrid()->toArray();
        $this->view->addJsFile('modules/admin/index/index.js');
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
        $grupoUsuarios = new \Admin\Model\GrupoUsuarios(['id' => $post->grupoUsuarios]);
        $usuario->setLogin($post->login)
                ->setSenha($post->senha)
                ->setGrupoUsuarios($grupoUsuarios)
                ->setUltimoLogin(new \Fuska\System\DateTime())
                ->setId($post->id);

        return \Fuska\View\Json::createWithArrayOrObject($service->save($usuario));
    }

}
