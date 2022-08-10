<?php
    $menu = "Movimentos";
    $submenu = "Avaliações de Pedidos";

    require_once 'topo.php';
    include_once 'classes/Avaliacoes.php';

    $avaliacao = new Avaliacoes();
    $avaliacao->setIdEmpresa($_SESSION['_idEmpresa']);

    $array_naoresp = array();
    $array_resp = array();

    $todas_avaliacoes = $avaliacao->recuperarAvaliacoesEmpresa();

    if (!empty($todas_avaliacoes['naorespondidos']))
        $array_naoresp = $todas_avaliacoes['naorespondidos'];

    if (!empty($todas_avaliacoes['respondidos']))
        $array_resp = $todas_avaliacoes['respondidos'];

?>

<h2 class="titulo-pagina">Avaliações de Pedidos Realizados <a target="_blank" href="relatorios/relatorio-avaliacoes-pedidos.php" class="float-right btn btn-outline-primary"><i class="fa fa-print"></i></a></h2>

<?php
    include 'menssagens.php';
?>

<?php

    if (!empty($array_naoresp)) {

        foreach ($array_naoresp as $naoresp) {

            ?>

            <div class="card mb-4 avaliacao-pedido">

                <div class="card-body">

                    <div class="header">

                        <h4 class="text-uppercase font-weight-bold mb-1">
                            PEDIDO #<?= str_pad($naoresp['idsaida'], 5, '0', STR_PAD_LEFT) ?> - <?= utf8_encode($naoresp['cli_nome']) ?>
                            <span class="float-right text-muted">

                                <?php

                                    for ($i = 1; $i <= 5; $i++) {

                                        if ($i <= intval($naoresp['classificacao'])) {
                                            ?>
                                            <i class="fa fa-star"></i>
                                            <?php
                                        } else {
                                            ?>
                                            <i class="fa fa-star-o"></i>
                                            <?php
                                        }

                                    }
                                    echo '<span class="text-dark"> ' . $naoresp['classificacao'] . '</span>';
                                ?>

                            </span>
                        </h4>
                        <h5 class="text-muted lead">
                            <?= date('d/m/Y H:i:s', strtotime($naoresp['data_criacao'])) ?>
                        </h5>

                    </div>

                    <div class="body">
                        <p><?= utf8_encode($naoresp['obs']) ?></p>

                        <form method="post" class="formRespostaAvaliacao" action="">
                            <input type="hidden" value="<?= $naoresp['idavaliacoes'] ?>" name="id_avaliacao">
                            <input type="hidden" name="responder_avaliacao">
                            <div class="text-center wrapper-resposta-avaliacao">
                                <a class="btn btn-primary text-center responder-avaliacao" href=""><i class="fa fa-share fa-flip-horizontal fa-rotate-180 mr-2"></i> Responder</a>
                            </div>
                        </form>

                    </div>

                </div>

            </div>

<?php

        }

    }

    if (!empty($array_resp)) {

        foreach ($array_resp as $resp) {

            ?>

            <div class="card mb-4 avaliacao-pedido bg-light">

                <div class="card-body">

                    <div class="header">

                        <h4 class="text-uppercase font-weight-bold mb-1">
                            PEDIDO #<?= str_pad($resp['idsaida'], 5, '0', STR_PAD_LEFT) ?> - <?= utf8_encode($resp['cli_nome']) ?>
                            <span class="float-right text-muted">

                                <?php

                                    for ($i = 1; $i <= 5; $i++) {

                                        if ($i <= intval($resp['classificacao'])) {
                                            ?>
                                            <i class="fa fa-star"></i>
                                            <?php
                                        } else {
                                            ?>
                                            <i class="fa fa-star-o"></i>
                                            <?php
                                        }

                                    }
                                    echo '<span class="text-dark"> ' . $resp['classificacao'] . '</span>';
                                ?>

                            </span>
                        </h4>
                        <h5 class="text-muted lead">
                            <?= date('d/m/Y H:i:s', strtotime($resp['data_criacao'])) ?>
                        </h5>

                    </div>

                    <div class="body">
                        <p><?= utf8_encode($resp['obs']) ?></p>
                        <hr>

                        <h4 class="text-uppercase font-weight-bold mb-1">Resposta do restaurante</h4>
                        <h5 class="text-muted lead">
                            <?= date('d/m/Y H:i:s', strtotime($resp['data_resposta'])) ?>
                        </h5>

                        <p><?= utf8_encode($resp['resposta']) ?></p>

                    </div>

                </div>

            </div>

<?php

        }

    }

?>

<?php
    include 'rodape.php';
?>

