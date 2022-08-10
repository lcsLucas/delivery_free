<?php
$menu = "Empresas";
$submenu = "Menu Empresa";
$multselect = TRUE;
$dataTables = TRUE;
include_once 'topo.php';
require_once './classes/Menu.php';
require_once './classes/TipoUsuario.php';

$descricao = $cod = $url = $icone = "";

$menu = new Menu();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $codigo = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
        $url = filter_input(INPUT_POST, "url", FILTER_SANITIZE_SPECIAL_CHARS);
        $icone = filter_input(INPUT_POST, "icone", FILTER_SANITIZE_SPECIAL_CHARS);
        $status = 1;

        if (empty($descricao)) {
            $erroCamposVazios = true;
        } else {
            $menu = new Menu($descricao, $url, $status);
            $menu->setIcone($icone);
            $menu->setTipo(1);

            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $menu->setId($codigo);
                $resp = $menu->alterar();
                if ($resp) {
                    $sucessoalterar = TRUE;
                    $descricao = $cod = $url = $icone = "";
                } else {
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                $resp = $menu->inserir_empresar();
                if ($resp) {
                    $sucessoinserir = TRUE;
                    $descricao = $cod = $url = $icone = "";
                } else {
                    $erroinserir = TRUE;
                }
            }
        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $menu->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if (!empty($menu->carregar())) {
            $cod = $menu->getId();
            $descricao = utf8_encode($menu->getDescricao());
            $url = $menu->getUrl();
            $icone = $menu->getIcone();

            $carregado = true;
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Carregar os dados do Usuário";
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $menu->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        $resp = $menu->excluir();
        if ($resp == TRUE) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    }  else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $menu->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($menu->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status do menu!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status do menu";
        }
    }
}

$lista = $menu->listar_empresa();

?>

<h2 class="titulo-pagina">Gerenciar Cadastro de Menus para Empresas</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Novo Menu" : "Alterar o Menu <q>$descricao</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?php echo $cod; ?>" >
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="nome"><strong>Descrição do Menu <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus name="descricao" value="<?php echo $descricao; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>URL do Menu</strong>: </label>
                    <input name="url" value="<?php echo $url; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>Ícone do Menu (Classe do Font-Awesome)</strong>: </label>
                    <input name="icone" value="<?php echo $icone; ?>" type="text" class="form-control" placeholder="fa-home, fa-user, fa-bars, ...">
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
            Menus Cadastrados das Empresas
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable">
                <thead>
                <tr>
                    <th>Descrição do Menu</th>
                    <th class="text-center not-ordering">Ativo</th>
                    <th class="text-center not-ordering">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($lista)) {
                    foreach ($lista as $rs) {
                        ?>
                        <tr>
                            <td><?php echo utf8_encode($rs['descricao_menu']); ?></td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['idmenu'] ?>" />
                                    <?php
                                    if ($rs['status']) {
                                        ?>
                                        <button type="submit" title="Clique para Desativar o Menu" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" title="Clique para Ativar o Menu" class="btn btn-link" name="alterar-status" ><i class="fa fa-square-o fa-2x text-danger" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['idmenu'] ?>" />
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar Menu" name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Menu">
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

