<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class FormPagto implements Interfaceclasses
{
    private $id;
    private $nome;
    private $descricao;
    private $numParcela;
    private $flagEntrada;
    private $ativo;
    private $idEmpresa;

    /**
     * FormPagto constructor.
     * @param $nome
     * @param $descricao
     * @param $numParcela
     * @param $flagEntrada
     * @param $idEmpresa
     */
    public function __construct($nome="", $descricao="", $numParcela="", $flagEntrada="", $idEmpresa="", $ativo = "")
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->numParcela = $numParcela;
        $this->flagEntrada = $flagEntrada;
        $this->idEmpresa = $idEmpresa;
        $this->ativo = "";
        $this->flagEntrada = 0;
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

    /**
     * @return string
     */
    public function getNumParcela()
    {
        return $this->numParcela;
    }

    /**
     * @param string $numParcela
     */
    public function setNumParcela($numParcela)
    {
        $this->numParcela = $numParcela;
    }

    /**
     * @return string
     */
    public function getFlagEntrada()
    {
        return $this->flagEntrada;
    }

    /**
     * @param string $flagEntrada
     */
    public function setFlagEntrada($flagEntrada)
    {
        $this->flagEntrada = $flagEntrada;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return string
     */
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    /**
     * @param string $idEmpresa
     */
    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function inserir()
    {
        $crud = new Crud();
        $resp = $crud->Inserir("forma_pagto",
                                                    array("pag_nome", "pag_descricao", "pag_numParcelas", "pag_entrada", "pag_ativo" , "emp_id"),
                                                    array(utf8_decode($this->nome), utf8_decode($this->descricao), $this->numParcela, $this->flagEntrada, $this->ativo, $this->idEmpresa)
        );

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes("forma_pagto",
            array("pag_nome", "pag_descricao", "pag_numParcelas", "pag_entrada", "emp_id"),
            array(utf8_decode($this->nome), utf8_decode($this->descricao), $this->numParcela, $this->flagEntrada, $this->idEmpresa),
            "pag_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("forma_pagto", "pag_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("forma_pagto WHERE emp_id = ? AND pag_ativo = ?", array($this->idEmpresa, 1));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "select count(*) total from forma_pagto where lower(pag_nome) like ? AND emp_id = ?";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM forma_pagto WHERE emp_id = ?", array($this->idEmpresa));
        }

        if(!empty($resp)){
            foreach ($resp as $rsr){
                $total = $rsr['total'];
            }
        }

        return  ceil(($total));
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        $crud = new Crud();

        if(!empty($filtro)){
            $sql = "forma_pagto where lower(pag_nome) like ? AND emp_id = ? order by pag_nome LIMIT ?, ?;";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%", $this->idEmpresa, $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("forma_pagto WHERE emp_id = ? order by pag_nome LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("forma_pagto WHERE pag_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["pag_nome"]);
            $this->descricao = html_entity_decode(utf8_encode($resp[0]["pag_descricao"]));
            $this->numParcela = $resp[0]["pag_numParcelas"];
            $this->flagEntrada = $resp[0]["pag_entrada"];
            $this->ativo = $resp[0]["pag_ativo"];
            $this->idEmpresa = $resp[0]["emp_id"];

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select pag_ativo from forma_pagto where pag_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['pag_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('forma_pagto', array('pag_ativo'), array(utf8_decode($this->ativo)), 'pag_id', $this->id);

        return $resp;
    }

    public function recuperaNumParcelas() {
        $crud = new Crud();

        $resp = $crud->ConsultaGenerica("SELECT pag_entrada, pag_numParcelas FROM forma_pagto WHERE pag_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->numParcela = $resp[0]["pag_numParcelas"];
            $this->flagEntrada = $resp[0]["pag_entrada"];

            return true;
        }

        return false;
    }

}