<?php
include_once "topo.php";
include_once "./sistema_delivery/classes/Cliente.php";
include_once "./sistema_delivery/classes/Cidade.php";

if (empty($_SESSION["_idcliente"])) {
    header('Location: ' . $baseurl . 'login');
    exit;
}

$cidade = new Cidade();

$cliente = new Cliente();
$cliente->setId($_SESSION["_idcliente"]);
$mask = true;
$validation = true;
$alert_zebra = true;

$id_cidade = 1;
$todas_cidades = $cidade->listar();
$todos_endereco = $cliente->listarEnderecosSite();
$page = 2;
?>

<div class="container my-5">

    <?php

    if (filter_has_var(INPUT_GET, 'continuar-pedido')) {

    ?>

        <div class="alert alert-info mb-5 text-center">
            <i class="fas fa-fw fa-info-circle"></i> Atenção! Por favor cadastre seu endereço para continuar o pedido. Após cadastrar seu endereço, você será levado de volta para o pedido
        </div>

    <?php

    }

    ?>

    <div class="row">

        <div class="col-12 col-md-3">

            <?php
            include_once 'sidebar-cliente.php';
            ?>

        </div>

        <div class="col-12 col-md-9">

            <div class="mb-5" id="cadastro-endereco">

                <header class="mb-3">

                    <h2 id="titulo-pagina" class="text-center">
                        Novo Endereço
                        <hr>
                    </h2>

                </header>

                <div id="efeito">

                    <div id="dados-cep" class="mt-4 container-fluid">

                        <form id="verifica-cep">

                            <div class="row">

                                <div class="col-sm-12 col-md-9">
                                    <div class="form-group m-0">
                                        <label for="input-busca-cep">Qual o seu CEP?</label>
                                        <input required type="text" class="form-control mascara-cep input-lg valida-cep" placeholder="_____-___" name="input-busca-cep" id="input-busca-cep">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3 d-flex align-items-end justify-content-end">
                                    <div class="form-group m-0">
                                        <button class="btn bg-cor-principal text-white btn-lg text-uppercase btnCep" type="submit">Prosseguir</button>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>

                    <div id="dados-endereco" class="container-fluid">

                        <form id="add-endereco" action="">

                            <div class="row">

                                <div class="col-12">

                                    <div class="form-group">
                                        <label class="control-label" for="descricao">Descrição <sup class="text-danger">*</sup>:</label>
                                        <input id="descricao" name="descricao" tabindex="1" maxlength="30" placeholder="exemplo: casa, trabalho..." class="form-control" required value="" type="text">
                                    </div>

                                </div>

                                <div class="col-12 col-md-9 col-lg-6">

                                    <div class="form-group">
                                        <label class="control-label" for="rua">Rua <sup class="text-danger">*</sup>:</label>
                                        <input id="rua" name="rua" maxlength="200" class="form-control" required value="" type="text">
                                    </div>

                                </div>

                                <div class="col-12 col-sm-4 col-md-3 col-lg-2">

                                    <div class="form-group">
                                        <label class="control-label" for="numero">Nº <sup class="text-danger">*</sup>:</label>
                                        <input id="numero" name="numero" autocomplete="off" tabindex="2" class="form-control mascara-numero text-center font-weight-bold" required value="" maxlength="6" type="tel">
                                    </div>

                                </div>

                                <div class="col-12 col-sm-8 col-md-4 col-lg-4">

                                    <div class="form-group">
                                        <label class="control-label" for="cep">CEP <sup class="text-danger">*</sup>:</label>
                                        <input disabled id="cep" class="form-control mascara-cep" value="" maxlength="9" type="tel">
                                        <input name="cep" id="cep-hidden" maxlength="9" type="hidden">
                                        <a href="javascript:fechaEndereco()">Alterar o CEP</a>
                                    </div>

                                </div>

                                <div class="col-12 col-md-8 col-lg-4">

                                    <div class="form-group">
                                        <label class="control-label" for="bairro">Bairro <sup class="text-danger">*</sup>:</label>
                                        <input id="bairro" name="bairro" maxlength="100" class="form-control" required value="" type="text">
                                    </div>

                                </div>

                                <div class="col-12 col-md-4 col-lg-4">

                                    <div class="form-group">
                                        <label class="control-label" for="selEstado">Estado <sup class="text-danger">*</sup>:</label>
                                        <select class="form-control" name="selEstado" id="selEstado" disabled="">
                                            <option value="sp">São Paulo</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>

                                <div class="col-12 col-md-8 col-lg-4">

                                    <div class="form-group">
                                        <label class="control-label" for="selCidade">Cidade <sup class="text-danger">*</sup>:</label>
                                        <select class="form-control select2" name="selCidade" id="selCidade" required="">
                                            <?php

                                            foreach ($todas_cidades as $result_cidade) {
                                            ?>
                                                <option value="<?= $result_cidade['cid_id'] ?>" <?= ($result_cidade['cid_id'] == $id_cidade ? "selected" : "") ?>><?= $result_cidade['cid_nome'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>

                                <div class="col-12 mt-4">
                                    <div class="form-group m-0 float-left">
                                        <a class="btn btn-secondary btn-lg px-3 text-uppercase" id="btnVoltar" href="#">Voltar</a>
                                    </div>
                                    <div class="form-group m-0 float-right">
                                        <button class="btn bg-cor-principal text-white btn-lg text-uppercase" tabindex="3" name="btnAddEndereco" id="btnAddEndereco" type="submit">Confirmar</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <hr id="divisor" class="my-5">

            <div id="listar-endereco">

                <header class="mb-5">

                    <h2 id="titulo-pagina" class="text-center">
                        Meus Endereços
                        <hr />
                    </h2>

                </header>

                <div class="table-responsive">

                    <table id="table-enderecos" class="table table- table-hover table-bordered">

                        <tbody>

                            <?php

                            if (!empty($todos_endereco)) {

                                foreach ($todos_endereco as $i => $endereco) {

                            ?>

                                    <tr>

                                        <td class="border-right-0 align-middle">

                                            <a data-id="<?= $endereco["end_id"] ?>" class="alterar-favorito <?= !empty($endereco["end_favorito"]) ? "endereco-ativo" : "" ?>" href="">
                                                <i class="<?= empty($endereco["end_favorito"]) ? "far" : "fa" ?> fa-star"></i>
                                            </a>

                                            <p class="m-0 text-center ml-3 d-inline font-weight-normal">
                                                <?= $endereco["end_descricao"] ?>
                                            </p>

                                        </td>

                                        <td class="border-right-0 border-left-0 align-middle">

                                            <span class="divisor-tabela"></span>

                                        </td>

                                        <td class="border-right-0 border-left-0 align-middle">

                                            <p class="m-0">
                                                <?= $endereco["end_rua"] ?>, <?= $endereco["end_numero"] ?> - <?= $endereco["cid_nome"] ?>
                                            </p>

                                        </td>

                                        <td class="border-left-0 align-middle text-center">

                                            <div class="dropdown show">
                                                <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ações
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a data-id="<?= $endereco["end_id"] ?>" class="dropdown-item excluir-endereco" href="">Excluir Endereço</a>
                                                    <a class="dropdown-item" href="#">Restaurantes Próximos</a>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>

                                <?php

                                }
                            } else {

                                ?>

                                <tr>

                                    <td class="text-center">Nenhum endereço cadastrado</td>

                                </tr>

                            <?php

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</div>

<?php
include_once "rodape.php";
?>