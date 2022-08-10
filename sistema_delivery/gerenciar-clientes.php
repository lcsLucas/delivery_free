<?php
    $menu = "Cadastros";
    $submenu = "Gerenciar Clientes";
    $dataTables = true;
    $mask = true;
    $select2 = true;
    $datetimepicker = true;

    include_once './topo.php';
    require_once 'classes/Cliente.php';
    require_once 'classes/Endereco.php';

    $cliente = new Cliente();
    $cliente->setIdEmpresa($_SESSION["_idEmpresa"]);//$_SESSION["_idEmpresa"]
    $endereco = new Endereco();

    $id = $id_end = $nome = $email = $telefone = $celular = $celular2 = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
        if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
            $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
            $id_end = filter_input(INPUT_POST, "codigo-end", FILTER_VALIDATE_INT);

            $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
            $email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
            $obs = trim(filter_input(INPUT_POST, "obs", FILTER_SANITIZE_SPECIAL_CHARS));
            $telefone = trim(filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_SPECIAL_CHARS));
            $celular = trim(filter_input(INPUT_POST, "celular", FILTER_SANITIZE_SPECIAL_CHARS));
            $celular2 = trim(filter_input(INPUT_POST, "celular2", FILTER_SANITIZE_SPECIAL_CHARS));


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

                $cliente->setNome($nome);
                $cliente->setEmail($email);
                $cliente->setObs($obs);
                $cliente->setTelefone($telefone);
                $cliente->setFone($celular);
                $cliente->setFone2($celular2);
                $cliente->setAtivo(1);

                $endereco->setRua($rua);
                $endereco->setNumero($numero);
                $endereco->setBairro($bairro);
                $endereco->setCep($cep);
                $endereco->getCidade()->setId($id_cidade);
                $endereco->getCidade()->getEstado()->setSigla($id_estado);

                $cliente->setEndereco($endereco);

                if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                    $cliente->setId($id);
                    $cliente->getEndereco()->setId($id_end);

                    if ($cliente->alterar()) {
                        $sucessoalterar = TRUE;
                        $id = $id_end = $nome = $email = $telefone = $celular = $celular2 = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";
                    } else {
                        $erroalterar = TRUE;
                        $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                    }

                } else {
                    if ($cliente->inserir()) {
                        $sucessoinserir = TRUE;
                        $id = $id_end = $nome = $email = $telefone = $celular = $celular2 = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = "";
                    } else {
                        $erroinserir = TRUE;
                    }
                }
            }

        } else if (filter_has_var(INPUT_POST, "editar")) {
            $cliente->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

            if ($cliente->carregar()) {

                $id = $cliente->getId();
                $id_end = $cliente->getEndereco()->getId();

                $nome = $cliente->getNome();
                $email = $cliente->getEmail();
                $obs = $cliente->getObs();
                $telefone = $cliente->getTelefone();
                $celular = $cliente->getFone();
                $celular2 = $cliente->getFone2();

                $rua = $cliente->getEndereco()->getRua();
                $bairro = $cliente->getEndereco()->getBairro();
                $numero = $cliente->getEndereco()->getNumero();
                $cep = $cliente->getEndereco()->getCep();
                $id_estado = $cliente->getEndereco()->getCidade()->getEstado()->getSigla();
                $id_cidade = $cliente->getEndereco()->getCidade()->getId();

                $carregado = true;
            }

        } else if (filter_has_var(INPUT_POST, "deletar")) {
            $cliente->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

            if($cliente->excluir()) {
                $sucessodeletar = TRUE;
            } else {
                $errodeletar = TRUE;
            }
        } else if (filter_has_var(INPUT_POST, "alterar-status")) {
            $cliente->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

            if($cliente->modificaAtivo()) {
                $sucessoPersonalizado = TRUE;
                $sucessoMensagem = "Ao Alterar o Status do Cliente!";
            } else {
                $erroPersonalizado = true;
                $erroMensagem = "Ao Alterar Status do Cliente!";
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
    $num_rows = $cliente->quantidadeRegistros($filtro);
    $lista = $cliente->listarPaginacao($filtro,$offset,$entries_per_page);

    $total_pages = ceil($num_rows / $entries_per_page);
    $pagination = pagination_six($total_pages, $page,$parametros);

?>

    <h2 class="titulo-pagina">Gerenciar Clientes</h2>

    <?php
    include 'menssagens.php';
    ?>

    <div class="card">
        <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
            <h5 class="titulo-card">
                <?= empty($carregado) ? "Cadastrar Novo Cliente" : "Alterar o Cliente <q>$nome</q>" ?>
            </h5>
        </div>
        <div class="card-body">
            <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="codigo" value="<?= $id ?>" />
                <input type="hidden" name="codigo-end" value="<?= $id_end ?>" />
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="nome">Nome <span class="obrigatorio">*</span>:</label>
                        <input type="text" class="form-control" value="<?= $nome ?>" id="nome" name="nome">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" value="<?= $email ?>" id="email" name="email">
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
                      <label for="validationCustomUsername">Celular <span class="obrigatorio">*</span>:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" ><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" class="form-control mascara-celular" id="celular" name="celular" value="<?= $celular ?>" placeholder="(__) _____-____" aria-describedby="inputGroupPrepend" required>
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
            Clientes Cadastrados
        </h5>
    </div>
    <div class="card-body">

        <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
            <div class="form-row">

                <div class="col-10">

                    <div class="form-group">
                        <label for="filtro">Buscar pelo Cliente:</label>
                        <input type="text" class="form-control" placeholder="Procurar pelo nome ou email..." name="filtro" value="<?= $filtro ?>">
                    </div>

                </div>

                <div class="col-2 text-center">

                    <label class="d-block invisible" for="">Botão</label>
                    <button type="submit" name="buscar" class="btn btn-primary mt-auto"><i class="fa fa-search"></i> BUSCAR</button>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-striped table-hover dataTable" >
                <thead>
                <tr>
                    <th>Nome do Cliente</th>
                    <th>Celular</th>
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
                            <td><?= utf8_encode($result["cli_nome"]) ?></td>
                            <td><?= utf8_encode($result["cli_celular"]) ?></td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $result['cli_id'] ?>" />
                                    <?php
                                    if ($result['cli_ativo']) {
                                        ?>
                                        <button type="submit" title="Clique para Desativar o Cliente" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" title="Clique para Ativar o Cliente" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $result['cli_id'] ?>" />
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar Cliente" name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Cliente">
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