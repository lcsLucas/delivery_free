    </div>
    <footer class="sticky-footer d-print-none">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Delivery Free <?= date('Y') ?></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tem Certeza Que Deseja Sair?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Clique no botão abaixo "Logout" se você deseja realmente encerrar a sessão atual.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="sair.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    
    <?php if(isset($dataTables)){ ?>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <?php } ?>
    
    <?php if(isset($chart)){ ?>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <?php } ?>
    
    <?php if(isset($fancybox)){ ?>
        <link href="vendor/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
        <script src="vendor/fancybox/jquery.fancybox.js" type="text/javascript"></script>
    <?php } ?>

    <?php if(isset($editor)){?>
        <script src="vendor/ckeditor-4/ckeditor.js"></script>
    <?php } ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>
    <link rel="stylesheet" href="plugins/datetimepicker/datetimepicker.css">
    <script src="plugins/datetimepicker/datetimepicker.js"></script>

    <?php if(isset($mask)){?>
        <script src="vendor/mask/jquery.mask.min.js"></script>
        <script src="vendor/mask/maskMoney.min.js"></script>
    <?php } ?>
        
    <?php if(isset($select2)){ ?>
    <!-- Multi Select Plugin Js -->
        <link rel="stylesheet" href="plugins/bootstrap-select/css/select2.min.css">
        <script src="plugins/bootstrap-select/js/select2.min.js"></script>
    <?php } ?>

    <?php if(isset($multi_select)){ ?>
        <!-- Multi Select Plugin Js -->
        <link rel="stylesheet" href="vendor/multi-select/css/multi-select.css">
        <script src="vendor/multi-select/js/jquery.multi-select.js"></script>
    <?php } ?>

    <?php if(isset($dropArea)){ ?>
        <link href="vendor/Droparea/droparea.css" rel="stylesheet" type="text/css"/>
        <script src="vendor/Droparea/droparea.min.js" type="text/javascript"></script>
    <?php } ?>

<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/locale/pt-br.js"></script>-->
<!--    <link rel="stylesheet" href="plugins/datetimepicker/datetimepicker.css">-->
<!--    <script src="plugins/datetimepicker/datetimepicker.js"></script>-->
    
    <!-- Custom scripts for this page
        <script src="js/sb-admin-charts.js"></script>
    -->
    <script src="plugins/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script src="js/sb-admin.js"></script>
    <script src="js/scripts.js"></script>
    
</body>
</html>