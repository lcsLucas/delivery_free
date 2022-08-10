<?php
include_once "topo.php";
include_once "sistema_delivery/classes/CarrinhoPedidos.php";

$carrinho = new CarrinhoPedidos();

if (empty($_SESSION['_carrinhoprodutos'])) {

    if (!empty($_SESSION['pagina_restaurante']))
        header('Location: '. $_SESSION['pagina_restaurante']);
    else
        header('Location: '. $baseurl . 'listar-restaurantes');
    exit;
} else {

    if (empty($_SESSION['_logado'])) {
        $_SESSION['continuar'] = true;
        $_SESSION['ultima_pagina'] = $baseurl . 'checkout-carrinho';
        header('Location: ' . $baseurl.'login');
        exit;
    } else {

        if (!empty($_SESSION['_hashcarrinho']) && !empty($_SESSION['_idrestaurante'])) {
            $carrinho->setIdEmpresa($_SESSION['_idrestaurante']);
            $carrinho->setSessao($_SESSION['_hashcarrinho']);
            $todos_produtos = $carrinho->carregarCarrinho($baseurl, true);
        }

    }

}

?>

<div class="container">

    <div id="progresso-compra">

        <div class="progresso-item active">
            <a href="<?= !empty($_SESSION['pagina_restaurante']) ? $_SESSION['pagina_restaurante']  : '' ?>">
                <span class="numero-progresso">1.</span>
                <span class="descricao-progresso">Carrinho</span>
            </a>
        </div>
        <div class="progresso-item active">

            <span class="numero-progresso">2.</span>
            <span class="descricao-progresso">Conferir</span>

        </div>
        <div class="progresso-item">

            <span class="numero-progresso">3.</span>
            <span class="descricao-progresso">Finalizar</span>

        </div>

    </div>

    <header class="mb-3">

        <h2 id="titulo-pagina" class="text-center">
            Conferir Produtos
            <hr>
        </h2>

    </header>

    <div class="table-responsive">

        <table class="table table-bordered" id="tabela-produtos-checkout">

            <thead>

                <tr>

                    <th style="width: 230px;" class="border-bottom-0 bg-light"></th>
                    <th style="width: 40%" class="border-bottom-0 bg-light font-weight-bold text-dark">Produto</th>
                    <th class="border-bottom-0 bg-light font-weight-bold text-dark text-center">Valor</th>
                    <th class="border-bottom-0 bg-light font-weight-bold text-dark text-center">Quantidade</th>
                    <th class="border-bottom-0 bg-light font-weight-bold text-dark text-center">SubTotal</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if (!empty($todos_produtos)) {

                foreach ($todos_produtos['produtos'] as $item) {

                 ?>

                    <tr class="text-muted" style="font-size: 1.2rem; font-weight: 300;">

                        <td class="text-center">
                            <img style="max-width: 130px; max-height: 100px; object-fit: contain" class="img-fluid w-100 mx-auto" src="<?= $item['foto'] ?>" alt="">
                        </td>
                        <td class="text-dark" style="font-size: 1.3rem; font-weight: 300;">
                            <?= $item['nome'] ?>

                            <?php

                            if (!empty($item['complementos'])) {

                                ?>

                                <div style="font-size: .9rem;" class="complementos ml-4">
                                    <?php

                                    foreach ($item['complementos'] as $complemento) {

                                        ?>
                                        <p class="text-muted m-0 font-weight-light">
                                            - <?= $complemento['nome'] ?>
                                        </p>
                                        <?php

                                    }

                                    ?>
                                </div>

                                <?php

                            }

                            ?>

                            <?php

                            if (!empty($item['obs'])) {

                                ?>
                                <small class="bg-light text-danger p-1 d-block">OBS: <?= $item['obs'] ?></small>
                                <?php

                            }

                            ?>

                        </td>

                        <td class="text-center">
                            R$ <?= $item['preco'] ?>

                            <?php

                            if (!empty($item['complementos'])) {

                                ?>

                                    <div style="font-size: .9rem;" class="complementos">

                                            <?php

                                            foreach ($item['complementos'] as $complemento) {

                                                ?>

                                                <p class="text-muted m-0 font-weight-light">+R$ <?= $complemento['preco'] ?></p>

                                                <?php

                                            }

                                            ?>

                                    </div>

                                <?php

                            }

                            ?>

                        </td>

                        <td class="text-center">
                            <?= $item['qtde'] ?>
                        </td>

                        <td class="text-center">
                            R$ <?= $item['subTotal'] ?>
                        </td>

                    </tr>

                    <?php

                }

            } else {

                echo '<tr><td colspan="5" class="text-center text-danger">Nenhum produto encontrado, recarregue a página</td></tr>';

                ?>

            <?php

            }

            ?>

            </tbody>

            <tfoot>

            <tr>

                <td colspan="5" class="text-right border-0 pr-0">
                    <div class="input-group input-group-lg ml-auto " style="max-width: 400px;">
                        <input <?= !empty($todos_produtos['cupom']) ? 'disabled' : '' ?> style="border-top-left-radius: 2rem;border-bottom-left-radius: 2rem;font-size: 1rem;font-weight: 300;" type="text" class="form-control text-uppercase" id="codigo-cupom" placeholder="Código do cupom" value="<?= !empty($todos_produtos['cupom']) ? $todos_produtos['cupom'] : '' ?>">
                        <div class="input-group-append">
                            <button id="aplicar-cupom" <?= !empty($todos_produtos['cupom']) ? 'disabled' : '' ?> style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem; font-size: .95rem;" class="btn <?= !empty($todos_produtos['cupom']) ? 'btn-success' : 'btn-secondary' ?>  border-0" type="button">Aplicar Cupom</button>
                        </div>
                    </div>

                    <?= !empty($todos_produtos['cupom']) ? '<a href="javascript:void(0)" id="remover-cupom">Remover cupom</a>' : '' ?>

                </td>

            </tr>

            <tr>

                <td colspan="5" class="text-right border-0">
                    <h3 style="font-size: 1.3rem; color: #2d2b2d; font-weight: bold; text-transform: uppercase" class="text-right mt-5">
                        Total do Pedido
                        <hr style="border-color: #A90E12;width: 100px;border-width: 3px; margin-left: auto; margin-right: 0;">
                    </h3>

                    <p class="lead m-0">Total dos Itens: <span class="font-weight-bold">+R$ <?= $todos_produtos['total_itens'] ?></span></p>
                    <p class="lead m-0">Taxa de entrega: <span class="font-weight-bold">+R$ <?= $todos_produtos['taxa_entrega'] ?></span></p>
                    <p class="lead m-0 <?= empty($todos_produtos['valor_desconto']) ? 'd-none' : '' ?>">Cupom Aplicado: <span class="font-weight-bold" id="valor-cupom"><?= !empty($todos_produtos['valor_desconto']) ? '-R$ ' . $todos_produtos['valor_desconto'] : '' ?></span></p>
                    <p class="lead m-0">Total Geral: <span class="font-weight-bold" id="valor-geral">R$ <?= $todos_produtos['total_geral'] ?></span></p>

                </td>

            </tr>

            </tfoot>

        </table>

    </div>

    <div class="mt-5 d-flex">

        <?php

        if (!empty($_SESSION['pagina_restaurante'])) {
            ?>
            <a class="btn bg-secondary btn-lg text-white" style="padding: 10px 50px;font-weight: normal;" href="<?= $_SESSION['pagina_restaurante'] ?>">Voltar</a>
        <?php
        }

        ?>

        <a href="<?= $baseurl ?>finalizar-pedido" style="width: 230px; letter-spacing: .04em" class="btn bg-cor-principal py-3 pr-5 pl-3 ml-auto text-white text-uppercase font-weight-bold position-relative">Continuar <i style="position: absolute;top: 50%;right: 10px;transform: translateY(-50%);" class="ml-4 fas fa-fw fa-chevron-circle-right"></i></a>
        <div class="clearfix"></div>
    </div>

</div>

<?php
include_once "rodape.php";
?>
