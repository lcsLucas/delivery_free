<?php

$menu = "Cadastros";
$submenu = "Formas de Pagamento";
$dataTables = TRUE;
$mask = true;

require_once 'topo.php';
include_once "classes/FormPagto.php";

$form_pagto = new FormPagto();
$form_pagto->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$id = $nome = $descricao = "";
$entrada = $num_parc = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $num_parc = filter_input(INPUT_POST, "num_parc", FILTER_SANITIZE_SPECIAL_CHARS);
        $entrada = !empty(filter_has_var(INPUT_POST, "entrada")) ? 1 : 0;
        $descricao = htmlentities(SQLinjection(filter_input(INPUT_POST, "descricao",FILTER_DEFAULT)));

        if (empty($nome)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $form_pagto->setNome($nome);
            $form_pagto->setNumParcela($num_parc);
            $form_pagto->setDescricao($descricao);
            $form_pagto->setFlagEntrada($entrada);
            $form_pagto->setAtivo(1);

            if (filter_has_var(INPUT_POST, "editar")) {
                $form_pagto->setId($id);

                if ($form_pagto->alterar()) {
                    $sucessoalterar = TRUE;
                    $id = $nome = $descricao = $num_parc = "";
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                if ($form_pagto->inserir()) {
                    $sucessoinserir = TRUE;
                    $id = $nome = $descricao = $num_parc = "";
                } else {
                    $erroinserir = TRUE;
                }
            }

        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $form_pagto->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));
        if ($form_pagto->carregar()) {
            $id = $form_pagto->getId();
            $nome = $form_pagto->getNome();
            $descricao = $form_pagto->getDescricao();
            $entrada = $form_pagto->getFlagEntrada();
            $num_parc = $form_pagto->getNumParcela();

            $carregado = true;
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $form_pagto->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if($form_pagto->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $form_pagto->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($form_pagto->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status da Forma de Pagamento!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status da Forma de Pagamento";
        }
    }
}

$filtro = "";
$parametros = "";
if(isset($_GET['buscar'])){
    $filtro = SQLinjection(filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS));
    $parametros = "&filtro=".$filtro."&buscar=";
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
$num_rows = $form_pagto->quantidadeRegistros($filtro);
$lista = $form_pagto->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Gerenciar Formas de Pagamento</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Nova Forma de Pagamento" : "Alterar Forma de Pagamento <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="form-row">
                <input type="hidden" name="codigo" value="<?= $id ?>" />

                <div class="form-group col-12 col-sm-9">
                    <label for="nome"><strong>Nome <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>

                <div class="form-group col-12 col-sm-3">
                    <label for="nome"><strong>Número de Parcelas <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" id="num_parc" name="num_parc" value="<?= $num_parc; ?>" type="text" class="form-control mascara-numero">
                </div>

                <div class="form-group col-12">
                    <label for="obs"><strong>Descrição</strong>: </label><br>
                    <textarea style="resize: none" name="descricao" id="obs" rows="5" class="form-group w-100"><?= $descricao ?></textarea>
                </div>


                <div class="form-group col-12">
                    <div class="form-check">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" <?= !empty($entrada) ? "checked" : "" ?> id="entrada" name="entrada">
                            Entrada
                        </label>
                    </div>
                </div>

                <div class="form-group col-12">
                    <?= (!empty($carregado)) ? "<input type=\"hidden\" name=\"editar\" /> " : "" ?>
                    <button type="submit" class="btn btn-outline-primary btn-lg pull-right" id="btnEnviar" name="btnEnviar">
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
<br><br>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="titulo-card">
            Formas de Pagamento Cadastradas
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable" >
                <thead>
                <tr>
                    <th>Nome</th>
                    <th class="text-center not-ordering">Ativo</th>
                    <th class="text-center not-ordering">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($lista)) {
                    foreach ($lista as $rs) {
                        ?>
                        <tr>
                            <td><?php echo utf8_encode($rs['pag_nome']); ?></td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['pag_id'] ?>" />
                                    <?php
                                    if ($rs['pag_ativo']) {
                                        ?>
                                        <button type="submit" title="Clique para Desativar a Forma de Pagamento" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" title="Clique para Ativar a Forma de Pagamento" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['pag_id'] ?>" />
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar de Forma de Pagamento" name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Forma de Pagamento">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include 'rodape.php';
?>

