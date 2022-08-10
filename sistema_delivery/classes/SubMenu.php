<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class SubMenu implements Interfaceclasses{

    private $id;
    private $descricao;
    private $url;
    private $status;
    private $menu;
    private $tipo;
    
    function __construct($descricao="", $url="", $status="", $menu="") {
        $this->descricao = $descricao;
        $this->url = $url;
        $this->status = $status;
        $this->menu = $menu;
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

    function getMenu() {
        return $this->menu;
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

    function setMenu($menu) {
        $this->menu = $menu;
    }
    
    public function alterar() {
        $crud = new Crud(FALSE);
        $resp = $crud->Altera('submenu',
                            array('descricao_submenu',
                                  'url',
                                  'status',
                                  'menu_idmenu'),
                            array(utf8_decode($this->descricao),
                                  $this->url,
                                  $this->status,
                                  $this->menu),
                            'idsubmenu', $this->id);


        return $resp;
    }

    public function carregar() {
        $crud = new Crud(FALSE);
        $res = $crud->Busca("submenu where idsubmenu = $this->id");
        if(!empty($res)){
            foreach ($res as $rs){
                $this->descricao = $rs['descricao_submenu'];
                $this->url = $rs['url'];
                $this->status = $rs['status'];
                $this->menu = $rs['menu_idmenu'];
            }
            return true;
        }
        return false;
    }

    public function excluir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Excluir('submenu','idsubmenu',$this->id);

        return $resp;
    }

    public function inserir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Inserir('submenu',
                                 array('descricao_submenu',
                                       'url',
                                       'status',
                                       'menu_idmenu'), 
                                 array(utf8_decode($this->descricao),
                                       $this->url,
                                       $this->status, 
                                       $this->menu));

        return $resp;
    }

    public function inserir_empresa() {
        $crud = new Crud(FALSE);
        $resp = $crud->Inserir('submenu',
            array('descricao_submenu',
                'url',
                'status',
                'tipo',
                'menu_idmenu'),
            array(utf8_decode($this->descricao),
                $this->url,
                $this->status,
                $this->tipo,
                $this->menu));

        return $resp;
    }

    public function listar() {
        $crud = new Crud(FALSE);
        $res = $crud->busca('submenu order by descricao_submenu asc');
        
        return $res;
    }

    public function listar_empresa() {
        $crud = new Crud();
        $res = $crud->busca("submenu WHERE tipo IS NOT NULL ORDER BY descricao_submenu");

        return $res;
    }
    
    public function relacionarSubMenuUsuario($idmenu,$idtipousuario){
        $crud = new Crud(TRUE);
        if($this->verificaRelacao($idmenu, $idtipousuario) == FALSE){
            $resp = $crud->Inserir("permissoes", array('visualizar','inserir','alterar','excluir'), 
                                             array(1,1,1,1));
            if($resp == TRUE){

                $idpermissao = $crud->proximoID("permissoes")-1;

                $resp = $crud->Inserir("tipousuarios_has_submenu", array('tipousuarios_idusuariotipo','submenu_idsubmenu','permissoes_idpermissoes'),
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
            $resp = $crud->Inserir("submenu_usuarios_empresa", array("idsubmenu", "idusuarios", "emp_id"), array($idmenu,$idusuarios, $idempresa));
        }

        $crud->executar($resp);
        return $resp;
    }

    public function desrelacionarSubMenuUsuario($idmenu,$idtipousuario){
        $crud = new Crud(TRUE);
        
        $resp = $crud->Busca("tipousuarios_has_submenu where tipousuarios_idusuariotipo = $idtipousuario and submenu_idsubmenu = $idmenu");
        if(isset($resp)){ 
            foreach ($resp as $rs){
                $resp = $crud->ExcluirCondicoes("tipousuarios_has_submenu", "tipousuarios_idusuariotipo = $idtipousuario and submenu_idsubmenu = $idmenu");
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
            $resp = $crud->ExcluirCondicoes("submenu_usuarios_empresa", "idsubmenu = " . $idmenu . " AND idusuarios = " . $idusuarios . " AND emp_id = " . $idempresa);
        }

        $crud->executar($resp);
        return $resp;
    }
    
    public function verificaRelacao($idmenu,$idtipousuario){
        $crud = new Crud(FALSE);
        $resp = $crud->Busca("tipousuarios_has_submenu where tipousuarios_idusuariotipo = $idtipousuario and submenu_idsubmenu = $idmenu");
        if(isset($resp)){ 
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function verificaRelacaoEmpresa($idmenu,$idusuario, $idempresa){
        $crud = new Crud(FALSE);
        $resp = $crud->ConsultaGenerica("SELECT COUNT(*) total FROM submenu_usuarios_empresa WHERE idsubmenu = ? AND idusuarios = ? AND emp_id = ? LIMIT 1", array($idmenu, $idusuario, $idempresa));

        if (!empty($resp)) {
            return !empty($resp[0]["total"]);
        }

        return false;

    }
    
    public function constroiSubMenus($idtipousuario,$idmenu){
        $crud = new Crud(FALSE);
        $resp = $crud->Busca("tipousuarios_has_submenu inner join submenu on idsubmenu = submenu_idsubmenu
                              and tipousuarios_idusuariotipo = $idtipousuario and menu_idmenu = $idmenu and status = 1");
        return $resp;
    }

    public function constroiSubMenusEmpresa($idusuarios,$idmenu){
        $crud = new Crud(FALSE);
        $resp = $crud->Consulta("submenu_usuarios_empresa sue inner join submenu s on s.idsubmenu = sue.idsubmenu
                              and idusuarios = ? and menu_idmenu = ? and status = 1", array($idusuarios, $idmenu));
        return $resp;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select status from submenu where idsubmenu = ? LIMIT 1", array($this->id));
        if(!empty($resp)) {
            $this->status = $resp[0]["status"];
        }

        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->status))
            $this->status = 0;
        else
            $this->status = 1;

        $resp = $crud->Altera('submenu', array('status'), array(utf8_decode($this->status)), 'idsubmenu', $this->id);

        return $resp;
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {
        
    }

    public function quantidadeRegistros($filtro, $chaves = "") {
        
    }

}
