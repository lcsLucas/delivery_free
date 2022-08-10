<?php
include_once "topo.php";

$mask = $validation = true;

$nome = $email = $fone = $cnpj = $endereco = $numero = $complemento = $bairro = $cidade = $cep = $estado = '';

if (filter_has_var(INPUT_POST, 'request_parceiro')) {

	$nome = trim(SQLinjection(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS)));
	$cnpj = trim(SQLinjection(filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_SPECIAL_CHARS)));
	$endereco = trim(SQLinjection(filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS)));
	$numero = trim(SQLinjection(filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT)));
	$complemento = trim(SQLinjection(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_SPECIAL_CHARS)));
	$bairro = trim(SQLinjection(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS)));
	$cidade = trim(SQLinjection(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS)));
	$cep = trim(SQLinjection(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_SPECIAL_CHARS)));
	$estado = trim(SQLinjection(filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS)));
	$email = trim(SQLinjection(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)));
	$fone = trim(SQLinjection(filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_SPECIAL_CHARS)));

	$nome = $email = $fone = $cnpj = $endereco = $numero = $complemento = $bairro = $cidade = $cep = $estado = '';

	$resp = true;

}

?>

<div class="container mt-5 mb-5">

    <?php

    if (!empty($resp)) {
        ?>
        <div class="alert alert-success mb-5">
            Solicitação enviada com sucesso. Aguarde, em breve entraremos em contato!
        </div>
    <?php
    }

    ?>

	<h2 id="titulo-pagina" class="text-center">
		Torna-se Parceiro
		<hr>
	</h2>

    <form action="" method="POST" id="formParceiro">

        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-9">

                <div class="form-group">
                    <label for="nome">Nome / Razão Social: <sup class="text-danger">*</sup></label>
                    <input value="<?= $nome ?>" autofocus required type="text" class="form-control" id="nome" name="nome" placeholder="">
                </div>

            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">

                <div class="form-group">
                    <label for="cnpj">CNPJ: <sup class="text-danger">*</sup></label>
                    <input value="<?= !empty($cnpj) ? $cnpj : '48.257.156/0001-89' ?>" required type="tel" class="form-control mascara-cnpj cnpj" id="cnpj" name="cnpj">
                </div>

            </div>

            <div class="col-sm-12 col-md-3 col-lg-3">

                <div class="form-group">
                    <label for="cep">CEP: <sup class="text-danger">*</sup></label>
                    <input value="<?= $cep ?>" required type="text" class="form-control mascara-cep cep" id="cep" name="cep" placeholder="">
                </div>

            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">

                <div class="form-group">
                    <label for="endereco">Endereço: <sup class="text-danger">*</sup></label>
                    <input value="<?= $endereco ?>" required type="text" class="form-control" id="endereco" name="endereco" placeholder="">
                </div>

            </div>

            <div class="col-sm-12 col-lg-2 col-md-3">

                <div class="form-group">
                    <label for="numero">Número: <sup class="text-danger">*</sup></label>
                    <input value="<?= $numero ?>" required type="text" class="form-control mascara-numero text-center" id="numero" name="numero">
                </div>

            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">

                <div class="form-group">
                    <label for="complemento">Complemento:</label>
                    <input value="<?= $complemento ?>" type="text" class="form-control" id="complemento" name="complemento">
                </div>

            </div>

            <div class="col-sm-12 col-md-6 col-lg-5">

                <div class="form-group">
                    <label for="bairro">Bairro: <sup class="text-danger">*</sup></label>
                    <input value="<?= $bairro ?>" required type="text" class="form-control" id="bairro" name="bairro" placeholder="">
                </div>

            </div>

            <div class="col-sm-12 col-md-9 col-lg-5">

                <div class="form-group">
                    <label for="cidade">Cidade: <sup class="text-danger">*</sup></label>
                    <input value="<?= $cidade ?>" required type="text" class="form-control" id="cidade" name="cidade" placeholder="">
                </div>

            </div>

            <div class="col-sm-12 col-md-3 col-lg-2">

                <div class="form-group">
                    <label for="estado">UF: <sup class="text-danger">*</sup></label>
                    <select id="estado" name="estado" class="form-control" required>
                        <option <?= $estado === 'AC' ? 'selected' : '' ?> value="AC">AC</option>
                        <option <?= $estado === 'AL' ? 'selected' : '' ?> value="AL">AL</option>
                        <option <?= $estado === 'AP' ? 'selected' : '' ?> value="AP">AP</option>
                        <option <?= $estado === 'AM' ? 'selected' : '' ?> value="AM">AM</option>
                        <option <?= $estado === 'BA' ? 'selected' : '' ?> value="BA">BA</option>
                        <option <?= $estado === 'CE' ? 'selected' : '' ?> value="CE">CE</option>
                        <option <?= $estado === 'DF' ? 'selected' : '' ?> value="DF">DF</option>
                        <option <?= $estado === 'ES' ? 'selected' : '' ?> value="ES">ES</option>
                        <option <?= $estado === 'GO' ? 'selected' : '' ?> value="GO">GO</option>
                        <option <?= $estado === 'MA' ? 'selected' : '' ?> value="MA">MA</option>
                        <option <?= $estado === 'MT' ? 'selected' : '' ?> value="MT">MT</option>
                        <option <?= $estado === 'MS' ? 'selected' : '' ?> value="MS">MS</option>
                        <option <?= $estado === 'MG' ? 'selected' : '' ?> value="MG">MG</option>
                        <option <?= $estado === 'PA' ? 'selected' : '' ?> value="PA">PA</option>
                        <option <?= $estado === 'PB' ? 'selected' : '' ?> value="PB">PB</option>
                        <option <?= $estado === 'PR' ? 'selected' : '' ?> value="PR">PR</option>
                        <option <?= $estado === 'PE' ? 'selected' : '' ?> value="PE">PE</option>
                        <option <?= $estado === 'PI' ? 'selected' : '' ?> value="PI">PI</option>
                        <option <?= $estado === 'RJ' ? 'selected' : '' ?> value="RJ">RJ</option>
                        <option <?= $estado === 'RN' ? 'selected' : '' ?> value="RN">RN</option>
                        <option <?= $estado === 'RS' ? 'selected' : '' ?> value="RS">RS</option>
                        <option <?= $estado === 'RO' ? 'selected' : '' ?> value="RO">RO</option>
                        <option <?= $estado === 'RR' ? 'selected' : '' ?> value="RR">RR</option>
                        <option <?= $estado === 'SC' ? 'selected' : '' ?> value="SC">SC</option>
                        <option <?= $estado === 'SP' ? 'selected' : '' ?> value="SP">SP</option>
                        <option <?= $estado === 'SE' ? 'selected' : '' ?> value="SE">SE</option>
                        <option <?= $estado === 'TO' ? 'selected' : '' ?> value="TO">TO</option>
                        <option <?= $estado === 'ES' ? 'selected' : '' ?> value="ES">ES</option>
                    </select>
                </div>

            </div>

            <div class="col-sm-12 col-md-6">

                <div class="form-group">
                    <label for="email">Email : <sup class="text-danger">*</sup></label>
                    <input value="<?= $email ?>" required type="email" class="form-control" id="email" name="email" placeholder="" autocomplete="email">
                </div>

            </div>

            <div class="col-sm-12 col-md-6">

                <div class="form-group">
                    <label for="fone">Fone: <sup class="text-danger">*</sup></label>
                    <input value="<?= $fone ?>" required type="text" class="form-control mascara-celular2 mascara-celular" id="fone" name="fone" placeholder="(__) ____-____">
                </div>

            </div>

            <div class="col-sm-12 col-md-12 text-right">
                <input type="hidden" name="request_parceiro">
                <button name="btnParceiro" type="submit" style="width: 250px; letter-spacing: .04em" class="btn bg-cor-principal py-3 pr-5 pl-3 ml-auto text-white text-uppercase font-weight-bold position-relative">Enviar solicitação <i style="position: absolute;top: 50%;right: 10px;transform: translateY(-50%);" class="ml-4 fas fa-fw fa-check-circle"></i></button>

            </div>

        </div>

    </form>

</div>

<?php
include_once "rodape.php";
?>
