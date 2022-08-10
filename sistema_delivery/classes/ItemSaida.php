<?php

class ItemSaida
{
    private $id;
    private $nome;
    private $qtde;
    private $preco;
    private $idEmp;

    /**
     * ItemSaida constructor.
     * @param $nome
     * @param $qtde
     * @param $preco
     * @param $idEmp
     */
    public function __construct($nome="", $qtde=0, $preco=0.0, $idEmp=0)
    {
        $this->nome = $nome;
        $this->qtde = $qtde;
        $this->preco = $preco;
        $this->idEmp = $idEmp;
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
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * @param mixed $qtde
     */
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
    }

    /**
     * @return mixed
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param mixed $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    /**
     * @return mixed
     */
    public function getIdEmp()
    {
        return $this->idEmp;
    }

    /**
     * @param mixed $idEmp
     */
    public function setIdEmp($idEmp)
    {
        $this->idEmp = $idEmp;
    }

    public function verificaProduto() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT count(pro_id) total FROM produto WHERE pro_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmp));

        if (!empty($resp)) {
            return (empty($resp[0]["total"]) && intval($resp[0]["total"]) > 0) ? false : true;
        }

        return false;
    }

    public function carregaNomeProduto() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT pro_nome FROM produto WHERE pro_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmp));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["pro_nome"]);

            return true;
        }

        return false;
    }

}