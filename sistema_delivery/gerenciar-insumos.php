<?php
$menu = "Insumos";
$submenu = "Gerenciar Insumos";
$dataTables = TRUE;
$select2 = true;

require_once 'topo.php';
require_once 'classes/Insumo.php';
require_once 'classes/UnidadeMedida.php';
require_once 'classes/CategoriaInsumos.php';
require_once 'classes/Fornecedor.php';

$unidade_medida = new UnidadeMedida();
$categoria_insumos = new CategoriaInsumos();
$categoria_insumos->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$insumo = new Insumo();
$insumo->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$fornecedor = new Fornecedor();
$fornecedor->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$id = $nome = $obs = $id_medida = $id_categoria = $id_fornecedor = $flag_estoque = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        $obs = trim(filter_input(INPUT_POST, "obs", FILTER_SANITIZE_SPECIAL_CHARS));
        $flag_estoque = !empty(filter_has_var(INPUT_POST, "controle")) ? 1 : 0;
        $id_categoria = filter_input(INPUT_POST, "selCategoria", FILTER_VALIDATE_INT);
        $id_fornecedor = filter_input(INPUT_POST, "selFornecedor", FILTER_VALIDATE_INT);
        $id_medida = filter_input(INPUT_POST, "selMedida", FILTER_VALIDATE_INT);

        if (empty($nome) || empty($id_fornecedor) || empty($id_categoria) || empty($id_medida)) {
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
            $erroCamposVazios = true;
        } else {
            $insumo->setNome($nome);
            $insumo->setObs($obs);
            $insumo->setControleEstoque($flag_estoque);
            $insumo->setIdCategoria($id_categoria);
            $insumo->setIdFornecedor($id_fornecedor);
            $insumo->setIdUnidade($id_medida);
            $insumo->setAtivo(1);

            if (filter_has_var(INPUT_POST, "editar")) {
                $insumo->setId($id);

                if ($insumo->alterar()) {
                    $sucessoalterar = TRUE;
                    $id = $nome = $obs = $id_medida = $id_categoria = $id_fornecedor = $flag_estoque = "";
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                if ($insumo->inserir()) {
                    $sucessoinserir = TRUE;
                    $id = $nome = $obs = $id_medida = $id_categoria = $id_fornecedor = $flag_estoque = "";
                } else {
                    $erroinserir = TRUE;
                }
            }

        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $insumo->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));
        if ($insumo->carregar()) {
            $id = $insumo->getId();
            $nome = $insumo->getNome();
            $obs = $insumo->getObs();
            $flag_estoque = $insumo->getControleEstoque();
            $id_categoria = $insumo->getIdCategoria();
            $id_fornecedor = $insumo->getIdFornecedor();
            $id_medida = $insumo->getIdUnidade();

            $carregado = true;
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $insumo->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if($insumo->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $insumo->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($insumo->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status do Insumo!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status do Insumo!";
        }
    }
}

$todas_medidas = $unidade_medida->listar();
$todas_categoria = $categoria_insumos->listar();
$todos_fornecedores = $fornecedor->listar();

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
$num_rows = $insumo->quantidadeRegistros($filtro);
$lista = $insumo->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Gerenciar Insumos</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Novo Insumo" : "Alterar o Insumo <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">

        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?= $id ?>" />
            <div class="form-row">

                <div class="col-sm-8 col-12">

                    <div class="form-group input-group-lg">
                        <label for="nome">Nome <span class="obrigatorio">*</span>:</label>
                        <input type="text" class="form-control" value="<?= $nome ?>" id="nome" name="nome" required>
                    </div>

                </div>

                <div class="col-12 col-sm-4">

                            <div class="form-group">
                                <label class="control-label" for="selMedida">Unidade de Medida <span class="obrigatorio">*</span>:</label>
                                <select class="form-control select2" name="selMedida" id="selMedida" required>
                                    <option value="">Selecione</option>
                                    <?php

                                    if ($todas_medidas) {
                                        foreach ($todas_medidas as $uni) {
                                            ?>

                                            <option data-formula="<?= utf8_encode($uni["uni_formula"]) ?>" <?= (utf8_encode($uni["uni_id"]) == $id_medida) ? "selected" : "" ?> value="<?= utf8_encode($uni["uni_id"]) ?>"><?= utf8_encode($uni["uni_nome"]) ?></option>

                                            <?php

                                        }
                                    }

                                    ?>

                                </select>
                                <div class="text-muted text-right"> </div>
                            </div>



                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="selCidade">Categoria do Insumo <span class="obrigatorio">*</span>:</label>
                        <select class="form-control select2" name="selCategoria" id="selCategoria" required>
                            <option value="">Selecione</option>

                            <?php

                            if ($todas_categoria) {
                                foreach ($todas_categoria as $cat) {
                                    ?>

                                    <option <?= (utf8_encode($cat["cat_id"]) == $id_categoria) ? "selected" : "" ?> value="<?= utf8_encode($cat["cat_id"]) ?>"><?= utf8_encode($cat["cat_nome"]) ?></option>

                                    <?php

                                }
                            }

                            ?>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="selCidade">Fornecedor do Insumo <span class="obrigatorio">*</span>:</label>
                        <select class="form-control select2" name="selFornecedor" id="selFornecedor" required>
                            <option value="">Selecione</option>
                            <?php

                            if ($todos_fornecedores) {
                                foreach ($todos_fornecedores as $for) {
                                    ?>

                                    <option <?= (utf8_encode($for["for_id"]) == $id_fornecedor) ? "selected" : "" ?> value="<?= utf8_encode($for["for_id"]) ?>"><?= utf8_encode($for["for_nome"]) ?></option>

                                    <?php

                                }
                            }

                            ?>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" <?= !empty($flag_estoque) ? "checked" : "" ?> id="controle" name="controle">
                        <label class="form-check-label" for="controle">
                            Controle de Estoque
                        </label>
                    </div>
                </div>

                <div class="form-group col-12">
                    <label for="obs"><strong>Observação</strong>: </label><br>
                    <textarea name="obs" id="obs" rows="5" class="form-group w-100"><?= $obs ?></textarea>
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
                Entregadores Cadastrados
            </h5>
        </div>
        <div class="card-body">

            <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
                <div class="form-row">

                    <div class="col-12">

                        <div class="form-group">

                            <div class="input-group">
                                <input type="text" class="form-control" name="filtro" placeholder="Procurar pelo nome..." value="<?= $filtro ?>">
                                <span class="input-group-btn">
                                    <button style="border-top-left-radius: 0; border-bottom-left-radius: 0" type="submit" name="buscar" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                </span>
                            </div><!-- /input-group -->

                        </div>

                    </div>

                </div>

            </form>

            <hr>

            <div class="table-responsive">

                <table class="table table-striped table-hover dataTable" >
                    <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Nome</th>
                        <th>Fornecedor</th>
                        <th class="text-center not-ordering">Ativo</th>
                        <th class="text-center not-ordering">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if (!empty($lista)) {
                        foreach ($lista as $result) {
                            ?>

                            <tr>
                                <td><?= utf8_encode($result["cat_nome"]) ?></td>
                                <td><?= utf8_encode($result["ins_nome"]) ?></td>
                                <td><?= utf8_encode($result["for_nome"]) ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['ins_id'] ?>" />
                                        <?php
                                        if ($result['ins_ativo']) {
                                            ?>
                                            <button type="submit" title="Clique para Desativar o Insumo" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" title="Clique para Ativar o Insumo" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['ins_id'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Insumo" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Insumo">
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
