<?php 
    $menu = "Home";
    $submenu = "";
    include 'topo.php';
    include_once 'classes/Saida.php';
    include_once 'classes/Entrega.php';
    $mask = true;
	$multi_select = TRUE;

    if (!empty($_SESSION['_idEmpresa'])) {

        include_once 'classes/Empresa.php';

        $empresa = new Empresa();
        $empresa->setId($_SESSION['_idEmpresa']);

        $tempo1 = $tempo2 = 0;
        $frete = '';
		$array_pedidos = array();
        $array_pedidos_enviados = array();
        $array_finalizados = array();
		$id_entregador = '';

        if (filter_has_var(INPUT_POST, 'btnTempo')) {

            $tempo1 = filter_input(INPUT_POST, "tempo_1", FILTER_VALIDATE_INT);
            $tempo2 = filter_input(INPUT_POST, "tempo_2", FILTER_VALIDATE_INT);

            if (empty($tempo1) || empty($tempo2)) {
                $erroCamposVazios = true;
            } else {

                $empresa->setTempoEspera1($tempo1);
                $empresa->setTempoEspera2($tempo2);

                if (!empty($empresa->definirTempoEspera())) {
                    $sucessoPersonalizado = true;
                    $sucessoMensagem = "tempo de entrega definido com sucesso";
                } else {
                    $erroPersonalizado = true;
                    $erroMensagem = "ao definir o tempo de entrega, tente novamente";
                }

            }

        } elseif(filter_has_var( INPUT_POST, 'btnFrete')) {
            $frete = filter_input(INPUT_POST, "frete", FILTER_SANITIZE_STRING);

            if (empty($frete))
                $erroCamposVazios = true;
            else {

                $frete2 = str_replace(".","",$frete);
                $frete2 = str_replace(",",".",$frete2);

                $empresa->setFrete($frete2);

                if (!empty($empresa->definirFrete())) {
                    $sucessoPersonalizado = true;
                    $sucessoMensagem = "Preço do frete da entrega definido com sucesso";
                } else {
                    $erroPersonalizado = true;
                    $erroMensagem = "ao definir o preço do frete da entrega, tente novamente";
                }

            }

        } elseif(filter_has_var(INPUT_POST, 'rejeitar')) {
			$id_pedido = filter_input(INPUT_POST, "id_pedido", FILTER_VALIDATE_INT);

			if (!empty($id_pedido)) {

                $saida = new Saida();
                $saida->setIdEmpresa($_SESSION['_idEmpresa']);
                $saida->setId($id_pedido);
                $saida->setStatus(2);

                if ($saida->alterarStatus()) {
					$sucessoPersonalizado = true;
					$sucessoMensagem = "Pedido rejeitado com sucesso";
                } else {
					$erroPersonalizado = true;
					$erroMensagem = "ao alterar status do pedido, tente novamente";
                }

            } else {
				$erroPersonalizado = true;
				$erroMensagem = "ao rejeitar pedido, tente novamente";
            }

        } elseif(filter_has_var(INPUT_POST, 'aceitar')) {
			$id_pedido = filter_input(INPUT_POST, "id_pedido", FILTER_VALIDATE_INT);

			if (!empty($id_pedido)) {

				$saida = new Saida();
				$saida->setIdEmpresa($_SESSION['_idEmpresa']);
				$saida->setId($id_pedido);
				$saida->setStatus(1);

				if ($saida->alterarStatus()) {

					$sucessoPersonalizado = true;
					$sucessoMensagem = "Pedido direcionado para o preparo, caso queria ir ao pedido <a href='detalhes-pedido.php?pedido=". $saida->getId() ."'>clique aqui</a>";

				} else {
					$erroPersonalizado = true;
					$erroMensagem = "ao alterar status do pedido, tente novamente";
				}

			} else {
				$erroPersonalizado = true;
				$erroMensagem = "ao rejeitar pedido, tente novamente";
			}
        } elseif(filter_has_var(INPUT_POST, 'btnEntrega')) {

            $entrega = new Entrega();
            $entrega->setIdEmpresa($_SESSION['_idEmpresa']);

            $id_entregador = filter_input(INPUT_POST, 'sel_entregador', FILTER_VALIDATE_INT);

			if (filter_has_var(INPUT_POST, "sel_pedido")) {
				$array_pedidos = array_filter($_POST["sel_pedido"]);
				$array_pedidos = filter_var_array($array_pedidos, FILTER_VALIDATE_INT);
			}

			if (empty($id_entregador)) {
				$erroPersonalizado = true;
				$erroMensagem = "Você não selecionou o entregador dessa entrega";
            } elseif(empty($array_pedidos)) {
				$erroPersonalizado = true;
				$erroMensagem = "Você não informou nenhum pedido para essa entrega";
            } else {

                $entrega->setEntregador($id_entregador);
                $entrega->setPedidos($array_pedidos);

                if ($entrega->inserir()) {
                    $sucessoPersonalizado = true;
                    $sucessoMensagem = "Entrega registrada com sucesso";
                } else {
                    $erroPersonalizado = true;
                    $erroMensagem = "Não foi possível registrar a entrega";
                }

            }

        } elseif (filter_has_var(INPUT_POST, 'btnFinalizar')) {
            $entrega = new Entrega();
            $entrega->setIdEmpresa($_SESSION['_idEmpresa']);

            if (filter_has_var(INPUT_POST, "sel_pedido_enviados")) {
                $array_finalizados = array_filter($_POST["sel_pedido_enviados"]);
                $array_finalizados = filter_var_array($array_finalizados, FILTER_VALIDATE_INT);
            }


            if (!empty($array_finalizados)) {

                $entrega->setPedidos($array_finalizados);

                if ($entrega->finalizarEntregas()) {
                    $sucessoPersonalizado = true;
                    $sucessoMensagem = "Entregas Finalizadas com sucesso";
                    $array_finalizados = array();
                } else {
                    $erroPersonalizado = true;
                    $erroMensagem = "Não foi possível finalizar as entregas";
                }

            } else {
                $erroPersonalizado = true;
                $erroMensagem = "Você não selecionou nenhuma entrega para finalizar";
            }

        }

        if (!empty($empresa->recuperarTempoEsperaFrete())) {
            $tempo1 = $empresa->getTempoEspera1();
            $tempo2 = $empresa->getTempoEspera2();
            $frete  = $empresa->getFrete();
        }

        $todos_entregadores = $empresa->recuperaEntregadores();

        $pedidos_abertos = $empresa->recuperaPedidosAbertos();
        $pedidos_preparando = $empresa->recuperaPedidosPreparando();
        $pedidos_enviados = $empresa->recuperaPedidosEnviados();
    }

?>

    <div class="block-header">
        <h2 class="titulo-pagina">Dashboard</h2>
    </div>

<?php
include 'menssagens.php';
?>

<div class="d-flex justify-content-between">

    <?php

    if (!empty($empresa)) {

        ?>

        <div class="card" style="width: 60%; max-width: 650px;">
            <div class="card-header bg-primary text-white text-center">
                Tempo estimado de entrega
            </div>
            <div class="card-body py-4">

                <form id="formTempoEntrega" class="form-inline" method="post">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <input value="<?= !empty($tempo1) ? $tempo1 : '' ?>" required style="max-width: 100px;" maxlength="3" type="text" class="form-control form-control-sm text-center"  placeholder="10" name="tempo_1">
                        <div class="input-group-append">
                            <span class="input-group-text">min</span>
                        </div>
                    </div>

                    <span class="mx-3">~</span>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <input value="<?= !empty($tempo2) ? $tempo2 : '' ?>" required style="max-width: 100px;" maxlength="3" type="text" class="form-control form-control-sm text-center" placeholder="20" name="tempo_2">
                        <div class="input-group-append">
                            <span class="input-group-text">min</span>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-sm ml-auto" name="btnTempo">Confirmar</button>
                </form>

            </div>
        </div>

        <div class="card" style="width: 38%; max-width: 450px;">
            <div class="card-header bg-primary text-white text-center">
                Preço do frete para a entrega
            </div>
            <div class="card-body py-4">

                <form id="formTempoEntrega" class="form-inline" method="post">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                        </div>
                        <input value="<?= $frete ?>" required maxlength="10" type="text" class="form-control form-control-sm text-center mascara-dinheiro mx-100" name="frete">
                    </div>


                    <button type="submit" class="btn btn-primary btn-sm ml-auto" name="btnFrete">Confirmar</button>

                </form>

            </div>
        </div>

        <?php

    }

    ?>

</div>

<?php

    if (!empty(!empty($empresa))) {

        ?>

        <div class="card d-block mt-5">

            <div class="card-header bg-primary text-white">Pedidos realizados em aberto</div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr class="bg-light">

                                <th style="width: 80px;" class="text-center">Nº</th>
                                <th style="width: 250px;">Endereço</th>
                                <th style="width: 150px;" class="text-center">Horário</th>
                                <th style="width: 130px;" class="text-center">Valor</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"></th>
                                <th style="width:140px" class="text-center">Ações</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php

                            if (!empty($pedidos_abertos)) {

                                foreach ($pedidos_abertos as $pedido) {

                                    ?>

                                    <tr>

                                        <td class="text-center"><?= str_pad($pedido['idsaida'], 4, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= utf8_encode($pedido['end_rua']) .', '. $pedido['end_numero'] .'<br>'. utf8_encode($pedido['end_bairro']) . ' - ' . $pedido['end_cep'] ?></td>
                                        <td class="text-center"><?= date('H:i:s d/m/Y', strtotime($pedido['data_criacao'])) ?></td>
                                        <td class="text-center">R$ <?= number_format($pedido['total_geral'], 2, ',', '.') ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-warning">Em aberto</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="detalhes-pedido.php?pedido=<?= $pedido['idsaida'] ?>" class="btn btn-primary">detalhes</a>
                                        </td>
                                        <td class="text-center">

                                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                                <input type="hidden" name="id_pedido" value="<?= $pedido['idsaida'] ?>">
                                                <button class="btn btn-danger btn-lg rejeitar-pedido" type="submit"><i class="fa fa-close"></i></button>
                                                <button class="btn btn-success btn-lg" name="aceitar" type="submit"><i class="fa fa-check"></i></button>
                                            </form>

                                        </td>

                                    </tr>

                                    <?php
                                }

                            } else {
                                ?>
                                <tr>
                                    <td class="text-center text-muted" colspan="7">Nenhum pedido feito ultimamente</td>
                                </tr>
                        <?php
                            }

                        ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <form id="formEntrega" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <div class="card d-block mt-5">

                <div class="card-header bg-primary text-white">Relizar nova entrega de pedidos</div>

                <div class="card-body">

					<?php

						if (!empty($pedidos_preparando)) {

							?>

                            <div class="form-group">

                                <label for="sel-entregador">Selecione o Entregador <sup class="text-danger">*</sup>:</label>

                                <select required name="sel_entregador" id="sel-entregador" class="form-control">
                                    <option value="">Selecione</option>
									<?php

										if (!empty($todos_entregadores)) {

											foreach ($todos_entregadores as $ent) {

												?>

                                                <option <?= intval($id_entregador) === intval($ent['ent_id']) ? 'selected' : '' ?> value="<?= $ent['ent_id'] ?>"><?= utf8_encode($ent['ent_nome']) ?></option>
												<?php

											}

										}

									?>

                                </select>

                            </div>

                            <div class="form-group">

                                <label for="sel-pedido" class="text-center d-block mt-5 text-uppercase">Selecione os pedidos <sup class="text-danger">*</sup>: </label>

                                <select required id="sel-pedido" name="sel_pedido[]" class="ms" multiple="multiple">

									<?php

										foreach ($pedidos_preparando as $ped) {

										    $selected = in_array(intval($ped['idsaida']), $array_pedidos);

											?>

                                            <option <?= !empty($selected) ? 'selected' : '' ?> value="<?= $ped['idsaida'] ?>">
                                                #<?= str_pad($ped['idsaida'], 4, '0', STR_PAD_LEFT) ?> | <?= date('H:i:s d/m/Y', strtotime($ped['data_criacao'])) ?>
												<?= utf8_encode($ped['end_rua']) .', '. $ped['end_numero'] .' - '. utf8_encode($ped['end_bairro']) . ' - ' . $ped['end_cep'] ?>
                                            </option>

											<?php

										}

									?>

                                </select>

                            </div>

                            <button type="submit" name="btnEntrega" class="btn btn-outline-primary btn-lg float-right"><i class="fa fa-check"></i> Confirmar</button>

                            <div class="clearfix"></div>

							<?php

						} else {
							?>

                            <p class="text-center text-muted m-0">Nenhum pedido sendo preparado para ser listado</p>

							<?php
						}

					?>

                </div>

            </div>

        </form>

        <form id="formEntregaFinalizada" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <div class="card d-block mt-5">

                <div class="card-header bg-primary text-white">Finalizar entrega de pedidos</div>

                <div class="card-body">

                    <?php

                        if (!empty($pedidos_enviados)) {
                            ?>

                            <div class="form-group">

                                <label for="sel-pedido-enviados" class="text-center d-block mt-5 text-uppercase">Selecione as entregas <sup class="text-danger">*</sup>: </label>

                                <select required id="sel-pedido-enviados" name="sel_pedido_enviados[]" class="ms" multiple="multiple">

                                    <?php

                                        foreach ($pedidos_enviados as $ped) {

                                            $selected = in_array(intval($ped['id']), $array_finalizados);

                                            ?>

                                            <option title="<?= $ped['enderecos'] ?>" <?= !empty($selected) ? 'selected' : '' ?> value="<?= $ped['id'] ?>">
                                                #<?= str_pad($ped['id'], 4, '0', STR_PAD_LEFT) ?> | <?= $ped['entregador'] ?> | <?= date('H:i:s d/m/Y', strtotime($ped['data'])) ?>
                                            </option>

                                            <?php

                                        }

                                    ?>

                                </select>

                            </div>

                            <button type="submit" name="btnFinalizar" class="btn btn-outline-primary btn-lg float-right"><i class="fa fa-check"></i> Confirmar</button>

                            <div class="clearfix"></div>

                            <?php

                        } else {
                            ?>

                            <p class="text-center text-muted m-0">Nenhuma entrega em andamento para finalizar</p>

                            <?php
                        }

                    ?>

                </div>

            </div>

        </form>

		<?php

	}

?>

<?php 
    include 'rodape.php';
?>
