<?php
$menu = "Movimentos";
$submenu = "Entrada de Produtos";
$dataTables = TRUE;
$mask = true;
$select2 = true;
$datetimepicker = true;

include_once './topo.php';
require_once "classes/FormPagto.php";
require_once "classes/Produto.php";
require_once "classes/ItemCompra.php";
require_once "classes/Entrada.php";

$lista_produtos = array();
$total = 0.0;

$entrada = new Entrada();
$entrada->setIdEmpresa($_SESSION["_idEmpresa"]);
$entrada->setTipo(1);

$id = $id_nota = $data = $id_pag = $observacao = "";
$frete = $desconto = $outros = 0.00;

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT);
        $id_nota = filter_input(INPUT_POST, "numero_nota", FILTER_VALIDATE_INT);
        $data = trim(SQLinjection(filter_input(INPUT_POST, "data", FILTER_SANITIZE_SPECIAL_CHARS)));
        $id_pag = filter_input(INPUT_POST, "pagamento", FILTER_VALIDATE_INT);
        $observacao = trim(SQLinjection(filter_input(INPUT_POST, "observacao", FILTER_SANITIZE_SPECIAL_CHARS)));
        $frete = trim(SQLinjection(filter_input(INPUT_POST, "frete", FILTER_SANITIZE_SPECIAL_CHARS)));
        $desconto = trim(SQLinjection(filter_input(INPUT_POST, "desconto", FILTER_SANITIZE_SPECIAL_CHARS)));
        $outros = trim(SQLinjection(filter_input(INPUT_POST, "outros", FILTER_SANITIZE_SPECIAL_CHARS)));
        $flag_entrada = empty(filter_has_var(INPUT_POST, "entrada")) ? false : true;

        $array_contas = array();
        if (filter_has_var(INPUT_POST, "valor_conta")) {
            $array_contas = array_filter($_POST["valor_conta"]);
            $array_contas = filter_var_array($array_contas, FILTER_VALIDATE_FLOAT);
        }

        $array_data = array();
        if (filter_has_var(INPUT_POST, "data_conta")) {
            $array_data = array_filter($_POST["data_conta"]);
            $array_data = filter_var_array($array_data, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if (empty($data) || empty($id_pag)) {
            $erroPersonalizado = true;
            $erroMensagem = "Os seguintes campos são obrigatórios: <q>Data</q>, <q>Pagamento</q>";
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $frete = str_replace(".", "", $frete);
            $frete = str_replace(",", ".", $frete);

            $desconto = str_replace(".", "", $desconto);
            $desconto = str_replace(",", ".", $desconto);

            $outros = str_replace(".", "", $outros);
            $outros = str_replace(",", ".", $outros);

            $entrada->setNumeroNota($id_nota);
            $entrada->setData(trataData($data));
            $entrada->getPagamento()->setId($id_pag);
            $entrada->setObservacao($observacao);
            $entrada->setFrete($frete);
            $entrada->setDesconto($desconto);
            $entrada->setOutros($outros);

            if (!empty($array_contas && !empty($array_data))) {

                if (count($array_contas) === count($array_data)) {

                    $entrada->setValorContas($array_contas);
                    $entrada->setDataContas($array_data);
                    $entrada->setContaEntrada($flag_entrada);

                }

            }

            if (filter_has_var(INPUT_POST, "editar")) {
                $entrada->setId($id);
                $resp = $entrada->alterar();
                if ($resp) {
                    $sucessoalterar = TRUE;
                    $id = $id_nota = $data = $id_pag = $observacao = "";
                    $frete = $desconto = $outros = 0.00;
                    unset($_SESSION["_produtosentrada"]);
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                $resp = $entrada->inserir_produtos();
                if ($resp) {
                    $sucessoinserir = TRUE;
                    $id = $id_nota = $data = $id_pag = $observacao = "";
                    $frete = $desconto = $outros = 0.00;
                    unset($_SESSION["_produtosentrada"]);
                } else {
                    $erroinserir = TRUE;
                }
            }

        }

    } else if(filter_has_var(INPUT_POST, "editar")) {
        $entrada->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

        if ($entrada->carregar()) {

            $id = $entrada->getId();
            $id_nota = !empty($entrada->getNumeroNota()) ? $entrada->getNumeroNota() : "";
            $data = trataDataInv($entrada->getData());
            $id_pag = $entrada->getPagamento()->getId();
            $observacao = $entrada->getObservacao();
            $frete = $entrada->getFrete();
            $desconto = $entrada->getDesconto();
            $outros = $entrada->getOutros();

            unset($_SESSION["_produtosentrada"]);
            $carregado = true;
        }

    } else if(filter_has_var(INPUT_POST, "deletar")) {
        $entrada->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

        if ($entrada->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    }
}

$form_pagto = new FormPagto();
$form_pagto->setIdEmpresa($_SESSION["_idEmpresa"]);
$todas_formas = $form_pagto->listar();

$produto = new Produto();
$produto->setIdEmpresa($_SESSION["_idEmpresa"]);
$todos_produtos = $produto->listar();

$item_compra = new ItemCompra();
$item_compra->setIdEmp($_SESSION["_idEmpresa"]);

/*require_once './vendor/faker/src/autoload.php';
$faker = Faker\Factory::create();
$faker->seed(5);*/

if (!empty($carregado)) {

    $lista_produtos = $entrada->recuperaProdutos();

    foreach ($lista_produtos as $i => $item) {

        $qtde = intval($item["qtdeproduto"]);
        $preco = floatval($item["precoproduto"]);

        $total += floatval($item["totalproduto"]);

        $item["nomeproduto"] = utf8_encode($item["nomeproduto"]);
        $item["qtdeproduto"] = number_format($item["qtdeproduto"], 2, ",", ".");
        $item["precoproduto"] = number_format($item["precoproduto"], 2, ",", ".");
        $item["totalproduto"] = number_format($item["totalproduto"], 2, ",", ".");

        $lista_produtos[$i] = $item;
    }

}

if (!empty($_SESSION["_produtosentrada"])) {

    foreach ($_SESSION["_produtosentrada"] as $i => $itens_session) {
        $item_compra->setId($i);

        if ($item_compra->carregaNomeProduto()) {

            $subTotal = $itens_session["qtdeproduto"] * $itens_session["precoproduto"];
            $total += $subTotal;

            $lista_produtos[] = array(
                "idproduto" => $item_compra->getId(),
                "nomeproduto" => $item_compra->getNome(),
                "qtdeproduto" => number_format($itens_session["qtdeproduto"],2,",","."),
                "precoproduto" => number_format($itens_session["precoproduto"],2,",","."),
                "totalproduto" => number_format($subTotal,2,",",".")
            );

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
$num_rows = $entrada->quantidadeRegistros2($periodo1, $periodo2);
$lista = $entrada->listarPaginacao2($periodo1, $periodo2, $offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

    <h2 class="titulo-pagina">Entrada de Produtos</h2>

<?php

include "menssagens.php";

?>

    <div class="card mb-3 <?= empty($carregado) ? "border-primary" : "border-danger" ?>">

        <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
            <i class="fa fa-shopping-cart"></i> <?= empty($carregado) ? "Cadastrar Nova Entrada de Produtos" : "Alterar Informações da Entrada Nº " . $id ?>
        </div>

        <div class="card-body">

            <form id="form-produtos" class="needs-validation" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off" novalidate>

                <div class="row">

                    <div class="col-sm-12 col-md-4">
                        <label for="nome">Número da Compra: </label>
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

                    <div class="col-sm-12 col-md-4">

                        <div class="form-group input-group-lg">
                            <label for="frete">Número da Nota:</label>
                            <input type="tel" class="form-control" id="numero_nota" name="numero_nota" value="<?= $id_nota ?>">
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="nome">Data da Compra:</label>
                        <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                            <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="data" required value="<?= !empty($data) ? $data : date("d/m/Y") ?>" >
                            <div class="input-group-append input-group-addon">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="nome">Forma de Pagamento:</label>
                        <select name="pagamento" id="pagamento" required class="form-control select2">
                            <option value="">Selecione</option>

                            <?php

                            if (!empty($todas_formas)) {
                                foreach ($todas_formas as $forma) {
                                    ?>

                                    <option <?= (intval($id_pag) === intval($forma["pag_id"])) ? "selected" : "" ?> value="<?= utf8_encode($forma["pag_id"]) ?>"><?= utf8_encode($forma["pag_nome"]) ?></option>

                                    <?php
                                }
                            }

                            ?>
                        </select>
                    </div>

                    <div class="col-sm-12">

                        <h3 style="text-transform: uppercase;font-weight: bold;font-size: 20px;margin: 40px 0;color: #007bff;border-bottom: 1px solid #007bff;">Itens da Compra</h3>

                        <form id="formAddProd" method="post" action="">

                            <div class="row">

                                <div class="col-12 col-xl-4">

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="produto">Produto:</label>
                                        <select <?= !empty($carregado) ? "disabled" : "" ?> id="sel-produto" name="produto" class="form-control select2">
                                            <option value="">Selecione</option>

                                            <?php

                                            if (!empty($todos_produtos)) {
                                                foreach($todos_produtos as $produto) {

                                                    ?>

                                                    <option data-medida="<?= $produto["uni_sigla"] ?>" value="<?= $produto["pro_id"] ?>"><?= utf8_encode($produto["pro_nome"]) ?></option>

                                                    <?php

                                                }
                                            }

                                            ?>

                                        </select>
                                        <div class="msg-erro text-danger"></div>
                                    </div>

                                </div>

                                <div class="col-12 col-md-6 col-xl-3">

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="qtde">Qtde:</label>
                                        <div class="input-group input-group-lg mb-3">
                                            <input <?= !empty($carregado) ? "disabled" : "" ?> maxlength="6" type="text" class="form-control text-center mascara-dinheiro" name="qtde" id="qtde" placeholder="0,00">

                                            <div class="input-group-append">
                                                <span class="input-group-text text-uppercase" id="sigla-uni">UN</span>
                                            </div>

                                        </div>
                                        <div class="msg-erro text-danger"></div>
                                        <p class="text-muted text-center">cálculo de qtde= 1,00 x 1 <span id="detalhe-uni" >UN</span></p>

                                    </div>

                                </div>

                                <div class="col-12 col-md-6 col-xl-3">

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="preco">Preço:</label>
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">R$</div>
                                            </div>
                                            <input <?= !empty($carregado) ? "disabled" : "" ?> type="text" maxlength="10" class="form-control text-right mascara-dinheiro" name="preco" id="preco" placeholder="0,00">
                                        </div>
                                        <div class="msg-erro text-danger"></div>
                                    </div>

                                </div>

                                <div class="col-12 col-xl-2 text-center">
                                    <label class="invisible" for="">botao adicionar</label>
                                    <div class="form-group">
                                        <a id="btn-add-produto" href="" class="btn btn-outline-primary btn-block btn-lg <?= !empty($carregado) ? "disabled" : "" ?>">Adicionar</a>
                                    </div>

                                </div>

                                <div class="col-12 mt-5">

                                    <div class="table-responsive">

                                        <table id="lista-produto" class="table" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>Produto</th>
                                                <th class="text-center">Qtde</th>
                                                <th class="text-center">Preço</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Excluir Item</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">

                                                    <p style="font-size: 20px;" class="text-muted font-weight-bold mt-4">

                                                        Total dos Itens: <span style="font-size: 30px;" class="text-success valor-itens">R$ <?= !empty($total) ? number_format($total, 2, ",",".") : "0,00" ?></span>

                                                    </p>

                                                    <strong> </strong>
                                                </td>
                                            </tr>
                                            </tfoot>
                                            <tbody>

                                            <?php

                                            if (!empty($lista_produtos)) {
                                                foreach ($lista_produtos as $item) {

                                                    ?>

                                                    <tr>
                                                        <td>
                                                            <?= $item["nomeproduto"] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?= $item["qtdeproduto"] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            R$
                                                            <?= $item["precoproduto"] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            R$ <?= $item["totalproduto"] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <a data-id="<?= empty($carregado) ? $item["idproduto"] : "" ?>" class="btn btn-danger btn-acao btn-excluir-produto <?= !empty($carregado) ? "disabled" : "" ?>"
                                                               title="Excluir Esse Item" href="">
                                                                <i class="fa fa-close" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }

                                            } else {

                                                ?>

                                                <tr>

                                                    <td colspan="6" class="text-muted text-center">Nenhum Produto Adicionado</td>

                                                </tr>

                                                <?php

                                            }

                                            ?>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="col-sm-12">

                        <h3 style="text-transform: uppercase;font-weight: bold;font-size: 20px;margin: 40px 0;color: #007bff;border-bottom: 1px solid #007bff;">Outras Informações</h3>

                    </div>

                    <div class="col-sm-12">

                        <div class="form-group">
                            <label>Observação</label>
                            <textarea class="form-control" name="observacao" style="resize: none;" rows="5"><?= $observacao ?></textarea>
                        </div>

                    </div>


                    <div class="col-sm-12 col-md-4">

                        <div class="form-group">
                            <label class="font-weight-bold" for="preco">Valor do Frete:</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">R$</div>
                                </div>
                                <input type="text" maxlength="10" class="form-control text-right mascara-dinheiro" name="frete" value="<?= number_format($frete,2,",",".") ?>" id="frete" placeholder="0,00">
                            </div>
                            <div class="msg-erro text-danger"></div>
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-4">

                        <div class="form-group">
                            <label class="font-weight-bold" for="preco">Valor de Desconto:</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">R$</div>
                                </div>
                                <input type="text" maxlength="10" class="form-control text-right mascara-dinheiro" value="<?= number_format($desconto,2,",",".") ?>" id="desconto" name="desconto" placeholder="0,00">
                            </div>
                            <div class="msg-erro text-danger"></div>
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-4">

                        <div class="form-group">
                            <label class="font-weight-bold" for="preco">Outros valores:</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">R$</div>
                                </div>
                                <input type="text" maxlength="10" class="form-control text-right mascara-dinheiro" value="<?= number_format($outros,2,",",".") ?>" id="outros" name="outros" placeholder="0,00">
                            </div>
                            <div class="msg-erro text-danger"></div>
                        </div>

                    </div>

                    <div class="form-group col-12 mt-5">
                        <div id="dados-parcelas"></div>
                        <?= (!empty($carregado)) ? "<input type=\"hidden\" name=\"editar\" /> " : "" ?>
                        <button type="submit" class="btn btn-outline-primary btn-lg pull-right gera-contas" id="btnEnviar" name="btnEnviar">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Confirmar
                        </button>
                        <a role="button" href="<?= $_SERVER["PHP_SELF"] ?>" class="btn btn-link btn-lg pull-right text-muted">
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

            <button type="button" class="btn btn-primary abre-modal-parcelas d-none" data-toggle="modal" data-target=".modal-parcelas-contas"></button>

            <!--<div data-backdrop="static" class="modal fade modal-parcelas-contas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="titulo-modal"></h5>
                            <button type="button" style="opacity: 1;" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label style="font-size: 20px;" for="data_conta">Data de vencimento:</label>
                                <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                                    <input type="text" class="form-control" placeholder="dd/mm/aaaa" id="data_conta" value="" >
                                    <div class="input-group-append input-group-addon">
                                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div class="msg-erro text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label style="font-size: 20px;" for="valor_conta">Valor da Conta:</label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input type="tel" maxlength="10" class="form-control text-right mascara-dinheiro" id="valor_conta" placeholder="0,00">
                                </div>
                                <div class="msg-erro text-danger"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="input_entrada" value="0">
                            <input type="hidden" id="input_parcela" value="1">
                            <input type="hidden" id="input_parcela_total" value="0">
                            <input type="hidden" id="input_total_itens" value="<?= number_format($total,2,".","") ?>">
                            <input type="hidden" id="input_total_geral" value="">
                            <input type="hidden" id="resto_conta" value="0">
                            <button type="button" id="btnConta" class="btn btn-primary">Prosseguir</button>
                        </div>
                    </div>
                </div>
            </div>-->

            <button type="button" class="btn btn-primary abre-modal-parcelas d-none" data-toggle="modal" data-target=".modal-parcelas-contas"></button>

            <div data-backdrop="static" class="modal fade modal-parcelas-contas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="titulo-modal"></h5>
                            <button type="button" style="opacity: 1;" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label style="font-size: 20px;" for="data_conta">Data de vencimento:</label>
                                <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                                    <input type="text" class="form-control" placeholder="dd/mm/aaaa" id="data_conta" value="" >
                                    <div class="input-group-append input-group-addon">
                                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div class="msg-erro text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label style="font-size: 20px;" for="valor_conta">Valor da Conta:</label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input type="tel" maxlength="10" class="form-control text-right mascara-dinheiro" id="valor_conta" placeholder="0,00">
                                </div>
                                <div class="msg-erro text-danger"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="input_entrada" value="0">
                            <input type="hidden" id="input_parcela" value="1">
                            <input type="hidden" id="input_parcela_total" value="0">
                            <input type="hidden" id="input_total_itens" value="<?= $total ?>">
                            <input type="hidden" id="input_total_geral" value="">
                            <input type="hidden" id="resto_conta" value="0">
                            <button type="button" id="btnConta" class="btn btn-primary">Prosseguir</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="card mb-3 border-primary">
        <div class="card-header bg-primary text-white">
            Relatório de Entradas de Produtos <a target="_blank" href="relatorios/relatorio-entradas-produtos.php?filtro=<?= $filtro . $parametros ?>" class="float-right border-white btn btn-outline-secondary"><i class="fa text-white fa-print"></i></a>
        </div>
        <div class="card-body text-center">

            <form action="<?= $_SERVER['PHP_SELF'] ?>" class="form-inline justify-content-center flex-wrap">
                <p class="text-left d-block w-100 text-center">Com Movimentação Em:</p>
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
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center">Nº da Entrada</th>
                    <th class="text-center">Data Compra</th>
                    <th class="text-center">Forma de Pagamento</th>
                    <th class="text-center">Frete</th>
                    <th class="text-center">Desconto</th>
                    <th class="text-center">Total</th>
                    <th class="text-center not-ordering">Ações</th>
                </tr>
                </thead>
                <tbody>

                <?php

                if (!empty($lista)) {
                    foreach ($lista as $item) {

                        ?>

                        <tr>

                            <td class="text-center"><?= $item["ent_id"] ?></td>
                            <td class="text-center"><?= trataDataInv($item["data"]) ?></td>
                            <td class="text-center"><?= utf8_encode($item["pag_nome"]) ?></td>
                            <td class="text-center"> <?= number_format($item["frete"], 2, ",", ".") ?> </td>
                            <td class="text-center"> <?= number_format($item["desconto"], 2, ",", ".") ?> </td>
                            <td class="text-center"> <?= number_format($item["total"], 2, ",", ".") ?> </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $item['ent_id'] ?>" />
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar Entrada" name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Entrada">
                                        <i class="fa fa-times" aria-hidden="true"></i>
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
                        <td class="text-center text-muted" colspan="7">Nenhuma Entrada Cadastrada</td>
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

<?php include_once './rodape.php'; ?>