<?php
	include_once "topo.php";
	include_once 'sistema_delivery/classes/Saida.php';

	if (empty($_SESSION["_idcliente"])) {
		header('Location: ' . $baseurl . 'login');
		exit;
	}

	$saida = new Saida();
	$saida->setCliente($_SESSION["_idcliente"]);

	$todos_pedidos = $saida->carregarPedidoCliente();

?>

<div class="container my-5">

	<h2 id="titulo-pagina" class="text-center">
		Pedidos realizados
		<hr>
	</h2>

    <div id="wrapper-pedidos">

		<?php

			if (!empty($todos_pedidos)) {

				foreach ($todos_pedidos as $pedido) {

				    $todos_produtos = $saida->recuperaItens($pedido['idsaida']);
					?>

                    <div class="pedido border my-4">

                        <div class="head bg-light p-3 text-muted font-weight-bold text-uppercase">
                            Pedido #<?= str_pad($pedido['idsaida'], 5, '0', STR_PAD_LEFT) ?> -
                            <?= utf8_encode($pedido['emp_nome']) ?>

                            <div class="float-right text-lowercase">

								<?php

                                    $str_status = 'aguardando';
                                    $class_status = 'badge-info';

                                    if (!empty($pedido['entrega_id'])) {

                                        if (!empty($pedido['ent_status']) && intval($pedido['ent_status']) === 1) {
                                            $str_status = 'pedido entregue';
                                            $class_status = 'badge-success';
                                        } else if (!empty($pedido['ent_status']) && intval($pedido['ent_status']) === 2) {
                                            $str_status = 'pedido não entregue';
                                            $class_status = 'badge-danger';
                                        } else {
                                            $str_status = 'saiu para entrega';
                                            $class_status = 'badge-warning';
                                        }

                                    } else {

                                        if(intval($pedido['status']) === 1) {
                                            $str_status = 'pedido em andamento';
                                            $class_status = 'badge-warning';
                                        } elseif(intval($pedido['status']) === 2) {
                                            $str_status = 'pedido cancelado';
                                            $class_status = 'badge-danger';
                                        }

                                    }

								?>

                                <span class="badge <?= $class_status ?>"><?= $str_status ?></span>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="body py-0 px-3">

                            <?php

                                if (!empty($todos_produtos)) {

                                    foreach ($todos_produtos as $produto) {

                                        $todos_complementos = $saida->recuperaComplementos($produto['id_prod_saida']);

                                        ?>

                                        <div class="produto clearfix border-bottom py-3 m-0">
                                            <?= utf8_encode($produto['nome']) ?> <span class="float-right">R$ <?= number_format(!empty($produto['prom_valor']) ? $produto['prom_valor'] : $produto['preco'], 2, ',', '.') ?> <span class="font-weight-light mx-2" style="font-size: .85rem;">x</span> <?= str_pad($produto['qtde'], 2, '0', STR_PAD_LEFT) ?></span>

                                            <?php

                                                if (!empty($todos_complementos)) {

													?>
                                                    <div class="pl-4 complementos text-muted font-weight-light">

														<?php

															foreach ($todos_complementos as $complemento) {

																?>

                                                                <p class="m-0">
                                                                    - <?= utf8_encode($complemento['nome']) ?> <span
                                                                            class="float-right">+R$ <?= number_format($complemento['preco'], 2, ',', '.') ?></span>
                                                                </p>

																<?php

															}

														?>

                                                    </div>
													<?php

												}

                                            ?>

                                        </div>

                            <?php

                                    }

                                } else {
                                    echo '<p class="lead text-center m-0 text-muted">Não foi possível carregar os produtos desse pedido, recarregue a página para tentar novamente</p>';
                                }

                            ?>

                        </div>

                        <div class="footer p-3 d-flex justify-content-between align-items-center">

                            <div>

                                <div class="mb-2 font-weight-bold text-uppercase">
                                    <span class="fa-stack">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas <?= $pedido['tipo_pagamento'] === '1' ? 'fa-dollar-sign' : 'fa-credit-card' ?> fa-stack-1x fa-inverse"></i>
                                    </span>
                                    Pagamento: <?= $pedido['tipo_pagamento'] === '1' ? 'Dinheiro' : 'Cartão' ?>
                                </div>

                                <div class="mt-2 font-weight-bold text-uppercase">
                                    <span class="fa-stack">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="far fa-clock fa-stack-1x fa-inverse"></i>
                                    </span>
                                    Data: <?= date('d/m/Y H:i', strtotime($pedido['data_criacao'])) ?>
                                </div>

                            </div>

                            <div class="text-right text-uppercase">

                                <p class="text-dark font-weight-bold m-0">SubTotal: <span class="ml-2 font-weight-normal">+R$ <?= number_format($pedido['total_itens'], 2, ',', '.') ?></span></p>
                                <p class="text-dark font-weight-bold m-0">Entrega: <span class="ml-2 font-weight-normal">+R$ <?= number_format($pedido['taxa_entrega'], 2, ',', '.') ?></span></p>
                                <?php

                                    if (!empty($pedido['promocao_valor'])) {

                                        if ($pedido['promocao_tipo_desconto'] === '1') {
											$desconto = filter_var($pedido['promocao_valor'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
											$entrega = filter_var($pedido['taxa_entrega'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
											$subtotal = filter_var($pedido['total_itens'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

											$total = $subtotal + $entrega;
											$desconto = $total * $desconto / 100;
											$valor_desconto = number_format($desconto, 2, ',', '.');


                                        } else
                                            $valor_desconto = number_format($pedido['promocao_valor'], 2, ',', '.');
                                        ?>
                                        <p class="text-dark font-weight-bold m-0">Desconto: <span class="ml-2 font-weight-normal">-R$ <?= $valor_desconto  ?></span></p>
										<?php
                                    }

                                ?>
                                <p class="text-dark font-weight-bold m-0">Total Geral: <span class="ml-2 font-weight-normal">R$ <?= number_format($pedido['total_geral'], 2, ',', '.') ?></span></p>

                            </div>

                        </div>

                    </div>

					<?php

				}

			} else {

			    ?>

                <p class="m-0 my-5 text-muted font-weight-light lead text-center">Você não fez nenhum pedido ainda :(</p>

        <?php

			}

		?>

    </div>

</div>

<?php
	include_once "rodape.php";
?>
