<?php
    $menu = "Gerenciar Entregas";
    $submenu = "";
    $dataTables = true;
    

    require_once './vendor/faker/src/autoload.php';
    $faker = Faker\Factory::create();
    $faker->seed(5);
?>

<?php include_once './topo.php'; ?>


      <div class="card mb-3 border-primary">
        <div class="card-header bg-primary text-white">
          <i class="fa fa-motorcycle"></i> Definir Nova Entrega
        </div>
        <div class="card-body">
          <form action="">
            <div class="form-row justify-content-start">
	            <div class="form-group col-3">
	                <label for="nome">Pedido:</label>
	               <div class="input-group">
	                <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
	                <div class="input-group-append">
	                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i></span>
	                </div>
	              </div>                              
	            </div>
              <div class="form-group col-md-3">
                  <label for="nome">Data do Pedido:</label>
                 <div class="input-group">
                  <input type="text" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                  </div>
                </div>                              
              </div>  
                <div class="form-group col-md-6">
                    <label for="nome">Cliente:</label>
                    <select class="custom-select">
                      <option selected>Selecione</option>
                    </select>                
                </div> 
                <div class="form-group col-md-12">  
                <hr>   
                </div>
                <div class="form-group col-md-6">
                    <label for="nome">Entregador:</label>
                    <select class="custom-select">
                      <option selected>Selecione</option>
                    </select>                
                </div>
                <div class="form-group col-md-6">
                    <label for="nome">Veículo:</label>
                    <select class="custom-select">
                      <option selected>Selecione</option>
                    </select>                
                </div>
                <div class="form-group col-md-12 text-right">
                	<br>
                	<br>
                    <button type="submit" class="btn btn-success btn-lg pull-right" id="btnEnviar" name="btnEnviar">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Vincular
                    </button>
                    <a role="button" href="gerenciar-banner.php" class="btn btn-link btn-lg">
                        Cancelar
                    </a>
                </div>
            </div>
          </form>
        </div>
    </div>

      <div class="card mb-3 border-primary">
        <div class="card-header bg-primary text-white">
          Relatório de Entregas</div>
        <div class="card-body text-center">
            <div class="form-group text-left">
                <label for="nome">Buscar pelo Cliente:</label>
                <input type="text" class="form-control" id="nome">                 
            </div>
            <p class="text-center">Entregas nos Dias:</p>  
            <form style="padding-left: 200px" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="dd/mm/aaaa">
                  <div class="input-group-append">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div> 
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="dd/mm/aaaa">
                  <div class="input-group-append">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>                 
                </form>
            <br>
            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> BUSCAR</button>
            </div>
          <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-center">Nº do Pedido</th>
                  <th>Data do Pedido</th>
                  <th>Cliente</th>
                  <th class="text-center">Valor Total</th>
                  <th>Entregador</th>
                  <th class="text-center not-ordering">Ações</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                    for($i = 1500; $i > 1400; $i--) {
                  ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td><?= $faker->date("d/m/Y", 'now') ?></td>
                        <td><?php echo $faker->firstName ?></td>
                        <td class="text-center">R$ <?php echo number_format($faker->randomFloat(NULL, 10, 120), 2, ",", ".") ?></td>
                        <td><?php echo $faker->firstName ?></td>
                        <td class="text-center">
                          <button type="submit" class="btn btn-info btn-acao" title="Editar Cliente" name="editar">
                              <i class="fa fa-pencil" aria-hidden="true"></i>
                          </button>
                          <button type="submit" class="btn btn-danger btn-acao" name="deletar" title="Excluir Funcionalidade" >
                              <i class="fa fa-close" aria-hidden="true"></i>
                          </button>
                        </td>
                    </tr>
                  <?php
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>


<?php include_once './rodape.php'; ?>