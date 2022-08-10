<?php
$menu = "Empresas";
$submenu = "SubMenu Empresa";

$multselect = TRUE;
$dataTables = true;

include 'topo.php';
require_once './classes/SubMenu.php';
require_once './classes/Menu.php';
require_once './classes/TipoUsuario.php';

$descricao = $cod = $url = $men = "";

$submenu = new SubMenu();
$menu = new Menu();


if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $codigo = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $men = filter_input(INPUT_POST, "menu", FILTER_VALIDATE_INT);
        $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
        $url = filter_input(INPUT_POST, "url", FILTER_SANITIZE_SPECIAL_CHARS);
        $status = 1;

        if (empty($descricao) || empty($men) || empty($url)) {
            $erroCamposVazios = true;
            $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
        } else {
            $submenu = new SubMenu($descricao, $url, $status,$men);
            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $submenu->setId($codigo);
                $resp = $submenu->alterar();
                if($resp){
                    $sucessoalterar = TRUE;
                    $descricao = $cod = $url = $men = "";
                }else{
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                $submenu->setTipo(1);

                $resp = $submenu->inserir_empresa();
                if($resp){
                    $sucessoinserir = TRUE;
                    $descricao = $cod = $url = $men = "";
                }else{
                    $erroinserir = TRUE;
                }
            }
        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $submenu->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if (!empty($submenu->carregar())) {
            $cod = $submenu->getId();
            $descricao = utf8_encode($submenu->getDescricao());
            $url = $submenu->getUrl();
            $men = $submenu->getMenu();

            $carregado = true;
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao Carregar os dados do SubMenu";
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $submenu->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        $resp = $submenu->excluir();
        if ($resp == TRUE) {
            $sucessodeletar = TRUE;
        } else {
            $errodeletar = TRUE;
        }
    }else if (filter_has_var(INPUT_POST, "alterar-status")) {
        $submenu->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if ($submenu->modificaAtivo()) {
            $sucessoPersonalizado = true;
            $sucessoMensagem = "ao alterar o status do menu!";
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "ao alterar o status do menu";
        }
    }
}


$lista = $submenu->listar_empresa();
$listmenu = $menu->listar_empresa();

?>

<h2 class="titulo-pagina">Gerenciar Cadastro de SubMenus</h2>

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
                    <label for="tipo"><strong>Menu Pai<span class="obrigatorio">*</span></strong>:</label>
                    <?php
                    if(isset($listmenu)){
                        ?>
                        <select id="menu" name="menu" class="form-control">
                            <option value="">Selecione uma Opção</option>
                            <?php
                            foreach ($listmenu as $rs){
                                ?>
                                <option <?php if($rs["idmenu"]==$men) { echo "selected"; } ?> value="<?php echo $rs["idmenu"]; ?>">
                                    <?php echo utf8_encode($rs["descricao_menu"]); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php
                    }
                    ?>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>Descrição do SubMenu <span class="obrigatorio">*</span></strong>: </label>
                    <input name="descricao" value="<?php echo $descricao; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="nome"><strong>URL do SubMenu <span class="obrigatorio">*</span></strong>: </label>
                    <input name="url" value="<?php echo $url; ?>" type="text" class="form-control" >
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
            SubMenus Cadastrados das Empresas
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable">
                <thead>
                <tr>
                    <th>Descrição do SubMenu</th>
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
                            <td><?php echo utf8_encode($rs['descricao_submenu']); ?></td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['idsubmenu'] ?>"/>
                                    <?php
                                    if ($rs['status']) {
                                        ?>
                                        <button type="submit" title="Clique para Desativar o SubMenu"
                                                class="btn btn-link" name="alterar-status"><i
                                                    class="fa fa-check-square-o fa-2x text-success"
                                                    aria-hidden="true"></i></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" title="Clique para Ativar o SubMenu" class="btn btn-link"
                                                name="alterar-status"><i class="fa fa-square-o fa-2x text-danger"
                                                                         aria-hidden="true"></i></button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                    <input type="hidden" name="acao-codigo" value="<?= $rs['idsubmenu'] ?>"/>
                                    <button type="submit" class="btn btn-info btn-acao" title="Editar SubMenu"
                                            name="editar">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar"
                                            title="Excluir SubMenu">
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

