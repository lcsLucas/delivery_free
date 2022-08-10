<?php
$menu = "Configurações";
$submenu = "Informações";
$dropArea = TRUE;
$mask = true;
$select2 = true;

require_once 'topo.php';
include_once 'classes/Empresa.php';
require_once 'classes/Endereco.php';

$empresa = new Empresa();
$empresa->setId($_SESSION['_idEmpresa']);
$endereco = new Endereco();

$nome = $descricao = $fone1 = $fone2 = '';
$rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
	if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração

		$nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
		$fone1 = trim(filter_input(INPUT_POST, "fone1", FILTER_SANITIZE_SPECIAL_CHARS));
		$fone2 = trim(filter_input(INPUT_POST, "fone2", FILTER_SANITIZE_SPECIAL_CHARS));
		$descricao = htmlentities(SQLinjection(filter_input(INPUT_POST, "descricao",FILTER_DEFAULT)));

		$rua = trim(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_SPECIAL_CHARS));
		$numero = trim(filter_input(INPUT_POST, "txtNumero", FILTER_VALIDATE_INT));
		$bairro = trim(filter_input(INPUT_POST, "txtBairro", FILTER_SANITIZE_SPECIAL_CHARS));
		$cep = trim(filter_input(INPUT_POST, "txtCep", FILTER_SANITIZE_SPECIAL_CHARS));
		$id_estado = trim(filter_input(INPUT_POST, "selEstado", FILTER_VALIDATE_INT));
		$id_cidade = trim(filter_input(INPUT_POST, "selCidade", FILTER_VALIDATE_INT));

		if (empty($nome) || empty($endereco)) {
			$erroCamposVazios = true;
		} else {

			$empresa->setNome($nome);
			$empresa->setDescricao($descricao);
			$empresa->setFone1($fone1);
			$empresa->setFone2($fone2);

			$endereco->setRua($rua);
			$endereco->setNumero($numero);
			$endereco->setBairro($bairro);
			$endereco->setCep($cep);
			$endereco->getCidade()->setId($id_cidade);
			$endereco->getCidade()->getEstado()->setSigla($id_estado);

			$empresa->setEndereco($endereco);

			if ($empresa->alterarInformacoes()) {
				$sucessoPersonalizado = TRUE;
				$sucessoMensagem = "Ao Alterar as informações do restaurante!";
				$nome = $descricao = $fone1 = $fone2 = '';
				$rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";
			} else {
				$erroPersonalizado = true;
				$erroMensagem = "Ao Alterar as informações do restaurante!";
			}


		}

	}

}

$lista_estados = $endereco->getCidade()->getEstado()->listar();
$lista_cidades = $endereco->getCidade()->listar();


if ($empresa->carregarInformacoes() && empty($erroPersonalizado)) {

	$nome = $empresa->getNome();
	$descricao = $empresa->getDescricao();
	$fone1 = $empresa->getFone1();
	$fone2 = $empresa->getFone2();

	$rua = $empresa->getEndereco()->getRua();
	$numero = $empresa->getEndereco()->getNumero();
	$cep = $empresa->getEndereco()->getCep();
	$bairro = $empresa->getEndereco()->getBairro();
	$id_estado = $empresa->getEndereco()->getCidade()->getEstado()->getSigla();
	$id_cidade = $empresa->getEndereco()->getCidade()->getId();

}


?>

<h2 class="titulo-pagina">Informações do restaurante</h2>

<?php
include 'menssagens.php';
?>

<div class="card">

	<div class="card-header bg-primary text-white">
		Descrição sobre o restaurante
	</div>

	<div class="card-body">

		<form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<div class="form-row">
				<div class="form-group col-12 input-group-lg">
					<label for="nome"><strong>Nome do Restaurante <span class="obrigatorio">*</span></strong>: </label>
					<input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
				</div>
				<div class="form-group col-12">
					<label for="obs"><strong>Descrição do Restaurante <span class="obrigatorio">*</span></strong>: </label><br>
					<textarea style="resize: none" name="descricao" id="obs" rows="5" class="form-group w-100" required><?= $descricao ?></textarea>
				</div>

				<div class="col-12 col-sm-6">

					<div class="form-group">

						<label for="validationCustomUsername">Fone 1 <span class="obrigatorio">*</span>:</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" ><i class="fa fa-phone" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control mascara-celular" id="celular" name="fone1" value="<?= $fone1 ?>" placeholder="(__) _____-____" >
						</div>

					</div>

				</div>
				<div class="col-12 col-sm-6">

					<div class="form-group">

						<label for="validationCustomUsername">Fone 2:</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" ><i class="fa fa-phone" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control mascara-celular" id="celular2" name="fone2" value="<?= $fone2 ?>" placeholder="(__) _____-____" >
						</div>

					</div>

				</div>

				<div class="form-group col-12">
					<hr>
					<h3><strong>Endereço</strong></h3>
				</div>

				<div class="col-12 col-md-9 col-lg-6">
					<div class="form-group">
						<label class="control-label" for="txtRua">Rua <span class="obrigatorio">*</span>:</label>
						<input type="text" id="txtRua" name="txtRua" maxlength="200" class="form-control" required value="<?= $rua ?>" />
					</div>
				</div>
				<div class="col-12 col-sm-4 col-md-3 col-lg-2">
					<div class="form-group">
						<label class="control-label" for="txtNumero">Nº <span class="obrigatorio">*</span>:</label>
						<input type="tel" id="txtNumero" name="txtNumero" aria-describedby="help-numero" class="form-control mascara-numero" required value="<?= $numero ?>" />
					</div>
				</div>
				<div class="col-12 col-sm-8 col-md-4 col-lg-4">
					<div class="form-group">
						<label class="control-label" for="txtCep">CEP <span class="obrigatorio">*</span>:</label>
						<input type="tel" id="txtCep" name="txtCep" class="form-control mascara-cep" required value="<?= $cep ?>" />
					</div>
				</div>
				<div class="col-12 col-md-8 col-lg-4">
					<div class="form-group">
						<label class="control-label" for="txtBairro">Bairro <span class="obrigatorio">*</span>:</label>
						<input type="text" id="txtBairro" name="txtBairro" maxlength="100" class="form-control" required value="<?= $bairro ?>" />
					</div>
				</div>
				<div class="form-group col-12 col-md-4 col-lg-4">
					<div class="form-group">
						<label class="control-label" for="txtEstado">Estado <span class="obrigatorio">*</span>:</label>
						<select class="form-control" name="selEstado" id="selEstado" disabled>
							<?php
							foreach ($lista_estados as $estado) {
								?>
								<option value="<?= $estado['est_sigla'] ?>"><?= utf8_encode($estado['est_nome']) ?></option>
								<?php
							}
							?>
						</select>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-12 col-md-8 col-lg-4">
					<div class="form-group">
						<label class="control-label" for="selCidade">Cidade <span class="obrigatorio">*</span>:</label>
						<select class="form-control select2" name="selCidade" id="selCidade" required>
							<?php

							foreach ($lista_cidades as $result_cidade) {
								?>
								<option value="<?= $result_cidade['cid_id'] ?>" <?= (utf8_encode($result_cidade['cid_id']) == $id_cidade ? "selected" : "") ?> ><?= utf8_encode($result_cidade['cid_nome']) ?></option>
								<?php
							}
							?>
						</select>
						<div class="help-block with-errors"></div>
					</div>
				</div>

				<div class="form-group col-12">
					<button type="submit" class="btn btn-outline-primary btn-lg pull-right" id="btnEnviar" name="btnEnviar">
						<i class="fa fa-check" aria-hidden="true"></i>
						Confirmar
					</button>
					<a role="button" href="<?= $_SERVER["PHP_SELF"] ?>" class="btn btn-link btn-lg pull-right text-muted">
						Cancelar
					</a>
				</div>
			</div>
		</form>


	</div>

</div>

<?php
include 'rodape.php';
?>