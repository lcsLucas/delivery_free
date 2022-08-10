<?php
    include_once "topo.php";
    include_once 'sistema_delivery/classes/Avaliacoes.php';

    $validation = true;

    if (empty($_SESSION["_idcliente"])) {
        header('Location: ' . $baseurl . 'login');
        exit;
    }

    $avaliacao = new Avaliacoes();
    $avaliacao->setCliente($_SESSION["_idcliente"]);

    $todas_avaliacoes = $avaliacao->recuperaAvaliacoes();

?>


    <div class="container my-5">

        <h2 id="titulo-pagina" class="text-center">
            Minhas Avaliações
            <hr>
        </h2>

        <div id="wrapper-avaliacoes">

            <?php

                if (!empty($todas_avaliacoes['naoavaliados'])) {
                    $array_naoavaliados = $todas_avaliacoes['naoavaliados'];

                    ?>

                    <div id="wrapper-avaliacoes-pendentes">

                        <div class="header d-flex justify-content-between">
                    <span>
                        Você tem <strong class="text-danger font-weight-bold"><?= count($array_naoavaliados) ?></strong> pedidos não avaliados
                    </span>
                            <a id="toggle-pedidos-pendentes" href="">mostrar</a>
                        </div>

                        <div class="body">

                            <?php

                                foreach ($array_naoavaliados as $i => $naoava) {

                                    ?>

                                    <div class="avaliacao-pedido">

                                        <header class="d-flex justify-content-between">
                                            <span>PEDIDO #<?= str_pad($naoava['idsaida'], 5, '0', STR_PAD_LEFT) ?> - <?= utf8_encode($naoava['emp_nome']) ?> (R$<?= number_format($naoava['total_geral'], 2, ',', '.') ?>)</span>
                                            <span><?= date('d/m/Y H:i:s', strtotime($naoava['data_criacao'])) ?></span>
                                        </header>

                                        <form method="post" class="form-avaliacao" action="">

                                            <div class="form-group m-0">

                                                <div class="avaliacao text-center d-flex justify-content-center">

                                                    <label>
                                                        <input required class="d-none" type="radio" name="avaliacao" value="1">
                                                        <i class="far fa-star"></i>
                                                    </label>

                                                    <label>
                                                        <input required class="d-none" type="radio" name="avaliacao" value="2">
                                                        <i class="far fa-star"></i>
                                                    </label>

                                                    <label>
                                                        <input required class="d-none" type="radio" name="avaliacao" value="3">
                                                        <i class="far fa-star"></i>
                                                    </label>

                                                    <label>
                                                        <input required class="d-none" type="radio" name="avaliacao" value="4">
                                                        <i class="far fa-star"></i>
                                                    </label>

                                                    <label>
                                                        <input required class="d-none" type="radio" name="avaliacao" value="5">
                                                        <i class="far fa-star"></i>
                                                    </label>

                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="obs<?= $i ?>">Observação <sup class="text-danger">*</sup>:</label>
                                                <textarea name="obs" id="obs<?= $i ?>" cols="30" maxlength="100" rows="3" required class="w-100"></textarea>
                                            </div>

                                            <div class="form-group text-right">
                                                <input type="hidden" name="id_pedido" value="<?= $naoava['idsaida'] ?>">
                                                <input type="hidden" name="avaliar_pedido" value="">
                                                <button type="submit" class="btn btn-success btn-lg px-5 text-uppercase font-weight-bold btn-avaliar">Avaliar</button>
                                            </div>

                                        </form>

                                    </div>

                                    <?php

                                }

                            ?>

                        </div>

                    </div>

                    <?php

                }

            ?>

            <hr class="mt-5">

            <div id="wrapper-todas-avaliacoes" class="mt-5">

                <?php

                    if (!empty($todas_avaliacoes['avaliados'])) {

                        $array_avaliados = $todas_avaliacoes['avaliados'];

                        foreach ($array_avaliados as $avaliados) {

                            ?>

                            <div class="avaliacao-realizada border">

                                <div class="header">

                                    <h4 class="text-uppercase font-weight-bold mb-1">
                                        PEDIDO #<?= str_pad($avaliados['idsaida'], 5, '0', STR_PAD_LEFT) ?> - <?= utf8_encode($avaliados['emp_nome']) ?>
                                        <span class="float-right text-muted">

                                            <?php

                                                for ($i = 1; $i <= 5; $i++) {

                                                    if ($i <= intval($avaliados['classificacao'])) {
                                                        ?>
                                                        <i class="fas fa-star"></i>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <i class="far fa-star"></i>
                                                        <?php
                                                    }

                                                }
                                                echo '<span class="text-dark"> ' . $avaliados['classificacao'] . '</span>';
                                            ?>

                                        </span>
                                    </h4>
                                    <h5 class="text-muted lead">
                                        <?= date('d/Y H:i:s', strtotime($avaliados['data_criacao'])) ?>
                                    </h5>

                                </div>

                                <div>
                                    <?= utf8_encode($avaliados['obs']) ?>
                                </div>

                            </div>

                            <?php

                        }

                    }

                ?>

            </div>

        </div>

    </div>


<?php
    include 'rodape.php';
?>