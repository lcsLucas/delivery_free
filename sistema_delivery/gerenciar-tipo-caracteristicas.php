<?php
$menu = "";
$submenu = "";
$dataTables = TRUE;

require_once 'topo.php';

$nome = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //requisição post
    if (filter_has_var(INPUT_POST, 'btnEnviar')) {// enviada do formulario de cadastro/alteração
        $id = filter_input(INPUT_POST, "codigo", FILTER_VALIDATE_INT);

        $carregado = filter_has_var(INPUT_POST, "editar") ? true : false;
    } else if (filter_has_var(INPUT_POST, "editar")) {
        
    } else if (filter_has_var(INPUT_POST, "del")) {
        
    } else if (filter_has_var(INPUT_POST, "alterar-status")) {
        
    }
}
?>

<h2 class="titulo-pagina">Gerenciar Tipos de Características</h2>

<?php
include 'menssagens.php';
?>

<div class="card">
    <div class="card-header <?= empty($carregado) ? "bg-primary" : "bg-danger" ?> text-white">
        <h5 class="titulo-card">
            <?= empty($carregado) ? "Cadastrar Novo Tipo" : "Alterar Tipo <q></q>" ?>
        </h5>
    </div>
    <div class="card-body">
        <form role="form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="codigo" value="" />
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="nome"><strong>Nome do Tipo <span class="obrigatorio">*</span></strong>: </label>
                    <input required="true" autofocus id="nome" name="nome" value="<?php echo $nome; ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-12">
                    <label for="obs"><strong>Descrição</strong>: </label><br>
                    <textarea style="resize: none" name="obs" id="obs" rows="5" class="form-group w-100"></textarea>
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
            Tipos Cadastrados
        </h5>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable table-condensed" >
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-center not-ordering">Ativo</th>
                        <th class="text-center not-ordering">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tamanhos</td>
                        <td class="text-center">
                            <button type="submit" title="Clique para Desativar a Empresa" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                        </td>
                        <td class="text-center">
                            <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                <button type="submit" class="btn btn-info btn-acao" title="Editar Empresa" name="editar">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Empresa">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>Sabores</td>
                        <td class="text-center">
                            <button type="submit" title="Clique para Desativar a Empresa" class="btn btn-link" name="alterar-status" ><i class="fa fa-check-square-o fa-2x text-success" aria-hidden="true"></i></button>
                        </td>
                        <td class="text-center">
                            <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
                                <button type="submit" class="btn btn-info btn-acao" title="Editar Empresa" name="editar">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <button type="submit" class="btn btn-danger btn-acao excluir" name="deletar" title="Excluir Empresa">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include 'rodape.php';
?>

