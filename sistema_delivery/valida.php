<?php
require_once './classes/Usuarios.php';
require_once "classes/ResponsavelEmpresa.php";

if(!isset($_SESSION["_idusuario"])){
   header("Location:index.php");
}else{
    $usu = new Usuarios();
    $usu->setId($_SESSION["_idusuario"]);

    if (!$usu->carregar()) {
        $r_empresa = new ResponsavelEmpresa();
        $r_empresa->setUsuario($usu);

        if($r_empresa->getUsuario()->carregar2()) {
            $r_empresa->getUsuario()->setTipoEmpresa(1);
            $usu = $r_empresa->getUsuario();

            $_SESSION["_idEmpresa"] = $r_empresa->recuperaIdEmpresa();
        }
    }
}

