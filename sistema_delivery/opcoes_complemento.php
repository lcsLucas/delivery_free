<?php

$unique = filter_input(INPUT_GET, 'unique', FILTER_SANITIZE_SPECIAL_CHARS);

?>

<div class="row opcoes-complementos">

    <div class="col-sm-12 col-md-4">

        <div class="form-group">

            <label for="nome-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Nome:</label>
            <input id="nome-<?= $unique ?>" name="nome_idcomp_<?= $unique ?>[]" maxlength="255" type="text" class="form-control form-control-sm" required>
        </div>

    </div>

    <div class="col-sm-12 col-md-4">

        <div class="form-group">

            <label for="descr-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Descrição:</label>
            <input id="descr-<?= $unique ?>" name="descr_idcomp_<?= $unique ?>[]" type="text" class="form-control form-control-sm" >

        </div>

    </div>

    <div class="col-sm-12 col-md-2 text-center">

        <div class="form-group form-control-sm">

            <label for="preco-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Preço</label>
            <input id="preco-<?= $unique ?>" value="0,00" name="preco_idcomp_<?= $unique ?>[]" maxlength="6" type="text" class="form-control form-control-sm mascara-dinheiro text-center" >

        </div>

    </div>

    <div class="col-sm-12 col-md-2 text-center">
        <div class="form-group">
            <br>
            <button type="button" style="font-size: .8rem; font-weight: bold;" class="btn btn-danger text-danger text-uppercase remove-opcao">
                <i class="fa fa-times text-white"></i>
            </button>
        </div>

    </div>

</div>