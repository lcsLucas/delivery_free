<?php

    $menu = "Empresas";
    $submenu = "Categorias de Cozinhas";
    $dropArea = $editor = true;

    require_once 'topo.php';
    require_once 'classes/CategoriaCozinhas.php';

    $categoria = new CategoriaCozinhas();
    $nome = $descricao = $id = $resumo = $imagem =  $file_imagem = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post

        if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
            $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
            $nome = trim(SQLinjection(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS)));
            $resumo = trim(SQLinjection(filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS)));
            $descricao = htmlspecialchars(trim(filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT)));

            $file_imagem = $_FILES['imgdestaque'];

            if (!empty($file_imagem['name'])) {

                if (!empty($categoria->verificarImagem($file_imagem))) {
                    $categoria->setFileImagem($file_imagem);
                    $img_ok = true;
                } else {
                    $erroPersonalizado = true;
                    $erroMensagem = $categoria->getRetorno();
                }

            } else
                $img_ok = true;

            if (!empty($img_ok)) {

                if (empty($nome) || empty($resumo) || empty($descricao)) {
                    $erroCamposVazios = true;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                } else {

                    $categoria->setNome($nome);
                    $categoria->setResumo($resumo);
                    $categoria->setDescricao($descricao);

                    if (filter_has_var(INPUT_POST, 'editar')) {

                        $categoria->setId($id);

                        if ($categoria->alterar()) {
                            $sucessoalterar = TRUE;
                            $nome = $descricao = $id = $resumo = $imagem =  $file_imagem = "";
                        } else {
                            $erroalterar = TRUE;
                            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                        }

                    } else {

                        if ($categoria->inserir()) {
                            $sucessoinserir = TRUE;
                            $nome = $descricao = $id = $resumo = $imagem =  $file_imagem = "";
                        } else {
                            $erroinserir = TRUE;
                        }

                    }

                }

            }

        } else if (filter_has_var(INPUT_POST, "editar")) {
            $categoria->setId(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT));

            if ($categoria->carregar()) {

                $nome = $categoria->getNome();
                $descricao = $categoria->getDescricao();
                $id = $categoria->getId();
                $resumo = $categoria->getResumo();
                $imagem = $categoria->getNomeImagem();

                $carregado = true;
            }

        } else if (filter_has_var(INPUT_POST, "deletar")) {
            $categoria->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
            $resp = $categoria->excluir();
            if($resp) {
                $sucessodeletar = TRUE;
            } else {
                $errodeletar = TRUE;
            }
        } else if (filter_has_var(INPUT_POST, "alterar-status")) {
            $categoria->setId(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT));
            if ($categoria->modificaAtivo()) {
                $sucessoPersonalizado = true;
                $sucessoMensagem = "ao alterar o status da categoria!";
            } else {
                $erroPersonalizado = true;
                $erroMensagem = "ao alterar o status da categoria";
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
    $num_rows = $categoria->quantidadeRegistros($filtro);
    $lista = $categoria->listarPaginacao($filtro,$offset,$entries_per_page);

    $total_pages = ceil($num_rows / $entries_per_page);
    $pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Categorias de Cozinha</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar nova categoria de cozinha" : "Alterar a categoria <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="formCatCozinhas" method="post" enctype="multipart/form-data" class="form-validate">
            <input type="hidden" name="codigo" value="<?= $id ?>" />
            <div class="form-row">
                <div class="form-group col-12 input-group-lg">
                    <label for="nome"><strong>Nome da Categoria <span class="obrigatorio">*</span></strong>: </label>
                    <input required autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12 input-group-lg">
                    <label for="resumo"><strong>Resumo <span class="obrigatorio">*</span></strong>: </label>
                    <input required id="resumo" name="resumo" value="<?php echo $resumo; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12">
                    <label for="ckeditor"><strong>Descrição</strong>: </label><br>
                    <textarea id="ckeditor"  name="descricao"><?= $descricao ?></textarea>
                </div>

                <div class="form-group col-12 text-center">
                    <label for="obs"><strong><?= (empty($carregado)) ? "Imagem da Categoria" : "Selecione Uma Nova Imagem para a Categoria" ?></strong>: </label>
                    <div class="droparea_container">

                        <div class="droparea text-center" id="drop1">
                            <?php
                            if(!empty($carregado) && !empty($imagem) && file_exists("../img/categoria_cozinhas/" . $imagem )){
                                ?>
                                <img class="img-fluid" src="../img/categoria_cozinhas/<?= $imagem . "?var=". rand ( 100 , 999 ) ?>" id="file_preview_1"> <br >
                                <?php
                            } else if(!empty($carregado) && !empty($imagem)){
                                ?>
                                <img class="img-fluid" src="<?= $imagem ?>" id="file_preview_1"> <br >
                                <?php
                            } else {
                                ?>
                                <img class="img-fluid" src="./images/640x480.png" id="file_preview_1"> <br >
                                <?php
                            }
                            ?>
                            <span>Clique para procurar a imagem!</span>
                        </div>
                    </div>
                    <input type="file" name="imgdestaque" id="file_1" style="display: none;" accept=".jpg,.png"> <!-- accept="image/jpeg" -->
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
            Categorias de cozinhas cadastradas
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" >
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
                    foreach ($lista as $reg) {
                        ?>

                        <tr>

                            <td><?= utf8_encode($reg['cat_nome']) ?></td>

                            <td class="text-center">

                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $reg['cat_id'] ?>" />
                                    <?php
                                    if ($reg['cat_status']) {
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
                                    <input type="hidden" name="acao-codigo" value="<?= $reg['cat_id'] ?>" />
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

                } else {
                    $naopagina = TRUE;
                    echo '<tr><td colspan="5" class="text-center">Nenhuma categoria cadastrada</td></tr>';
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
</div>

<?php
include 'rodape.php';
?>
