<?php

include_once "topo.php";
include_once 'sistema_delivery/classes/Empresa.php';
include_once 'sistema_delivery/classes/CategoriaCozinhas.php';
include_once 'sistema_delivery/classes/CarrinhoPedidos.php';
include_once 'sistema_delivery/classes/Avaliacoes.php';

$todos_produtos = array();
$restaurante = new Empresa();
$categoria_cozinha = new CategoriaCozinhas();
$carrinho = new CarrinhoPedidos();
$avaliacao = new Avaliacoes();

$alert_zebra = true;

///////////////////////////////////////////////////////////////////////////////////////////
// Tratamento da URL enviada por Requisição
$url = $_SERVER['REQUEST_URI'];

$url = $url = trim($url,'/');
if (!empty($uri))
    $url = trim(substr($url, strlen($valor_uri)),"/");

if (!empty($url)) {

    $partes_url = explode('/', $url);

    $id = filter_var($partes_url[$POS_URI_ID], FILTER_VALIDATE_INT);

    if (!empty($id)) {

        $restaurante->setId($id);

        if ($restaurante->carregar2()) {

            if (!empty($_SESSION['_idrestaurante']) && !empty($_SESSION['_carrinhoprodutos']) && $_SESSION['_idrestaurante'] !== $restaurante->getId()) {

                if (!empty($_SESSION['_cupomaplicado']))
                    unset($_SESSION['_cupomaplicado']);

                unset($_SESSION['_carrinhoprodutos'], $_SESSION['_hashcarrinho']);
                setcookie("_hashcarrinho", "", time() - 36000, "/", "", 0, 1);
            }

            $_SESSION['_idrestaurante'] = $id;
            $_SESSION['pagina_restaurante'] = $baseurl . trim(str_replace($valor_uri, '', $_SERVER['REQUEST_URI']), '/');
			$_SESSION['continuar'] = true;
            $carrinho->setIdEmpresa($id);
            $avaliacao->setIdEmpresa($id);

            $todas_categorias = $restaurante->listarCategoriasProdutos();
            $todas_avaliacoes = $avaliacao->recuperarAvaliacoesRespondidas();
            $carregado = true;
        }

    }

}

if (empty($carregado))
    header('Location:' . $baseurl. 'restaurantes');
else {

    if (!empty($_SESSION['_hashcarrinho'])) {
        $carrinho->setSessao($_SESSION['_hashcarrinho']);
        $todos_produtos = $carrinho->carregarCarrinho($baseurl);
    }

}

$steps = true;
/*
unset($_SESSION['_carrinhoprodutos'], $_SESSION['_hashcarrinho']);
setcookie("_hashcarrinho", "", time() - 36000, "/", "", 0, 1);
*/
?>

<div class="d-none" id="load-produto">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>

    <div id="restaurante" class="container">

        <div id="topo-restaurante">

            <div class="media">
                <div class="wrapper-img float-left">
                    <img class="img-fluid w-100" src="<?= $baseurl ?>img/restaurantes/logos/<?= $restaurante->getNomeLogo() ?>" alt="">
                </div>
                <div class="media-body">
                    <div style="color: #666;" class="conteudo-restaurante">
                        <h3 class="titulo-restaurante m-0"><?= $restaurante->getNome() ?></h3>

                        <div class="ranting">
							<?php

							$avaliacao = $restaurante->getAvaliacoes();

							$avaliacao = intval($avaliacao['media']);
							$total_avaliacoes = intval($avaliacao['total']);

							for ($i = 1; $i <= 5; $i++) {

								if ($i <= intval($avaliacao)) {
									?>
                                    <i class="fas fa-star"></i>
									<?php
								} else {
									?>
                                    <i class="far fa-star"></i>
									<?php
								}

							}

							if ($total_avaliacoes < 5)
								echo '<span class="badge bg-success bg-cor-principal text-white ml-2">Novo</span>';

							?>
                        </div>

                        <div class="my-2 info-restaurante">

                            <p class="m-0 float-left mr-3"><i class="fas fa-fw fa-utensils m-0"></i> <?= $restaurante->getCategoriasEmpresa() ?></p>
                            <p class="m-0"><i class="fas fa-fw fa-clock m-0"></i> <?= $restaurante->getTempoEspera1() ?>min ~ <?= $restaurante->getTempoEspera2() ?>min</p>
							<?php

							if (!empty($restaurante->getFone1()) || !empty($restaurante->getFone2())) {
								?>
                                <p class="m-0 mt-1"><i class="fas fa-fw fa-phone fa-flip-horizontal m-0"></i> <?= $restaurante->getFone1() ?> <?= !empty($restaurante->getFone2()) ? '| ' . $restaurante->getFone2() : '' ?></p>
								<?php
							}

							?>
                            <p class="m-0 mt-1"><i class="fas fa-map-marker-alt m-0"></i> <?= $restaurante->getEndereco()->getRua() . ', ' . $restaurante->getEndereco()->getNumero() . ' - ' . $restaurante->getEndereco()->getCidade()->getNome() ?></p>

                        </div>

                        <p>
							<?= $restaurante->getDescricao() ?>
                        </p>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>

        </div>

        <div id="conteudo-restaurante">

            <ul class="nav nav-tabs" id="opcoes-restaurante" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Cardápio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Avaliações</a>
                </li>

            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <div class="row">

                        <div class="col-12 col-md-8">

                            <div class="accordion" id="accordionCategoria">

                                <?php

                                if (!empty($todas_categorias)) {

                                    foreach ($todas_categorias as $categoria) {
                                        $categoria_cozinha->setId($categoria['cat_id']);
                                        $produtos_cat = $categoria_cozinha->listar_produtos();

                                        ?>

                                        <div class="card">

                                            <div class="card-header">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link d-flex align-items-center" type="button" data-toggle="collapse" data-target="#cat-<?= $categoria['cat_id'] ?>" aria-expanded="true" aria-controls="cat-<?= $categoria['cat_id'] ?>">
                                                        <?= utf8_encode($categoria['cat_nome']) ?> <i class="fa fa-chevron-down d-flex"></i>
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="cat-<?= $categoria['cat_id'] ?>" class="collapse show">

                                                <div class="card-body">

                                                    <?php

                                                    if (!empty($produtos_cat)) {

                                                        foreach ($produtos_cat as $prod) {

                                                            ?>

                                                            <a class="link-produto" href="javascript:void(0)">

                                                                <div class="wrapper-produto">

                                                                    <div class="wrapper-img">

                                                                        <input type="hidden" name="pro_id" value="<?= $prod['pro_id'] ?>">
                                                                        <input type="hidden" name="pro_nome" value="<?= utf8_encode($prod['pro_nome']) ?>">
                                                                        <input type="hidden" name="pro_valor" value="<?= (!empty($prod['valor_promocao'])) ? $prod['valor_promocao'] : $prod['pro_valor'] ?>">
                                                                        <img class="img-fluid w-100" src="<?= $baseurl ?>img/restaurantes/produtos/thumbs/<?= $prod['pro_foto'] ?>" alt="">

                                                                    </div>

                                                                    <div class="wrapper-descricao">

                                                                        <h4 class="titulo-produto"><?= utf8_encode($prod['pro_nome']) ?></h4>

                                                                        <p>
                                                                            <?= utf8_encode($prod['pro_descricao']) ?>
                                                                        </p>

                                                                    </div>

                                                                    <div class="wrapper-informacoes">

                                                                        <?php

                                                                        if (!empty($prod['valor_promocao'])) {
                                                                            ?>

                                                                            <del>
                                                                                R$ <?= number_format($prod['pro_valor'], 2, ',', '.') ?>
                                                                            </del>

                                                                            R$ <?= number_format($prod['valor_promocao'], 2, ',', '.') ?>

                                                                            <?php
                                                                        } else {
                                                                            ?>

                                                                            R$ <?= number_format($prod['pro_valor'], 2, ',', '.') ?>

                                                                            <?php
                                                                        }

                                                                        ?>



                                                                        <span class="add-produto">
                                                                            Adicionar

                                                                            <i class="fa fa-plus-circle"></i>

                                                                        </span>
                                                                    </div>

                                                                </div>

                                                            </a>

                                                            <?php

                                                        }

                                                    } else {
                                                        ?>
                                                            <p class="my-3 text-muted text-center">Nenhum produto para ser listado</p>
                                                        <?php
                                                    }

                                                    ?>

                                                </div>

                                            </div>

                                        </div>

                                <?php

                                    }

                                }

                                ?>

                            </div>

                        </div>

                        <div class="col-12 col-md-4 position-relative">

                            <div id="carrinho" class="card border-0">

                                <div class="card-header bg-cor-principal text-center">

                                    <i class="fa fa-shopping-cart"></i>

                                    Carrinho

                                </div>

                                <div class="card-body border border-top-0 p-0">

                                    <?php

                                    if (empty($todos_produtos)) {
                                        ?>

                                        <div id="vazio">
                                            <img src="<?= $baseurl ?>img/carrinho-vazio.svg" alt="">
                                            Seu carrinho está vazio
                                        </div>

                                    <?php
                                    } else {

                                        foreach ($todos_produtos['produtos'] as $carrinho) {

                                            ?>

                                            <div class="carrinho-item d-flex py-4 d-flex align-items-center justify-content-center px-2 flex-row flex-nowrap border-bottom">
                                                <div class="informacoes d-flex flex-row flex-wrap">
                                                    <span class="d-inline-block font-weight-light pr-3 item-qtde"><?= str_pad($carrinho['qtde'],2, '0', STR_PAD_LEFT) ?></span>
                                                    <span class="d-inline-block font-weight-bold item-nome"><?= $carrinho['nome'] ?></span>
                                                    <span class="d-inline-block font-weight-bold item-preco text-right">R$ <?= $carrinho['preco'] ?></span>

                                                    <?php

                                                    if (!empty($carrinho['complementos'])) {
                                                        ?>
                                                        <div class="complementos ml-5 w-100 clearfix pr-3">

                                                            <?php

                                                            foreach ($carrinho['complementos'] as $complemento) {

                                                                ?>
                                                                <p class="text-muted m-0 font-weight-light">
                                                                    - <?= $complemento['nome'] ?>
                                                                    <?php

                                                                    if ($complemento['preco'] !== '0,00') {
                                                                        ?>
                                                                        <span class="float-right">+R$ <?= $complemento['preco'] ?></span>
                                                                        <?php
                                                                    }

                                                                    ?>
                                                                </p>
                                                                <?php

                                                            }

                                                            ?>

                                                        </div>
                                                        <?php
                                                    }

                                                    ?>

                                                </div>

                                                <div class="d-flex align-items-center justify-content-center editar-item flex-column">
                                                    <a class="btn btn-outline-primary border-0 btn-sm editar-produto" href="javascript:void(0)">
                                                        <i class="fas fa-pen d-inline-block "></i>
                                                    </a>
                                                    <a class="btn btn-outline-danger border-0 btn-sm excluir-produto" href="javascript:void(0)">
                                                        <i class="fa fa-times d-inline-block "></i>
                                                    </a>
                                                    <input type="hidden" name="id_item_carrinho" value="<?= $carrinho['iditem'] ?>">
                                                    <input type="hidden" name="id_produto" value="<?= $carrinho['idproduto'] ?>">
                                                    <input type="hidden" name="nome_produto" value="<?= $carrinho['nome'] ?>">
                                                    <input type="hidden" name="preco_produto" value="<?= $carrinho['preco'] ?>">
                                                    <input type="hidden" name="obs_produto" value="<?= $carrinho['obs'] ?>">
                                                    <input type="hidden" name="foto_produto" value="<?= $carrinho['foto'] ?>">
                                                    <input type="hidden" name="qtde_produto" value="<?= $carrinho['qtde'] ?>">
                                                </div>

                                            </div>

                                            <?php
                                        }

                                    }

                                    ?>

                                </div>

                                <div class="card-footer border border-top-0 py-3 <?= !empty($todos_produtos) ? '' : 'd-none' ?>">

                                    <p class="font-weight-bold mb-1 text-dark clearfix mt-3">Total dos Itens: <span class="float-right" id="total-itens">+R$ <?= !empty($todos_produtos['total_itens']) ? $todos_produtos['total_itens'] : '0,00' ?></span></p>
                                    <p class="font-weight-bold mb-1 text-dark clearfix">Taxa de Entrega: <span class="float-right" id="taxa-entrega">+R$ <?= !empty($todos_produtos['taxa_entrega']) ? $todos_produtos['taxa_entrega'] : '0,00' ?></span></p>
                                    <p class="font-weight-bold mb-1 text-dark clearfix mb-4">Total Geral: <span class="float-right" id="total-geral">R$ <?= !empty($todos_produtos['total_geral']) ? $todos_produtos['total_geral'] : '0,00' ?></span></p>
                                    <a href="<?= $baseurl ?>checkout-carrinho" class="btn py-3 text-white btn-block text-uppercase font-weight-bold position-relative">Confirmar pedido <i class="fa fa-chevron-circle-right"></i></a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <?php

                        if (!empty($todas_avaliacoes)) {

                            foreach ($todas_avaliacoes as $ava) {

                                ?>

                                <div class="card mb-4 avaliacao-restaurante">

                                    <div class="card-body">

                                        <div class="header">

                                            <h4 class="text-uppercase font-weight-bold mb-1">
												<?= utf8_encode($ava['cli_nome']) ?>

                                                <span class="float-right text-muted">

                                                    <?php

                                                    for ($i = 1; $i <= 5; $i++) {

                                                        if ($i <= intval($ava['classificacao'])) {
                                                            ?>
                                                            <i class="fas fa-star"></i>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <i class="far fa-star"></i>
                                                            <?php
                                                        }

                                                    }
                                                    echo '<span class="text-dark"> ' . $ava['classificacao'] . '</span>';
                                                    ?>

                                                </span>
                                            </h4>

                                            <h5 class="text-muted lead data-avaliacao">
												<?= date('d/m/Y H:i:s', strtotime($ava['data_criacao'])) ?>
                                            </h5>

                                        </div>

                                        <div class="body">
                                            <p class="m-0"><?= utf8_encode($ava['obs']) ?></p>
                                            <hr>

                                            <h4 class="text-uppercase font-weight-bold mb-1">Resposta do restaurante</h4>
                                            <h5 class="text-muted lead data-avaliacao">
												<?= date('d/m/Y H:i:s', strtotime($ava['data_resposta'])) ?>
                                            </h5>

                                            <p class="m-0"><?= utf8_encode($ava['resposta']) ?></p>

                                        </div>

                                    </div>

                                </div>

                    <?php

                            }

                        }

                    ?>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="modalSelecaoProduto" tabindex="-1" role="dialog" aria-labelledby="modalSelecaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">

                <form action="" method="post" id="formAddProduto">

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-uppercase"></h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">

                        <div class="container-fluid my-2">

                            <div class="bg-light p-3">

                                <div class="row">

                                    <div class="col-8 bg-light">
                                        <div id="steps-complementos"></div>
                                    </div>

                                    <div class="col-4">

                                        <img style="border-radius: 5px" src="" class="img-fluid d-block w-100" alt="">

                                    </div>

                                </div>

                            </div>

                            <label class="error"></label>

                        </div>

                    </div>
                    <div class="modal-footer align-items-end flex-wrap border-0">

                        <div class="form-group form-group-sm-sm w-100">
                            <label class="text-muted" for="obs">Observação:</label>
                            <input type="text" class="form-control form-control-sm border-top-0 border-left-0 border-right-0" id="obs" style="border-radius: 0" name="obs">
                        </div>

                        <div class="form-group m-0 mr-auto">
                            <label class="text-muted" for="qtde">Quantidade:</label>

                            <div class="input-group number-spinner">
                                <span class="input-group-btn">
                                    <button type="button" style="width: 40px; height: 38px; border-radius: 0" class="btn btn-default btn-danger btn-sm btn-down">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </span>
                                <input id="qtde" name="qtde" readonly style="max-width: 60px; font-size: 1.2rem; font-weight: lighter; background: #FFF !important;" type="tel" class="form-control text-center border-0" value="1" min="1" max="999">
                                <span class="input-group-btn">
                                    <button type="button" style="width: 40px; height: 38px; border-radius: 0" class="btn btn-default btn-danger btn-sm btn-up">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group text-right m-0">
                            <button type="button" class="btn px-3 py-2 btn-light text-uppercase font-weight-bold d-none mr-3" id="voltar_comp"><i class="fas fa-chevron-left pr-3"></i> voltar</button>
                            <button type="button" class="btn px-3 py-2 text-white bg-danger text-uppercase font-weight-bold" id="prosseguir_comp">Prosseguir <i class="fas fa-chevron-right pl-3"></i></button>
                            <input type="hidden" name="produto_id" value="">
                            <input type="hidden" name="item_carrinho_id" value="">
                            <input type="hidden" name="add_produto" value="">
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

<?php

include_once "rodape.php";

?>
