<?php 
    $dataTables = TRUE;
    $menu = "Usuários";
    $submenu = "Tipo usuários";
    include 'topo.php';
?>
<?php include './classes/TipoUsuario.php'; ?>
<?php
$nome = $cod = "";

$tipoUsuario = new TipoUsuario();


if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);
        $nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
        
        if (empty($nome)) {
            $erroCamposVazios = true;
        } else {
            $tipoUsuario = new TipoUsuario($nome);
            if (filter_has_var(INPUT_POST, "editar")) { //aletar banner, se existir a variavel editar
                $tipoUsuario = new TipoUsuario($nome);
                $tipoUsuario->setId($id);
                $resp = $tipoUsuario->alterar();
                if($resp == TRUE){
                    $sucessoalterar = TRUE;
                    $nome = $cod = "";
                }else{
                    $erroalterar = TRUE;
                    $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
                }
            } else {
                $resp = $tipoUsuario->inserir();
                if($resp == TRUE){
                    $sucessoinserir = TRUE;
                    $nome = $cod = "";
                }else{
                    $erroinserir = TRUE;
                }
            }
        }

    } else if (filter_has_var(INPUT_POST, "editar")) {
        $tipoUsuario->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        if($tipoUsuario->carregar()) {
            $cod = $tipoUsuario->getId();
            $nome = $tipoUsuario->getNome();

            $carregado = true;
        } else {
            $erroPersonalizado = true;
            $erroMensagem = "Ao carregar as informações";
        }
    } else if (filter_has_var(INPUT_POST, "deletar")) {
        $tipoUsuario->setId(filter_input(INPUT_POST, 'acao-codigo', FILTER_VALIDATE_INT));
        $resp = $tipoUsuario->excluir();
        if($resp){
            $sucessodeletar = TRUE;
        }else{
            $errodeletar = TRUE;
        }
    } 
}


$lista = $tipoUsuario->listar();

?>

<h2 class="titulo-pagina">Gerenciar tipos de Usuários</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
<?= empty($carregado) ? "Cadastrar Novo Tipo de Usuários" : "Alterar Tipo de Usuários <q>$nome</q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="<?php echo $cod; ?>" > 
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="nome"><strong>Nome do Tipo de Usuários <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
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
            Tipos de usuários Cadastrados
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-center not-ordering col-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($lista)) {
                        foreach ($lista as $rs) {
                            ?>
                            <tr>
                                <td><?php echo utf8_encode($rs['nome_tipo']) ?></td>
                                <td class="text-center">
                                    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="acao-codigo" value="<?= $rs['idusuariotipo'] ?>" />
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

<?php 
    include 'rodape.php';
?>
