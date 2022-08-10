<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class ItensCarrinho
{
    private $id;
    private $qtde;
    private $obs;
    private $complementos;

    /**
     * ItensCarrinho constructor.
     * @param $qtde
     * @param $obs
     */
    public function __construct($qtde=0, $obs='')
    {
        $this->qtde = $qtde;
        $this->obs = $obs;
        $this->complementos = array();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * @param int $qtde
     */
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
    }

    /**
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param string $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    /**
     * @return array
     */
    public function getComplementos()
    {
        return $this->complementos;
    }

    /**
     * @param array $complementos
     */
    public function setComplementos($complementos)
    {
        $this->complementos = $complementos;
    }

}