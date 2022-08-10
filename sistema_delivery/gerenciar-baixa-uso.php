<?php
    $menu = "Insumos";
    $submenu = "Baixa do uso";
    $dataTables = TRUE;
    $select2 = true;
    $mask = true;

    include_once './topo.php';
    include_once  "classes/Insumo.php";
    include_once "classes/MotivoUso.php";
    include_once "classes/BaixaInsumo.php";

    $id_insumo = $id_motivo = $qtde = $filtro = "";

    $insumo = new Insumo();
    $insumo->setIdEmpresa($_SESSION["_idEmpresa"]);

    $motivo = new MotivoUso();
    $motivo->setIdEmpresa($_SESSION["_idEmpresa"]);

    $baixa = new BaixaInsumo();
    $baixa->setIdEmpresa($_SESSION["_idEmpresa"]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
        if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
            $id_insumo = filter_input(INPUT_POST, "insumo", FILTER_VALIDATE_INT);
            $id_motivo = filter_input(INPUT_POST, "motivo", FILTER_VALIDATE_INT);
            $qtde = trim(filter_input(INPUT_POST, "qtde", FILTER_SANITIZE_SPECIAL_CHARS));

            if (empty($id_insumo) || empty($id_motivo) || empty($qtde)) {
                $erroCamposVazios = true;
            } else {

                $qtde2 = str_replace(".", "", $qtde);
                $qtde2 = str_replace(",", ".", $qtde2);

                $baixa->getInsumo()->setId($id_insumo);
                $baixa->getMotivo()->setId($id_motivo);
                $baixa->setQtde($qtde2);

                if ($baixa->darBaixaInsumo()) {
                    $id_insumo = $id_motivo = $qtde = $filtro = "";
                    $sucessoPersonalizado = true;
                    $sucessoMensagem = "Baixa realizada com sucesso";
                } else {
                    if (!empty($baixa->getRetorno())) {
                        $erroPersonalizado = true;
                        $erroMensagem = $baixa->getRetorno();
                    } else {
                        $erroinserir = TRUE;
                    }

                }

            }

        }

    }


    $todos_insumos = $insumo->listar_controle_estoque();
    $todos_motivos = $motivo->listar();

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
    $num_rows = $baixa->quantidadeRegistros($filtro);
    $lista = $baixa->listarPaginacao($filtro,$offset,$entries_per_page);

    $total_pages = ceil($num_rows / $entries_per_page);
    $pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Dar Baixa no Uso</h2>

<?php
include "menssagens.php";
?>

<div class="card mb-3 <?= empty($carregado) ? "border-primary" : "border-danger" ?>">

    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Nova Baixa no Uso do Insumo" : "Alterar Informações da Entrada Nº " . $id ?>
        </h5>
    </div>

    <div class="card-body">

        <form id="form-baixa" class="needs-validation" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off" novalidate>

            <div class="row">

                <div class="col-12">

                    <div class="form-group">
                        <label class="font-weight-bold" for="insumo">Selecione o Insumo:</label>
                        <select <?= !empty($carregado) ? "disabled" : "" ?> id="sel-insumo" name="insumo" class="form-control select2">
                            <option value="">Selecione</option>

                            <?php

                            if (!empty($todos_insumos)) {
                                foreach($todos_insumos as $insumo) {

                                    ?>

                                    <option <?= (intval($id_insumo) === intval($insumo["ins_id"])) ? "selected" : "" ?> data-medida="<?= $insumo["uni_sigla"] ?>" value="<?= $insumo["ins_id"] ?>"><?= utf8_encode($insumo["ins_nome"]) ?></option>

                                    <?php

                                }
                            }

                            ?>

                        </select>
                        <div class="msg-erro text-danger"></div>
                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label class="font-weight-bold" for="insumo">Selecione o Motivo:</label>
                        <select <?= !empty($carregado) ? "disabled" : "" ?> name="motivo" class="form-control select2">
                            <option value="">Selecione</option>

                            <?php

                            if (!empty($todos_motivos)) {
                                foreach($todos_motivos as $mot) {

                                    ?>

                                    <option <?= (intval($id_motivo) === intval($mot["mot_id"])) ? "selected" : "" ?> value="<?= $mot["mot_id"] ?>"><?= utf8_encode($mot["mot_nome"]) ?></option>

                                    <?php

                                }
                            }

                            ?>

                        </select>
                        <div class="msg-erro text-danger"></div>
                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label class="font-weight-bold" for="qtde">Qtde Usada:</label>
                        <div class="input-group input-group-lg mb-3">
                            <input <?= !empty($carregado) ? "disabled" : "" ?> maxlength="6" type="text" class="form-control text-center mascara-dinheiro" value="<?= $qtde ?>" name="qtde" id="qtde" placeholder="0,00">

                            <div class="input-group-append">
                                <span class="input-group-text text-uppercase" id="sigla-uni">UN</span>
                            </div>

                        </div>
                        <div class="msg-erro text-danger"></div>
                        <p class="text-muted text-center">calculo qtde = 1,00 x 1 <span id="detalhe-uni" >UN</span></p>

                    </div>

                </div>

                <div class="col-12 mt-5">

                    <div class="form-group">

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

            </div>

        </form>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="titulo-card">
            Baixas no Uso dos insumos Cadastradas
        </h5>
    </div>
    <div class="card-body">

        <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">

            <div class="form-row">

                <div class="col-12">

                    <div class="form-group">

                        <div class="input-group">
                            <input type="text" class="form-control" name="filtro" placeholder="Procurar pelo nome do insumo ou do motivo..." value="<?= $filtro ?>">
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

                    <th class="text-center" >Data da baixa</th>
                    <th class="" >Insumo</th>
                    <th class="text-center" >Qtde</th>
                    <th class="" >Motivo</th>

                </tr>

                </thead>

                <tbody>

                <?php

                if (!empty($lista)) {
                    foreach ($lista as $bai) {

                        ?>

                        <tr>

                            <td class="text-center"><?= date("d/m/Y", strtotime($bai["bai_dtCad"])) ?></td>
                            <td><?= utf8_encode($bai["ins_nome"]) ?></td>
                            <td class="text-center" ><?= number_format($bai["bai_qtde"], 2 , ",", ".") ?></td>
                            <td><?= utf8_encode($bai["mot_nome"]) ?></td>

                        </tr>

                        <?php

                    }
                } else {
                    $naopagina = TRUE;

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

<?php include_once './rodape.php'; ?>
