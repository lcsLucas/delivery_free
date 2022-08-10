<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class CategoriaCaracteristicas implements Interfaceclasses
{
    private $id;
    private $nome;
    private $descricao;
    private $ativo;
    private $idEmpresa;

    /**
     * CategoriaCaracteristicas constructor.
     * @param $nome
     * @param $descricao
     * @param $ativo
     * @param $idEmpresa
     */
    public function __construct($nome="", $descricao="", $ativo="", $idEmpresa="")
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->ativo = $ativo;
        $this->idEmpresa = $idEmpresa;
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
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param string $ativo
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
        $resp = $crud->Inserir("tipo_caracteristicas",
            array("tip_nome", "tip_descricao", "tip_ativo", "emp_id"),
            array(utf8_decode($this->nome), utf8_decode($this->descricao), $this->ativo, $this->idEmpresa)
        );

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes("tipo_caracteristicas", array(
            "tip_nome", "tip_descricao"),
            array(utf8_decode($this->nome), utf8_decode($this->descricao)),
            "tip_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("tipo_caracteristicas", "tip_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->BuscaGenerica("SELECT tip_id, tip_nome FROM tipo_caracteristicas ORDER BY tip_nome");

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "select count(*) total from tipo_caracteristicas where lower(tip_nome) like ? AND emp_id = ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%"), $this->idEmpresa);
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM tipo_caracteristicas WHERE emp_id = ?", array($this->idEmpresa));
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
            $sql = "tipo_caracteristicas where lower(tip_nome) like ? AND emp_id = ? order by tip_nome LIMIT ?, ?;";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%", $this->idEmpresa, $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("tipo_caracteristicas WHERE emp_id = ? order by tip_nome LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("tipo_caracteristicas WHERE tip_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["tip_nome"]);
            $this->descricao = html_entity_decode(utf8_encode($resp[0]["tip_descricao"]));
            $this->ativo = $resp[0]["tip_ativo"];

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select tip_ativo from tipo_caracteristicas where tip_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['tip_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('tipo_caracteristicas', array('tip_ativo'), array(utf8_decode($this->ativo)), 'tip_id', $this->id);

        return $resp;
    }

}