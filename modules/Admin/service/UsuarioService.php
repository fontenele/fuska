<?php

namespace Admin\Service;

class UsuarioService extends \Fuska\Mvc\Service {

    public function __construct() {
        parent::__construct("Admin\Model\Usuario");
    }

    public function autenticar(\Admin\Model\Usuario $usuario) {
        $usuarioBusca = $this->findOneBy(['login' => $usuario->getLogin(), 'senha' => md5($usuario->getSenha())]);
        if ($usuarioBusca) {
            return $usuarioBusca->normalizeDataToView();
        }
        return false;
    }

}
