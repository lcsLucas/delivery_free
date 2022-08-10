<?php

include_once 'Estado.php';

class Cidade implements Interfaceclasses{
    private $id;
    private $nome;
    private $estado;

    public function __construct($nome = "") {
        $this->nome = $nome;
        $this->estado = new Estado ();

    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }


    public function alterar() {

    }

    public function carregar(){
        $crud = new Crud();
            $res = $crud->Consulta("cidade where cid_id = ?",array($this->id));
            if(!empty($res)) {
                $this->nome = $res[0]['cid_nome'];
                $this->estado->setSigla($res[0]['est_sigla']);
                $this->estado->carregar();

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
        $res = $crud->busca('cidade order by cid_nome');

        return $res;
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {

    }

    public function quantidadeRegistros($filtro, $chaves = "") {

    }

}
