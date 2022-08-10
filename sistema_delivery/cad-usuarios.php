<?php
$menu = "Usuários";
$submenu = "Gerenciar usuários";
$dataTables = TRUE;
$fancybox = TRUE;

require_once 'topo.php';
require_once './classes/Usuarios.php';
require_once './classes/TipoUsuario.php';

$cod = $nome = $email = $tipo = $usuari = $senha = "";
$usuario = new Usuarios();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
        $tipo = filter_input(INPUT_POST, "tipo", FILTER_VALIDATE_INT);
        $usuari = trim(filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_SPECIAL_CHARS));
        $senha = trim(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS));
        $status = 1;

        if (empty($nome) || empty($email) || empty($tipo) || empty($usuari) || empty($senha)) {
            $erroCamposVazios = true;            
        } else {
            $usuario = new Usuarios($usuari, $senha, $email, $nome, $status, $tipo);
            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $usuario->setId($id);
                if (!$usuario->exixteEmail()) {
                    $resp = $usuario->alterar();
                    if ($resp) {
                        $sucessoalterar = TRUE;
                        $cod = $nome = $email = $tipo = $usuari = $senha = "";
                    } else {
                        $erroalterar = TRUE;
                        $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                    }

                } else {
                    $erroemailexiste = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }

            } else {
                if (!$usuario->exixteUsuario()) {
                    if (!$usuario->exixteEmail()) {
                        $resp = $usuario->inserir();
                        if ($resp) {
                            $sucessoinserir = TRUE;
                            $cod = $nome = $email = $tipo = $usuari = $senha = "";
                        } else {
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
        $usuario->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if (!empty($usuario->carregar())) {
            $cod = $usuario->getId();
            $nome = $usuario->getNome();
            $email = $usuario->getEmail();
            $tipo = $usuario->getTipo();
            $usuari = $usuario->getUsuario();

            $carregado = true;
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Carregar os dados do Usuário";
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $usuario->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        $resp = $usuario->excluir();
        if ($resp == TRUE) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $usuario->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($usuario->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status do usuário!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status do usuário";
        }
    }
}

$lista = $usuario->listar();
$usuariotipo = new TipoUsuario();
$r = $usuariotipo->listar();
?>

<h2 class="titulo-pagina">Gerenciar Usuários</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
<?= empty($carregado) ? "Cadastrar Novo Usuário" : "Alterar Usuário <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="form-row">
                <div class="form-group col-12">
                    <input type="hidden" name="codigo" value="<?= $cod ?>" />
                    <label for="tipo"><strong>Tipo de Usuário <span class="obrigatorio">*</span></strong>:</label>
                        <?php
                            if (isset($r)) {
                        ?>
                        <select id="tipo" name="tipo" class="form-control">
                        <?php
                        foreach ($r as $rs) {
                            ?>
                                <option <?php
                                if ($rs["idusuariotipo"] == $tipo) {
                                    echo "selected";
                                }
                                ?> value="<?php echo $rs["idusuariotipo"]; ?>">
                                        <?php echo utf8_encode($rs["nome_tipo"]); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php
                            }
                        ?>
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="nome"><strong>Nome <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="email"><strong>Email <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" id="email" name="email" value="<?php echo $email; ?>" type="email" class="form-control">
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="usuario"><strong>Usuário <span class="obrigatorio">*</span></strong>: </label>
                    <input <?= !empty($carregado) ? 'readonly' : '' ?> required="true" name="usuario" id="usuario" value="<?php echo $usuari; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-sm-6 col-12">
                    <label for="senha"><strong>Senha <span class="obrigatorio">*</span></strong>: </label>
                    <input required id="senha" name="senha" value="" type="password" class="form-control">
                    <a class="fancyboxgerarsenha fancybox.iframe pull-right" href="gerar-senha.php" >Gerar senha</a>
                </div>
                <div class="form-group col-12">
                    <hr>
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
            Usuários Cadastrados
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>E-mail</th>
                        <th class="text-center not-ordering">Ativo</th>
                        <th class="text-center not-ordering">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($lista)) {
                        foreach ($lista as $rs) {
                            ?>
                            <tr>
                                <td><?php echo utf8_encode($rs['nome']) ?></td>
                                <td><?php echo $rs['usuario']; ?></td>
                                <td><?php echo $rs['email']; ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $rs['idusuarios'] ?>" />
                                        <input type="hidden" name="acao-status" value="<?= !empty($rs['status']) ? "0" : "1" ?>" />
                                        <?php
                                        if ($rs['status']) {
                                            ?>
                                            <button type="submit" title="Clique para Desativar o Usuário" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" title="Clique para Ativar o Usuário" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                        <?php } ?>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $rs['idusuarios'] ?>" />
                                        <button type="submit" class="btn btn-info btn-acao" title="Editar Usuário" name="editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Usuário">
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
</div>

<?php
include 'rodape.php';
?>

