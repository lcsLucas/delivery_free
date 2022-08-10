<?php
$menu = "Estabelecimentos";
$submenu = "Gerenciar Empresas";
$dataTables = TRUE;
$fancybox = TRUE;
$mask = true;
$select2 = true;

require_once 'topo.php';
require_once 'classes/Empresa.php';
require_once 'classes/ResponsavelEmpresa.php';
require_once 'classes/Endereco.php';

$codigo = $codigo_emp = $codigo_usu = $codigo_end = $nome = $fantasia = $cnpj = $nome_responsavel = $usuario = $senha = $fone = $email = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = $comissao = "";
$endereco = new Endereco();
$empresa = new Empresa();
$responsavel = new ResponsavelEmpresa();


if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $codigo = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $codigo_emp = filter_input(INPUT_POST, "codigo-emp", FILTER_VALIDATE_INT);
        $codigo_usu = filter_input(INPUT_POST, "codigo-usu", FILTER_VALIDATE_INT);
        $codigo_end = filter_input(INPUT_POST, "codigo-end", FILTER_VALIDATE_INT);
		$comissao = filter_input(INPUT_POST, "comissao", FILTER_SANITIZE_SPECIAL_CHARS);

        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        $fantasia = trim(filter_input(INPUT_POST, "fantasia", FILTER_SANITIZE_SPECIAL_CHARS));
        $cnpj = trim(filter_input(INPUT_POST, "cnpj", FILTER_SANITIZE_SPECIAL_CHARS));
        $nome_responsavel = trim(filter_input(INPUT_POST, "responsavel", FILTER_SANITIZE_SPECIAL_CHARS));
        $usuario = trim(filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_SPECIAL_CHARS));
        $senha = trim(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS));
        $fone = trim(filter_input(INPUT_POST, "fone", FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
        $obs = trim(filter_input(INPUT_POST, "obs", FILTER_SANITIZE_SPECIAL_CHARS));

        $rua = trim(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_SPECIAL_CHARS));
        $numero = trim(filter_input(INPUT_POST, "txtNumero", FILTER_VALIDATE_INT));
        $bairro = trim(filter_input(INPUT_POST, "txtBairro", FILTER_SANITIZE_SPECIAL_CHARS));
        $cep = trim(filter_input(INPUT_POST, "txtCep", FILTER_SANITIZE_SPECIAL_CHARS));
        $id_estado = trim(filter_input(INPUT_POST, "selEstado", FILTER_VALIDATE_INT));
        $id_cidade = trim(filter_input(INPUT_POST, "selCidade", FILTER_VALIDATE_INT));

        if (empty($nome) || empty($fantasia) || empty($responsavel) || empty($usuario) || empty($senha)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $empresa->setNome($nome);
            $empresa->setFantasia($fantasia);
            $empresa->setCnpj($cnpj);

            $endereco->setRua($rua);
            $endereco->setNumero($numero);
            $endereco->setBairro($bairro);
            $endereco->setCep($cep);
            $endereco->getCidade()->setId($id_cidade);
            $endereco->getCidade()->getEstado()->setSigla($id_estado);

            if (!empty($comissao)) {

				$comissao2 = str_replace(".", "", $comissao);
				$comissao2 = str_replace(",", ".", $comissao2);

				$empresa->setComissao($comissao2);

            }

            $responsavel->setEmpresa($empresa);
            $responsavel->setEndereco($endereco);

            $responsavel->setNome($nome_responsavel);
            $responsavel->setEmail($email);
            $responsavel->setFone($fone);
            $responsavel->setObs($obs);

            $responsavel->getUsuario()->setEmail($responsavel->getEmail());
            $responsavel->getUsuario()->setUsuario($usuario);
            $responsavel->getUsuario()->setSenha($senha);
            $responsavel->getUsuario()->setTipoEmpresa(1);
            $responsavel->getUsuario()->setStatus(1);

            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $responsavel->setId($codigo);
                $responsavel->getEmpresa()->setId($codigo_emp);
                $responsavel->getUsuario()->setId($codigo_usu);
                $responsavel->getEndereco()->setId($codigo_end);

                $resp = $responsavel->alterar();
                if($resp){
                    $sucessoalterar = TRUE;
					$codigo = $codigo_emp = $codigo_usu = $codigo_end = $nome = $fantasia = $cnpj = $nome_responsavel = $usuario = $senha = $fone = $email = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = $comissao = "";
				}else{
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }


            } else {

                if (!$responsavel->getUsuario()->exixteUsuario()) {
                    if (!$responsavel->getUsuario()->exixteEmail()) {
                $resp = $responsavel->inserir();
                if($resp){
                    $sucessoinserir = TRUE;
					$codigo = $codigo_emp = $codigo_usu = $codigo_end = $nome = $fantasia = $cnpj = $nome_responsavel = $usuario = $senha = $fone = $email = $obs = $rua = $bairro = $numero = $cep = $id_estado = $id_cidade = $comissao = "";
				}else{
                    $erroinserir = TRUE;
                }
                    } else {
                        $erroemailexiste = TRUE;
                    }
                } else {
                    $errousuarioexiste = TRUE;
                }

            }

        }


    } else if (filter_has_var(INPUT_POST, "editar")) {
        $responsavel->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));

        if (!empty($responsavel->carregar())) {

            $codigo = $responsavel->getId();
            $codigo_emp = $responsavel->getEmpresa()->getId();
            $codigo_usu = $responsavel->getUsuario()->getId();
            $codigo_end = $responsavel->getEndereco()->getId();

            $nome = $responsavel->getEmpresa()->getNome();
            $fantasia = $responsavel->getEmpresa()->getFantasia();
            $cnpj = $responsavel->getEmpresa()->getCnpj();
			$comissao = $responsavel->getEmpresa()->getComissao();
            $nome_responsavel = $responsavel->getNome();
            $usuario = $responsavel->getUsuario()->getUsuario();
            $fone = $responsavel->getFone();
            $email = $responsavel->getEmail();
            $obs = $responsavel->getObs();
            $rua = $responsavel->getEndereco()->getRua();
            $bairro = $responsavel->getEndereco()->getBairro();
            $numero = $responsavel->getEndereco()->getNumero();
            $cep = $responsavel->getEndereco()->getCep();
            $id_estado = $responsavel->getEndereco()->getCidade()->getEstado()->getSigla();
            $id_cidade = $responsavel->getEndereco()->getCidade()->getId();

            $carregado = true;
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Carregar os dados do Usuário";
        }

    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $responsavel->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        $resp = $responsavel->excluir();
        if($resp) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }

    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $empresa->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        $resp = $empresa->modificaAtivo();

        if($resp) {
            $sucessoPersonalizado = TRUE;
            $sucessoMensagem = "Ao Alterar o Status da Empresa!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Alterar Status da Empresa!";
        }

    }
}

$lista_estados = $endereco->getCidade()->getEstado()->listar();
$lista_cidades = $endereco->getCidade()->listar();

$periodo1 = '';
$periodo2 = '';
$filtro = "";
$parametros = "";

if(isset($_GET['filtro'])){
	$filtro = SQLinjection(filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS));
	$parametros = "&filtro=".$filtro;
}

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

	$parametros = "&periodo1=".$periodo1."&periodo2=". $periodo2;
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
$num_rows = $responsavel->quantidadeRegistros2($filtro, $periodo1, $periodo2);
$lista = $responsavel->listarPaginacao2($filtro, $periodo1, $periodo2, $offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);
?>

<h2 class="titulo-pagina">Gerenciar Empresas</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
<?= empty($carregado) ? "Cadastrar Nova Empresa" : "Alterar Empresa <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?= $codigo ?>" />
            <input type="hidden" name="codigo-emp" value="<?= $codigo_emp ?>" />
            <input type="hidden" name="codigo-usu" value="<?= $codigo_usu ?>" />
            <input type="hidden" name="codigo-end" value="<?= $codigo_end ?>" />
            <div class="form-row">
                <div class="form-group col-12 col-sm-12">
                    <label for="nome"><strong>Razão Social <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12 col-sm-9">
                    <label for="nome"><strong>Nome Fantásia <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="fantasia" name="fantasia" value="<?php echo $fantasia; ?>" type="text" class="form-control">
                </div>

                <div class="col-12 col-sm-3">

                    <div class="form-group">
                        <label class="font-weight-bold" for="comissao">Comissão da Venda <span class="obrigatorio">*</span>:</label>
                        <div class="input-group">
                            <input max="99" type="tel" maxlength="5" class="form-control text-center mascara-dinheiro" data-desconto="1" name="comissao" value="<?= $comissao ?>" id="comissao" placeholder="0,00">
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                        <div class="msg-erro text-danger"></div>
                    </div>

                </div>

                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>CNPJ <sup>(opcional)</sup> </strong>: </label>
                    <input required="true" autofocus id="cnpj" name="cnpj" value="<?php echo $cnpj; ?>" type="text" placeholder="__.___.___/____-__" class="form-control mascara-cnpj">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>Responsável <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="responsavel" name="responsavel" value="<?php echo $nome_responsavel; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="email"><strong>Email <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" <?= !empty($carregado) ? "readonly" : "" ?> id="email" name="email" value="<?php echo $email; ?>" type="email" class="form-control">
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="fone"><strong>Fone <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" id="fone" name="fone" value="<?php echo $fone; ?>" placeholder="(__) _____-____" type="tel" class="form-control mascara-telefone">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>Usuário Administrador <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" <?= !empty($carregado) ? "readonly" : "" ?> autofocus id="adm" name="usuario" value="<?php echo $usuario; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="senha"><strong>Senha do Administrador<span class="obrigatorio">*</span></strong>: </label>
                    <input required id="senha" name="senha" value="" type="password" class="form-control">
                    <a class="fancyboxgerarsenha fancybox.iframe pull-right" href="gerar-senha.php" >Gerar senha</a>
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
                        <label class="control-label" for="txtNumero">Número <span class="obrigatorio">*</span>:</label>
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
                                <option value="<?= $result_cidade['cid_id'] ?>" <?= (utf8_encode($result_cidade['cid_id']) === $id_cidade ? "selected" : "") ?> ><?= utf8_encode($result_cidade['cid_nome']) ?></option>
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
            Empresas Cadastradas <a target="_blank" href="relatorios/relatorio-empresas.php?filtro=<?= $filtro . $parametros ?>" class="float-right border-white btn btn-outline-secondary"><i class="fa text-white fa-print"></i></a>
        </h5>
    </div>
    <div class="card-body">

        <form action="<?= $_SERVER['PHP_SELF'] ?>" class="">
            <div class="form-group">
                <label for="">Nome da empresa ou responsável:</label>
                <input type="text" class="form-control" name="filtro" value="<?= $filtro ?>">

            </div>

            <div class="form-group d-flex flex-wrap justify-content-center">

                <p class="text-left d-block w-100 text-center">Perido de Faturamento:</p>
                <div class="input-group datepicker w-50 mx-2" style="max-width: 400px;">
                    <input type="text" class="form-control" name="periodo1" id="data1" placeholder="__/__/____" value="<?= filter_has_var(INPUT_GET, 'periodo1') ? $_GET['periodo1'] : '' ?>">
                    <div style="cursor: pointer;" class="input-group-append input-group-addon">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>

                <div class="input-group datepicker w-50 mx-2" style="max-width: 400px;">
                    <input type="text" class="form-control" name="periodo2" placeholder="__/__/____" value="<?= filter_has_var(INPUT_GET, 'periodo2') ? $_GET['periodo2'] : '' ?>">
                    <div style="cursor: pointer;" class="input-group-append input-group-addon">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>

            </div>

            <div class="w-100 mt-3 text-center">
                <button type="submit" name="buscar" class="btn btn-primary mb-2"><i class="fa fa-search"></i> BUSCAR</button>
				<?php
				if (filter_has_var(INPUT_GET, 'filtro')) {
					?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-danger mb-2 ml-2"><i class="fa fa-times"></i> CANCELAR</a>
					<?php
				}
				?>
            </div>

        </form>

        <div class="table-responsive">
            <!--  e.emp_id, emp_nome, resp_nome, resp_email, resp_fone, emp_ativo  -->
            <table class="table table-striped table-hover" >
                <thead>
                    <tr>
                        <th>Nome Empresa</th>
                        <th>Resposável</th>
                        <th>Email</th>
                        <th>Fone</th>
                        <th class="text-center not-ordering">Ativo</th>
                        <th style="width: 107px;" class="text-center not-ordering">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (!empty($lista)) {
                        foreach ($lista as $result) {
                            ?>

                            <tr>
                                <td><?= utf8_encode($result["emp_nome"]) ?></td>
                                <td><?= utf8_encode($result["resp_nome"]) ?></td>
                                <td><?= utf8_encode($result["resp_email"]) ?></td>
                                <td><?= utf8_encode($result["resp_fone"]) ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['emp_id'] ?>" />
                                        <?php
                                        if ($result['emp_ativo']) {
                                            ?>
                                            <button type="submit" title="Clique para Desativar a Empresa" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" title="Clique para Ativar a Empresa" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $result['resp_id'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Empresa" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Empresa">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <?php

                        }
                    } else {
						$naopagina = TRUE;
					    echo '<tr><td colspan="6" class="text-center">Nenhum registro encontrado</td></tr>';
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

