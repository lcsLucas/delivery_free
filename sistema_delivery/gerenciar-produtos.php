<?php
$menu = "Produtos";
$submenu = "Gerenciar Produtos";
$dropArea = TRUE;
$mask = true;
$select2 = true;

require_once 'topo.php';
require_once 'classes/Produto.php';
require_once 'classes/UnidadeMedida.php';
require_once 'classes/CategoriaProdutos.php';
require_once 'classes/Fornecedor.php';

$unidade_medida = new UnidadeMedida();
$categoria_Produtos = new CategoriaProdutos();
$categoria_Produtos->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$produto = new Produto();
$produto->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$fornecedor = new Fornecedor();
$fornecedor->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

$id = $nome = $obs = $id_medida = $id_categoria = $id_fornecedor = $flag_estoque = $custo = $valor = $imagem = $file_imagem = "";
$array_idcat = array();
$array_cat = array();
$array_obg = array();
$array_min = array();
$array_max = array();
$array_complementos = array();
$array_complementos_cat = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        $obs = trim(filter_input(INPUT_POST, "obs", FILTER_SANITIZE_SPECIAL_CHARS));
        $custo = trim(filter_input(INPUT_POST, "custo", FILTER_SANITIZE_SPECIAL_CHARS));
        $valor = trim(filter_input(INPUT_POST, "valor", FILTER_SANITIZE_SPECIAL_CHARS));
        $flag_estoque = !empty(filter_has_var(INPUT_POST, "controle")) ? 1 : 0;
        $id_categoria = filter_input(INPUT_POST, "selCategoria", FILTER_VALIDATE_INT);
        $id_fornecedor = filter_input(INPUT_POST, "selFornecedor", FILTER_VALIDATE_INT);
        $id_medida = filter_input(INPUT_POST, "selMedida", FILTER_VALIDATE_INT);

        $file_imagem = $_FILES['imgproduto'];

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
            $array_min = filter_var_array($array_min, FILTER_VALIDATE_BOOLEAN);
        }

        if (filter_has_var(INPUT_POST, "max_cat")) {
            $array_max = array_filter($_POST["max_cat"]);
            $array_max = filter_var_array($array_max, FILTER_SANITIZE_STRING);
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

        if (!empty($file_imagem['name'])) {

            if (!empty($produto->verificarImagem($file_imagem))) {
                $produto->setFileImagem($file_imagem);
                $img_ok = true;
            } else {
                $erroPersonalizado = true;
                $erroMensagem = $produto->getRetorno();
            }

        } else
            $img_ok = true;

        if (!empty($img_ok)) {

            $valor2 = str_replace(".","",$valor);
            $valor2 = str_replace(",",".",$valor2);

            $custo2 = str_replace(".","",$custo);
            $custo2 = str_replace(",",".",$custo2);

            if (empty($nome) || empty($id_categoria) || empty($id_medida)) {
                $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                $erroCamposVazios = true;
            } else {
                $produto->setNome($nome);
                $produto->setObs($obs);
                $produto->setControleEstoque($flag_estoque);
                $produto->setCusto($custo2);
                $produto->setPreco($valor2);
                $produto->setIdCategoria($id_categoria);
                $produto->setIdFornecedor($id_fornecedor);
                $produto->setIdUnidade($id_medida);
                $produto->setAtivo(1);
                $produto->setComplementos($array_complementos);

                if (filter_has_var(INPUT_POST, "editar")) {
                    $produto->setId($id);

                    if ($produto->alterar()) {
                        $sucessoalterar = TRUE;
                        $id = $nome = $obs = $id_medida = $id_categoria = $id_fornecedor = $flag_estoque = $custo = $valor = $imagem = $file_imagem = "";
                        $array_complementos= array();
                    } else {
                        $erroalterar = TRUE;
                        $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                    }
                } else {
                    if ($produto->inserir()) {
                        $sucessoinserir = TRUE;
                        $id = $nome = $obs = $id_medida = $id_categoria = $id_fornecedor = $flag_estoque = $custo = $valor = $imagem = $file_imagem = "";
                        $array_complementos= array();
                    } else {
                        $erroinserir = TRUE;
                    }
                }

            }

        }


    } else if (filter_has_var(INPUT_POST, "editar")) {
        $produto->setId(SQLinjection(filter_input(INPUT_POST, "acao-codigo", FILTER_VALIDATE_INT)));
        if ($produto->carregar()) {
            $id = $produto->getId();
            $nome = $produto->getNome();
            $obs = $produto->getObs();
            $flag_estoque = $produto->getControleEstoque();
            $custo = $produto->getCusto();
            $valor = $produto->getPreco();
            $id_categoria = $produto->getIdCategoria();
            $id_fornecedor = $produto->getIdFornecedor();
            $id_medida = $produto->getIdUnidade();
            $imagem = $produto->getNomeImagem();

            $array_complementos = $produto->getComplementos();

            $categoria_Produtos->setId($id_categoria);
            $array_complementos_cat = $categoria_Produtos->carregar_complementos();

            $carregado = true;
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $produto->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if($produto->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $produto->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($produto->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status do Produto!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status do Produto!";
        }
    }
}

$todas_medidas = $unidade_medida->listar();
$todas_categoria = $categoria_Produtos->listar();
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
$num_rows = $produto->quantidadeRegistros($filtro);
$lista = $produto->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Gerenciar Produtos</h2>

<?php
include 'menssagens.php';
?>

    <div class="card">
        <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
            <h5 class="titulo-card">
                <?= empty($carregado) ? "Cadastrar Novo Produto" : "Alterar o Produto <q>$nome</q>" ?>
            </h5>
        </div>
        <div class="card-body">

            <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="codigo" value="<?= $id ?>" />
                <div class="form-row">

                    <div class="form-group col-sm-8 col-12 input-group-lg">
                        <label for="nome">Nome <span class="obrigatorio">*</span>:</label>
                        <input type="text" class="form-control" value="<?= $nome ?>" id="nome" name="nome" required>
                    </div>

                    <div class="form-group col-12 col-sm-4">

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
                            <label class="control-label" for="selCidade">Categoria do Produto <span class="obrigatorio">*</span>:</label>
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
                            <label class="control-label" for="selCidade">Fornecedor do Produto <sup class="text-muted">(Opcional)</sup>:</label>
                            <select class="form-control select2" name="selFornecedor" id="selFornecedor">
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

                    <div class="col-12 col-sm-6">

                        <div class="form-group">

                            <label for="basic-url">Preço de Custo <span class="obrigatorio">*</span>: </label>
                            <div class="input-group mb-3 input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="text" class="form-control mascara-dinheiro" maxlength="10" name="custo" value="<?= $custo ?>" required>
                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-sm-6">

                        <div class="form-group">

                            <label for="basic-url">Preço de Venda <span class="obrigatorio">*</span>: </label>
                            <div class="input-group mb-3 input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="text" class="form-control mascara-dinheiro" maxlength="10" name="valor" value="<?= $valor ?>" required>
                            </div>

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
                        <label for="obs"><strong>Descrição</strong>: </label><br>
                        <textarea name="obs" id="obs" rows="5" class="form-group w-100"><?= $obs ?></textarea>
                    </div>

                    <div class="form-group col-12 text-center">
                        <label for="obs"><strong>Imagem do Produto</strong>: </label>
                        <div class="droparea_container">

                            <div class="droparea text-center" id="drop1">
                                <?php
                                if(!empty($carregado) && !empty($imagem) && file_exists("../img/restaurantes/produtos/" . $imagem )){
                                    ?>
                                    <img class="img-fluid" src="../img/restaurantes/produtos/<?= $imagem . "?var=". rand ( 100 , 999 ) ?>" id="file_preview_1"> <br >
                                    <?php
                                } else if(!empty($carregado) && !empty($imagem)){
                                    ?>
                                    <img class="img-fluid" src="<?= $imagem ?>" id="file_preview_1"> <br >
                                    <?php
                                } else {
                                    ?>
                                    <img class="img-fluid" src="https://placehold.it/450x338" id="file_preview_1"> <br >
                                    <?php
                                }
                                ?>
                                <span>Clique para procurar a imagem!</span>
                            </div>
                        </div>
                        <input type="file" name="imgproduto" id="file_1" style="display: none;" accept=".jpg,.png"> <!-- accept="image/jpeg" -->
                    </div>

                    <?php

                    if (!empty($array_complementos_cat)) {

                        ?>

                        <div id="complemento-cat-roduto" class="col-12">

                            <div class="form-group col-12">
                                <hr>
                                <h4 class="text-center text-muted text-uppercase"><strong>Complementos da Categoria do Produto</strong></h4>
                            </div>

                            <div class="col-12">

                                <?php

                                    foreach ($array_complementos_cat as $comp) {

                                        $unique = $comp['catcom_id'];

                                        ?>

                                        <div class="complemento" style="display:none; position:relative; border: 1px solid #CCC;background: #EEE; border-radius: 2px; margin-bottom: 20px; padding: 20px 15px;">

                                            <div class="row">

                                                <div class="col-sm-12 col-md-6">

                                                    <div class="form-group">

                                                        <label for="cat-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Categoria do Complemento:</label>
                                                        <input disabled title="Você não pode editar o complemento da categoria desse produto" value="<?= utf8_encode($comp['catcom_nome']) ?>" id="cat-<?= $unique ?>" type="text" class="form-control form-control-sm"  required>
                                                    </div>

                                                </div>

                                                <div class="col-sm-12 col-md-2 text-center">

                                                    <label for="obg-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Obrigatório</label>
                                                    <input id="obg-<?= $unique ?>" disabled title="Você não pode editar o complemento da categoria desse produto" <?= !empty($comp['catcom_obrigatorio']) ? 'checked' : '' ?> class="form-control checkbox" type="checkbox" value="1">

                                                </div>

                                                <div class="col-sm-12 col-md-2 text-center">

                                                    <div class="form-group form-control-sm">

                                                        <label for="min-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Qtde Min</label>
                                                        <input id="min-<?= $unique ?>" disabled title="Você não pode editar o complemento da categoria desse produto" value="<?= !empty($comp['catcom_obrigatorio']) && empty($comp['catcom_qtdemin']) ? 1 : $comp['catcom_qtdemin'] ?>" type="text" class="form-control form-control-sm text-center" >

                                                    </div>

                                                </div>

                                                <div class="col-sm-12 col-md-2 text-center">

                                                    <div class="form-group form-control-sm">

                                                        <label for="max-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;" >Qtde Max</label>
                                                        <input id="max-<?= $unique ?>" disabled title="Você não pode editar o complemento da categoria desse produto" value="<?= $comp['catcom_qtdemax'] ?>" maxlength="3" type="text" class="form-control form-control-sm text-center" >

                                                    </div>

                                                </div>

                                                <div class="col-sm-12">

                                                    <hr>

                                                </div>

                                                <div class="col-sm-12">

                                                    <div class="wrapper-opcoes">

                                                        <h6 class="text-center text-muted text-uppercase"><strong>Opções do complemento</strong></h6>

                                                        <?php

                                                        if (!empty($comp['opcoes'])) {

                                                            foreach ($comp['opcoes'] as $opcao) {

                                                                ?>

                                                                <div class="row opcoes-complementos">

                                                                    <div class="col-sm-12 col-md-5">

                                                                        <div class="form-group">

                                                                            <label for="nome-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Nome:</label>
                                                                            <input id="nome-<?= $unique ?>" value="<?= utf8_encode($opcao['nome']) ?>" disabled title="Você não pode editar o complemento da categoria desse produto" type="text" class="form-control form-control-sm">
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-sm-12 col-md-5">

                                                                        <div class="form-group">

                                                                            <label for="descr-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Descrição:</label>
                                                                            <input id="descr-<?= $unique ?>" value="<?= utf8_encode($opcao['descricao']) ?>" disabled title="Você não pode editar o complemento da categoria desse produto" type="text" class="form-control form-control-sm" >

                                                                        </div>

                                                                    </div>

                                                                    <div class="col-sm-12 col-md-2 text-center">

                                                                        <div class="form-group form-control-sm">

                                                                            <label for="preco-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Preço</label>
                                                                            <input id="preco-<?= $unique ?>" value="<?= number_format($opcao['preco'], 2, ',', '.') ?>" disabled title="Você não pode editar o complemento da categoria desse produto" type="text" class="form-control form-control-sm text-center" >

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <?php

                                                            }

                                                        }

                                                        ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }

                                ?>

                                <div class="text-center">
                                    <button id="exibir_ocultar_complemento" class="btn btn-primary btn-sm">Exibir / Ocultar</button>
                                </div>


                            </div>

                        </div>

                        <?php

                    }

                    ?>

                    <div class="col-12">

                        <div class="form-group col-12">
                            <hr>
                            <h4 class="text-center text-muted text-uppercase"><strong>Complementos do Produto</strong></h4>
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
                                                        <input autofocus maxlength="255" name="cat_complementos[]" value="<?= utf8_encode($comp['catcom_nome']) ?>" id="cat-<?= $unique ?>" type="text" class="form-control form-control-sm"  required>
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
                                                        <input id="min-<?= $unique ?>" name="min_cat[]" value="<?= !empty($comp['catcom_obrigatorio']) && empty($comp['catcom_qtdemin']) ? 1 : $comp['catcom_qtdemin'] ?>" maxlength="3" type="text" class="form-control form-control-sm text-center mascara-numero" >

                                                    </div>

                                                </div>

                                                <div class="col-sm-12 col-md-2 text-center">

                                                    <div class="form-group form-control-sm">

                                                        <label for="max-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;" >Qtde Max</label>
                                                        <input id="max-<?= $unique ?>" name="max_cat[]" value="<?= $comp['catcom_qtdemax'] ?>" maxlength="3" type="text" class="form-control form-control-sm text-center mascara-numero" >

                                                    </div>

                                                </div>

                                                <div class="col-sm-12">

                                                    <hr>

                                                </div>

                                                <div class="col-sm-12">

                                                    <div class="wrapper-opcoes">

                                                        <h6 class="text-center text-muted text-uppercase"><strong>Opções do complemento</strong></h6>

                                                        <?php

                                                        if (!empty($comp['opcoes'])) {

                                                            foreach ($comp['opcoes'] as $opcao) {

                                                                ?>

                                                                <div class="row opcoes-complementos">

                                                                    <div class="col-sm-12 col-md-4">

                                                                        <div class="form-group">

                                                                            <label for="nome-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Nome:</label>
                                                                            <input id="nome-<?= $unique ?>" value="<?= utf8_encode($opcao['nome']) ?>" name="nome_idcomp_<?= $unique ?>[]" maxlength="255" type="text" class="form-control form-control-sm" required>
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-sm-12 col-md-4">

                                                                        <div class="form-group">

                                                                            <label for="descr-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Descrição:</label>
                                                                            <input id="descr-<?= $unique ?>" value="<?= utf8_encode($opcao['descricao']) ?>" name="descr_idcomp_<?= $unique ?>[]" type="text" class="form-control form-control-sm" >

                                                                        </div>

                                                                    </div>

                                                                    <div class="col-sm-12 col-md-2 text-center">

                                                                        <div class="form-group form-control-sm">

                                                                            <label for="preco-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Preço</label>
                                                                            <input id="preco-<?= $unique ?>" value="<?= number_format($opcao['preco'], 2, ',', '.') ?>" name="preco_idcomp_<?= $unique ?>[]" type="text" maxlength="6" class="form-control form-control-sm mascara-dinheiro text-center" >

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
                Produtos Cadastrados
            </h5>
        </div>
        <div class="card-body">

            <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
                <div class="form-row">

                    <div class="col-12">

                        <div class="form-group">

                            <div class="input-group">
                                <input type="text" class="form-control" name="filtro" placeholder="Procurar pelo nome do produto ou categoria..." value="<?= $filtro ?>">
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

                <table class="table table-striped table-hover" >
                    <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Nome</th>
                        <th>Preço de Venda</th>
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
                                <td><?= utf8_encode($result["pro_nome"]) ?></td>
                                <td><?= number_format($result["pro_valor"], 2, ",", ".") ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['pro_id'] ?>" />
                                        <?php
                                        if ($result['pro_ativo']) {
                                            ?>
                                            <button type="submit" title="Clique para Desativar o Produto" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" title="Clique para Ativar o Produto" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['pro_id'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Produto" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Produto">
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
