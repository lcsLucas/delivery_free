<?php

    $menu = "Insumos";
    $submenu = "Motivos de uso";

    include_once './topo.php';
    include_once 'classes/MotivoUso.php';

    $motivo = new MotivoUso();
    $motivo->setIdEmpresa($_SESSION["_idEmpresa"]);

    $dataTables = TRUE;

    $nome = $id = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
        if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
            $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
            $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($nome)) {
                $erroCamposVazios = true;
                $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
            } else {

                $motivo->setNome($nome);

                if (filter_has_var(INPUT_POST, "editar")) {
                    $motivo->setId($id);

                    if ($motivo->alterar()) {
                        $sucessoalterar = TRUE;
                        $nome = $id = "";
                    } else {
                        $erroalterar = TRUE;
                        $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                    }

                }else {
                    if ($motivo->inserir()) {
                        $sucessoinserir = TRUE;
                        $nome = $id = "";
                    } else {
                        $erroinserir = TRUE;
                    }
                }

            }

        } else if (filter_has_var(INPUT_POST, "editar")) {
            $motivo->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

            if (!empty($motivo->carregar())) {
                $id = $motivo->getId();
                $nome = $motivo->getNome();

                $carregado = true;
            }

        } else if (filter_has_var(INPUT_POST, "deletar")) {
            $motivo->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));

            if($motivo->excluir()) {
                $sucessodeletar = TRUE;
            } else {
                $errodeletar = TRUE;
            }

        } else if (filter_has_var(INPUT_POST, "alterar-status")) {

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
    $num_rows = $motivo->quantidadeRegistros($filtro);
    $lista = $motivo->listarPaginacao($filtro,$offset,$entries_per_page);

    $total_pages = ceil($num_rows / $entries_per_page);
    $pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Gerenciar Motivos de Uso</h2>

<?php
include 'menssagens.php';
?>

<div class="card mb-3 <?= empty($carregado) ? "border-primary" : "border-danger" ?>">

    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Novo Motivo de Uso" : "Alterar Motivo de Uso \"". $nome ."\"" ?>
        </h5>
    </div>

    <div class="card-body">

        <form class="needs-validation" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off" novalidate>

            <div class="form-group input-group-lg">
                <label for="nome">Nome do Motivo<span class="obrigatorio">*</span>:</label>
                <input type="text" class="form-control" value="<?= $nome ?>" id="nome" name="nome" required>
                <input type="hidden" name="codigo" value="<?= $id ?>" />
            </div>

            <div class="form-group">
                <?= (!empty($carregado)) ? "<input type=\"hidden\" name=\"editar\" /> " : "" ?>
                <button type="submit" class="btn btn-outline-primary btn-lg pull-right" id="btnEnviar" name="btnEnviar">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    Confirmar
                </button>
                <a role="button" href="<?= $_SERVER["PHP_SELF"] ?>" class="btn btn-link btn-lg pull-right text-muted">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="titulo-card">
            Motivos de Uso Cadastrados
        </h5>
    </div>
    <div class="card-body">

        <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">

            <div class="form-row">

                <div class="col-12">

                    <div class="form-group">

                        <div class="input-group">
                            <input type="text" class="form-control" name="filtro" placeholder="Procurar pelo nome do motivo..." value="<?= $filtro ?>">
                            <span class="input-group-btn">
                                    <button style="border-top-left-radius: 0; border-bottom-left-radius: 0" type="submit" name="buscar" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                </span>
                        </div><!-- /input-group -->

                    </div>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-striped table-hover dataTable" >

                <thead>

                <tr>

                    <th class="col-auto" >Nome</th>
                    <th class="text-center col-auto">Ações</th>

                </tr>

                </thead>

                <tbody>

                <?php

                if (!empty($lista)) {
                    foreach ($lista as $mot) {

                        ?>

                        <tr>

                            <td><?= utf8_encode($mot["mot_nome"]) ?></td>

                            <td class="text-center">

                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $mot['mot_id'] ?>" />
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar Motivo do uso" name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Motivo do uso">
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

</div>

<?php
include 'rodape.php';
?>
