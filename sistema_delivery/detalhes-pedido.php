<?php
	$menu = "Movimentos";
	$submenu = "Pedidos realizados";
	$dataTables = TRUE;

	require_once 'topo.php';
	include_once 'classes/Saida.php';

	$saida = new Saida();
	$saida->setIdEmpresa($_SESSION['_idEmpresa']);

	if (filter_has_var(INPUT_GET, 'pedido')) {

		$id = filter_input(INPUT_GET, 'pedido', FILTER_VALIDATE_INT);

		if (!empty($id)) {

			$saida->setId($id);

			if (!empty($saida->carregarPedidoId())) {

				$todos_produtos = $saida->recuperaItens($saida->getId());

				$carregado = true;
			}

		}

	}

	if (empty($carregado)) {
		header('Location: pedidos-realizados.php');
		exit;
	}

    $str_status = 'aguardando confirmação';
    $class_status = 'alert-info';

    if (!empty($saida->getStatus())) {

        if (!empty($saida->getEntrega()['id'])) {

            if (!empty($saida->getEntrega()['status']) && intval($saida->getEntrega()['status']) === 1) {
                $str_status = 'pedido entregue';
                $class_status = 'alert-success';
            } else if (!empty($saida->getEntrega()['status']) && intval($saida->getEntrega()['status']) === 2) {
                $str_status = 'pedido não entregue';
                $class_status = 'alert-danger';
            } else {
                $str_status = 'saiu para entrega';
                $class_status = 'alert-warning';
            }

        } else {

            if(intval($saida->getStatus()) === 1) {
                $str_status = 'pedido em andamento';
                $class_status = 'alert-warning';
            } elseif(intval($saida->getStatus()) === 2) {
                $str_status = 'pedido cancelado';
                $class_status = 'alert-danger';
            }

        }

    }

?>

<div role="alert" class="alert <?= $class_status ?> text-center mb-5 d-print-none">
    <a class="alert-link" href="javascript:void(0)">Status:</a> <?= $str_status ?>
</div>

<h2 class="titulo-pagina">Detalhes do Pedido: #<?= str_pad($saida->getId(), 4, '0', STR_PAD_LEFT) ?> <a class="btn btn-outline-primary float-right d-print-none" href="javascript:window.print()"><i class="fa fa-print"></i></a></h2>

<div class="row">

	<div class="col-12 col-md-4">

		<div class="form-group text-uppercase font-weight-bold">
			<label class="text-primary" for="">Código:</label>
			<p style="font-size: 1.4em" class="text-dark"><?= str_pad($saida->getId(), 4, '0', STR_PAD_LEFT) ?></p>
		</div>

	</div>

	<div class="col-12 col-md-4">

		<div class="form-group text-uppercase font-weight-bold">
			<label class="text-primary" for="">Data:</label>
			<p style="font-size: 1.4em" class="text-dark"><?= date('d/m/Y H:i:s', strtotime($saida->getDataCriacao())) ?></p>
		</div>

	</div>

	<div class="col-12 col-md-4">

		<div class="form-group text-uppercase font-weight-bold">
			<label class="text-primary" for="">Pagamento:</label>
			<div style="font-size: 1.4em;" class="text-dark">
				<?= intval($saida->getTipoPagamento()) === 1 ? 'Dinheiro' : 'Cartão' ?>
                <?php

                    if (!empty($saida->getTroco())) {
                        ?>
                        <div class="text-danger bg-light" style="font-size: .8em;">
                        Troco para: R$ <?= number_format($saida->getTroco(), 2, ',', '.') ?>
                        </div>
                <?php
                    }

                ?>
			</div>
		</div>

	</div>

    <div class="col-12 col-md-4">
        <div class="form-group text-uppercase font-weight-bold">
            <label class="text-primary" for="">Cliente:</label>
            <p style="font-size: 1.4em;" class="text-dark">
				<?= $saida->getCliente()['nome'] ?>
            </p>
        </div>

    </div>

    <div class="col-12 col-md-4">
        <div class="form-group text-uppercase font-weight-bold">
            <label class="text-primary" for="">Celular 1:</label>
            <p style="font-size: 1.4em;" class="text-dark">
                <?= $saida->getCliente()['celular1'] ?>
            </p>
        </div>

    </div>

    <?php

        if (!empty($saida->getCliente()['celular2'])) {

            ?>

            <div class="col-12 col-md-4">
                <div class="form-group text-uppercase font-weight-bold">
                    <label class="text-primary" for="">Celular 2:</label>
                    <p style="font-size: 1.4em;" class="text-dark">
                        <?= $saida->getCliente()['celular2'] ?>
                    </p>
                </div>

            </div>

    <?php

        }

    ?>

    <div class="col-12 col-md-12">

        <div class="form-group text-uppercase font-weight-bold">
            <label class="text-primary" for="">Endereço:</label>
            <p style="font-size: 1.4em;" class="text-dark">
				<?= $saida->getEndereco()['rua'] . ', ' . $saida->getEndereco()['numero'] .' - '. $saida->getEndereco()['bairro'] .' - '. $saida->getEndereco()['cep'] ?>
            </p>
        </div>

    </div>

    <div class="col-12">

        <h4 class="titulo-pagina h2">Itens do Pedido</h4>

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th class="border-bottom bg-light">Produto</th>
                        <th class="border-bottom bg-light text-center">Qtde</th>
                        <th class="border-bottom bg-light text-center">Preço</th>
                        <th class="border-bottom bg-light text-center">SubTotal</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                    
                    if (!empty($todos_produtos)) {

						foreach ($todos_produtos as $produto) {

							$todos_complementos = $saida->recuperaComplementos($produto['id_prod_saida']);

							$total_item = filter_var(!empty($produto['prom_valor']) ? $produto['prom_valor'] : $produto['preco'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * $produto['qtde'];

							?>

                            <tr>

                                <td class="py-3">
									<?php

										echo '<span class="text-uppercase">' . utf8_encode($produto['nome']) . '</span>';

										if (!empty($todos_complementos)) {

											?>

                                            <div style="font-size: .9rem;" class="complementos ml-3">

												<?php

													foreach ($todos_complementos as $complemento) {

														?>

                                                        <p class="m-0">
                                                            - <?= utf8_encode($complemento['nome']) ?>
                                                        </p>

														<?php

													}

												?>

                                            </div>

											<?php

										}

										if (!empty($produto['obs'])) {

											echo '<span class="text-danger d-block">OBS: ' . $produto['obs'] . '</span>';

										}

									?>


                                </td>
                                <td class="text-center py-3">
									<?= $produto['qtde'] ?>
                                </td>
                                <td class="text-center py-3">
									R$ <?= number_format(!empty($produto['prom_valor']) ? $produto['prom_valor'] : $produto['preco'], 2, ',', '.') ?>

									<?php

										if (!empty($todos_complementos)) {

											?>
                                            <div style="font-size: .9rem;" class="complementos">

												<?php

													foreach ($todos_complementos as $comp) {

													    $total_item += filter_var($comp['preco'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

														?>

                                                        <p class="m-0">+R$ <?= number_format($comp['preco'], 2, ',', '.') ?></p>

														<?php
													}
												?>

                                            </div>

											<?php
										}
									?>

                                </td>
                                <td class="text-center py-3">
									<?= number_format($total_item, 2, ',', '.') ?>
                                </td>

                            </tr>

							<?php

						}

					}
                    
                ?>

                </tbody>

                <tfoot class="text-right">

                    <tr>
                        <td class="py-3 text-uppercase" colspan="4">

                            <p class="mb-1"><strong>SubTotal:</strong> <?= number_format($saida->getTotalItens(), 2, ',', '.') ?></p>
                            <p class="mb-1"><strong>Taxa Entrega:</strong> <?= number_format($saida->getTaxaEntrega(), 2, ',', '.') ?></p>
                            <?php


                                if (!empty($saida->getValorPromocao())) {

									if ($saida->getTipoDescontoPromocao() === '1') {
										$desconto = filter_var($saida->getValorPromocao(), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
										$entrega = filter_var($saida->getTaxaEntrega(), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
										$subtotal = filter_var($saida->getTotalItens(), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

										$total = $subtotal + $entrega;
										$desconto = $total * $desconto / 100;
										$valor_desconto = number_format($desconto, 2, ',', '.');


									} else
										$valor_desconto = number_format($saida->getValorPromocao(), 2, ',', '.');

                                    ?>
                                        <p class="mb-1"><strong>Desconto:</strong>  <?= $valor_desconto ?></p>
                                    <?php
                                }
                            ?>
                            <p class="mb-1"><strong>Total Geral:</strong> <?= number_format($saida->getTotalGeral(), 2, ',', '.') ?></p>

                        </td>
                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

<?php
	include 'rodape.php';
?>

