<?php

class Estado implements Interfaceclasses{
    private $sigla;
    private $nome;

    public function __construct($sigla = "", $nome = "") {
        $this->sigla = $sigla;
        $this->nome = $nome;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function alterar() {

    }

    public function carregar(){
        $crud = new Crud();

            $res = $crud->Consulta("estado where est_sigla = ?", array($this->sigla));
            if(!empty($res)) {
                foreach ($res as $reg) {
                    $this->nome = $reg['est_nome'];
                }
                return true;
            }

        return false;
    }

    public function excluir() {

    }

    public function inserir() {

    }

    public function listar() {
        $crud = new Crud(FALSE);
        $res = $crud->busca('estado order by est_nome');

        return $res;
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {

    }

    public function quantidadeRegistros($filtro, $chaves = "") {

    }

}
