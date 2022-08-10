<?php

    $menu = "Promoções";
    $submenu = "Gerenciar Promoções de Produtos";
    $mask = true;
    $dataTables = true;
    $select2 = true;
    $datetimepicker = true;

    $id = $codigo_promocional = $nome = $valor_desconto = $data_final = $data_inicial = "";

    include_once 'topo.php';
    include_once 'classes/Promocao.php';
    require_once "classes/Produto.php";

    $promocao = new Promocao();
    $promocao->setIdEmpresa($_SESSION["_idEmpresa"]);
    $promocao->setTipo(1); //0 = promoção de produtos

    $id = $nome = $codigo_promocional = $data_inicial = $data_final = $tipo_desconto = $valor_desconto = $porcentagem_desconto = "";
    $array_id = array();
    $array_tpdesc = array();
    $array_desc = array();
    $array_produtos = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
        if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
            $id = filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT);
            $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
            $data_inicial = trim(SQLinjection(filter_input(INPUT_POST, "data_inicial", FILTER_SANITIZE_SPECIAL_CHARS)));
            $data_final = trim(SQLinjection(filter_input(INPUT_POST, "data_final", FILTER_SANITIZE_SPECIAL_CHARS)));

            if (filter_has_var(INPUT_POST, "produto_id")) {
                $array_id = array_filter($_POST["produto_id"]);
                $array_id = filter_var_array($array_id, FILTER_VALIDATE_INT);
                $array_produtos['id'] = $array_id;
            }

            if (filter_has_var(INPUT_POST, "tipo_desconto")) {
                $array_tpdesc = array_filter($_POST["tipo_desconto"]);
                $array_tpdesc = filter_var_array($array_tpdesc, FILTER_VALIDATE_INT);
                $array_produtos['desc_tipo'] = $array_tpdesc;
            }

            if (filter_has_var(INPUT_POST, "valor_desconto")) {
                $array_desc = array_filter($_POST["valor_desconto"]);
                $array_desc = filter_var_array($array_desc, FILTER_VALIDATE_INT);
                $array_produtos['desc_valor'] = $array_desc;
            }

            if (empty($array_produtos)) {

                $erroPersonalizado = true;
                $erroMensagem = "Você não informou nenhum produto para a promoção";
                $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;

            } else {

                if (empty($nome) || empty($data_inicial) || empty($data_final)) {
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                    $erroCamposVazios = true;
                } else {

                    $promocao->setNome($nome);
                    $promocao->setDataInicial($data_inicial);
                    $promocao->setDataFinal($data_final);
                    $promocao->setProdutos($array_produtos);

                    if (filter_has_var(INPUT_POST, "editar")) {
                        $promocao->setId($id);
                        $resp = $promocao->alterar2();
                        if ($resp) {
                            $sucessoalterar = TRUE;
                            $id = $nome = $codigo_promocional = $data_inicial = $data_final = $tipo_desconto = $valor_desconto = $porcentagem_desconto = "";
                            $array_id = array();
                            $array_tpdesc = array();
                            $array_desc = array();
                            $array_produtos = array();
                        } else {
                            $erroalterar = TRUE;
                            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                        }

                    } else {
                        $resp = $promocao->inserir2();

                        if ($resp) {
                            $sucessoinserir = TRUE;
                            $id = $nome = $codigo_promocional = $data_inicial = $data_final = $tipo_desconto = $valor_desconto = $porcentagem_desconto = "";
                            $array_id = array();
                            $array_tpdesc = array();
                            $array_desc = array();
                            $array_produtos = array();
                        } else {
                            $erroinserir = TRUE;
                        }

                    }

                }

            }

        } else if(filter_has_var(INPUT_POST, "editar")) {
            $promocao->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

            if ($promocao->carregar()) {

                $id = $promocao->getId();
                $data_inicial = $promocao->getDataInicial();
                $data_final = $promocao->getDataFinal();
                $nome = $promocao->getNome();
                $array_produtos = $promocao->getProdutos();

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
        } else if(filter_has_var(INPUT_POST, "deletar")) {
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
$num_rows = $promocao->quantidadeRegistros2($periodo1, $periodo2);
$lista = $promocao->listarPaginacao2($periodo1, $periodo2, $offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

    $produto = new Produto();
    $produto->setIdEmpresa($_SESSION["_idEmpresa"]);
    $todos_produtos = $produto->listar();

?>

<div class="alert alert-warning">
    Ao adicionar uma promoção a um produto, as promoções antigas vinculadas a ele serão removidas
</div>

<h2 class="titulo-pagina">Gerenciar Promoções de Produtos</h2>

<?php
include "menssagens.php";
?>

<div class="card mb-3 <?= empty($carregado) ? "border-primary" : "border-danger" ?>">

    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <?= empty($carregado) ? "Nova Promoção" : "Alterar Promoção <q>".$nome."</q>" ?>
    </div>

    <div class="card-body">

        <form id="form-cupons" class="needs-validation" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off" novalidate>

            <div class="row justify-content-md-center">

                <div class="col-sm-12 col-md-12 col-lg-12">

                    <div class="form-group input-group-lg">
                        <label class="font-weight-bold" for="nome">Nome da Promoção <span class="obrigatorio">*</span>:</label>
                        <input type="tel" class="form-control" id="nome" name="nome" maxlength="60" required value="<?= $nome ?>">
                        <input type="hidden" name="acao-codigo" value="<?= $id ?>" />
                    </div>

                </div>

                <div class="col-sm-12 col-md-6 col-lg-5">
                    <label class="font-weight-bold">Data Inicial <span class="obrigatorio">*</span>:</label>
                    <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                        <input type="text" class="form-control text-center" placeholder="__/__/____" name="data_inicial" required value="<?= !empty($data_inicial) ? $data_inicial : '' ?>" >
                        <div class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-5">
                    <label class="font-weight-bold">Data Final <span class="obrigatorio">*</span>:</label>
                    <div style="cursor: pointer;" class="input-group input-group-lg datepicker">
                        <input type="text" class="form-control text-center" placeholder="__/__/____" name="data_final" required value="<?= !empty($data_final) ? $data_final : '' ?>" >
                        <div class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <h3 style="text-transform: uppercase;font-weight: bold;font-size: 20px;margin: 40px 0;color: #007bff;border-bottom: 1px solid #007bff;">Seleção dos Produtos</h3>

                    <form id="formAddProd" method="post" action="">

                        <div class="row">

                            <div class="col-sm-12 col-md-5 col-lg-5">

                                <label class="font-weight-bold" >Tipo de Desconto <span class="obrigatorio">*</span>:</label>

                                <div class="form-control form-control-lg text-center">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" <?= (($tipo_desconto == 1) || empty($tipo_desconto)) ? "checked" : "" ?> name="tpDesconto" id="tpDesconto1" value="1">
                                        <label class="form-check-label" for="tpDesconto1">Porcentual</label>
                                    </div>
                                    <div class="form-check form-check-inline ml-3">
                                        <input class="form-check-input" type="radio" name="tpDesconto" <?= $tipo_desconto == 2 ? "checked" : "" ?> id="tpDesconto2" value="2">
                                        <label class="form-check-label" for="tpDesconto2">Valor Fixo</label>
                                    </div>

                                </div>

                            </div>

                            <div id="valor" class="col-sm-12 col-md-5 col-lg-5 <?= $tipo_desconto == 2 ? "" : "d-none" ?>">

                                <div class="form-group">
                                    <label class="font-weight-bold" for="valor_desconto">Valor do Desconto <span class="obrigatorio">*</span>:</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">R$</div>
                                        </div>
                                        <input <?= $tipo_desconto == 2 ? "" : "disabled" ?> type="tel" maxlength="10" class="form-control text-right mascara-dinheiro desconto_promocao" data-desconto="2" name="valor_desconto" value="<?= $valor_desconto ?>" id="valor_desconto" placeholder="0,00">
                                    </div>
                                    <div class="msg-erro text-danger"></div>
                                </div>

                            </div>

                            <div id="porcentagem" class="col-sm-12 col-md-5 col-lg-5 <?= (($tipo_desconto == 1) || empty($tipo_desconto)) ? "" : "d-none" ?>">

                                <div class="form-group">
                                    <label class="font-weight-bold" for="porcentagem_desconto">Porcentagem do Desconto <span class="obrigatorio">*</span>:</label>
                                    <div class="input-group input-group-lg">
                                        <input <?= (($tipo_desconto == 1) || empty($tipo_desconto)) ? "" : "disabled" ?> max="100" type="tel" maxlength="6" class="form-control text-center mascara-dinheiro desconto_promocao" data-desconto="1" name="porcentagem_desconto" value="<?= $porcentagem_desconto ?>" id="porcentagem_desconto" placeholder="0,00">
                                        <div class="input-group-append">
                                            <div class="input-group-text">%</div>
                                        </div>
                                    </div>
                                    <div class="msg-erro text-danger"></div>
                                </div>

                            </div>

                            <div class="col-12 col-xl-4">

                                <div class="form-group">
                                    <label class="font-weight-bold" for="sel-promocao-produto">Produto:</label>
                                    <select id="sel-promocao-produto" name="produto" class="form-control select2">
                                        <option value="">Selecione</option>

                                        <?php

                                        if (!empty($todos_produtos)) {
                                            foreach($todos_produtos as $produto) {

                                                if (!empty($array_produtos)) {

                                                    if (in_array(intval($produto["pro_id"]), $array_produtos['id'])) {
                                                        $array_produtos['nome'][] = $produto["pro_nome"];
                                                        $array_produtos['preco'][] = $produto["pro_valor"];

                                                    }

                                                }

                                                ?>

                                                <option data-preco="<?= $produto["pro_valor"] ?>" value="<?= $produto["pro_id"] ?>"><?= utf8_encode($produto["pro_nome"]) ?></option>

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
                                    <label class="font-weight-bold" for="preco">Preço do Produto:</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">R$</div>
                                        </div>
                                        <input readonly type="text" maxlength="10" class="form-control text-right mascara-dinheiro" name="preco" id="preco" placeholder="0,00">
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-6 col-xl-3">

                                <div class="form-group">
                                    <label class="font-weight-bold" for="preco">Preço Descontado:</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">R$</div>
                                        </div>
                                        <input readonly type="text" maxlength="10" class="form-control text-right mascara-dinheiro" name="preco_desconto" id="preco_desconto" placeholder="0,00">
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-xl-2 text-center">
                                <label class="invisible" for="">botao adicionar</label>
                                <div class="form-group">
                                    <a id="btn-add-prod-promocao" href="" class="btn btn-outline-primary btn-block btn-lg">Adicionar</a>
                                </div>

                            </div>

                            <div class="col-12 mt-5">

                                <div class="table-responsive">

                                    <table id="lista-produto-promocao" class="table table-hover table-striped" >

                                        <thead>
                                        <tr>
                                            <th class="border-bottom-0">Produto</th>
                                            <th class="text-center border-bottom-0">Preço</th>
                                            <th class="text-center border-bottom-0">Desconto Aplicado</th>
                                            <th class="text-center border-bottom-0">Preço com desconto</th>
                                            <th class="text-center border-bottom-0">Excluir Item</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <?php

                                        if (!empty($array_produtos)) {


                                            foreach ($array_produtos['id'] as $i => $id) {

                                                $preco = filter_var($array_produtos['preco'][$i], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                                $desconto = filter_var($array_produtos['desc_valor'][$i], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                                $tipo = $array_produtos['desc_tipo'][$i];

                                                ?>
                                                
                                                <tr>

                                                    <td><?= utf8_encode($array_produtos['nome'][$i]) ?></td>
                                                    <td class="text-center">R$ <?= number_format($preco, 2, ',', '.') ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                            $str_desc = '';

                                                            if($tipo === 1)
                                                                $str_desc = number_format($desconto, 2, ',', '.') . '%';
                                                            else
                                                                $str_desc = 'R$ ' . number_format($desconto, 2, ',', '.');

                                                            echo $str_desc;
                                                        ?>
                                                    </td>
                                                    <td class="text-center">

                                                        <?php

                                                            if ($tipo === 1) {

                                                                $val_desc = $preco * $desconto / 100;
                                                                $result = $preco - $val_desc;

                                                            } else
                                                                $result = $preco - $desconto;


                                                            echo 'R$ ' . number_format($result, 2, ',', '.');

                                                        ?>

                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger remover-produto-promocao"><i class="fa fa-close"></i></button>
                                                        <input type="hidden" name="produto_id[]" value="<?= $id ?>" />
                                                        <input type="hidden" name="tipo_desconto[]" value="<?= $tipo ?>" />
                                                        <input type="hidden" name="valor_desconto[]" value="<?= $desconto ?>" />
                                                    </td>
                                                    
                                                </tr>

                                        <?php

                                            }

                                        } else {

                                            ?>

                                            <tr class="remover text-center text-muted">
                                                <td colspan="5">Nenhum produto adicionado</td>
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
        Relatório de Promoções <a target="_blank" href="relatorios/relatorio-promocoes-produtos.php?filtro=<?= $filtro . $parametros ?>" class="float-right border-white btn btn-outline-secondary"><i class="fa text-white fa-print"></i></a>
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

                        <td><?= utf8_encode($item["pro_nome"]) ?></td>
                        <td class="text-center"><?= trataDataInv($item["pro_dtInicio"]) ?></td>
                        <td class="text-center"><?= trataDataInv($item["pro_dtFinal"]) ?></td>
                        <td class="text-center">
                            <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                <input type="hidden" name="acao-codigo" value="<?= $item['pro_id'] ?>" />
                                <?php
                                if ($item['pro_ativo']) {
                                    ?>
                                    <button type="submit" title="Clique para Desativar a Promoção" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                    <?php
                                } else {
                                    ?>
                                    <button type="submit" title="Clique para Ativar a Promoção" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
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
        if(!isset($naopagina)){
            echo $pagination;
        }
        ?>

    </div>
</div>

<?php include_once './rodape.php'; ?>
