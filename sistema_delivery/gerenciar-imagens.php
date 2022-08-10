<?php
$menu = "Configurações";
$submenu = "Gerenciar Imagens";
$dropArea = TRUE;

require_once 'topo.php';
include_once 'classes/Empresa.php';

$empresa = new Empresa();
$empresa->setId($_SESSION['_idEmpresa']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração

        $file_logo = $_FILES['imgLogo'];
        $file_favicon = $_FILES['imgFavicon'];

        if (empty($file_logo['name']) && empty($file_favicon['name'])) {
            $erroPersonalizado = true;
            $erroMensagem = "Nenhuma imagem enviada";
        } else {

            if (!empty($file_logo['name'])) {

                if (!empty($empresa->verificarImagem($file_logo))) {
                    $empresa->setFileLogo($file_logo);
                    $img_ok = true;
                }

            }

            if (!empty($file_favicon['name'])) {

                if (!empty($empresa->verificarImagem($file_favicon))) {
                    $empresa->setFileFavicon($file_favicon);
                    $img_ok = true;
                }

            }

            if (!empty($img_ok)) {

                if ($empresa->salvarImagens()) {
                    $sucessoPersonalizado = true;
                    $sucessoMensagem = "Imagem salva com sucesso";
                } else {
                    $erroPersonalizado = true;
                    $erroMensagem = $empresa->getRetorno();
                }

            } else {
                $erroPersonalizado = true;
                $erroMensagem = $empresa->getRetorno();
            }

        }

    }

}

$empresa->carregarImagens();

$imagem_logo =$empresa->getNomeLogo();
$imagem_favicon = $empresa->getNomeFavicon();

?>

<h2 class="titulo-pagina">Logo e Favicon do restaurante</h2>

<?php
include 'menssagens.php';
?>

<form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="col-12 col-md-6">

            <div class="form-group col-12 text-center">
                <label class="m-0"><strong>Logo do restaurante:</strong></label>
                <div class="droparea_container">

                    <div class="droparea text-center mt-3" id="drop1">
                        <?php
                        if(!empty($imagem_logo) && file_exists("../img/restaurantes/logos/" . $imagem_logo )){
                            ?>
                            <img class="img-fluid" src="../img/restaurantes/logos/<?= $imagem_logo . "?var=". rand ( 100 , 999 ) ?>" id="file_preview_1"> <br >
                            <?php
                        } else {
                            ?>
                            <img class="img-fluid" src="https://placehold.it/250x188" id="file_preview_1"> <br >
                            <?php
                        }
                        ?>
                        <span>Clique para procurar a imagem!</span>
                    </div>
                </div>
                <input type="file" name="imgLogo" id="file_1" style="display: none;" accept=".jpg,.png"> <!-- accept="image/jpeg" -->
            </div>

        </div>

        <div class="col-12 col-md-6">

            <div class="form-group col-12 text-center">
                <label class="m-0"><strong>Favicon do restaurante:</strong></label>
                <div class="droparea_container">

                    <div class="droparea text-center mt-3" id="drop2">
                        <?php
                        if(!empty($imagem_favicon) && file_exists("../img/restaurantes/favicon/" . $imagem_favicon )){
                            ?>
                            <img class="img-fluid" src="../img/restaurantes/favicon/<?= $imagem_favicon . "?var=". rand ( 100 , 999 ) ?>" id="file_preview_2"> <br >
                            <?php
                        } else {
                            ?>
                            <img class="img-fluid" src="https://placehold.it/250x188" id="file_preview_2"> <br >
                            <?php
                        }
                        ?>
                        <span>Clique para procurar a imagem!</span>
                    </div>
                </div>
                <input type="file" name="imgFavicon" id="file_2" style="display: none;" accept=".jpg,.png"> <!-- accept="image/jpeg" -->
            </div>

        </div>

        <div class="col-12">

            <div class="form-group my-4">

                <button type="submit" class="btn btn-outline-primary btn-lg pull-right" id="btnEnviar" name="btnEnviar">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    Confirmar
                </button>
                <a role="button" href="<?= $_SERVER["PHP_SELF"] ?>" class="btn btn-link btn-lg pull-right text-muted">
                    Cancelar
                </a>
                <div class="clearfix"></div>
            </div>

        </div>

    </div>

</form>

<?php
include 'rodape.php';
?>

