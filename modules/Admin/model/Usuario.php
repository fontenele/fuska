<?php

namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @Table(name="tab_usuario", indexes={@Index(name="IDX_5AC3D8B8461BB837", columns={"grupo_usuarios"})})
 * @Entity
 */
class Usuario extends \Fuska\Mvc\Model {

    /**
     * @var integer
     *
     * @Column(name="cod", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="tab_usuario_cod_seq", allocationSize=1, initialValue=1)
     */
    public $id;

    /**
     * @var string
     *
     * @Column(name="login", type="string", length=12, nullable=true)
     */
    public $login;

    /**
     * @var string
     *
     * @Column(name="senha", type="string", length=32, nullable=true)
     */
    public $senha;

    /**
     * @var string
     *
     * @Column(name="nome", type="string", length=100, nullable=true)
     */
    public $nome;

    /**
     * @var \DateTime
     *
     * @Column(name="ultimo_login", type="datetime", nullable=true)
     */
    public $ultimoLogin;

    /**
     * @var integer
     *
     * @Column(name="status", type="integer", nullable=true)
     */
    public $status;

    /**
     * @var GrupoUsuarios
     *
     * @ManyToOne(targetEntity="GrupoUsuarios")
     * @JoinColumns({
     *   @JoinColumn(name="grupo_usuarios", referencedColumnName="cod")
     * })
     */
    public $grupoUsuarios;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Usuario
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
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
     * Get nome
     *
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Usuario
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Set ultimoLogin
     *
     * @param \DateTime $ultimoLogin
     * @return Usuario
     */
    public function setUltimoLogin($ultimoLogin) {
        $this->ultimoLogin = $ultimoLogin;
        return $this;
    }

    /**
     * Get ultimoLogin
     *
     * @return \DateTime
     */
    public function getUltimoLogin() {
        return $this->ultimoLogin;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Usuario
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set grupoUsuarios
     *
     * @param GrupoUsuarios $grupoUsuarios
     * @return Usuario
     */
    public function setGrupoUsuarios(GrupoUsuarios $grupoUsuarios = null) {
        $this->grupoUsuarios = $grupoUsuarios;
        return $this;
    }

    /**
     * Get grupoUsuarios
     *
     * @return GrupoUsuarios
     */
    public function getGrupoUsuarios() {
        return $this->grupoUsuarios;
    }

}
