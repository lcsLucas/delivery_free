<?php 
      $dropArea = TRUE;
      $menu = "Home";
      $submenu = "";
      include './topo.php'; 
?>
<?php require_once './classes/Usuarios.php'; ?>
<?php 

$cod = $nome = $email = $usuari = "";

$usuario = new Usuarios();

if(isset($_POST['alt'])){
    $nome = $_POST['nome'];
    $imagem = $_FILES['imgdestaque']['tmp_name'];
    $usuario->setId($usu->getId());
    $usuario->setNome($nome);
    
    //  verifica se tem imagem
    $image_mime = image_type_to_mime_type(exif_imagetype($imagem));
    if("image/jpeg" == $image_mime){
        $ext = strtolower(strrchr( $_FILES['imgdestaque']['name'],'.')); 
        if($ext == ".jpg" || $ext == ".jpeg"){
            $resp = $usuario->alteraPerfil($imagem);
            if($resp == TRUE){
                $sucessoinserir = TRUE;
            }else{
                 $erroinserir = TRUE;
            }
        }else{
            $erroextencao = TRUE;
        }
    }else{
        $erroextencao = TRUE;
    }
    
}

$usuario->setId($usu->getId());
$usuario->carregar();

$nome = $usuario->getNome();
$email = $usuario->getEmail();
$usuari = $usuario->getUsuario();

?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Alterar Perfil</h2>
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
                            
                                <input type="hidden" name="codigo" value="<?php echo $cod; ?>" > 
                                
                                <div class="col-sm-12">
                                    <div class="droparea_container"  >
                                      <label for="nome">Imagem de perfil para destaque:</label>
                                      <div class="droparea text-center" id="drop1">
                                          <?php if( !file_exists("images/usuarios/".$usuario->getId().".jpg")){ ?>
                                          <img class="img-responsive" src="images/user.png" id="file_preview_1" > <br >
                                          <?php } else{ ?>
                                          <img class="img-responsive" src="images/usuarios/<?php echo $usuario->getId(); ?>.jpg" id="file_preview_1" > <br >    
                                          <?php
                                          } ?>
                                          <span >Clique para procurar a imagem!</span>
                                      </div>
                                    </div>
                                    <input type="file" name="imgdestaque" id="file_1" accept="image/jpeg" style="display: none;" >
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input required="true" autofocus name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                                            <label class="form-label">Nome</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input readonly required="true" autofocus name="email" value="<?php echo $email; ?>" type="text" id="email_address" class="form-control">
                                            <label class="form-label">E-mail</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input readonly required="true" autofocus name="usuario" value="<?php echo $usuari; ?>" type="text" class="form-control">
                                            <label class="form-label">Usuário</label>
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

