<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class CategoriaInsumos implements Interfaceclasses
{
    private $id;
    private $nome;
    private $descricao;
    private $ativo;
    private $idEmpresa;

    /**
     * CategoriaInsumos constructor.
     * @param $nome
     * @param $descricao
     * @param $ativo
     * @param $idEmpresa
     */
    public function __construct($nome = "", $descricao = "", $ativo = "", $idEmpresa = "")
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
        $resp = $crud->Inserir(
            "categoria_insumos",
            array("cat_nome", "cat_descricao", "cat_ativo", "emp_id"),
            array(utf8_decode($this->nome), utf8_decode($this->descricao), $this->ativo, $this->idEmpresa)
        );

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes(
            "categoria_insumos",
            array(
                "cat_nome", "cat_descricao"
            ),
            array(utf8_decode($this->nome), utf8_decode($this->descricao)),
            "cat_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("categoria_insumos", "cat_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("categoria_insumos WHERE emp_id = ? AND cat_ativo = '1' ORDER BY cat_nome", array($this->idEmpresa));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if (!empty($filtro)) {
            $sql = "select count(*) total from categoria_insumos where lower(ins_nome) like ? AND emp_id = ?";
            $resp = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM categoria_insumos WHERE emp_id = ?", array($this->idEmpresa));
        }

        if (!empty($resp)) {
            foreach ($resp as $rsr) {
                $total = $rsr['total'];
            }
        }

        return  ceil(($total));
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        $crud = new Crud();

        if (!empty($filtro)) {
            $sql = "categoria_insumos where lower(cat_nome) like ? AND emp_id = ? order by cat_nome LIMIT ?, ?;";
            $res = $crud->Consulta($sql, array("%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa, $inicio, $fim));
        } else {
            $res = $crud->Consulta("categoria_insumos WHERE emp_id = ? order by cat_nome LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("categoria_insumos WHERE cat_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = $resp[0]["cat_nome"];
            $this->descricao = html_entity_decode($resp[0]["cat_descricao"]);
            $this->ativo = $resp[0]["cat_ativo"];

            return true;
        }

        return false;
    }

    public function modificaAtivo()
    {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select cat_ativo from categoria_insumos where cat_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['cat_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if (!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('categoria_insumos', array('cat_ativo'), array(utf8_decode($this->ativo)), 'cat_id', $this->id);

        return $resp;
    }
}
