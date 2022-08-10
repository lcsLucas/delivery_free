<?php
$usur_system = true;
require '../config.php';
require_once './classes/Usuarios.php';
require_once './classes/Acesso.php';
include '../recaptchaconf.php';

$ip = get_client_ip();

$acesso = new Acesso();
$acesso->setIp($ip);
$acesso->setData(date("Y-m-d H:i:s"));

$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

//Pegar as tentativas do IP
 $tentativas = $acesso->retornaTentativas();

if($localhost == FALSE){
    if($tentativas > 3){
//if($_COOKIE['tentaivas'] >= 3){
        if (!$resp->isSuccess()){ 
            //setcookie("tentaivas",$_COOKIE['tentaivas']+1);
            $acesso->inserir();
            header("Location:index.php?robo=Código informado é invalido");
            exit;
        }
//}
    }
}

if(isset($_POST['entrar'])){ // clicou no botão logar
        
        if(!isset($_POST['senha'])){ // ver se informou senha
            $erro = "Informe a senha";
        }
        if(!isset($_POST['login'])){ // ver se informou email
            $erro = "Informe a usuário"; //ou email
        }
        
        if(!isset($erro)){ // não tem erro
            //efetuar verificações
            $loginemail = $_POST['login'];
            $senha = $_POST['senha'];
            
            // usou login
            $usu = new Usuarios(SQLinjection($loginemail), $senha, SQLinjection($loginemail));
            $resposta = $usu->login();
            if($resposta != -1){
                $_SESSION['_idusuario'] = $resposta; // guarda na sessão
                header("Location:principal.php");
            }else{
                //setcookie("tentaivas",$_COOKIE['tentaivas']+1);
                $acesso->inserir();
                header("Location:index.php?erro=usuário não encontrado");
            }
            
        }else{
            //setcookie("tentaivas",$_COOKIE['tentaivas']+1);
            $acesso->inserir();
            header("Location:index.php?erro=$erro");
        }
}


