<?php

$menu = "Promoções";
$submenu = "Gerenciar Cupons Promocionais";
$mask = true;
$dataTables = true;
$datetimepicker = true;

$id = $codigo_promocional = $nome = $valor_desconto = $data_final = $data_inicial = "";

include_once './topo.php';
include_once 'classes/Promocao.php';

$promocao = new Promocao();
$promocao->setIdEmpresa($_SESSION["_idEmpresa"]);
$promocao->setTipo(0); //0 = promoção de cupons

$id = $nome = $codigo_promocional = $data_inicial = $data_final = $tipo_desconto = $valor_desconto = $porcentagem_desconto = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) { // enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT);
        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        $codigo_promocional = trim(filter_input(INPUT_POST, "codigo_promocional", FILTER_SANITIZE_SPECIAL_CHARS));
        $data_inicial = trim(SQLinjection(filter_input(INPUT_POST, "data_inicial", FILTER_SANITIZE_SPECIAL_CHARS)));
        $data_final = trim(SQLinjection(filter_input(INPUT_POST, "data_final", FILTER_SANITIZE_SPECIAL_CHARS)));
        $tipo_desconto = filter_input(INPUT_POST, "tpDesconto", FILTER_VALIDATE_INT);
        $valor_desconto = trim(SQLinjection(filter_input(INPUT_POST, "valor_desconto", FILTER_SANITIZE_SPECIAL_CHARS)));
        $porcentagem_desconto = trim(SQLinjection(filter_input(INPUT_POST, "porcentagem_desconto", FILTER_SANITIZE_SPECIAL_CHARS)));

        if (empty($nome) || empty($codigo_promocional) || empty($data_inicial) || empty($data_final) || ($tipo_desconto !== 1 && $tipo_desconto !== 2)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {

            $valor_desconto2 = str_replace(".", "", $valor_desconto);
            $valor_desconto2 = str_replace(",", ".", $valor_desconto2);

            $porcentagem_desconto2 = str_replace(".", "", $porcentagem_desconto);
            $porcentagem_desconto2 = str_replace(",", ".", $porcentagem_desconto2);

            $promocao->setNome($nome);
            $promocao->setCupom($codigo_promocional);
            $promocao->setDataInicial($data_inicial);
            $promocao->setDataFinal($data_final);
            $promocao->setTipoDesconto($tipo_desconto);

            if ($tipo_desconto === 1)
                $promocao->setDescontoPorcentagem($porcentagem_desconto2);
            else if ($tipo_desconto === 2)
                $promocao->setDescontoValor($valor_desconto2);

            if (!empty($porcentagem_desconto2) && $porcentagem_desconto2 > 60) {
                $erroPersonalizado = true;
                $erroMensagem = "Porcentagem maior que 60%";
                $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
            } else {

                if (filter_has_var(INPUT_POST, "editar")) {
                    $promocao->setId($id);
                    $resp = $promocao->alterar();
                    if ($resp) {
                        $sucessoalterar = TRUE;
                        $id = $nome = $codigo_promocional = $data_inicial = $data_final = $tipo_desconto = $valor_desconto = $porcentagem_desconto = "";
                    } else {
                        $erroalterar = TRUE;
                        $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                    }
                } else {
                    $resp = $promocao->inserir();

                    if ($resp) {
                        $sucessoinserir = TRUE;
                        $id = $nome = $codigo_promocional = $data_inicial = $data_final = $tipo_desconto = $valor_desconto = $porcentagem_desconto = "";
                    } else {
                        $erroinserir = TRUE;
                    }
                }
            }
        }
    } else if (filter_has_var(INPUT_POST, "editar")) {
        $promocao->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

        if ($promocao->carregar()) {
            $id = $promocao->getId();
            $nome = $promocao->getNome();
            $codigo_promocional = $promocao->getCupom();
            $data_inicial = $promocao->getDataInicial();
            $data_final = $promocao->getDataFinal();
            $tipo_desconto = $promocao->getTipoDesconto();
            $valor_desconto = $promocao->getDescontoValor();
            $porcentagem_desconto = $promocao->getDescontoPorcentagem();

            $carregado = true;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $promocao->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($promocao->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status da Promoção!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status da Promoção!";
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $promocao->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

        if ($promocao->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    }
}

$periodo1 = '';
$periodo2 = '';
$filtro = "";
$parametros = "";
if (!empty($_GET['periodo1']) && !empty($_GET['periodo2'])) {

    $periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
    $periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

    $parametros = "&filtro=&periodo1=" . $periodo1 . "&periodo2=" . $periodo2;
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
$num_rows = $promocao->quantidadeRegistros3($periodo1, $periodo2);
$lista = $promocao->listarPaginacao3($periodo1, $periodo2, $offset, $entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page, $parametros);

?>

<h2 class="titulo-pagina">Gerenciar Cupons Promocionais</h2>

<?php
include "menssagens.php";
?>

<div class="card mb-3 <?= empty($carregado) ? "border-primary" : "border-danger" ?>">

    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <?= empty($carregado) ? "Cadastrar Novo Cupom Promocional" : "Alterar Cupom Promocional <q>" . $nome . "</q>" ?>
    </div>

    <div class="card-body">

        <form id="form-cupons" class="needs-validation" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off" novalidate>

            <div class="row justify-content-md-center">

                <div class="col-sm-12 col-md-6 col-lg-6">

                    <div class="form-group input-group-lg">
                        <label class="font-weight-bold" for="codigo_promocional">Código Promocional <span class="obrigatorio">*</span>:</label>
                        <input type="tel" class="form-control text-uppercase" id="codigo_promocional" name="codigo_promocional" maxlength="20" required value="<?= $codigo_promocional ?>">
                        <input type="hidden" name="acao-codigo" value="<?= $id ?>">
                        <p class="text-muted">Exemplo de código: PROMOCAODODIA</p>
                    </div>

                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">

                    <div class="form-group input-group-lg">
                        <label class="font-weight-bold" for="nome">Nome da Promoção <span class="obrigatorio">*</span>:</label>
                        <input type="tel" class="form-control text-uppercase" id="nome" name="nome" maxlength="60" required value="<?= $nome ?>">
                    </div>

                </div>

                <div class="col-sm-12 col-md-6 col-lg-5">

                    <label class="font-weight-bold">Tipo de Desconto <span class="obrigatorio">*</span>:</label>

                    <div class="form-control form-control-lg text-center">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?= (($tipo_desconto == 1) || empty($tipo_desconto)) ? "checked" : "" ?> name="tpDesconto" id="tpDesconto1" required value="1">
                            <label class="form-check-label" for="tpDesconto1">Porcentual</label>
                        </div>
                        <div class="form-check form-check-inline ml-3">
                            <input class="form-check-input" type="radio" name="tpDesconto" <?= $tipo_desconto == 2 ? "checked" : "" ?> id="tpDesconto2" required value="2">
                            <label class="form-check-label" for="tpDesconto2">Valor Fixo</label>
                        </div>

                    </div>

                </div>

                <div id="valor" class="col-sm-12 col-md-6 col-lg-5 <?= $tipo_desconto == 2 ? "" : "d-none" ?>">

                    <div class="form-group">
                        <label class="font-weight-bold" for="valor_desconto">Valor do Desconto <span class="obrigatorio">*</span>:</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <div class="input-group-text">R$</div>
                            </div>
                            <input <?= $tipo_desconto == 2 ? "" : "disabled" ?> type="tel" maxlength="10" class="form-control text-right mascara-dinheiro" name="valor_desconto" required value="<?= $valor_desconto ?>" id="valor_desconto" placeholder="0,00">
                        </div>
                    </div>

                </div>

                <div id="porcentagem" class="col-sm-12 col-md-6 col-lg-5 <?= (($tipo_desconto == 1) || empty($tipo_desconto)) ? "" : "d-none" ?>">

                    <div class="form-group">
                        <label class="font-weight-bold" for="porcentagem_desconto">Porcentagem do Desconto <span class="obrigatorio">*</span>:</label>
                        <div class="input-group input-group-lg">
                            <input <?= (($tipo_desconto == 1) || empty($tipo_desconto)) ? "" : "disabled" ?> max="100" type="tel" maxlength="6" class="form-control text-center mascara-dinheiro" name="porcentagem_desconto" required value="<?= $porcentagem_desconto ?>" id="porcentagem_desconto" placeholder="0,00">
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="w-100"></div>

                <div class="col-sm-12 col-md-6 col-lg-5">
                    <label class="font-weight-bold">Data Inicial <span class="obrigatorio">*</span>:</label>
                    <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                        <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_inicial" required value="<?= !empty($data_inicial) ? $data_inicial : date("d/m/Y") ?>">
                        <div class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-5">
                    <label class="font-weight-bold">Data Final <span class="obrigatorio">*</span>:</label>
                    <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                        <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="data_final" required value="<?= !empty($data_final) ? $data_final : date("d/m/Y") ?>">
                        <div class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12 mt-5">
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

    </div>
</div>

<div class="card mb-3 border-primary">
    <div class="card-header bg-primary text-white">
        Relatório de Cupons Promocionais <a target="_blank" href="relatorios/relatorio-promocoes-cupons.php?filtro=<?= $filtro . $parametros ?>" class="float-right border-white btn btn-outline-secondary"><i class="fa text-white fa-print"></i></a>
    </div>
    <div class="card-body text-center">

        <form action="<?= $_SERVER['PHP_SELF'] ?>" class="form-inline justify-content-center flex-wrap">
            <p class="text-left d-block w-100 text-center">No Período:</p>
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
                        <th>Nome</th>
                        <th>Código Promocional</th>
                        <th class="text-center">Data Início</th>
                        <th class="text-center">Data Final</th>
                        <th class="text-center">Ativo</th>
                        <th class="text-center not-ordering">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    if (!empty($lista)) {
                        foreach ($lista as $item) {

                    ?>

                            <tr>

                                <td><?= $item["pro_nome"] ?></td>
                                <td><?= $item["pro_cupom"] ?></td>
                                <td class="text-center"><?= trataDataInv($item["pro_dtInicio"]) ?></td>
                                <td class="text-center"><?= trataDataInv($item["pro_dtFinal"]) ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $item['pro_id'] ?>" />
                                        <?php
                                        if ($item['pro_ativo']) {
                                        ?>
                                            <button type="submit" title="Clique para Desativar a Promoção" class="btn btn-link" name="alterar-status"><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                        } else {
                                        ?>
                                            <button type="submit" title="Clique para Ativar a Promoção" class="btn btn-link" name="alterar-status"><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $item['pro_id'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Promoção" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Promoção">
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
                            <td class="text-center text-muted" colspan="7">Nenhuma Promoção Cadastrada</td>
                        </tr>

                    <?php
                    }

                    ?>

                </tbody>
            </table>

            <?php
            if (!isset($naopagina)) {
                echo $pagination;
            }
            ?>

        </div>
    </div>

    <?php include_once './rodape.php'; ?>