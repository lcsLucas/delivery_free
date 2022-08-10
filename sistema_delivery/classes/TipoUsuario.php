<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class TipoUsuario implements Interfaceclasses {
    
    private $id;
    private $nome;

    function __construct($nome="") {
        $this->nome = $nome;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function alterar() {
        $crud = new Crud(FALSE);
        
        $resp = $crud->Altera('tipousuarios',
                            array('nome_tipo'),
                            array(utf8_decode($this->nome)), 
                            'idusuariotipo', $this->id);

        return $resp;
    }

    public function carregar() {
        $crud = new Crud(FALSE);
        $res = $crud->Busca("tipousuarios where idusuariotipo = $this->id");
        if(!empty($res)){
            foreach ($res as $rs){
                $this->nome = utf8_encode($rs['nome_tipo']);
            }
            return true;
        }
        
        return false;
    }

    public function excluir() {
        $crud = new Crud(FALSE);
        if($this->id != ""){
            $resp = $crud->Excluir('tipousuarios','idusuariotipo',$this->id);
            if($resp == TRUE){
                $respp = "Registro excluido";
            }else{
                $respp = "Problemas ao excluir o registro no banco de dados";
            }
        }else{
            $respp = "Informe o código para excluir";
        }
        return $resp;
    }

    public function inserir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Inserir('tipousuarios',
                                 array('nome_tipo'), 
                                 array(utf8_decode($this->nome)));
        if($resp == FALSE){
            $respp = "Problemas ao inserir o registro no banco de dados";
        }else{
            $respp = "Cadastrado com sucesso";
        }
        return $resp;
    }

    public function listar() {
        $crud = new Crud(FALSE);
        $res = $crud->busca('tipousuarios order by nome_tipo asc');
        
        return $res;
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {
        
    }

    public function quantidadeRegistros($filtro, $chaves = "") {
        
    }

}
