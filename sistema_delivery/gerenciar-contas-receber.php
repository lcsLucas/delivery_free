<?php
$menu = "Finanças";
$submenu = "Contas Receber";
$datetimerpicker=true;
$mask = true;

require_once 'topo.php';
include_once 'classes/ContaReceber.php';

$contas_receber = new ContaReceber();
$contas_receber->setIdEmpresa($_SESSION["_idEmpresa"]);

$id = $num_conta = $num_parcela = $valor_conta = $valor_pagar = $data_emissao = $data_vencimento = $data_pagamento = $ck_finalizar = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
	if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
		$id = filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT);
		$num_parcela = filter_input(INPUT_POST, "num_parcela", FILTER_VALIDATE_INT);
		$data_vencimento = filter_input(INPUT_POST, "data_vencimento", FILTER_SANITIZE_SPECIAL_CHARS);
		$data_pagamento = filter_input(INPUT_POST, "data_pagamento", FILTER_SANITIZE_SPECIAL_CHARS);
		$data_emissao = filter_input(INPUT_POST, "data_emissao", FILTER_SANITIZE_SPECIAL_CHARS);
		$valor_conta = filter_input(INPUT_POST, "valor_conta", FILTER_SANITIZE_SPECIAL_CHARS);
		$valor_pagar = filter_input(INPUT_POST, "valor_pagar", FILTER_SANITIZE_SPECIAL_CHARS);
		$ck_finalizar = filter_has_var(INPUT_POST, "ckFinalizar");

		if (empty($id) || empty($data_vencimento) || empty($data_pagamento) || empty($valor_conta) || empty($valor_pagar)) {
			$erroCamposVazios = true;
			$carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
		} else {

			$valor_conta2 = str_replace(".", "", $valor_conta);
			$valor_conta2 = str_replace(",", ".", $valor_conta2);
			$valor_conta2 = floatval($valor_conta2);

			$valor_pagar2 = str_replace(".", "", $valor_pagar);
			$valor_pagar2 = str_replace(",", ".", $valor_pagar2);
			$valor_pagar2 = floatval($valor_pagar2);

			if ($valor_conta2 < $valor_pagar2) {
				$erroPersonalizado = true;
				$erroMensagem = "O valor pago está maior que o valor da conta";
				$carregado = true;
			} else {
				$contas_receber->setDataVencimento(trataData($data_vencimento));
				$contas_receber->setDataPago(trataData($data_pagamento));
				$contas_receber->setValor($valor_conta2);
				$contas_receber->setValorPago($valor_pagar2);
				$contas_receber->setId($id);

				if ($contas_receber->alterar()) {
					$sucessoalterar = TRUE;
					$id = $num_conta = $num_parcela = $valor_conta = $valor_pagar = $data_emissao = $data_vencimento = $data_pagamento = $ck_finalizar = "";
				} else {
					$carregado = true;
					$erroalterar = TRUE;
				}
			}

		}

	} else if(filter_has_var(INPUT_POST, "editar")) {
		$contas_receber->setId(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT));

		if (!empty($contas_receber->carregar())) {
			$id = $contas_receber->getId();
			$num_conta = $contas_receber->getId();
			$num_parcela = $contas_receber->getNumParcela();
			$valor_conta = number_format($contas_receber->getValor(), 2, ",", ".");
			$valor_pagar = number_format($contas_receber->getValorPago(), 2, ",", ".");
			$data_emissao = date("d/m/Y", strtotime($contas_receber->getDataCriacao()));
			$data_vencimento = date("d/m/Y", strtotime($contas_receber->getDataVencimento()));
			$data_pagamento = !empty($contas_receber->getDataPago()) ? date("d/m/Y", strtotime($contas_receber->getDataPago())) : "";

			$carregado = true;
		}

	}

}

$periodo1 = '';
$periodo2 = '';
$filtro = "";
$parametros = "";
if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

	$parametros = "&filtro=&periodo1=".$periodo1."&periodo2=". $periodo2;
}

//paginação
$urlpaginacao = "&page=1";
$entries_per_page = 10;
if (isset($_GET["page"])) {
	$pag = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
	$urlpaginacao = "&page=$pag";
}

$page = (isset($pag) ? $pag : 1);

$offset = (($page * $entries_per_page) - $entries_per_page);
$num_rows = $contas_receber->quantidadeRegistros2($periodo1, $periodo2);
$lista = $contas_receber->listarPaginacao2($periodo1, $periodo2, $offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Contas a Receber</h2>

<?php
include 'menssagens.php';
?>

<div class="card mb-3 border-primary">
    <div class="card-header bg-primary text-white">
        <i class="fa fa-money"></i> Detalhes da Conta a Receber
    </div>
    <div class="card-body">

        <form id="form-contas-pagar" class="needs-validation" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off" novalidate>

            <div class="form-row">

                <div class="col-12 col-sm-6 col-md-4">

                    <div class="form-group form-group-lg">

                        <label class="control-label" for="num_conta">Código:</label>
                        <div class="input-group input-group-lg">
                            <input <?= !empty($carregado) ? "disabled" : "" ?>  type="text" class="form-control" id="numero" name="numero" value="<?= $id ?>">
                            <input type="hidden" name="acao-codigo" value="<?= $id ?>">
                            <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">
                                        <a id="btn-pesquisa" style="color: inherit; height: 100%; width: 100%;" href="<?= $_SERVER["PHP_SELF"] ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
                                    </span>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-sm-6 col-md-4">

                    <div class="form-group input-group-lg">
                        <label for="num_parcela">Nº da Parcela:</label>
                        <input readonly type="number" min="1" max="99999" class="form-control" id="num_parcela" name="num_parcela" value="<?= $num_parcela ?>">
                    </div>

                </div>

                <div class="col-12 col-sm-6 col-md-4">

                    <div class="form-group input-group-lg">

                        <label for="data_emissao">Data da Emissão:</label>
                        <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                            <input readonly type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_emissao" id="data_emissao" required value="<?= !empty($data_emissao) ? $data_emissao : "" ?>" >
                            <div class="input-group-append input-group-addon">
                                <span class="input-group-text" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group input-group-lg">

                        <label for="data_vencimento">Data do Vencimento:</label>
                        <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                            <input <?= empty($carregado) ? "readonly" : "" ?> type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_vencimento" id="data_vencimento" required value="<?= !empty($data_vencimento) ? $data_vencimento : "" ?>" >
                            <div class="input-group-append input-group-addon">
                                <span class="input-group-text" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group input-group-lg">

                        <label for="data_pagamento">Data do Pagamento:</label>
                        <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                            <input <?= empty($carregado) ? "readonly" : "" ?> type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_pagamento" id="data_pagamento" required value="<?= !empty($data_pagamento) ? $data_pagamento : "" ?>" >
                            <div class="input-group-append input-group-addon">
                                <span class="input-group-text" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group input-group-lg">
                        <label for="valor_conta">Valor da Parcela:</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <div class="input-group-text">R$</div>
                            </div>
                            <input <?= empty($carregado) ? "readonly" : "" ?> type="text" maxlength="10" class="form-control text-right mascara-dinheiro" name="valor_conta" id="valor_conta" value="<?= $valor_conta ?>" placeholder="0,00">
                        </div>
                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group input-group-lg">
                        <label for="valor_pagar">Valor Pago:</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <div class="input-group-text">R$</div>
                            </div>
                            <input <?= empty($carregado) ? "readonly" : "" ?> type="text" maxlength="10" class="form-control text-right mascara-dinheiro" name="valor_pagar" id="valor_pagar" value="<?= $valor_pagar ?>" placeholder="0,00" required>
                        </div>
                    </div>

                </div>

                <div class="col-12 mt-3">

                    <div class="form-check btn-lg">
                        <input <?= empty($carregado) ? "readonly" : "" ?> <?= (!empty($carregado) && !empty($ck_finalizar)) ? "checked" : "" ?> style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="" name="ckFinalizar" id="defaultCheck1">
                        <label class="form-check-label ml-2" for="defaultCheck1">
                            Finalizar Conta?
                        </label>
                    </div>

                </div>

                <div class="form-group col-md-12 text-right">
                    <br>
                    <br>
                    <button <?= empty($carregado) ? "disabled" : "" ?> type="submit" class="btn btn-success btn-lg pull-right" id="btnEnviar" name="btnEnviar">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Confirmar
                    </button>
                    <a role="button" href="<?= $_SERVER["PHP_SELF"] ?>" class="btn btn-link btn-lg <?= empty($carregado) ? "disabled" : "" ?>">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>

        <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
            <input type="hidden" id="input-pesq" name="acao-codigo" value="<?= $id ?>" />
            <button type="submit" class="btn btn-info btn-acao d-none" title="Editar Entrada" name="editar">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </button>
        </form>

    </div>

</div>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="titulo-card">
            Contas a receber cadastradas <a target="_blank" href="relatorios/relatorio-contas-receber.php?filtro=<?= $filtro . $parametros ?>" class="float-right border-white btn btn-outline-secondary"><i class="fa text-white fa-print"></i></a>
        </h5>
    </div>
    <div class="card-body text-center">

        <form action="<?= $_SERVER['PHP_SELF'] ?>" class="form-inline justify-content-center flex-wrap">
            <p class="text-left d-block w-100 text-center">Com Vencimento Em:</p>
            <div class="input-group input-group-lg datepicker mb-2 mr-sm-2">
                <input required type="text" class="form-control" name="periodo1" id="data1" placeholder="__/__/____" value="<?= filter_has_var(INPUT_GET, 'periodo1') ? $_GET['periodo1'] : '' ?>">
                <div style="cursor: pointer;" class="input-group-append input-group-addon">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <div class="input-group input-group-lg datepicker mb-2 mr-sm-2">
                <input required type="text" class="form-control" name="periodo2" placeholder="__/__/____" value="<?= filter_has_var(INPUT_GET, 'periodo2') ? $_GET['periodo2'] : '' ?>">
                <div style="cursor: pointer;" class="input-group-append input-group-addon">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>

            <div class="w-100 mt-3">
                <button type="submit" name="filtro" class="btn btn-primary mb-2"><i class="fa fa-search"></i> BUSCAR</button>
                <?php
                if (filter_has_var(INPUT_GET, 'periodo1') ? $_GET['periodo1'] : '') {
                    ?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-danger mb-2 ml-2"><i class="fa fa-times"></i> CANCELAR</a>
					<?php
                }
                ?>
            </div>

        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="dataTable">
                <thead>
                <tr>
                    <th class="text-center">Código</th>
                    <th class="text-left">Pagamento</th>
                    <th class="text-center">Valor da Parcela</th>
                    <th class="text-center">Data do Vencimento</th>
                    <th class="text-center">Data do Pagamento</th>
                    <th class="text-center">Valor Pago</th>
                    <th class="text-center">Pago</th>
                    <th class="text-center not-ordering">Ações</th>
                </tr>
                </thead>
                <tbody>

				<?php

				if (!empty($lista)) {

					foreach ($lista as $item) {

						?>

                        <tr>

                            <td class="text-center">
								<?= $item["con_id"] ?>
                            </td>
                            <td class="text-left">

								<?php

								if (strcmp($item["con_dtPago"], $item["con_dtVencimento"]) === 0)
									echo 'Dinheiro';
								else
									echo 'Cartão';

								?>

                            </td>
                            <td class="text-center">
                                R$ <?= number_format($item["con_valor"], 2, ",", ".") ?>
                            </td>
                            <td class="text-center">
								<?= date("d/m/Y", strtotime($item["con_dtVencimento"])) ?>
                            </td>
                            <td class="text-center">
								<?= empty($item["con_dtPago"]) ? "-" : date("d/m/Y", strtotime($item["con_dtPago"])) ?>
                            </td>

                            <td class="text-center">
                                R$ <?= number_format($item["con_valorPago"], 2, ",", ".") ?>
                            </td>

                            <td class="text-center">

								<?php

								if (empty($item["con_dtPago"])) {

									?>

                                    <i class="fa fa-square-o text-danger" aria-hidden="true"></i>

									<?php

								} else {

									?>

                                    <i class="fa fa-check-square-o text-success" aria-hidden="true"></i>

									<?php

								}

								?>


                            </td>
                            <td class="text-center">

                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $item['con_id'] ?>"/>
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar Conta a Receber"
                                            name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

						<?php

					}
				} else {
					$naopagina = TRUE;

					?>

                    <tr>
                        <td class="text-center text-muted" colspan="7">Nenhuma Conta Cadastrada</td>
                    </tr>

					<?php

				}

				?>

                </tbody>
            </table>

			<?php
			if(!isset($naopagina)){
				echo $pagination;
			}
			?>

        </div>

    </div>
</div>

<?php
include 'rodape.php';
?>

