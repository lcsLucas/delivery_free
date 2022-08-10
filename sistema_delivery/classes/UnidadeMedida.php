<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class UnidadeMedida implements Interfaceclasses
{

    private $id;
    private $nome;
    private $formula;
    private $sigla;

    /**
     * UnidadeMedida constructor.
     * @param $id
     * @param $nome
     * @param $formula
     * @param $sigla
     */
    public function __construct($nome="", $formula="", $sigla="")
    {
        $this->nome = $nome;
        $this->formula = $formula;
        $this->sigla = $sigla;
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
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * @param string $formula
     */
    public function setFormula($formula)
    {
        $this->formula = $formula;
    }

    /**
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param string $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    public function inserir()
    {
        // TODO: Implement inserir() method.
    }

    public function alterar()
    {
        // TODO: Implement alterar() method.
    }

    public function excluir()
    {
        // TODO: Implement excluir() method.
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Busca("unidade_medida");

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        // TODO: Implement quantidadeRegistros() method.
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        // TODO: Implement listarPaginacao() method.
    }

    public function carregar()
    {
        // TODO: Implement carregar() method.
    }

}