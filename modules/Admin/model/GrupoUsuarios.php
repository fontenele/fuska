<?php

namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoUsuarios
 *
 * @Table(name="tab_grupo_usuarios")
 * @Entity
 */
class GrupoUsuarios extends \Fuska\Mvc\Model {

    /**
     * @var integer
     *
     * @Column(name="cod", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="tab_grupo_usuarios_cod_seq", allocationSize=1, initialValue=1)
     */
    public $id;

    /**
     * @var string
     *
     * @Column(name="nome", type="string", length=60, nullable=true)
     */
    public $nome;

    /**
     * @var integer
     *
     * @Column(name="status", type="integer", nullable=true)
     */
    public $status;

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
     * @return GrupoUsuarios
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return GrupoUsuarios
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
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
     * Set status
     *
     * @param integer $status
     * @return GrupoUsuarios
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

}
