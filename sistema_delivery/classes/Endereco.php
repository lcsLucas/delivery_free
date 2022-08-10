<?php

require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'Cidade.php';

class Endereco implements Interfaceclasses {
    private $id;
    private $rua;
    private $numero;
    private $cep;
    private $bairro;
    private $cidade;
    private $descricao;
    private $crud;

    function __construct($rua="", $numero="", $cep="", $bairro="", $descricao="") {
        $this->rua = $rua;
        $this->numero = $numero;
        $this->cep = $cep;
        $this->bairro = $bairro;
        $this->descricao = $descricao;
        $this->cidade = new Cidade();
    }

    function getId() {
        return $this->id;
    }

    function getRua() {
        return $this->rua;
    }

    function getNumero() {
        return $this->numero;
    }

    function getCep() {
        return $this->cep;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRua($rua) {
        $this->rua = $rua;
    }

    function setNumero($numero) {
        if (!empty($numero) && intval($numero) >= 0)
            $this->numero = $numero;
        else
            $this->numero = 0;
    }

    /**
     * @return mixed
     */
    public function getCrud()
    {
        return $this->crud;
    }

    /**
     * @param mixed $crud
     */
    public function setCrud($crud)
    {
        $this->crud = $crud;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function alterar() {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Altera("endereco",
            array("end_rua",
                "end_numero",
                "end_cep",
                "end_bairro",
                "cid_id"
            ),
            array(utf8_decode($this->rua),
                utf8_decode($this->numero),
                utf8_decode($this->cep),
                utf8_decode($this->bairro),
                $this->cidade->getId()
            ),
            "end_id" , $this->id
        );

        return $resp;
    }

    public function carregar() {
        $crud = new Crud();
        $resp = $crud->Consulta("endereco WHERE end_id = ? LIMIT 1", array($this->id));
        if (!empty($resp)) {
            $this->rua = utf8_encode($resp[0]["end_rua"]);
            $this->numero = utf8_encode($resp[0]["end_numero"]);
            $this->cep = utf8_encode($resp[0]["end_cep"]);
            $this->bairro = utf8_encode($resp[0]["end_bairro"]);
            $this->cidade->setId($resp[0]["cid_id"]);
            $this->cidade->carregar();

            return true;
        }

        return false;
    }

    public function excluir() {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Excluir("endereco", "end_id", $this->id);
        return $resp;
    }

    public function inserir() {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Inserir("endereco",
            array("end_rua",
                "end_numero",
                "end_cep",
                "end_bairro",
                "cid_id",
                "end_descricao",
                "end_ativo"
            ),
            array(utf8_decode($this->rua),
                utf8_decode($this->numero),
                utf8_decode($this->cep),
                utf8_decode($this->bairro),
                $this->cidade->getId(),
                utf8_decode($this->descricao),
                "1"
            )
        );

        if (!empty($resp)) {
            $this->id = $this->crud->getUltimoCodigo();
        }

        return $resp;
    }

    public function listar() {

    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {

    }

    public function quantidadeRegistros($filtro, $chaves = "") {

    }
}

