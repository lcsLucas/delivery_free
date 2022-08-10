<?php

include_once "topo.php";
include_once './sistema_delivery/classes/Empresa.php';

$filtro = filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS);

$empresa = new Empresa();
$todos_restaurantes = $empresa->listar_ativas($filtro);


?>

    <div id="lista-restaurantes" class="container">

        <header class="mb-3">

            <h2 id="titulo-pagina" class="text-center">

				<?= !empty($filtro) ? 'resultados de: "' . $filtro . '"' : 'Restaurantes' ?>

                <hr>
            </h2>

        </header>

        <div id="filtro" class="text-right">

            <div class="form-group">
                <label class="font-weight-bold" for="sel_pesquisa">Ordenar Por:</label>
                <select class="form-control ml-auto" style="max-width: 200px;" id="sel_pesquisa">
                    <option>Relevância</option>
                </select>
            </div>

            <!-- https://tympanus.net/Development/SimpleDropDownEffects/index6.html -->

        </div>

        <?php

        if (!empty($todos_restaurantes)) {

            ?>

            <div class="row">

                <?php

                foreach ($todos_restaurantes as $restaurante) {

                    ?>

                    <div class="col-sm-12 col-md-6">

                        <a href="<?= $baseurl ?>restaurante/<?= $restaurante['emp_id'] ?>/<?= tiraAcentos2(utf8_encode($restaurante['emp_nome'])) ?>">

                            <div class="media restaurante mb-4">
                                <div class="wrapper-img align-self-center">
                                    <img src="img/restaurantes/logos/<?= $restaurante['emp_logo'] ?>" class="img-responsive w-100 d-block" alt="logo <?= utf8_encode($restaurante['emp_nome']) ?>">
                                </div>
                                <div class="media-body">
                                    <h3 class="titulo-restaurante m-0"><?= utf8_encode($restaurante['emp_nome']) ?></h3>

                                    <div class="info-restaurante mt-2">

                                        <p class="m-0"><i class="fas fa-utensils mr-1"></i> <?= utf8_encode($restaurante['categoria']) ?></p>
                                        <p class="m-0"><i class="far fa-clock mr-1"></i> <?= $restaurante['tempo1'] ?>min ~ <?= $restaurante['tempo2'] ?>min</p>
                                        <div class="ranting mt-2">
                                            <p class="m-0">Avaliação</p>

                                            <?php

                                                $avaliacao = intval($restaurante['media_avaliacoes']);
                                                $total_avaliacoes = intval($restaurante['total_avaliacoes']);

                                                for ($i = 1; $i <= 5; $i++) {

                                                    if ($i <= intval($avaliacao)) {
                                                        ?>
                                                        <i class="fas fa-star"></i>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <i class="far fa-star"></i>
                                                        <?php
                                                    }

                                                }

                                                if ($total_avaliacoes < 5)
                                                    echo '<span class="badge bg-success bg-cor-principal text-white ml-2">Novo</span>';

                                            ?>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </a>

                    </div>

                    <?php

                }

                ?>

            </div>

            <?php

        } else {
            ?>

            <p class="text-center text-muted">Nenhum restaurante encontrado</p>

            <?php
        }

        ?>

    </div>

<?php

include_once "rodape.php";

?>
