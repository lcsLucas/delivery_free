<?php

$unique = date('YmdHis');

?>

<div class="complemento" style="position:relative; border: 1px solid #CCC;background: #EEE; border-radius: 2px; margin-bottom: 20px; padding: 20px 15px;">
<button class="btn btn-danger remover-complemento" style="position: absolute;top: -19px;right: -18px;border-radius: 50%;" type="button">
    <i class="fa fa-times text-white"></i>
</button>
    <div class="row">

        <div class="col-sm-12 col-md-6">

            <div class="form-group">

                <label for="cat-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Categoria do Complemento:</label>
                <input autofocus maxlength="255" name="cat_complementos[]" id="cat-<?= $unique ?>" type="text" class="form-control form-control-sm"  required>
                <input type="hidden" name="id_complementos[]" value="idcomp_<?= $unique ?>">
                <input type="hidden" name="unique[]" value="<?= $unique ?>">
            </div>

        </div>

        <div class="col-sm-12 col-md-2 text-center">

            <label for="obg-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Obrigatório</label>
            <input id="obg-<?= $unique ?>" name="cat_obg[]" class="form-control checkbox" type="checkbox" value="1">

        </div>

        <div class="col-sm-12 col-md-2 text-center">

            <div class="form-group form-control-sm">

                <label for="min-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;">Qtde Min</label>
                <input id="min-<?= $unique ?>" name="min_cat[]" maxlength="3" type="text" class="form-control form-control-sm text-center mascara-numero" >

            </div>

        </div>

        <div class="col-sm-12 col-md-2 text-center">

            <div class="form-group form-control-sm">

                <label for="max-<?= $unique ?>" style="font-size: .85rem; font-weight: bold;" >Qtde Max</label>
                <input id="max-<?= $unique ?>" name="max_cat[]" maxlength="3" type="text" class="form-control form-control-sm text-center mascara-numero" >

            </div>

        </div>

        <div class="col-sm-12">

            <hr>

        </div>

        <div class="col-sm-12">

            <div class="wrapper-opcoes">

                <h6 class="text-center text-muted text-uppercase"><strong>Opções do complemento</strong></h6>

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
                            <input id="preco-<?= $unique ?>" value="0,00" name="preco_idcomp_<?= $unique ?>[]" type="text" maxlength="6" class="form-control form-control-sm mascara-dinheiro text-center" >

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

            </div>

        </div>

        <div class="form-group col-12 text-center mt-4">

            <button type="button" class="btn btn-primary btn-sm add-complemento">Adicionar Opção</button>

        </div>

    </div>

</div>