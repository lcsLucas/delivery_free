<?php

$menu = "Composição";
$submenu = "Composição do Produto";
$dataTables = TRUE;

require_once 'topo.php';
include_once "classes/CategoriaCaracteristicas.php";

$categoria_carac = new CategoriaCaracteristicas();
$categoria_carac->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]
$nome = $descricao = $id = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = htmlentities(SQLinjection(filter_input(INPUT_POST, "descricao",FILTER_DEFAULT)));

        if (empty($nome)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $categoria_carac->setNome($nome);
            $categoria_carac->setDescricao($descricao);
            $categoria_carac->setAtivo(1);

            if (filter_has_var(INPUT_POST, "editar")) {
                $categoria_carac->setId($id);

                if ($categoria_carac->alterar()) {
                    $sucessoalterar = TRUE;
                    $nome = $descricao = $id = "";
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }

            } else {
                if ($categoria_carac->inserir()) {
                    $sucessoinserir = TRUE;
                    $nome = $descricao = $id = "";
                } else {
                    $erroinserir = TRUE;
                }
            }
        }

    } else if (filter_has_var(INPUT_POST, "editar")) {

        $categoria_carac->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));
        if ($categoria_carac->carregar()) {
            $id = $categoria_carac->getId();
            $descricao = $categoria_carac->getDescricao();
            $nome = $categoria_carac->getNome();

            $carregado = true;
        }

    } else if (filter_has_var(INPUT_POST, "deletar")) {

        $categoria_carac->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if($categoria_carac->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }

    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $categoria_carac->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($categoria_carac->modificaAtivo()) {
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
$num_rows = $categoria_carac->quantidadeRegistros($filtro);
$lista = $categoria_carac->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);


?>

<h2 class="titulo-pagina">Gerenciar Grupos de Complementos</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Novo Grupo de Complementos" : "Alterar Grupo <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?= $id ?>" />
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="nome"><strong>Nome do Grupo <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12">
                    <label for="obs"><strong>Descrição</strong>: </label><br>
                    <textarea style="resize: none" name="descricao" id="obs" rows="5" class="form-group w-100"><?= $descricao ?></textarea>
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
            Grupos de Complementos Cadastrados
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable table-condensed" >
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
                            <td><?php echo utf8_encode($rs['tip_nome']); ?></td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['tip_id'] ?>" />
                                    <?php
                                    if ($rs['tip_ativo']) {
                                        ?>
                                        <button type="submit" title="Clique para Desativar a Categoria" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" title="Clique para Ativar a Categoria" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['tip_id'] ?>" />
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

