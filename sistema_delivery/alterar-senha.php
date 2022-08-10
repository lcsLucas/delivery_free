<?php 
      $menu = "Home";
      $submenu = "";
      include './topo.php'; 
?>
<?php require_once './classes/Usuarios.php'; ?>
<?php 

$usuario = new Usuarios();

if(isset($_POST['alt'])){
    
    $senhaantiga = $_POST['senhaantiga'];
    $novasenha = $_POST['novasenha'];
    $repitasenha = $_POST['repitasenha'];
    
    if($novasenha == $repitasenha){
            $usuario->setId($_SESSION["_idusuario"]);
            $usuario->carregar();
            $resp = $usuario->alterarSenha($senhaantiga, $novasenha);
            if($resp == TRUE){
                $senhaalterada = TRUE;
            }else{
                $senhainvalida = TRUE;
            }
    }else{
        $senhasdiferentes = TRUE;
    }
}

?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Alterar Senha</h2>
            </div>
            
            <?php 
                include 'menssagens.php';
            ?>
            
            <div class="row clearfix">
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                                Alterar
                            </h2>
                        </div>
                        <div class="body">
                            <form id="sign_in" role="form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data"  >
                            
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input required="true" autofocus name="senhaantiga" value="" type="password" class="form-control">
                                            <label class="form-label">Senha antiga</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input  required="true" autofocus name="novasenha" value="" type="password" class="form-control">
                                            <label class="form-label">Nova senha</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input  required="true" autofocus name="repitasenha" value="" type="password" class="form-control">
                                            <label class="form-label">Repita a nova senha</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" name="alt" class="btn btn-success m-t-15 waves-effect">Alterar</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
</section>
<?php include './rodape.php'; ?>


