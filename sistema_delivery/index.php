<?php
include '../config.php';
include '../recaptchaconf.php';
require_once './classes/Acesso.php';

$ip = get_client_ip();

$acesso = new Acesso();
$acesso->setIp($ip);

//Pegar as tentativas do IP
$tentativas = $acesso->retornaTentativas();
?>
<!DOCTYPE html>
<html lang="pt">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Painel Administrativo | Sistema Delivery Free</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet"> 
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class="bg-dark">
        <!-- sb -->
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header text-center bg-primary">
                    <h3 class="text-uppercase text-white">Acessar o Sistema</h3>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET["erro"])) {
                        ?>
                        <div class="alert alert-danger" role="alert">                                
                            <p class="mb-0 text-center ">
                                <?= $_GET["erro"] ?>
                            </p>
                        </div>
                        <?php
                    }
                    ?>
                    <form role="form" action="verifica.php" id="sign_in" method="POST">
                        <?php
                        if (isset($_GET["robo"])) {
                            ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Erro!</h4>
                                Prove que você não é um robô.
                            </div>	
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label class="form-label sr-only">E-mail ou Usúario:</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend2"><i class="fa fa-user-circle-o"></i></span>
                                </div>
                                <input type="text" class="form-control" id="login" name="login" placeholder="Email ou Usuário" required autofocus>
                            </div>            
                        </div>
                        <div class="form-group">
                            <label class="form-label sr-only">Senha:</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend2"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                            </div>             
                        </div>
                        <?php
                        if ($tentativas > 3) {
                            ?>
                            <div class="form-group">
                                <center>
                                    <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                                    <script type="text/javascript"
                                            src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
                                    </script>
                                </center>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <button name="entrar" class="btn btn-outline-info btn-block btn-lg" type="submit">ENTRAR</button>  
                            <p class="login-lost"><a href="">Esqueceu sua senha?</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    </body>

</html>


