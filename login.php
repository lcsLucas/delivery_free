<?php
$validation = true;
$alert_zebra = true;
include_once "topo.php";

if (!empty($_SESSION["_logado"])) {
    header("Location: minha-conta");
    exit;
}

?>

<div class="container">

    <div class="row">

        <?php

        if (!empty($_SESSION['continuar']) && !empty($_SESSION['_carrinhoprodutos'])) {

            ?>

            <div class="col-sm-12 mt-5">

                <div class="alert alert-info text-center"><i class="fas fa-fw fa-info-circle"></i> Atenção! para continuar o pedido, por favor faça o login ou cadastre-se</div>

            </div>

            <?php

        }

        ?>


        <div id="divisor" class="col-sm-12 col-md-6">

            <div class="width-480" id="form-login">

                <h2 class="titulo">Login</h2>
                <p class="text-muted">Bem Vindo de volta! Faça o login com sua conta para continuar</p>

                <form id="f-login" method="post" action="" class="needs-validation">

                    <div class="form-group">

                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fas fa-at"></i>
                                </span>
                            </div>
                            <input maxlength="60" type="text" required class="form-control border-left-0" placeholder="Login ou email" name="usuario" id="usuario">
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>
                            <input maxlength="60" required type="password" class="form-control border-left-0" placeholder="senha" name="senha">
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" name="ckConectado" id="ckConectado">
                            <label class="form-check-label" for="ckConectado">
                                Permanecer conectado
                            </label>
                        </div>

                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn bg-cor-principal text-white d-block ml-auto" name="btnLogin">Logar</button>
                        <a id="link-senha" class="mt-3 d-block" href="">Esqueceu sua senha?</a>
                    </div>

                </form>

            </div>

        </div>

        <div class="col-sm-12 col-md-6">

            <div class="width-480" id="form-cadastro">

                <h2 class="titulo">Cadastrar-se</h2>
                <p class="text-muted">Novo aqui? Aproveite e crie uma conta</p>

                <form id="f-cadastro" method="get" action="cadastro.php" class="needs-validation">

                    <div class="form-group">

                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input maxlength="60" type="text" required class="form-control border-left-0" placeholder="Seu nome" name="nome" id="cad-nome">
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input maxlength="60" type="email" required class="form-control border-left-0" placeholder="Seu email" name="email" id="cad-email">
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="form-check invisible">
                            <label></label>
                        </div>

                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn bg-cor-principal text-white d-block ml-auto">Cadastrar-se</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php
include_once "rodape.php";
?>
