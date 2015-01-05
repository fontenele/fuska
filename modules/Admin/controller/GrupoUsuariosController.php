<?php

namespace Admin\Controller;

class GrupoUsuariosController extends \Fuska\Mvc\Controller {

    public function relatorio() {
        $service = new \Admin\Service\GrupoUsuariosService;
        $collection = new \Fuska\System\Collection($service->findBy([], ['nome' => 'ASC']));

        $queryGrupoUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\GrupoUsuarios u');
        $this->view->totals = ['grupoUsuarios' => $queryGrupoUsuarios->getSingleScalarResult()];
        $this->view->list = $collection->normalizeDataToGrid()->toArray();
        $this->view->addJsFile('modules/admin/index/index.js');
        return $this->view;
    }

    public function cadastro() {
        if ($this->request->get->id) {
            $service = new \Admin\Service\GrupoUsuariosService;
            $this->view->grupoUsuarios = $service->find($this->request->get->id)->normalizeDataToView();
        }
        $queryGrupoUsuarios = \Fuska\Mvc\Service::getManager()->createQuery('SELECT COUNT(u.id) FROM Admin\Model\GrupoUsuarios u');
        $this->view->totals = ['grupoUsuarios' => $queryGrupoUsuarios->getSingleScalarResult()];
        $this->view->addJsFile('modules/admin/index/index.js');
        return $this->view;
    }

    public function salvar() {
        $service = new \Admin\Service\GrupoUsuariosService;
        $grupoUsuarios = new \Admin\Model\GrupoUsuarios;

        if ($this->request->isDelete()) {
            $grupoUsuarios->id = $this->request->get->id;
            return \Fuska\View\Json::createWithArrayOrObject($service->delete($grupoUsuarios));
        }

        $post = $this->request->post;
        $grupoUsuarios->setNome($post->nome)
                ->setStatus($post->status)
                ->setId($post->id);

        return \Fuska\View\Json::createWithArrayOrObject($service->save($grupoUsuarios));
    }

}
