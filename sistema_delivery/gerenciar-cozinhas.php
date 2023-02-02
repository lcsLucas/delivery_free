<?php
$menu = "Configurações";
$submenu = "Categorias da Cozinha";
$multi_select = TRUE;

require_once 'topo.php';
include_once 'classes/Empresa.php';
include_once 'classes/CategoriaCozinhas.php';

$categoria = new CategoriaCozinhas();
$empresa = new Empresa();
$empresa->setId($_SESSION['_idEmpresa']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post

    if (filter_has_var(INPUT_POST, 'btnEnviar')) { // enviada do formulario de cadastro/alteração

        $array_categorias = array();
        if (filter_has_var(INPUT_POST, "sel_categorias")) {
            $array_categorias = array_filter($_POST["sel_categorias"]);
            $array_categorias = filter_var_array($array_categorias, FILTER_VALIDATE_INT);

            $empresa->setCategoriasEmpresa($array_categorias);

            if (!empty($empresa->inserir_categorias())) {
                $sucessoPersonalizado = true;
                $sucessoMensagem = "categorias relacionadas com sucesso";
                $array_categorias = array();
            } else {
                $erroPersonalizado = true;
                $erroMensagem = "Não foi possível relacionar as categorias com o restaurante, tente novamente";
            }
        }
    }
}

$array_categorias = $empresa->listarCategoriasId();
$todas_categorias = $categoria->listar_ativos_empresa($array_categorias);
$categorias_empresa = $empresa->listarCategorias();

?>

<h2 class="titulo-pagina">Informações do Restaurante</h2>

<?php
include 'menssagens.php';

?>

<div class="alert alert-info mb-4">
    <i class="fa fa-info-circle"></i> Atenção a ordem das categorias é importante. Sendo ordenadas pelas mais importantes
</div>

<form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <div class="form-row">

        <div class="form-group col-12">

            <select id="sel-categorias" name="sel_categorias[]" class="ms" multiple="multiple">

                <?php

                if (!empty($categorias_empresa)) {

                    foreach ($categorias_empresa as $cat_sel) {

                ?>

                        <option selected value="<?= $cat_sel['cat_id'] ?>"><?= $cat_sel['cat_nome'] ?></option>

                    <?php

                    }
                }

                if (!empty($todas_categorias)) {

                    foreach ($todas_categorias as $cat) {

                    ?>

                        <option value="<?= $cat['cat_id'] ?>"><?= $cat['cat_nome'] ?></option>

                <?php

                    }
                }

                ?>

            </select>

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

<?php
include 'rodape.php';
?>