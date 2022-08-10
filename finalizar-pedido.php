<?php
include_once "topo.php";
include_once "sistema_delivery/classes/CarrinhoPedidos.php";
include_once "./sistema_delivery/classes/Cliente.php";

	if (empty($_SESSION["_idcliente"])) {
		header('Location: ' . $baseurl . 'login');
		exit;
	}

$carrinho = new CarrinhoPedidos();

$cliente = new Cliente();
$cliente->setId($_SESSION["_idcliente"]);



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

$jquery_card = true;
$mask = true;
$validation = true;
$alert_zebra = true;

$todos_endereco = $cliente->listarEnderecosSite();
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
                <a href="<?= $baseurl ?>checkout-carrinho">
                    <span class="numero-progresso">2.</span>
                    <span class="descricao-progresso">Conferir</span>
                </a>
            </div>
            <div class="progresso-item active">

                <span class="numero-progresso">3.</span>
                <span class="descricao-progresso">Finalizar</span>

            </div>

        </div>

        <header class="mb-5">

            <h2 id="titulo-pagina" class="text-center">
                Finalizar Pedido
                <hr>
            </h2>

        </header>

        <form id="form-pedido" method="post" action="">

            <div class="row">

                <div class="col-12 col-lg-8">

                    <div style="background: #F4F4F4;" class="bg-light h-100 pb-5">

                        <div class="py-5 text-center">

                            <h4 style="color: #A90E12; text-transform: uppercase; font-weight: bold; font-size: 1.5rem;" class="mb-4 text-center">Forma de Pagamento:</h4>

                            <div class="form-group">

                                <label style="display: block; margin-bottom: 10px;" for="">Escolha uma forma de pagamento:</label>
                                <div class="wrapper-check">
                                    <input required data-target="#mostrar-dinheiro" class="d-none" value="1" type="radio" name="check_pagamento" id="check-pag-dinheiro">
                                    <label for="check-pag-dinheiro">Dinheiro</label>
                                </div>

                                <div class="wrapper-check">
                                    <input required data-target="#mostrar-cartao" class="d-none" value="2" type="radio" name="check_pagamento" id="check-pag-cartao">
                                    <label for="check-pag-cartao">Cartão</label>
                                </div>

                            </div>

                        </div>

                        <div id="mostrar-dinheiro" class="form-group text-left mx-auto d-none" style="max-width: 400px;">
                            <label style="font-size: 1.25rem;" class="text-dark" for="troco">Levar troco para:</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-dark">R$</span>
                                </div>
                                <input style="box-shadow: none; font-size: 1.85rem; font-weight: bold;" maxlength="6" type="text" class="form-control text-right text-dark mascara-dinheiro" id="troco" name="troco" value="0,00">
                            </div>
                            <small class="form-text text-muted">Ex: troco para R$ 100,00</small>
                        </div>

                        <div id="mostrar-cartao" class="form-group d-none mx-auto" style="max-width: 400px;">

                            <div id="wrapper-card"></div>

                            <div class="row mt-5">

                                <div class="col-12 col-md-12">

                                    <div class="form-group">
                                        <label class="text-dark font-weight-light m-0" for="number">Número do cartão</label>
                                        <input type="tel" id="number" name="numero_cartao" class="form-control validate_card" required>
                                    </div>

                                </div>
                                <div class="col-12 col-md-12">

                                    <div class="form-group">
                                        <label class="text-dark font-weight-light m-0" for="name">Nome do titular</label>
                                        <input type="text" id="name" name="nome_titular" class="form-control text-uppercase validate_card" required>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="form-group">
                                        <label class="text-dark font-weight-light m-0" for="expiry">Validade</label>
                                        <input type="tel" id="expiry" name="validate_cartao" placeholder="__/__" maxlength="7" class="form-control validate_card" required>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="form-group">
                                        <label class="text-dark font-weight-light m-0" for="cvc">Código de segurança</label>
                                        <input type="tel" id="cvc" name="codigo_seguranca" class="form-control validate_card" required>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-12 col-lg-4" style="background: #F4F4F4;">

                    <div class="wrapper-carrinho d-flex flex-column px-4 py-0 h-100">

                        <div class="header d-flex flex-row" style="border-bottom: 2px solid #E6E6E6; padding: 30px 0 15px;">

                            <p style="width: 70%;" class="text-dark font-weight-bold m-0">Produtos</p>
                            <p style="width: 30%; text-align: right;" class="text-dark font-weight-bold m-0">Total</p>

                        </div>

                        <div style="max-height: 400px;overflow-y: auto; overflow-x: hidden" class="body d-flex flex-column">

                            <?php

                            if (!empty($todos_produtos)) {

                                foreach ($todos_produtos['produtos'] as $prod) {

                                    ?>

                                    <div class="d-flex flex-row py-3">

                                        <div style="width: 70%;" class="text-muted font-weight-normal m-0">
                                        <span class="mr-2 font-weight-bold text-dark">
                                            <span style="font-size: .7rem;">x</span><?= $prod['qtde'] ?>
                                        </span>
                                            <?= $prod['nome'] ?>

                                            <?php

                                            if (!empty($prod['complementos'])) {
                                                ?>

                                                <div style="font-size: .75rem;" class="ml-3 mt-1">

                                                    <?php

                                                    foreach ($prod['complementos'] as $comp) {

                                                        ?>

                                                        <p class="m-0">- <?= $comp['nome'] ?></p>

                                                        <?php

                                                    }

                                                    ?>
                                                </div>

                                                <?php
                                            }

                                            ?>

                                        </div>

                                        <div style="width: 30%; text-align: right;" class="text-muted font-weight-light m-0">
                                            R$ <?= $prod['preco'] ?>

                                            <?php

                                            if (!empty($prod['complementos'])) {
                                                ?>

                                                <div style="font-size: .75rem;">

                                                    <?php

                                                    foreach ($prod['complementos'] as $comp) {

                                                        ?>

                                                        <p class="m-0">+R$ <?= $comp['preco'] ?></p>

                                                        <?php

                                                    }

                                                    ?>
                                                </div>

                                                <?php
                                            }

                                            ?>


                                        </div>

                                    </div>

                                    <?php

                                }

                            }

                            ?>

                        </div>



                        <?php

                        if (!empty($todos_produtos)) {

                            ?>

                            <div class="d-flex footer flex-row flex-wrap pb-3 pt-4 mt-auto mt-auto">

                                <div style="width: 70%;" class="text-dark font-weight-bold m-0">
                                    SubTotal:
                                </div>

                                <div style="width: 30%; text-align: right;" class="text-dark font-weight-bold m-0">
                                    +R$ <?= $todos_produtos['total_itens'] ?>
                                </div>

                                <div style="width: 70%;" class="text-dark font-weight-bold m-0">
                                    Entrega:
                                </div>

                                <div style="width: 30%; text-align: right;" class="text-dark font-weight-bold m-0">
                                    +R$ <?= $todos_produtos['taxa_entrega'] ?>
                                </div>

                                <?php

                                if (!empty($todos_produtos['valor_desconto'])) {

                                    ?>

                                    <div style="width: 70%;" class="text-dark font-weight-bold m-0">
                                        Desconto:
                                    </div>

                                    <div style="width: 30%; text-align: right;" class="text-dark font-weight-bold m-0">
                                        -R$ <?= $todos_produtos['valor_desconto'] ?>
                                    </div>

                                    <?php

                                }

                                ?>

                                <div style="width: 70%;" class="text-dark font-weight-bold m-0">
                                    Total Geral:
                                </div>

                                <div style="width: 30%; text-align: right;" class="text-dark font-weight-bold m-0">
                                    R$ <?= $todos_produtos['total_geral'] ?>
                                </div>

                            </div>

                            <?php

                        }

                        ?>

                    </div>

                </div>

                <div class="col-12 mt-3">

                    <div style="background: #F4F4F4;" class="bg-light py-5 px-4">

                        <h4 style="color: #A90E12; text-transform: uppercase; font-weight: bold; font-size: 1.5rem;" class="mb-5 text-center">Informações para a entrega:</h4>

                        <div class="mb-5">

                            <p class="m-2">Endereço para a entrega:</p>

                            <div class="border p-3">

                                <?php

                                    if (!empty($todos_endereco)) {

                                        ?>


                                                <p id="endereco-selecionado" class="m-0">
                                                    <i class="fa fa-check-circle text-success mr-3"></i> <span><?= utf8_encode($todos_endereco[0]['end_rua']) . ', ' . $todos_endereco[0]['end_numero'] . ' - ' . utf8_encode($todos_endereco[0]['cid_nome'])  . ' | ' . utf8_encode($todos_endereco[0]['end_descricao']) ?></span> <a id="mostrar-enderecos" class="float-right" href="">alterar endereço</a>
                                                </p>

                                                <div class="d-none text-dark" id="wrapper-enderecos">

                                                    <h5 class="text-center text-uppercase font-weight-bold mb-3">Selecione um endereço:</h5>

                                                    <?php

                                                        foreach ($todos_endereco as $i => $endereco) {

                                                            ?>

                                                            <div class="form-check m-1">
                                                                <input required class="form-check-input" <?= ($i === 0) ? 'checked' : '' ?> type="radio" name="check_endereco" id="check-endereco<?= $i ?>" value="<?= $endereco['end_id'] ?>">
                                                                <label class="form-check-label" for="check-endereco<?= $i ?>">
                                                                    <?= substr(utf8_encode($endereco['end_descricao']), 0, 15) ?> - <?= utf8_encode($endereco['end_rua']) ?>, <?= $endereco['end_numero'] ?> - <?= utf8_encode($endereco['cid_nome']) ?>
                                                                </label>
                                                            </div>

                                                            <?php

                                                        }

                                                    ?>

                                                </div>

                                        <?php

                                    } else {

                                        ?>

                                        <p class="m-0 text-center text-muted">Nenhum endereço cadastrado,
                                            <a href="meus-enderecos/?continuar-pedido=">cadastrar novo endereço</a>
                                        </p>

                                        <?php

                                    }

                                ?>

                            </div>

                            <!--<div class="text-center mt-4">
                                <a class="btn btn-primary btn-sm" href="javascript:void(0)">Adicionar endereço</a>
                            </div>-->

                        </div>

                        <div class="text-right">
                            <button type="submit" style="width: 230px; letter-spacing: .04em" class="btn bg-cor-principal py-3 pr-5 pl-3 ml-auto text-white text-uppercase font-weight-bold position-relative">Finalizar Pedido <i style="position: absolute;top: 50%;right: 10px;transform: translateY(-50%);" class="ml-4 fas fa-fw fa-check-circle"></i></button>
                        </div>

                    </div>

                </div>

            </div>
            <input type="hidden" name="finalizar_pedido">
        </form>

    </div>

<?php
include_once "rodape.php";
?>