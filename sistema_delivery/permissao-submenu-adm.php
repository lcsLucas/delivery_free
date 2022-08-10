<?php
$menu = "Empresas";
$submenu = "Permissões de Menus";

include './topo.php';

include_once './classes/ResponsavelEmpresa.php';
include_once './classes/SubMenu.php';

$responsavel = new ResponsavelEmpresa();
$menu_emp = new SubMenu();

$lista_menu = $menu_emp->listar_empresa();


if(!empty($_GET['adpe'])){
    $resp = $menu_emp->relacionarMenuUsuarioEmpresa($_GET['menu'],$_GET['idus'], $_GET["idemp"]);
    if($resp == TRUE){
        $sucessorelacionar = TRUE;
    }else{
        $errorelacionar = TRUE;
    }
}

if(!empty($_GET['rmpe'])){
    $resp = $menu_emp->desrelacionarMenuUsuarioEmpresa($_GET['menu'],$_GET['idus'], $_GET["idemp"]);
    if($resp == TRUE){
        $sucessodesrelacionar = TRUE;
    }else{
        $errodesrelacionar = TRUE;
    }
}

//paginação
$urlpaginacao = "&page=1";
$entries_per_page = 5;
if (filter_has_var(INPUT_GET, "page")) {
    $pag = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    $urlpaginacao = "&page=$pag";
}

$page = (isset($pag) ? $pag : 1);

$filtro = "";
$parametros = "";
if(filter_has_var(INPUT_GET, "buscar")){
    $filtro = filter_input(INPUT_GET, "filtro", FILTER_SANITIZE_SPECIAL_CHARS);
    $parametros = "&filtro=".$filtro."&buscar=";
}

$offset = (($page * $entries_per_page) - $entries_per_page);
$num_rows = $responsavel->quantidadeRegistros($filtro);
$lista = $responsavel->listarPaginacao($filtro,$offset,$entries_per_page);

$total_pages = ceil($num_rows / $entries_per_page);
$pagination = pagination_six($total_pages, $page,$parametros);

?>

    <h2 class="titulo-pagina">Gerenciar Permissões dos SubMenus das Empresas</h2>

<?php
include 'menssagens.php';
?>

    <form class="form-inline mt-4 mb-3 pt-4 pb-3" id="formBusca" action="<?= $_SERVER["PHP_SELF"] ?>" style="justify-content: center;">

        <label class="sr-only" for="rua">Buscar Por: <span class="col-pink">*</span>:</label>
        <input style="" type="text" id="filtro" name="filtro" placeholder="Informe uma parte do nome da empresa ou do responsável" class="form-control col-10" value="<?= $filtro ?>" />

        <button type="submit" name="buscar" class="btn btn-success btn-search col-1 ml-4">Buscar</button>

    </form>

<?php
if(!empty($lista)) {
    foreach ($lista as $lista_usuarios) {
        ?>

        <div class="card border-primary mt-5 mb-5">
            <h5 class="card-header bg-primary text-white">

                Permissões de Menu ao Cliente:
                <q><b><?= utf8_encode($lista_usuarios["resp_nome"]) ?></b></q>

            </h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable"
                           class="table table-hover js-basic-example dataTable">
                        <thead>
                        <th>Descrição Menu</th>
                        <th class="text-center">Permissões</th>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($lista_menu)) {
                            foreach ($lista_menu as $result_menu) {
                                ?>
                                <tr>
                                    <td>
                                        <?= utf8_encode($result_menu["descricao_submenu"]) ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($menu_emp->verificaRelacaoEmpresa($result_menu["idsubmenu"], $lista_usuarios["usu_adm"], $lista_usuarios["emp_id"]) == false) {
                                            ?>
                                            <a role="button"
                                               title="Clique para remover a permissão desse usuário para esse menu"
                                               class="btn btn-link"
                                               href="?menu=<?= $result_menu["idsubmenu"]; ?>&adpe=1&idus=<?= $lista_usuarios["usu_adm"]; ?>&idemp=<?= $lista_usuarios["emp_id"]; ?>"><i
                                                    class="fa fa-square-o fa-3x text-danger"
                                                    aria-hidden="true"></i></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a role="button"
                                               title="Clique para remover a permissão desse usuário para esse menu"
                                               class="btn btn-link"
                                               href="?menu=<?php echo $result_menu["idsubmenu"]; ?>&rmpe=1&idus=<?php echo $lista_usuarios["usu_adm"]; ?>&idemp=<?= $lista_usuarios["emp_id"]; ?>"><i
                                                    class="fa fa-check-square-o fa-3x text-success"
                                                    aria-hidden="true"></i></a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="2" class="text-center">Nenhum Menu para
                                    listar
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php
    }
    echo $pagination;
} else {
    ?>
    <p class="text-center">Nenhum Cliente Cadastrado</p>
    <?php
}
?>

<?php include './rodape.php'; ?>