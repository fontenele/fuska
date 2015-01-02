<?php

namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @Table(name="usuario", uniqueConstraints={@UniqueConstraint(name="id", columns={"id"})})
 * @Entity
 */
class Usuario extends \Fuska\Mvc\Model {

    /**
     * @var integer
     *
     * @Column(name="id", type="bigint", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @Column(name="login", type="string", length=12, nullable=false)
     */
    public $login;

    /**
     * @var string
     *
     * @Column(name="senha", type="string", length=32, nullable=false)
     */
    public $senha;

    /**
     * @var \Fuska\System\DateTime
     *
     * @Column(name="ultimo_login", type="datetime", nullable=true)
     */
    public $ultimoLogin = 'CURRENT_TIMESTAMP';

    /**
     * Set id
     *
     * @param string $id
     * @return Usuario
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Usuario
     */
    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * Set senha
     *
     * @param string $senha
     * @return Usuario
     */
    public function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha() {
        return $this->senha;
    }

    /**
     * Set ultimoLogin
     *
     * @param \Fuska\System\DateTime $ultimoLogin
     * @return Usuario
     */
    public function setUltimoLogin($ultimoLogin) {
        $this->ultimoLogin = $ultimoLogin;
        return $this;
    }

    /**
     * Get ultimoLogin
     *
     * @return \Fuska\System\DateTime
     */
    public function getUltimoLogin() {
        return $this->ultimoLogin;
    }

}
