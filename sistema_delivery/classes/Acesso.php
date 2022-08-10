<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class Acesso implements Interfaceclasses {
    
    private $id;
    private $ip;
    private $data;

    function __construct($ip="", $data="") {
        $this->ip = $ip;
        $this->data = $data;
    }

    function getId() {
        return $this->id;
    }

    function getIp() {
        return $this->ip;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setData($data) {
        $this->data = $data;
    }
    
    public function alterar() {
        
    }

    public function carregar() {
        
    }

    public function excluir() {
        
    }

    public function inserir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Inserir('acesso',
                                 array('ip','data_hora'), 
                                 array($this->ip,$this->data));
        if($resp == FALSE){
            $respp = "Problemas ao inserir o registro no banco de dados";
        }else{
            $respp = "Cadastrado com sucesso";
        }
        return $resp;
    }

    public function retornaTentativas(){
        $crud = new Crud(FALSE);
        // ip no intervalo dos ultimos 30 minutos
        $res = $crud->BuscaAtributos("count(*) qtde "," acesso where ip = '$this->ip' and data_hora > ADDDATE( now(), INTERVAL -30 minute)");
        
        if(isset($res)){
            foreach ($res as $rs){
                $resp = $rs['qtde'];
            }
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

