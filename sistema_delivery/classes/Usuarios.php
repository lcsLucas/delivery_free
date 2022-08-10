<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class Usuarios implements Interfaceclasses{
    
    private $id;
    private $usuario;
    private $senha;
    private $email;
    private $nome;
    private $status;
    private $tipo_empresa;
    private $tipo;
    private $crud;
    
    function __construct($usuario="", $senha="", $email="", $nome="", $status="", $tipo="") {
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->email = $email;
        $this->nome = $nome;
        $this->status = $status;

        $this->tipo= $tipo;
    }

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getEmail() {
        return $this->email;
    }

    function getNome() {
        return utf8_encode($this->nome);
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCrud()
    {
        return $this->crud;
    }

    /**
     * @param mixed $crud
     */
    public function setCrud($crud)
    {
        $this->crud = $crud;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    
    function getTipoEmpresa() {
        return $this->tipo_empresa;
    }

    function setTipoEmpresa($tipo) {
        $this->tipo_empresa = $tipo;
    }
    
    public function alterar() {
        $this->encripta();
        $crud = new Crud(true);
        
            $resp = $crud->Altera('usuarios',
                                array('usuario',
                                      'senha',
                                      'email',
                                      'nome',  
                                      'status'),
                                array(strtolower($this->usuario),
                                      $this->senha,
                                      strtolower($this->email),
                                      utf8_decode($this->nome),
                                      $this->status), 
                                'idusuarios', $this->id);

            if($resp){
                $resp = $crud->Altera('usuarios_has_tipousuarios',
                                     array('tipousuarios_idusuariotipo'), 
                                     array($this->tipo),'usuarios_idusuarios',$this->id);
            }
        
        $crud->executar($resp);
        return $resp;
    }

    public function alterar2() {
        if (empty($this->crud))
            $this->crud = new Crud();

        $this->encripta();

        $resp = $this->crud->Altera('usuarios',
            array(
                'senha',
                'nome'),
            array(
                $this->senha,
                utf8_decode($this->nome)
            ),
            'idusuarios', $this->id);

        return $resp;
    }

    public function carregar() {
        $crud = new Crud(TRUE);
        $res = $crud->Consulta(" usuarios usu 
                             inner join usuarios_has_tipousuarios 
                             uht on uht.usuarios_idusuarios = usu.idusuarios where usu.idusuarios = ?",
                             array($this->id));

        if(isset($res)){
            foreach ($res as $rs){
                $this->usuario = $rs['usuario'];
                $this->senha = $rs['senha'];
                $this->email = $rs['email'];
                $this->nome = $rs['nome'];
                $this->status = $rs['status'];
                $this->tipo = $rs['tipousuarios_idusuariotipo'];
            }
            return true;
        }

        return false;
    }

    public function carregar2() {
        $crud = new Crud(TRUE);
        $resp = $crud->Consulta("usuarios WHERE idusuarios = ? LIMIT 1", array($this->id));

        if (!empty($resp)) {
            $this->usuario = $resp[0]['usuario'];
            $this->senha = $resp[0]['senha'];
            $this->email = $resp[0]['email'];
            $this->nome = $resp[0]['nome'];
            $this->status = $resp[0]['status'];
            $this->tipo_empresa = $resp[0]["tipo_empresa"];

            return true;
        }

        return false;
    }

    public function excluir() {
        $crud = new Crud(FALSE);
        $resp = $crud->Excluir('usuarios_has_tipousuarios','usuarios_idusuarios',$this->id);

        if ($resp)
            $resp = $crud->Excluir('usuarios','idusuarios',$this->id);

        return $resp;
    }

    public function excluir2() {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Excluir("usuarios", "idusuarios", $this->id);
        return $resp;
    }

    public function inserir() {
        $this->encripta();
        $crud = new Crud(TRUE);
        $resp = $crud->Inserir('usuarios',
                                 array('usuario',
                                      'senha',
                                      'email',
                                      'nome',  
                                      'status'), 
                                 array(strtolower($this->usuario),
                                       $this->senha,
                                       strtolower($this->email),
                                       utf8_decode($this->nome),
                                       $this->status));
        

        if($resp){
            $codigo = $crud->getUltimoCodigo();
            $resp = $crud->Inserir('usuarios_has_tipousuarios',
                                 array('usuarios_idusuarios','tipousuarios_idusuariotipo'), 
                                 array($codigo,$this->tipo));
        }

        $crud->executar($resp);
        return $resp;
    }

    public function inserir2() {

        if (empty($this->crud))
            $this->crud = new Crud();

        $this->encripta();

        $resp = $this->crud->Inserir('usuarios',
                                                        array('usuario',
                                                              'nome',
                                                              'senha',
                                                              'email',
                                                               'status',
                                                               'tipo_empresa'),
                                                        array(strtolower($this->usuario),
                                                            strtolower($this->nome),
                                                              $this->senha,
                                                              strtolower($this->email),
                                                              $this->status,
                                                              $this->tipo_empresa
                                                        )
                                );

        if ($resp) {
            $this->id = $this->crud->getUltimoCodigo();
        }

        return $resp;
    }

    public function listar() {
        $crud = new Crud(FALSE);
        $res = $crud->busca('usuarios WHERE tipo_empresa IS NULL');//usuarios usu
                                //inner join usuarios_has_tipousuarios uht on usu.idusuarios = uht.usuarios_idusuarios
                                //inner join tipousuarios tpu on tpu.idtipousuarios = uht.tipousuarios_idtipousuarios
        
        return $res;
    }

    private function encripta() {
        $senha = $this->senha;
        $codifica = password_hash($senha, PASSWORD_DEFAULT);
        $this->senha = $codifica;
        return $codifica;
    }
    
    public function login(){
        $ema = strtolower($this->email);
        $usu = strtolower($this->usuario);
        $crud = new Crud(FALSE);

        if(validaEmail($ema) == TRUE){
            // login com email
            $rs = $crud->ConsultaGenerica("select idusuarios,senha from usuarios where email = ? and status = ?",array($ema,1));
        } else {
            // login com usuario
            $rs = $crud->ConsultaGenerica("Select idusuarios,senha from usuarios where usuario = ? and status = ?",array($usu,1));
        }
        
        //print_r($rs); exit;
        if (isset($rs)) {
            foreach ($rs as $rsr) {
                if(password_verify($this->senha, $rsr['senha'])){
                    $id = $rsr['idusuarios'];
                    //Gravar log de acesso
                    $crud->inserir("usuario_logs", array('usuarios_idusuarios', 'data_hora'), array($id, date("Y-m-d H:i:s")));
                }else{
                    return -1;
                }
            }
            return $id;
        } else {
            return -1;
        }
    }
    
    public function alteraStatus(){
         $crud = new Crud(FALSE);
         $resp = $crud->Altera("usuarios", array('status'), array($this->status), 'idusuarios', $this->id);
         return $resp;
    }
    
    public function exixteUsuario(){
        $crud = new Crud(FALSE);
        $resp = $crud->Consulta("usuarios where usuario = ?",array($this->usuario));
        
        if(isset($resp)){            
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function exixteEmail(){
        $crud = new Crud(FALSE);
        $resp = $crud->Consulta("usuarios where email = ?",array($this->email));
        if(isset($resp)){            
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function exixteEmail2(){
        $crud = new Crud(FALSE);
        $resp = $crud->Consulta("usuarios where email = ? AND idsusuarios <> ?",array($this->email,$this->id));
        if(isset($resp)){            
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function alterarSenha($senhaantiga,$novasenha){
        $crud = new Crud(FALSE);
        $senha = $this->getSenha();
        $this->setSenha($senhaantiga);
        
        if(password_verify($this->senha, $senha)){
            $this->setSenha($novasenha);
            $this->encripta();
            $resp = $crud->Altera("usuarios", array("senha"), array($this->senha), "idusuarios", $this->id);
            return $resp;
        }else{
            return FALSE;
        }
    }
    
    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select status from usuarios where idusuarios = ? LIMIT 1", array($this->id));
        if(!empty($resp)) {
            $this->status = $resp[0]["status"];
        }
        
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->status))
            $this->status = 0;
        else
            $this->status = 1;
        
        $resp = $crud->Altera('usuarios', array('status'), array(utf8_decode($this->status)), 'idusuarios', $this->id);
        
        return $resp;
    }
    
    public function alteraPerfil($imagem){
        $crud = new Crud(FALSE);
        if($this->id != ""){
            $resp = $crud->Altera('usuarios',
                                array('nome'),
                                array(utf8_decode($this->nome)), 
                                'idusuarios', $this->id);

            if($imagem != ""){
                if($this->RedimensionarImagem($imagem, $this->id.".jpg", 45, "images/usuarios",2000)){}
            }
            
            if($resp == FALSE){
                $crud->executar(FALSE);
                $resp = "Problemas ao alterar o registro no banco de dados";
            }
            return $resp;    
        }else{
            $resp = "Informe o código para alterar";
        }
        return $resp;
    }
    
    function RedimensionarImagem($imagem, $name, $largura, $pasta, $limite) {
            $img = imagecreatefromjpeg($imagem);
            $x = imagesx($img);
            $y = imagesy($img);
            $altura = ($largura * $y) / $x;
            
            $nova = imagecreatetruecolor($largura, $altura);
            
            if ($x > $limite && $y > $limite) {
                return false;
            } else {
                imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
                imagejpeg($nova, "$pasta/$name",100);
                //unlink("$pasta/$name");
                imagedestroy($img);
                imagedestroy($nova);
                //return $name;
                return true;
                //print '<p class="msg">Imagem enviada com sucesso</p>';
            }
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {
        
    }

    public function quantidadeRegistros($filtro, $chaves = "") {
        
    }

}
