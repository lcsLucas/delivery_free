<?php
	$menu = "Movimentos";
	$submenu = "Pedidos Realizados";
	$dataTables = TRUE;

	require_once 'topo.php';
	include_once 'classes/Saida.php';

	$saida = new Saida();
	$saida->setIdEmpresa($_SESSION['_idEmpresa']);

	$todosPedidos = $saida->listarEmpresa();

?>

<h2 class="titulo-pagina">Pedidos Realizados <a target="_blank" href="relatorios/relatorio-pedidos-realizados.php" class="float-right btn btn-outline-primary"><i class="fa fa-print"></i></a></h2>

<div class="table-responsive">

	<table class="table table-hover border-left border-bottom border-top border-right">

		<thead>

			<tr class="bg-light">
				<th class="text-center">Nº</th>
				<th class="text-center">Hora</th>
				<th>Cliente</th>
				<th>Endereço</th>
				<th class="text-center">Valor</th>
				<th class="text-center">Status</th>
				<th></th>
			</tr>

		</thead>

		<tbody>

		<?php

			if (!empty($todosPedidos)) {

				foreach ($todosPedidos as $pedido) {
					
					?>
		
					<tr>

						<td class="text-center"><?= str_pad($pedido['idsaida'], 4, '0', STR_PAD_LEFT) ?></td>
						<td class="text-center"><?= date('H:i:s d/m/Y', strtotime($pedido['data_criacao'])) ?></td>
						<td><?= utf8_encode($pedido['cli_nome']) ?></td>
						<td><?= utf8_encode($pedido['end_rua']) .', '. $pedido['end_numero'] .'<br>'. utf8_encode($pedido['end_bairro']) . ' - ' . $pedido['end_cep'] ?></td>
						<td class="text-center">R$ <?= number_format($pedido['total_geral'], 2, ',', '.') ?></td>
						<td class="text-center">
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
						</td>
						<td>
							<a href="detalhes-pedido.php?pedido=<?= $pedido['idsaida'] ?>" class="btn btn-primary">detalhes</a>
						</td>
						
					</tr>
					
		<?php
					
				}

			} else {
				echo '<tr><td class="text-center text-muted" colspan="7">Nenhum pedido para ser listado</td></tr>';
			}

		?>

		</tbody>

	</table>

</div>

<?php
	include 'rodape.php';
?>

