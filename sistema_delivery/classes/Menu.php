<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class Menu implements Interfaceclasses{
    
    private $id;
    private $descricao;
    private $url;
    private $status;
    private $icone;
    private $tipo;
    
    function __construct($descricao="", $url="", $status="") {
        $this->descricao = $descricao;
        $this->url = $url;
        $this->status = $status;
    }
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getUrl() {
        return $this->url;
    }

    function getStatus() {
        return $this->status;
    }
    
    function getIcone() {
        return $this->icone;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    function setIcone($icone) {
        $this->icone = $icone;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    public function alterar() {
        $crud = new Crud(FALSE);
        $resp = $crud->Altera('menu',
                                    array('descricao_menu',
                                          'url',
                                          'status',
                                          'icone'),
                                    array(utf8_decode($this->descricao),
                                          $this->url,
                                          $this->status,
                                          $this->icone),
                            'idmenu', $this->id);

        return $resp;
    }

    public function carregar() {
        $crud = new Crud(FALSE);
            $res = $crud->Busca("menu where idmenu = $this->id");
            if(!empty($res)){
                foreach ($res as $rs){
                    $this->descricao = $rs['descricao_menu'];
                    $this->url = $rs['url'];
                    $this->status = $rs['status'];
                    $this->icone = $rs["icone"];
                    $this->tipo = $rs["tipo"];
                }
                return true;
            }

            return false;
    }

    public function excluir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Excluir('menu','idmenu',$this->id);

        return $resp;
    }

    public function inserir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Inserir('menu',
                                 array('descricao_menu',
                                       'url',
                                       'status',
                                       'icone'), 
                                 array(utf8_decode($this->descricao),
                                       $this->url,
                                       $this->status,
                                       $this->icone));

        return $resp;
    }

    public function inserir_empresar() {
        $crud = new Crud(FALSE);
        $resp = $crud->Inserir('menu',
            array('descricao_menu',
                'url',
                'status',
                'icone',
                'tipo'),
            array(utf8_decode($this->descricao),
                $this->url,
                $this->status,
                $this->icone,
                $this->tipo)
        );

        return $resp;
    }

    public function listar() {
        $crud = new Crud(FALSE);
        $res = $crud->busca('menu WHERE tipo IS NULL order by descricao_menu asc');
        
        return $res;
    }

    public function listar_empresa() {
        $crud = new Crud(FALSE);
        $res = $crud->busca('menu WHERE tipo IS NOT NULL order by descricao_menu asc');

        return $res;
    }
    
    public function relacionarMenuUsuario($idmenu,$idtipousuario){
        $crud = new Crud(TRUE);
        if($this->verificaRelacao($idmenu, $idtipousuario) == FALSE){
            $resp = $crud->Inserir("permissoes", array('visualizar','inserir','alterar','excluir'), 
                                             array(1,1,1,1));
            if($resp == TRUE){

                $idpermissao = $crud->proximoID("permissoes")-1;

                $resp = $crud->Inserir("tipousuarios_has_menu", array('tipousuarios_idusuariotipo','menu_idmenu','permissoes_idpermissoes'),
                                                                array($idtipousuario,$idmenu,$idpermissao));

                if($resp == TRUE){
                    $crud->executar(TRUE);
                    return TRUE;
                }
            }else{
                $crud->executar(FALSE);
                return FALSE;
            }
        }else{
            $crud->executar(FALSE);
            return FALSE;
        }
    }

    public function  relacionarMenuUsuarioEmpresa($idmenu,$idusuarios, $idempresa) {
        $crud = new Crud(true);
        $resp = false;

        if (!$this->verificaRelacaoEmpresa($idmenu,$idusuarios, $idempresa)) {
            $resp = $crud->Inserir("menu_usuarios_empresa", array("idmenu", "idusuarios", "emp_id"), array($idmenu,$idusuarios, $idempresa));
        }

        $crud->executar($resp);
        return $resp;
    }

    public function desrelacionarMenuUsuario($idmenu,$idtipousuario){
        $crud = new Crud(TRUE);
        
        $resp = $crud->Busca("tipousuarios_has_menu where tipousuarios_idusuariotipo = $idtipousuario and menu_idmenu = $idmenu");
        if(isset($resp)){ 
            foreach ($resp as $rs){
                $resp = $crud->ExcluirCondicoes("tipousuarios_has_menu", "tipousuarios_idusuariotipo = $idtipousuario and menu_idmenu = $idmenu");
                if($resp == TRUE){
                    $resp = $crud->Excluir("permissoes", "idpermissoes",$rs['permissoes_idpermissoes']);
                    if($resp == TRUE){
                        $crud->executar(TRUE);
                        return TRUE;
                    }
                }else{
                    $crud->executar(FALSE);
                    return FALSE;
                }
            }
        }else{
            $crud->executar(FALSE);
            return FALSE;
        }
    }

    public function desrelacionarMenuUsuarioEmpresa($idmenu,$idusuarios, $idempresa){
        $crud = new Crud(TRUE);
        $resp = false;

        if ($this->verificaRelacaoEmpresa($idmenu,$idusuarios, $idempresa)) {
            $resp = $crud->ExcluirCondicoes("menu_usuarios_empresa", "idmenu = " . $idmenu . " AND idusuarios = " . $idusuarios . " AND emp_id = " . $idempresa);
        }

        $crud->executar($resp);
        return $resp;
    }
    
    public function verificaRelacao($idmenu,$idtipousuario){
        $crud = new Crud(FALSE);
        $resp = $crud->Busca("tipousuarios_has_menu where tipousuarios_idusuariotipo = $idtipousuario and menu_idmenu = $idmenu");
        if(isset($resp)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function verificaRelacaoEmpresa($idmenu,$idusuario, $idempresa){
        $crud = new Crud(FALSE);
        $resp = $crud->ConsultaGenerica("SELECT COUNT(*) total FROM menu_usuarios_empresa WHERE idmenu = ? AND idusuarios = ? AND emp_id = ? LIMIT 1", array($idmenu, $idusuario, $idempresa));

        if (!empty($resp)) {
            return !empty($resp[0]["total"]);
        }

        return false;

    }
    
    public function constroiMenus($idtipousuario){
        $crud = new Crud(FALSE);
        $resp = $crud->Busca("tipousuarios_has_menu inner join menu on idmenu = menu_idmenu
                              and tipousuarios_idusuariotipo = $idtipousuario and status = 1");
        return $resp;
    }

    public function constroiMenusEmpresa($idusuarios){
        $crud = new Crud(FALSE);
        $resp = $crud->Consulta("menu_usuarios_empresa mue inner join menu m on m.idmenu = mue.idmenu
                              WHERE idusuarios = ? and status = 1", array($idusuarios));
        return $resp;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select status from menu where idmenu = ? LIMIT 1", array($this->id));
        if(!empty($resp)) {
            $this->status = $resp[0]["status"];
        }

        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->status))
            $this->status = 0;
        else
            $this->status = 1;

        $resp = $crud->Altera('menu', array('status'), array(utf8_decode($this->status)), 'idmenu', $this->id);

        return $resp;
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {
        
    }

    public function quantidadeRegistros($filtro, $chaves = "") {
        
    }

}
