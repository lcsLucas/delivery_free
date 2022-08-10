<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'UnidadeMedida.php';

class Insumo implements Interfaceclasses
{
    private $id;
    private $nome;
    private $dtCad;
    private $controle_estoque;
    private $obs;
    private $ativo;
    private $idUnidade;
    private $idCategoria;
    private $idFornecedor;
    private $idEmpresa;

    /**
     * Insumo constructor.
     * @param $nome
     * @param $dtCad
     * @param $controle_estoque
     * @param $obs
     * @param $idUnidade
     * @param $idCategoria
     * @param $idFornecedor
     * @param $idEmpresa
     */
    public function __construct($nome="", $controle_estoque="", $obs="", $idUnidade="", $idCategoria="", $idFornecedor="", $idEmpresa="")
    {
        $this->nome = $nome;
        $this->dtCad = date("Y-m-d");
        $this->controle_estoque = $controle_estoque;
        $this->obs = $obs;
        $this->idUnidade = $idUnidade;
        $this->idCategoria = $idCategoria;
        $this->idFornecedor = $idFornecedor;
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
    public function getDtCad()
    {
        return $this->dtCad;
    }

    /**
     * @param string $dtCad
     */
    public function setDtCad($dtCad)
    {
        $this->dtCad = $dtCad;
    }

    /**
     * @return string
     */
    public function getControleEstoque()
    {
        return $this->controle_estoque;
    }

    /**
     * @param string $controle_estoque
     */
    public function setControleEstoque($controle_estoque)
    {
        $this->controle_estoque = $controle_estoque;
    }

    /**
     * @return mixed
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param mixed $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    /**
     * @return string
     */
    public function getIdUnidade()
    {
        return $this->idUnidade;
    }

    /**
     * @param string $idUnidade
     */
    public function setIdUnidade($idUnidade)
    {
        $this->idUnidade = $idUnidade;
    }

    /**
     * @return string
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * @param string $idCategoria
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    /**
     * @return string
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param string $idFornecedor
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
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

    public function inserir()
    {

        $crud = new Crud();
        $resp = $crud->Inserir("insumo",
                                               array("ins_nome",
                                                     "ins_dtCad",
                                                     "ins_obs",
                                                     "ins_controle_estoque",
                                                     "ins_ativo",
                                                     "uni_id",
                                                     "cat_id",
                                                     "for_id",
                                                     "emp_id"
                                               ),
                                               array(
                                                   utf8_decode($this->nome),
                                                   utf8_decode($this->dtCad),
                                                   utf8_decode($this->obs),
                                                   utf8_decode($this->controle_estoque),
                                                   utf8_decode($this->ativo),
                                                   $this->idUnidade,
                                                   $this->idCategoria,
                                                   $this->idFornecedor,
                                                   $this->idEmpresa
                                               )
        );

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes("insumo",
            array("ins_nome",
                "ins_dtCad",
                "ins_obs",
                "ins_controle_estoque",
                "uni_id",
                "cat_id",
                "for_id",
                "emp_id"
            ),
            array(
                utf8_decode($this->nome),
                utf8_decode($this->dtCad),
                utf8_decode($this->obs),
                utf8_decode($this->controle_estoque),
                $this->idUnidade,
                $this->idCategoria,
                $this->idFornecedor,
                $this->idEmpresa
            ),
            "ins_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->Excluir("estoque_insumo", "ins_id", $this->id);
        if ($resp)
            $resp = $crud->Excluir("insumo", "ins_id", $this->id);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("insumo i INNER JOIN unidade_medida um ON i.uni_id = um.uni_id WHERE emp_id = ? AND ins_ativo = ?", array($this->idEmpresa, 1));

        return $resp;
    }

    public function listar_controle_estoque() {
        $crud = new Crud();
        $resp = $crud->Consulta("insumo i INNER JOIN unidade_medida um ON i.uni_id = um.uni_id WHERE emp_id = ? AND ins_controle_estoque = '1' AND ins_ativo = ?", array($this->idEmpresa, 1));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "SELECT COUNT(*) total FROM insumo i INNER JOIN fornecedor f ON i.for_id = f.for_id INNER JOIN categoria_insumos ci ON i.cat_id = ci.cat_id where (lower(ins_nome) like ? OR lower(cat_nome) like ?) AND i.emp_id = ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM insumo i INNER JOIN fornecedor f ON i.for_id = f.for_id INNER JOIN categoria_insumos ci ON i.cat_id = ci.cat_id WHERE i.emp_id = ?", array($this->idEmpresa));
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
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "SELECT i.ins_id, i.ins_nome, f.for_nome, ci.cat_nome, ins_ativo FROM insumo i INNER JOIN fornecedor f ON i.for_id = f.for_id INNER JOIN categoria_insumos ci ON i.cat_id = ci.cat_id where (lower(ins_nome) like ? OR lower(cat_nome) like ?) AND i.emp_id = ? order by i.ins_nome LIMIT ?, ?";
            $res = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa, $inicio, $fim));
        } else {
            $res = $crud->ConsultaGenerica("SELECT i.ins_id, i.ins_nome, f.for_nome, ci.cat_nome, ins_ativo FROM insumo i INNER JOIN fornecedor f ON i.for_id = f.for_id INNER JOIN categoria_insumos ci ON i.cat_id = ci.cat_id WHERE i.emp_id = ? order by i.ins_nome LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("insumo WHERE ins_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["ins_nome"]);
            $this->dtCad = $resp[0]["ins_dtCad"];
            $this->obs = utf8_encode($resp[0]["ins_obs"]);
            $this->controle_estoque = $resp[0]["ins_controle_estoque"];
            $this->idUnidade = $resp[0]["uni_id"];
            $this->idCategoria = $resp[0]["cat_id"];
            $this->idFornecedor = $resp[0]["for_id"];
            $this->idEmpresa = $resp[0]["emp_id"];

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select ins_ativo from insumo where ins_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['ins_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('insumo', array('ins_ativo'), array(utf8_decode($this->ativo)), 'ins_id', $this->id);

        return $resp;
    }

}