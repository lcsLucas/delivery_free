</div>

<footer class="text-white" id="rodape">

    <div id ="galeria-imagens" class="owl-carousel">

        <img src="<?= $baseurl ?>img/galeria-principal/1.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/2.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/3.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/4.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/5.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/6.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/7.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/8.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/9.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/10.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/11.jpg" alt="" class="img-fluid w-100">
        <img src="<?= $baseurl ?>img/galeria-principal/12.jpg" alt="" class="img-fluid w-100">

    </div>

    <div class="container text-center">

        <div class="wrapper-sociais">

            <ul class="nav d-flex justify-content-center">

                <li class="nav-item">
                    <a class="icone-redes-sociais" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>

                <li class="nav-item mx-4">
                    <a class="icone-redes-sociais" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="icone-redes-sociais" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>

            </ul>

        </div>

        <a class="brand my-4" href="">
            Delivery Free
        </a>

        <div class="my-3" id="info">

            <p class="mx-0 my-2">Delivery Free <span class="text-danger mx-3">|</span> Rua Washington Luiz, 1000 - Presidente Prudente - SP<span class="text-danger mx-3">|</span> Telefone: (18) 3333-3333</p>
            <p class="text-muted my-1">Copyright &copy; <?= date('Y') ?> Delivery Free. Todos os direitos reservados</p>

        </div>

        <a target="_blank" id="link-parceiro" class="bg-danger" href="<?= $baseurl ?>parceiro">
            <i class="fas fa-handshake"></i> Seja um Parceiro
        </a>

    </div>

    <a target="_blank" href="<?= $baseurl ?>help" id="btn-help">
        <i class="far fa-question-circle"></i>
    </a>

</footer>

</div>

<link rel="stylesheet" href="<?= $baseurl ?>css/estilo.css">
<script src="<?= $baseurl ?>vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= $baseurl ?>vendor/bootstrap/js/popper.min.js"></script>
<script src="<?= $baseurl ?>vendor/bootstrap/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="<?= $baseurl ?>vendor/owlcarousel2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?= $baseurl ?>vendor/owlcarousel2.3.4/assets/owl.theme.default.min.css">
<script src="<?= $baseurl ?>vendor/owlcarousel2.3.4/owl.carousel.min.js"></script>

<?php if (!empty($validation)) { ?>
    <script src="<?= $baseurl ?>vendor/jquery-validate/jquery.validate.min.js"></script>
    <script src="<?= $baseurl ?>vendor/jquery-validate/localization/messages_pt_BR.min.js"></script>
<?php } ?>

<?php if(!empty($mask)){?>
    <script src="<?= $baseurl ?>vendor/mask/jquery.mask.min.js"></script>
    <script src="<?= $baseurl ?>vendor/mask/maskMoney.min.js"></script>
<?php } ?>

<?php
if(!empty($steps)) {
    ?>
    <link rel="stylesheet" href="<?= $baseurl ?>vendor/jquery-steps/jquery.steps.css">
    <script src="<?= $baseurl ?>vendor/jquery-steps/jquery.steps.min.js"></script>
    <?php
}
?>

<?php if(!empty($datetimepicker)){ ?>
    <link rel="stylesheet" href="<?= $baseurl ?>vendor/datetimepicker/css/bootstrap-datepicker.min.css" />
    <script src="<?= $baseurl ?>vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= $baseurl ?>vendor/datetimepicker/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<?php } ?>

<?php if (!empty($alert_zebra)) { ?>
    <link rel="stylesheet" href="<?= $baseurl ?>vendor/zebra-dialog/dist/css/materialize/zebra_dialog.min.css" />
    <script src="<?= $baseurl ?>vendor/zebra-dialog/dist/zebra_dialog.min.js"></script>
<?php } ?>

<?php if (!empty($jquery_card)) { ?>
    <link rel="stylesheet" href="<?= $baseurl ?>vendor/jquery-card/card.css" />
    <script src="<?= $baseurl ?>vendor/jquery-card/jquery.card.js"></script>
    <script src="<?= $baseurl ?>vendor/jquery-card/card.js"></script>
<?php } ?>

<?php if(isset($fancybox)){ ?>
    <link href="<?= $baseurl ?>vendor/fancybox/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= $baseurl ?>vendor/fancybox/jquery.fancybox.min.js" type="text/javascript"></script>
<?php } ?>

<script>const baseurl = '<?= $baseurl ?>';</script>
<script src="<?= $baseurl ?>js/script.js"></script>
</body>
</html>