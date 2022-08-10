<?php

class ItemCompra
{
    private $id;
    private $nome;
    private $qtde;
    private $preco;
    private $idEmp;

    /**
     * ItemCompra constructor.
     * @param $nome
     * @param $qtde
     * @param $preco
     */
    public function __construct($nome="", $qtde="", $preco="", $idEmp="")
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
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * @param string $qtde
     */
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
    }

    /**
     * @return string
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param string $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    /**
     * @return string
     */
    public function getIdEmp()
    {
        return $this->idEmp;
    }

    /**
     * @param string $idEmp
     */
    public function setIdEmp($idEmp)
    {
        $this->idEmp = $idEmp;
    }

    public function verificaInsumo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT count(ins_id) total FROM insumo WHERE ins_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmp));

        if (!empty($resp)) {
            return (empty($resp[0]["total"]) && intval($resp[0]["total"]) > 0) ? false : true;
        }

        return false;
    }

    public function verificaProduto() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT count(pro_id) total FROM produto WHERE pro_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmp));

        if (!empty($resp)) {
            return (empty($resp[0]["total"]) && intval($resp[0]["total"]) > 0) ? false : true;
        }

        return false;
    }

    public function carregaNomeInsumo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT ins_nome FROM insumo WHERE ins_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmp));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["ins_nome"]);

            return true;
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