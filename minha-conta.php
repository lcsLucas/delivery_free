<?php
    include_once "topo.php";
    include_once "./sistema_delivery/classes/Cliente.php";

    if (empty($_SESSION["_idcliente"])) {
		header('Location: ' . $baseurl . 'login');
        exit;
    }

    $cliente = new Cliente();
    $cliente->setId($_SESSION["_idcliente"]);
    $dados_cliente = $cliente->recupeDadosSite();

    $mask = true;
    $datetimepicker = true;
    $alert_zebra = true;
    $validation = true;
	$page = 1;
?>

<div id="minha-conta" class="container my-5">


    <div class="row">

        <div class="col-12 col-md-3">

            <?php
                include_once 'sidebar-cliente.php';
            ?>

        </div>

        <div class="col-12 col-md-9">

            <div id="form-cadastro">

                <form autocomplete="off" method="post" action="" class="needs-validation" id="f-dados-conta">

                    <header class="mb-5">

                        <h2 id="titulo-pagina" class="text-center">
                            Meus dados
                            <hr>
                        </h2>

                    </header>

                    <div class="row">

                        <div class="col-sm-12 col-md-6">

                            <div class="form-group mb-4">
                                <label for="nome">Nome Completo <sup class="text-danger">*</sup>:</label>

                                <div class="input-group input-group-lg mb-1">
                                    <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-user"></i>
                                </span>
                                    </div>
                                    <input maxlength="60" type="text" required class="form-control border-left-0" placeholder="Seu nome" value="<?= !empty($cliente->getNome()) ? $cliente->getNome() : "" ?>" name="nome" id="nome">
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 col-md-6">

                            <div class="form-group mb-4">
                                <label for="email">Email <sup class="text-danger">*</sup>:</label>

                                <div class="input-group input-group-lg mb-1">
                                    <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                    </div>
                                    <input disabled title="Você não pode alterar seu email" maxlength="60" type="email" required class="form-control border-left-0 not-enable" value="<?= !empty($cliente->getEmail()) ? $cliente->getEmail() : "" ?>" placeholder="Seu Email" name="email" id="email">
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 col-md-6">

                            <div class="form-group mb-4">
                                <label for="usuario">Login <sup class="text-danger">*</sup>:</label>

                                <div class="input-group input-group-lg mb-1">
                                    <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-user"></i>
                                </span>
                                    </div>
                                    <input disabled title="Você não pode alterar seu login" maxlength="60" type="text" required class="form-control border-left-0 not-enable" value="<?= !empty($cliente->getUsuario()) ? $cliente->getUsuario() : "" ?>" placeholder="Seu login" name="usuario" id="usuario">
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 col-md-6">

                            <div class="form-group mb-4">
                                <label for="nascimento">Data de Nascimento <sup>(opcional)</sup>:</label>

                                <div class="input-group input-group-lg mb-1 datepicker date" data-provide="datepicker">
                                    <input maxlength="60" type="text" class="form-control border-right-0 mascara-data append datetimepicker-input" data-target="#datetimepicker" value="<?= !empty($cliente->getNascimento()) ? $cliente->getNascimento() : "" ?>" placeholder="__/__/____" name="nascimento" id="nascimento">
                                    <div style="cursor: pointer;" class="input-group-append input-group-addon" data-target="#datetimepicker" data-toggle="datetimepicker">
                                <span class="input-group-text border-left-0">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 col-md-6">

                            <div class="form-group mb-4">
                                <label for="celular">Celular <sup class="text-danger">*</sup>:</label>

                                <div class="input-group input-group-lg mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-right-0">
                                            <i class="fab fa-whatsapp"></i>
                                        </span>
                                    </div>
                                    <input maxlength="15" type="tel" required class="form-control border-left-0 mascara-celular" value="<?= !empty($cliente->getFone()) ? $cliente->getFone() : "" ?>" placeholder="Seu celular" name="celular" id="celular">
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 col-md-6">

                            <div class="form-group mb-4">
                                <label for="celular2">Celular 2 <sup>(opcional)</sup>:</label>

                                <div class="input-group input-group-lg mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-right-0">
                                            <i class="fab fa-whatsapp"></i>
                                        </span>
                                    </div>
                                    <input maxlength="15" type="tel" class="form-control border-left-0 mascara-celular" value="<?= !empty($cliente->getFone2()) ? $cliente->getFone2() : "" ?>" placeholder="Seu celular" name="celular2" id="celular2">
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 text-right mt-4">

                            <div class="form-group">
                                <button name="btnAlterar" type="submit" class="btn bg-cor-principal btn-lg text-white d-block ml-auto px-4 py-2">
                                    Alterar Dados <i class="fas fa-check ml-2"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                </form>

                <hr id="divisor" class="my-5">

                <form autocomplete="off" method="post" action="" class="needs-validation" id="f-senha-conta">

                    <header class="mb-5 mt-5">

                        <h2 id="titulo-pagina" class="text-center">
                            Alterar Senha
                            <hr>
                        </h2>

                    </header>

                    <div class="form-group mb-4">
                        <label for="senha">Senha Atual<sup class="text-danger">*</sup>:</label>
                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                        <span class="input-group-text border-right-0">
                            <i class="fa fa-key"></i>
                        </span>
                            </div>
                            <input maxlength="30" type="password" required class="form-control border-left-0" placeholder="Sua senha atual" name="senha" id="senha">
                        </div>

                    </div>

                    <div class="form-group mb-4">
                        <label for="senha2">Nova Senha <sup class="text-danger">*</sup>:</label>
                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                        <span class="input-group-text border-right-0">
                            <i class="fa fa-key"></i>
                        </span>
                            </div>
                            <input maxlength="30" type="password" required class="form-control border-left-0" placeholder="Sua nova senha" name="senha_nova" id="senha_nova">
                        </div>

                    </div>

                    <div class="form-group mb-4">
                        <label for="senha2">Repita a Nova Senha <sup class="text-danger">*</sup>:</label>
                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                        <span class="input-group-text border-right-0">
                            <i class="fa fa-key"></i>
                        </span>
                            </div>
                            <input maxlength="30" type="password" required class="form-control border-left-0" placeholder="Repita a nova senha novamente" name="senha2" id="senha2">
                        </div>

                    </div>

                    <div class="form-group">
                        <button name="btnAlteraSenha" type="submit" class="btn bg-cor-principal btn-lg text-white d-block ml-auto px-4 py-2">
                            Alterar Senha <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php
include_once "rodape.php";
?>
