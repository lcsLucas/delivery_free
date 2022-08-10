<?php
    include_once "topo.php";
    $mask = true;
    $datetimepicker = true;
    $alert_zebra = true;
    $validation = true;
    $nome = $email = "";

    if (filter_has_var(INPUT_GET, "nome")) {
        $nome = filter_input(INPUT_GET, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if (filter_has_var(INPUT_GET, "email")) {
        $email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    }

?>

<div id="form-cadastro" class="container my-5">

	<?php

	if (!empty($_SESSION['continuar']) && !empty($_SESSION['_carrinhoprodutos'])) {

		?>

        <div class="mb-5">
            <div class="alert alert-info text-center"><i class="fas fa-fw fa-info-circle"></i> Atenção! Faça o cadastro, para ser levado de volta para o pedido</div>
        </div>

		<?php

	}

	?>

    <header class="mb-5">

        <h1 id="titulo-pagina" class="text-center">
            Crie sua conta
            <hr>
        </h1>

    </header>

    <form autocomplete="off" method="post" action="" class="needs-validation" id="f-cria-conta">

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
                        <input maxlength="60" type="text" required class="form-control border-left-0" value="<?= $nome ?>" placeholder="Seu nome" name="nome" id="nome">
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
                        <input maxlength="60" type="email" required class="form-control border-left-0" value="<?= $email ?>" placeholder="Seu Email" name="email" id="email">
                    </div>

                </div>

            </div>

            <div class="col-sm-12 col-md-6">

                <div class="form-group mb-4">
                    <label for="usuario">Login <sup class="text-danger">*</sup>:</label>

                    <div class="input-group input-group-lg mb-1">
                        <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fas fa-at"></i>
                                </span>
                        </div>
                        <input maxlength="60" type="text" required class="form-control border-left-0" placeholder="Seu login" name="usuario" id="usuario">
                    </div>

                </div>

            </div>

            <div class="col-sm-12 col-md-6">

                <div class="form-group mb-4">
                    <label for="nascimento">Data de nascimento <sup>(opcional)</sup>:</label>

                    <div class="input-group input-group-lg mb-1 datepicker date" data-provide="datepicker">
                        <input maxlength="60" type="text" class="form-control border-right-0 mascara-data append datetimepicker-input" data-target="#datetimepicker" placeholder="__/__/____" name="nascimento" id="nascimento">
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
                        <input maxlength="15" type="tel" required class="form-control border-left-0 mascara-celular" placeholder="Seu celular" name="celular" id="celular">
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
                        <input maxlength="15" type="tel" class="form-control border-left-0 mascara-celular" placeholder="Seu celular" name="celular2" id="celular2">
                    </div>

                </div>

            </div>

            <div class="col-sm-12 col-md-6">
                <div class="form-group mb-4">
                    <label for="senha">Senha <sup class="text-danger">*</sup>:</label>
                    <div class="input-group input-group-lg mb-1">
                        <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-key"></i>
                                </span>
                        </div>
                        <input maxlength="30" type="password" required class="form-control border-left-0" placeholder="Sua senha" name="senha" id="senha">
                    </div>

                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="form-group mb-4">
                    <label for="senha2">Repita a senha <sup class="text-danger">*</sup>:</label>
                    <div class="input-group input-group-lg mb-1">
                        <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <i class="fa fa-key"></i>
                                </span>
                        </div>
                        <input maxlength="30" type="password" required class="form-control border-left-0" placeholder="Sua senha novamente" name="senha2" id="senha2">
                    </div>

                </div>
            </div>

            <div class="col-sm-12">

                <div class="form-check mb-2 form-group">

                    <label class="form-check-label d-block" for="ckTermos" >
                        <input required class="form-check-input" type="checkbox" name="ckTermos" id="ckTermos" title="Por favor, confirme que você leu e aceita nossos termos de uso">
                        Ao cadastrar, aceito os <a href="">termos de uso e políticas de privacidade</a>
                    </label>

                </div>

            </div>

            <div class="col-sm-12 text-right mt-5">

                <div class="form-group">
                    <button name="btnCadastro" type="submit" class="btn bg-cor-principal text-white d-block ml-auto px-4">
                        Confirmar <i class="fas fa-check ml-2"></i>
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>


<?php
    include_once "rodape.php";
?>
