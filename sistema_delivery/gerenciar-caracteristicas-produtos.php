<?php
$menu = "Características dos Itens";
$submenu = "Características de Produtos";
$dataTables = true;
$mask = true;

include_once 'topo.php';
require_once './classes/CategoriaCaracteristicas.php';
require_once './classes/Caracteristica.php';

$id_grupo = $id = $nome = $valor = "";

$grupo_carc = new CategoriaCaracteristicas();
$caracteristica = new Caracteristica();
$caracteristica->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $id_grupo = filter_input(INPUT_POST, "id_grupo", FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $valor = filter_input(INPUT_POST, "valor", FILTER_SANITIZE_SPECIAL_CHARS);

        $valor = str_replace(".","",$valor);
        $valor = str_replace(",",".",$valor);

        if (empty($nome) || empty($id_grupo) || empty($valor)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $caracteristica->setNome($nome);
            $caracteristica->setValorAdicional($valor);
            $caracteristica->setIdTipo($id_grupo);
            $caracteristica->setAtivo(1);
            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $caracteristica->setId($codigo);
                if($caracteristica->alterar()){
                    $sucessoalterar = TRUE;
                    $id_grupo = $id = $nome = $valor = "";
                }else{
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                if($caracteristica->inserir()){
                    $sucessoinserir = TRUE;
                    $id_grupo = $id = $nome = $valor = "";
                }else{
                    $erroinserir = TRUE;
                }
            }
        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $caracteristica->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if (!empty($caracteristica->carregar())) {

            $id = $caracteristica->getId();
            $nome = $caracteristica->getNome();
            $valor = $caracteristica->getValorAdicional();
            $id_grupo = $caracteristica->getIdTipo();

            $carregado = true;
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Carregar os dados do Complemento";
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $caracteristica->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

        if ($caracteristica->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }

    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $caracteristica->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($caracteristica->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status do complemento!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status do complemento";
        }
    }
}

$todos_grupo = $grupo_carc->listar();

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
$num_rows = $caracteristica->quantidadeRegistros($filtro);
$lista = $caracteristica->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

<h2 class="titulo-pagina">Gerenciar Complementos de Produtos</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Novo Complemento" : "Alterar Complemento <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?php echo $id; ?>" >
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="tipo"><strong>Grupo Característica<span class="obrigatorio">*</span></strong>:</label>

                        <select id="id_grupo" name="id_grupo" class="form-control" required>
                            <option value="">Selecione uma Opção</option>
                            <?php

                            if (!empty($todos_grupo))
                            foreach ($todos_grupo as $rs){
                                ?>
                                <option <?php if($rs["tip_id"] == $id_grupo) { echo "selected"; } ?> value="<?php echo $rs["tip_id"]; ?>">
                                    <?php echo utf8_encode($rs["tip_nome"]); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>

                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>Nome <span class="obrigatorio">*</span></strong>: </label>
                    <input name="nome" value="<?php echo $nome; ?>" type="text" class="form-control" required>
                </div>
                <div class="form-group col-12 col-sm-6">

                    <label for="basic-url">Valor Adicional <span class="obrigatorio">*</span>: </label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input name="valor" value="<?php echo $valor; ?>" maxlength="10" type="text" class="form-control mascara-dinheiro" required>
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
            Complementos Cadastrados
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable">
                <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Nome</th>
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
                            <td><?= utf8_encode($result["tip_nome"]) ?></td>
                            <td><?= utf8_encode($result["car_nome"]) ?></td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $result['car_id'] ?>" />
                                    <?php
                                    if ($result['car_ativo']) {
                                        ?>
                                        <button type="submit" title="Clique para Desativar o Complemento" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" title="Clique para Ativar o Complemento" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $result['car_id'] ?>" />
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar Complemento" name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Complemento">
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

