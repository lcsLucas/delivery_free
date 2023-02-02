<?php

$menu = "Produtos";
$submenu = "Categorias de Produtos";
$dataTables = TRUE;

require_once 'topo.php';
include_once "classes/CategoriaProdutos.php";

$mask = true;
$categoria_produtos = new CategoriaProdutos();
$categoria_produtos->setIdEmpresa($_SESSION["_idEmpresa"]);
$nome = $descricao = $id = "";
$array_idcat = array();
$array_cat = array();
$array_obg = array();
$array_min = array();
$array_max = array();
$array_complementos = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) { // enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = htmlentities(SQLinjection(filter_input(INPUT_POST, "descricao", FILTER_DEFAULT)));

        if (filter_has_var(INPUT_POST, "cat_complementos")) {
            $array_cat = array_filter($_POST["cat_complementos"]);
            $array_cat = filter_var_array($array_cat, FILTER_SANITIZE_STRING);
        }

        if (filter_has_var(INPUT_POST, "cat_obg")) {
            $array_obg = array_filter($_POST["cat_obg"]);
            $array_obg = filter_var_array($array_obg, FILTER_SANITIZE_STRING);
        }

        if (filter_has_var(INPUT_POST, "min_cat")) {
            $array_min = array_filter($_POST["min_cat"]);
            $array_min = filter_var_array($array_min, FILTER_VALIDATE_INT);
        }

        if (filter_has_var(INPUT_POST, "max_cat")) {
            $array_max = array_filter($_POST["max_cat"]);
            $array_max = filter_var_array($array_max, FILTER_VALIDATE_INT);
        }


        if (filter_has_var(INPUT_POST, "id_complementos")) {
            $array_idcat = array_filter($_POST["id_complementos"]);
            $array_idcat = filter_var_array($array_idcat, FILTER_SANITIZE_STRING);

            if (!empty($array_idcat)) {

                foreach ($array_idcat as $ind => $id_cat) {

                    $array_descr = array();
                    $array_preco = array();
                    $array_nome = array();

                    if (filter_has_var(INPUT_POST, 'descr_' . $id_cat)) {
                        $array_descr = array_filter($_POST['descr_' . $id_cat]);
                        $array_descr = filter_var_array($array_descr, FILTER_SANITIZE_STRING);
                    }

                    if (filter_has_var(INPUT_POST, 'preco_' . $id_cat)) {
                        $array_preco = array_filter($_POST['preco_' . $id_cat]);
                        $array_preco = filter_var_array($array_preco, FILTER_SANITIZE_STRING);
                    }

                    if (filter_has_var(INPUT_POST, 'nome_' . $id_cat)) {
                        $array_nome = array_filter($_POST['nome_' . $id_cat]);
                        $array_nome = filter_var_array($array_nome, FILTER_SANITIZE_STRING);
                    }

                    if (!empty(trim($array_cat[$ind])) && !empty($array_nome)) {

                        $array_complementos[] = array(
                            'nome' => $array_cat[$ind],
                            'flag_obrigatorio' => !empty($array_obg[$ind]) ? 1 : 0,
                            'qtde_min' => !empty($array_min[$ind]) ? $array_min[$ind] : 0,
                            'qtde_max' => !empty($array_max[$ind]) ? $array_max[$ind] : 0,
                            'opcoes' => array(
                                'nome' => $array_nome,
                                'descricao' => $array_descr,
                                'preco' => $array_preco,
                            )
                        );
                    }
                }
            }
        }

        if (empty($nome)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $categoria_produtos->setNome($nome);
            $categoria_produtos->setDescricao($descricao);
            $categoria_produtos->setAtivo(1);
            $categoria_produtos->setComplementos($array_complementos);

            if (filter_has_var(INPUT_POST, "editar")) {
                $categoria_produtos->setId($id);

                if ($categoria_produtos->alterar()) {
                    $sucessoalterar = TRUE;
                    $nome = $descricao = $id = "";
                    $array_idcat = array();
                    $array_cat = array();
                    $array_obg = array();
                    $array_min = array();
                    $array_max = array();
                    $array_complementos = array();
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                if ($categoria_produtos->inserir()) {
                    $sucessoinserir = TRUE;
                    $nome = $descricao = $id = "";
                    $array_idcat = array();
                    $array_cat = array();
                    $array_obg = array();
                    $array_min = array();
                    $array_max = array();
                    $array_complementos = array();
                } else {
                    $erroinserir = TRUE;
                }
            }
        }
    } else if (filter_has_var(INPUT_POST, "editar")) {

        $categoria_produtos->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));
        if ($categoria_produtos->carregar()) {
            $id = $categoria_produtos->getId();
            $descricao = $categoria_produtos->getDescricao();
            $nome = $categoria_produtos->getNome();
            $array_complementos = $categoria_produtos->getComplementos();

            $carregado = true;
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {

        $categoria_produtos->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($categoria_produtos->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $categoria_produtos->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($categoria_produtos->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status da Categoria!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status da Categoria";
        }
    }
}

$filtro = "";
$parametros = "";
if (isset($_GET['buscar'])) {
    $filtro = SQLinjection(filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS));
    $parametros = "&filtro=" . $filtro . "&buscar=";
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
$num_rows = $categoria_produtos->quantidadeRegistros($filtro);
$lista = $categoria_produtos->listarPaginacao($filtro, $offset, $entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page, $parametros);


?>

<h2 class="titulo-pagina">Gerenciar Categorias de Produtos</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Nova Categoria de Produtos" : "Alterar Categoria <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?= $id ?>" />
            <div class="form-row">
                <div class="form-group col-12 input-group-lg">
                    <label for="nome"><strong>Nome da Categoria <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12">
                    <label for="obs"><strong>Descrição</strong>: </label><br>
                    <textarea style="resize: none" name="descricao" id="obs" rows="5" class="form-group w-100"><?= $descricao ?></textarea>
                </div>

                <div class="col-12">

                    <div class="form-group col-12">
                        <hr>
                        <h4 class="text-center text-muted text-uppercase"><strong>Complementos</strong></h4>
                    </div>

                    <div class="col-12">

                        <div id="wrapper-complementos">

                            <?php

                            if (!empty($array_complementos)) {

                                foreach ($array_complementos as $comp) {

                                    $unique = $comp['catcom_id'];

                            ?>

                                    <div class="complemento" style="position:relative; border: 1px solid #CCC;background: #EEE; border-radius: 2px; margin-bottom: 20px; padding: 20px 15px;">
                                        <button class="btn btn-danger remover-complemento" style="position: absolute;top: -19px;right: -18px;border-radius: 50%;" type="button">
                                            <i class="fa fa-times text-white"></i>
                                        </button>
                                        <div class="row">

                                            <div class="col-sm-12 col-md-6">

                                                <div class="form-group">

                                                    <label for="cat-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Categoria do Complemento:</label>
                                                    <input autofocus maxlength="255" name="cat_complementos[]" value="<?= $comp['catcom_nome'] ?>" id="cat-<?= $unique ?>" type="text" class="form-control form-control-sm" required>
                                                    <input type="hidden" name="id_complementos[]" value="idcomp_<?= $unique ?>">
                                                    <input type="hidden" name="unique[]" value="<?= $unique ?>">
                                                </div>

                                            </div>

                                            <div class="col-sm-12 col-md-2 text-center">

                                                <label for="obg-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Obrigatório</label>
                                                <input id="obg-<?= $unique ?>" name="cat_obg[]" <?= !empty($comp['catcom_obrigatorio']) ? 'checked' : '' ?> class="form-control checkbox" type="checkbox" value="1">

                                            </div>

                                            <div class="col-sm-12 col-md-2 text-center">

                                                <div class="form-group form-control-sm">

                                                    <label for="min-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Qtde Min</label>
                                                    <input id="min-<?= $unique ?>" name="min_cat[]" value="<?= !empty($comp['catcom_obrigatorio']) && empty($comp['catcom_qtdemin']) ? 1 : $comp['catcom_qtdemin'] ?>" maxlength="3" type="text" class="form-control form-control-sm text-center mascara-numero">

                                                </div>

                                            </div>

                                            <div class="col-sm-12 col-md-2 text-center">

                                                <div class="form-group form-control-sm">

                                                    <label for="max-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Qtde Max</label>
                                                    <input id="max-<?= $unique ?>" name="max_cat[]" value="<?= $comp['catcom_qtdemax'] ?>" maxlength="3" type="text" class="form-control form-control-sm text-center mascara-numero">

                                                </div>

                                            </div>

                                            <div class="col-sm-12">

                                                <hr>

                                            </div>

                                            <div class="col-sm-12">

                                                <div class="wrapper-opcoes">

                                                    <?php

                                                    if (!empty($comp['opcoes'])) {

                                                        foreach ($comp['opcoes'] as $opcao) {

                                                    ?>

                                                            <div class="row opcoes-complementos">

                                                                <div class="col-sm-12 col-md-4">

                                                                    <div class="form-group">

                                                                        <label for="nome-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Nome:</label>
                                                                        <input id="nome-<?= $unique ?>" value="<?= $opcao['nome'] ?>" name="nome_idcomp_<?= $unique ?>[]" maxlength="255" type="text" class="form-control form-control-sm" required>
                                                                    </div>

                                                                </div>

                                                                <div class="col-sm-12 col-md-4">

                                                                    <div class="form-group">

                                                                        <label for="descr-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Descrição:</label>
                                                                        <input id="descr-<?= $unique ?>" value="<?= $opcao['descricao'] ?>" name="descr_idcomp_<?= $unique ?>[]" type="text" class="form-control form-control-sm">

                                                                    </div>

                                                                </div>

                                                                <div class="col-sm-12 col-md-2 text-center">

                                                                    <div class="form-group form-control-sm">

                                                                        <label for="preco-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Preço</label>
                                                                        <input id="preco-<?= $unique ?>" value="<?= number_format($opcao['preco'], 2, ',', '.') ?>" name="preco_idcomp_<?= $unique ?>[]" type="text" maxlength="6" class="form-control form-control-sm mascara-dinheiro text-center">

                                                                    </div>

                                                                </div>

                                                                <div class="col-sm-12 col-md-2 text-center">
                                                                    <div class="form-group">
                                                                        <br>
                                                                        <button type="button" style="font-size: .8rem; font-weight: bold;" class="btn btn-danger text-danger text-uppercase remove-opcao">
                                                                            <i class="fa fa-times text-white"></i>
                                                                        </button>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                    <?php

                                                        }
                                                    }

                                                    ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-12 text-center mt-4">

                                                <button type="button" class="btn btn-primary btn-sm add-complemento">Adicionar Opção</button>

                                            </div>

                                        </div>

                                    </div>

                            <?php

                                }
                            }

                            ?>

                        </div>

                    </div>

                    <div class="form-group col-12 text-center mt-4">

                        <button id="add-complemento" type="button" class="btn btn-primary">Adicionar Categoria de Complementos</button>

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
            Categorias de Produtos Cadastrados
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable table-condensed">
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
                                <td><?php echo $rs['cat_nome']; ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $rs['cat_id'] ?>" />
                                        <?php
                                        if ($rs['cat_ativo']) {
                                        ?>
                                            <button type="submit" title="Clique para Desativar a Categoria" class="btn btn-link" name="alterar-status"><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                        } else {
                                        ?>
                                            <button type="submit" title="Clique para Ativar a Categoria" class="btn btn-link" name="alterar-status"><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $rs['cat_id'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Categoria" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Categoria">
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