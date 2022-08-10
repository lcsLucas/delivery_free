<?php
$menu = "Cadastros";
$submenu = "Gerenciar Fornecedores";
$dataTables = true;
$mask = true;
$select2 = true;
$datetimepicker = true;

include_once './topo.php';
require_once 'classes/Fornecedor.php';
require_once 'classes/Endereco.php';

$fornecedor = new Fornecedor();
$fornecedor->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]
$endereco = new Endereco();

$id = $id_end = $nome = $razao = $cnpj = $email = $telefone = $celular = $celular2 = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $id_end = filter_input(INPUT_POST, "codigo-end", FILTER_VALIDATE_INT);

        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
        $obs = trim(filter_input(INPUT_POST, "obs", FILTER_SANITIZE_SPECIAL_CHARS));
        $telefone = trim(filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_SPECIAL_CHARS));
        $celular = trim(filter_input(INPUT_POST, "celular", FILTER_SANITIZE_SPECIAL_CHARS));
        $celular2 = trim(filter_input(INPUT_POST, "celular2", FILTER_SANITIZE_SPECIAL_CHARS));
        $razao = trim(filter_input(INPUT_POST, "razao", FILTER_SANITIZE_SPECIAL_CHARS));
        $cnpj = trim(filter_input(INPUT_POST, "cnpj", FILTER_SANITIZE_SPECIAL_CHARS));

        $rua = trim(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_SPECIAL_CHARS));
        $numero = trim(filter_input(INPUT_POST, "txtNumero", FILTER_VALIDATE_INT));
        $bairro = trim(filter_input(INPUT_POST, "txtBairro", FILTER_SANITIZE_SPECIAL_CHARS));
        $cep = trim(filter_input(INPUT_POST, "txtCep", FILTER_SANITIZE_SPECIAL_CHARS));
        $id_estado = trim(filter_input(INPUT_POST, "selEstado", FILTER_VALIDATE_INT));
        $id_cidade = trim(filter_input(INPUT_POST, "selCidade", FILTER_VALIDATE_INT));

        if (empty($nome || empty($celular))) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {

            $fornecedor->setNome($nome);
            $fornecedor->setEmail($email);
            $fornecedor->setObs($obs);
            $fornecedor->setTelefone($telefone);
            $fornecedor->setFone($celular);
            $fornecedor->setFone2($celular2);
            $fornecedor->setAtivo(1);
            $fornecedor->setRazao($razao);
            $fornecedor->setCnpj($cnpj);

            $endereco->setRua($rua);
            $endereco->setNumero($numero);
            $endereco->setBairro($bairro);
            $endereco->setCep($cep);
            $endereco->getCidade()->setId($id_cidade);
            $endereco->getCidade()->getEstado()->setSigla($id_estado);

            $fornecedor->setEndereco($endereco);

            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $fornecedor->setId($id);
                $fornecedor->getEndereco()->setId($id_end);

                if ($fornecedor->alterar()) {
                    $sucessoalterar = TRUE;
                    $id = $id_end = $nome = $razao = $cnpj = $email = $telefone = $celular = $celular2 = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }

            } else {
                if ($fornecedor->inserir()) {
                    $sucessoinserir = TRUE;
                    $id = $id_end = $nome = $razao = $cnpj = $email = $telefone = $celular = $celular2 = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";
                } else {
                    $erroinserir = TRUE;
                }
            }
        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $fornecedor->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

        if ($fornecedor->carregar()) {

            $id = $fornecedor->getId();
            $id_end = $fornecedor->getEndereco()->getId();

            $nome = $fornecedor->getNome();
            $email = $fornecedor->getEmail();
            $obs = $fornecedor->getObs();
            $telefone = $fornecedor->getTelefone();
            $celular = $fornecedor->getFone();
            $celular2 = $fornecedor->getFone2();
            $razao = $fornecedor->getRazao();
            $cnpj = $fornecedor->getCnpj();

            $rua = $fornecedor->getEndereco()->getRua();
            $bairro = $fornecedor->getEndereco()->getBairro();
            $numero = $fornecedor->getEndereco()->getNumero();
            $cep = $fornecedor->getEndereco()->getCep();
            $id_estado = $fornecedor->getEndereco()->getCidade()->getEstado()->getSigla();
            $id_cidade = $fornecedor->getEndereco()->getCidade()->getId();

            $carregado = true;
        }

    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $fornecedor->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

        if($fornecedor->excluir()) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $fornecedor->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

        if($fornecedor->modificaAtivo()) {
            $sucessoPersonalizado = TRUE;
            $sucessoMensagem = "Ao Alterar o Status do Fornecedor!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Alterar Status do Fornecedor!";
        }
    }
}


$lista_estados = $endereco->getCidade()->getEstado()->listar();
$lista_cidades = $endereco->getCidade()->listar();

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
$num_rows = $fornecedor->quantidadeRegistros($filtro);
$lista = $fornecedor->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

    <h2 class="titulo-pagina">Gerenciar Fornecedores</h2>

<?php
include 'menssagens.php';
?>

    <div class="card">
        <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
            <h5 class="titulo-card">
                <?= empty($carregado) ? "Cadastrar Novo Fornecedor" : "Alterar o Fornecedor <q>$nome</q>" ?>
            </h5>
        </div>
        <div class="card-body">
            <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="codigo" value="<?= $id ?>" />
                <input type="hidden" name="codigo-end" value="<?= $id_end ?>" />
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="nome">Nome da Empresa<span class="obrigatorio">*</span>:</label>
                        <input type="text" class="form-control" value="<?= $nome ?>" id="nome" name="nome" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" value="<?= $email ?>" id="email" name="email">
                    </div>
                    <div class="form-group col-6">
                        <label for="nome">Razão Social:</label>
                        <input type="text" class="form-control" value="<?= $razao ?>" id="razao" name="razao">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">CNPJ:</label>
                        <input type="tel" class="form-control mascara-cnpj" placeholder="__.___.___/____-__" value="<?= $cnpj ?>" id="cnpj" name="cnpj">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="validationCustomUsername">Telefone:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" ><i class="fa fa-phone" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control mascara-telefone" id="telefone"name="telefone" value="<?= $telefone ?>" placeholder="(__) _____-____" aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="validationCustomUsername">Celular:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" ><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control mascara-celular" id="celular" name="celular" value="<?= $celular ?>" placeholder="(__) _____-____" aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="validationCustomUsername">Celular 2:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" ><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control mascara-celular" id="celular2" name="celular2" value="<?= $celular2 ?>" placeholder="(__) _____-____" aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="obs"><strong>Observação</strong>: </label><br>
                        <textarea name="obs" id="obs" rows="5" class="form-group w-100"><?= $obs ?></textarea>
                    </div>
                    <div class="form-group col-12">
                        <hr>
                        <h3><strong>Endereço</strong></h3>
                    </div>

                    <div class="col-12 col-md-9 col-lg-6">
                        <div class="form-group">
                            <label class="control-label" for="txtRua">Rua <span class="obrigatorio">*</span>:</label>
                            <input type="text" id="txtRua" name="txtRua" maxlength="200" class="form-control" required value="<?= $rua ?>" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                        <div class="form-group">
                            <label class="control-label" for="txtNumero">Nº <span class="obrigatorio">*</span>:</label>
                            <input type="tel" id="txtNumero" name="txtNumero" aria-describedby="help-numero" class="form-control mascara-numero" required value="<?= $numero ?>" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="txtCep">CEP <span class="obrigatorio">*</span>:</label>
                            <input type="tel" id="txtCep" name="txtCep" class="form-control mascara-cep" required value="<?= $cep ?>" />
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="txtBairro">Bairro <span class="obrigatorio">*</span>:</label>
                            <input type="text" id="txtBairro" name="txtBairro" maxlength="100" class="form-control" required value="<?= $bairro ?>" />
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="txtEstado">Estado <span class="obrigatorio">*</span>:</label>
                            <select class="form-control" name="selEstado" id="selEstado" disabled>
                                <?php
                                foreach ($lista_estados as $estado) {
                                    ?>
                                    <option value="<?= $estado['est_sigla'] ?>"><?= utf8_encode($estado['est_nome']) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="selCidade">Cidade <span class="obrigatorio">*</span>:</label>
                            <select class="form-control select2" name="selCidade" id="selCidade" required>
                                <?php

                                foreach ($lista_cidades as $result_cidade) {
                                    ?>
                                    <option value="<?= $result_cidade['cid_id'] ?>" <?= (utf8_encode($result_cidade['cid_id']) == $id_cidade ? "selected" : "") ?> ><?= utf8_encode($result_cidade['cid_nome']) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="help-block with-errors"></div>
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
                Fornecedores Cadastrados
            </h5>
        </div>
        <div class="card-body">

            <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
                <div class="form-row">

                    <div class="col-10">

                        <div class="form-group">
                            <label for="filtro">Buscar pelo Fornecedor:</label>
                            <input type="text" class="form-control" placeholder="Procurar pelo nome ou email..." name="filtro" value="<?= $filtro ?>">
                        </div>

                    </div>

                    <div class="col-2 text-center">

                        <label for="" class="d-block invisible">botao</label>

                        <div class="form-group">

                            <button type="submit" name="buscar" class="btn btn-primary mb-2"><i class="fa fa-search"></i> BUSCAR</button>

                        </div>


                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-striped table-hover dataTable" >
                    <thead>
                    <tr>
                        <th>Nome do Fornecedor</th>
                        <th>Email</th>
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
                                <td><?= utf8_encode($result["for_nome"]) ?></td>
                                <td><?= utf8_encode($result["for_email"]) ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['for_id'] ?>" />
                                        <?php
                                        if ($result['for_ativo']) {
                                            ?>
                                            <button type="submit" title="Clique para Desativar o Fornecedor" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" title="Clique para Ativar o Fornecedor" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['for_id'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Fornecedr" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Fornecedor">
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