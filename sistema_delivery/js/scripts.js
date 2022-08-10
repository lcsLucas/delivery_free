$(function() {

    window.addEventListener('keydown', function (e) {
        var code = e.which || e.keyCode;
        if (code == 112) {
            e.preventDefault();
            window.open('help.php');
        }

        return true;
    });

    var requisicao = false;

    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {

        form.addEventListener('submit', function(event) {

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
            }

        }, false);
    });

    if ($('#ckeditor').length)
        CKEDITOR.replace( 'ckeditor' );

    if($(".fancyboxgerarsenha").length)
    $(".fancyboxgerarsenha").fancybox({
        maxWidth	: 350,
        maxHeight	: 120,
        fitToView	: false,
        width		: '70%',
        height		: '70%',
        autoSize	: false,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });

    if ($("#drop1").length) {

        var options1 = {
            url: 'server.php',
            file_holder: '#file_1',
            file_preview: '#file_preview_1',
            success: function (server_return, name, uploaded_file) {
            }
        };

        $('#drop1').droparea(options1);

    }

    if ($("#drop2").length) {

        var options2 = {
            url: 'server.php',
            file_holder: '#file_2',
            file_preview: '#file_preview_2',
            success: function (server_return, name, uploaded_file) {
            }
        };

        $('#drop2').droparea(options2);

    }

    if ($("#tinymce, .tinymce").length) {
        //TinyMCE
        tinymce.init({
            selector: "#tinymce, .tinymce",
            plugins: "a11ychecker, advcode, linkchecker, media mediaembed, powerpaste, tinycomments, tinydrive, tinymcespellchecker",
            toolbar: "a11ycheck, code, insertfile, tinycomments"
        });
    }

    if($(".dataTable").length) {
        $('.dataTable').DataTable({
            paging: false,
            lengthChange: true,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: true,
            bJQueryUI: true, 
            responsive: true,
            oLanguage: { 
            sProcessing: "Processando...", 
            sLengthMenu: "Mostrar _MENU_ registros", 
            sZeroRecords: "Não foram encontrados resultados", 
            sInfo: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            sInfoEmpty: "Nenhum registro encontrado",
            sInfoFiltered: "", 
            sInfoPostFix: "", 
            sSearch: "Buscar:", 
            sUrl: "", 
                oPaginate: { 
                sFirst: "Primeiro", 
                sPrevious: "Anterior", 
                sNext: "Seguinte", 
                sLast: "Último" 
                } 
            }
        });
    }
    
      $("body").on("click",".excluir", function(e) {
          e.preventDefault();
          var $this = $(this);
          
            swal({
                title: "Você tem certeza?",
                text: "Deseja realmente deletar esta informação do sistema? Você não será capaz de recuperar este registro! Atenção Esse Registro Pode Estar Atrelado a Outros Registros",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, deletar isso!!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                var input_del = $("<input>");
                input_del.prop("name","deletar");
                input_del.prop("type","hidden");

                var form = $this.parent("form");
                form.append(input_del);
                form.submit();
            });          
      });

    if ($('.rejeitar-pedido').length)
        $(".rejeitar-pedido").click(function(e) {
            e.preventDefault();
            var $this = $(this);

            swal({
                title: "REJEITAR PEDIDO",
                text: "Atenção você está preste a rejeitar esse pedido, tem certeza que deseja fazer isso?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, rejeitar!!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                var input_del = $("<input>");
                input_del.prop("name","rejeitar");
                input_del.prop("type","hidden");

                var form = $this.parent("form");
                form.append(input_del);
                form.submit();
            });
        });

    $('#selMedida').change(function() {
        if (0 === $(this).prop("selectedIndex")) {
            $(this).siblings("div.text-muted").html(" ");
        } else {
            var option = $(this).children("option[value=\""+ $(this).val() +"\"]");


            $(this).siblings("div.text-muted").html("cálculo do estoque = " + option.data("formula"));
        }
    });

    if($(".mascara-dinheiro").length)
        $(".mascara-dinheiro").maskMoney({thousands:'.', decimal:',', allowZero:false});

    if($(".mascara-hora").length)
        $('.mascara-hora').mask('00:00',{placeholder: "hh:mm"});

    if($(".mascara-cep").length)
        $('.mascara-cep').mask('00000-000');

    if($(".mascara-numero").length)
        $('.mascara-numero').mask('000000');

    if($(".mascara-telefone").length)
        $('.mascara-telefone').mask('(00) 0000-0000');

    if($(".mascara-celular").length)
        $('.mascara-celular').mask('(00) 00000-0000');

    if($(".mascara-cnpj").length)
        $('.mascara-cnpj').mask('00.000.000/0000-00');

    if ($(".select2").length) {
        $(".select2").select2({
            placeholder: 'Selecione um opção'
        });
    }

    $("#sel-insumo, #sel-produto").on("change", function (e) {
        var $this = $(this);
        var uni = $this.find(":selected").data("medida");

        $("#sigla-uni, #detalhe-uni").html(uni);

    });

    $("#btn-add-insumo").click(function () {
        var $this = $(this);
        var pai = "";
        var insumo = $("#sel-insumo");
        var qtde = $("#qtde");
        var preco = $("#preco");

        var val_qtde = qtde.maskMoney('unmasked')[0];
        var val_preco = preco.maskMoney('unmasked')[0];

        if (!$.isNumeric(insumo.val())) {
            var i_erro = true;

            pai = insumo.parent(".form-group");
            pai.find(".msg-erro").html("selecione um insumo");
        } else{
            pai = insumo.parent(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!$.isNumeric(val_qtde) || val_qtde === 0) {
            var q_erro = true;

            pai = qtde.parents(".form-group");
            pai.find(".msg-erro").html("informe uma qtde");
        } else{
            pai = qtde.parents(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!$.isNumeric(val_preco) || val_preco === 0) {
            var p_erro = true;

            pai = preco.parents(".form-group");
            pai.find(".msg-erro").html("informe o preço");
        } else {
            pai = preco.parents(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!p_erro && !q_erro && !i_erro) {
            $.ajax({
                type: "POST",
                url: "ajax-requisicoes.php",
                data: "addInsumo=&insumo=" + insumo.val() + "&qtde=" + val_qtde + "&preco=" + val_preco,
                dataType: "json",
                beforeSend: function () {
                    $this.html("<i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center disabled");
                    $(".btn-excluir-insumo").addClass("text-center disabled");
                }
            }).done(function(retorno) {

                if (retorno["status"]) {
                    constroiTabelaInsumos(retorno["produtos"]);
                    $(".valor-itens").html("R$ " + retorno["totalGeral"]);
                    $("#input_total_itens").val(retorno["totalGeral2"]);
                } else {
                    swal(retorno["titulo"], retorno["mensagem"], "error");
                }

                $this.html("Adicionar").removeClass("disabled");
                $(".btn-excluir-insumo").removeClass("disabled");

                qtde.val("");preco.val("");
                insumo.val('0').trigger('change');

            }).fail(function () {
                $this.html("Adicionar").removeClass("disabled");
                $(".btn-excluir-insumo").removeClass("disabled");
                swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
            });
        }

        return false;
    });

    $("#btn-add-produto").click(function () {
        var $this = $(this);
        var pai = "";
        var produto = $("#sel-produto");
        var qtde = $("#qtde");
        var preco = $("#preco");

        var val_qtde = qtde.maskMoney('unmasked')[0];
        var val_preco = preco.maskMoney('unmasked')[0];

        if (!$.isNumeric(produto.val())) {
            var i_erro = true;

            pai = produto.parent(".form-group");
            pai.find(".msg-erro").html("selecione um produto");
        } else{
            pai = produto.parent(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!$.isNumeric(val_qtde) || val_qtde === 0) {
            var q_erro = true;

            pai = qtde.parents(".form-group");
            pai.find(".msg-erro").html("informe uma qtde");
        } else{
            pai = qtde.parents(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!$.isNumeric(val_preco) || val_preco === 0) {
            var p_erro = true;

            pai = preco.parents(".form-group");
            pai.find(".msg-erro").html("informe o preço");
        } else {
            pai = preco.parents(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!p_erro && !q_erro && !i_erro) {
            $.ajax({
                type: "POST",
                url: "ajax-requisicoes.php",
                data: "addProduto=&produto=" + produto.val() + "&qtde=" + val_qtde + "&preco=" + val_preco,
                dataType: "json",
                beforeSend: function () {
                    $this.html("<i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center disabled");
                    $(".btn-excluir-produto").addClass("text-center disabled");
                }
            }).done(function(retorno) {

                if (retorno["status"]) {
                    constroiTabelaProdutos(retorno["produtos"]);
                    $(".valor-itens").html("R$ " + retorno["totalGeral"]);
                    $("#input_total_itens").val(retorno["totalGeral2"]);
                } else {
                    swal(retorno["titulo"], retorno["mensagem"], "error");
                }

                $this.html("Adicionar").removeClass("disabled");
                $(".btn-excluir-produto").removeClass("disabled");

                qtde.val("");preco.val("");
                produto.val('0').trigger('change');

            }).fail(function () {
                $this.html("Adicionar").removeClass("disabled");
                $(".btn-excluir-produto").removeClass("disabled");
                swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
            });
        }

        return false;
    });

    $("#btn-add-produto-saida").click(function () {
        var $this = $(this);
        var pai = "";
        var produto = $("#sel-produto");
        var qtde = $("#qtde");
        var preco = $("#preco");

        var val_qtde = qtde.maskMoney('unmasked')[0];
        var val_preco = preco.maskMoney('unmasked')[0];

        if (!$.isNumeric(produto.val())) {
            var i_erro = true;

            pai = produto.parent(".form-group");
            pai.find(".msg-erro").html("selecione um produto");
        } else{
            pai = produto.parent(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!$.isNumeric(val_qtde) || val_qtde === 0) {
            var q_erro = true;

            pai = qtde.parents(".form-group");
            pai.find(".msg-erro").html("informe uma qtde");
        } else{
            pai = qtde.parents(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!$.isNumeric(val_preco) || val_preco === 0) {
            var p_erro = true;

            pai = preco.parents(".form-group");
            pai.find(".msg-erro").html("informe o preço");
        } else {
            pai = preco.parents(".form-group");
            pai.find(".msg-erro").html("");
        }

        if (!p_erro && !q_erro && !i_erro) {
            $.ajax({
                type: "POST",
                url: "ajax-requisicoes.php",
                data: "addProdutoSaida=&produto=" + produto.val() + "&qtde=" + val_qtde + "&preco=" + val_preco,
                dataType: "json",
                beforeSend: function () {
                    $this.html("<i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center disabled");
                    $(".btn-excluir-produto-saida").addClass("text-center disabled");
                }
            }).done(function(retorno) {

                if (retorno["status"]) {
                    constroiTabelaProdutosSaida(retorno["produtos"]);
                    $(".valor-itens").html("R$ " + retorno["totalGeral"]);
                    $("#input_total_itens").val(retorno["totalGeral2"]);
                } else {
                    swal(retorno["titulo"], retorno["mensagem"], "error");
                }

                $this.html("Adicionar").removeClass("disabled");
                $(".btn-excluir-produto-saida").removeClass("disabled");

                qtde.val("");preco.val("");
                produto.val('0').trigger('change');

            }).fail(function () {
                $this.html("Adicionar").removeClass("disabled");
                $(".btn-excluir-produto-saida").removeClass("disabled");
                swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
            });
        }

        return false;
    });

    $("#lista-insumo tbody").on("click", ".btn-excluir-insumo", function () {
        $this = $(this);

        $.ajax({
            type: "POST",
            url: "ajax-requisicoes.php",
            data: "remInsumo=&insumo=" + $this.data("id"),
            dataType: "json",
            beforeSend: function () {
                $this.html("<i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center disabled");
                $(".btn-excluir-insumo, #btn-add-insumo").addClass("text-center disabled");
            }
        }).done(function(retorno) {

            if (retorno["status"]) {
                constroiTabelaInsumos(retorno["produtos"]);
                $(".valor-itens").html("R$ " + retorno["totalGeral"]);
            } else {
                swal(retorno["titulo"], retorno["mensagem"], "error");
            }

            $this.html("<i class=\"fa fa-close\"></i>");
            $(".btn-excluir-insumo, #btn-add-insumo").removeClass("disabled");
        }).fail(function () {
            $(".btn-excluir-insumo, #btn-add-insumo").removeClass("disabled");
            swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
        });

        return false;
    });

    $("#lista-produto tbody").on("click", ".btn-excluir-produto", function () {
        $this = $(this);

        $.ajax({
            type: "POST",
            url: "ajax-requisicoes.php",
            data: "remProduto=&produto=" + $this.data("id"),
            dataType: "json",
            beforeSend: function () {
                $this.html("<i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center disabled");
                $(".btn-excluir-produto, #btn-add-produto").addClass("text-center disabled");
            }
        }).done(function(retorno) {

            if (retorno["status"]) {
                constroiTabelaProdutos(retorno["produtos"]);
                $(".valor-itens").html("R$ " + retorno["totalGeral"]);
            } else {
                swal(retorno["titulo"], retorno["mensagem"], "error");
            }

            $this.html("<i class=\"fa fa-close\"></i>");
            $(".btn-excluir-produto, #btn-add-produto").removeClass("disabled");
        }).fail(function () {
            $(".btn-excluir-produto, #btn-add-produto").removeClass("disabled");
            swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
        });

        return false;
    });

    $("#lista-produto tbody").on("click", ".btn-excluir-produto-saida", function () {
        $this = $(this);

        $.ajax({
            type: "POST",
            url: "ajax-requisicoes.php",
            data: "remProdutoSaida=&produto=" + $this.data("id"),
            dataType: "json",
            beforeSend: function () {
                $this.html("<i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center disabled");
                $(".btn-excluir-produto-saida, #btn-add-produto-saida").addClass("text-center disabled");
            }
        }).done(function(retorno) {

            if (retorno["status"]) {
                constroiTabelaProdutosSaida(retorno["produtos"]);
                $(".valor-itens").html("R$ " + retorno["totalGeral"]);
            } else {
                swal(retorno["titulo"], retorno["mensagem"], "error");
            }

            $this.html("<i class=\"fa fa-close\"></i>");
            $(".btn-excluir-produto-saida, #btn-add-produto-saida").removeClass("disabled");
        }).fail(function () {
            $(".btn-excluir-produto-saida, #btn-add-produto-saida").removeClass("disabled");
            swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
        });

        return false;
    });

    if ($('.datepicker').length)
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa pt-3 pb-3 fa-chevron-left',
            next: 'fa pt-3 pb-3 fa-chevron-right',
            today: 'fa fa-bullseye',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        }
    });
    
    $("#btn-pesquisa").click(function (event) {
        event.preventDefault();
        var $this = $(this);
        var input = $("#numero");
        var input2 = $("#input-pesq");

        if ($.isNumeric(input.val())) {
            input2.val(input.val());
            (input2.siblings(".btn-acao")).trigger("click");
        }

    });
    
    $("#relatorio-entrada-insumos").click(function () {

        var nome = $(this).data("nome");
        window.open("controi-relatorios.php?rel=entrada-insumos&nome=" + encodeURI(nome),"_blank");

        return false;
    });

    $('.modal-parcelas-contas').on('show.bs.modal', function (e) {
        var $this = $(this);
        var entrada = $("#input_entrada");
        var parcela = $("#input_parcela");
        var total_geral = $("#input_total_geral");
        var total_parcela = $("#input_parcela_total");
        var resto = $("#resto_conta");
        var dias = 30;
        var data = new Date();

        if ($.isNumeric(entrada.val()) && parseInt(entrada.val()) === 1) {
            $this.find("#titulo-modal").html("Dados da Parcela de Entrada");

            var result = parseFloat(total_geral.val()) / (parseInt(total_parcela.val()) + 1);

            $("#data_conta").val(dataFormatada(data));
            $("#valor_conta").val(number_format(result,2,",","."));

        } else {
            $this.find("#titulo-modal").html("Dados da Parcela Nº " + parcela.val());

            var result = parseFloat(total_geral.val()) / (parseInt(total_parcela.val()));

            data.setDate(data.getDate() + (dias*parseInt(parcela.val())));

            $("#data_conta").val(dataFormatada(data));
            $("#valor_conta").val(number_format(result,2,",","."));
        }

    });
    
    $("#btnConta").click(function () {
        var data_conta = $("#data_conta");
        var input_conta = $("#valor_conta");
        var entrada = $("#input_entrada");
        var parcela = $("#input_parcela");
        var total_geral = $("#input_total_geral");
        var total_parcela = $("#input_parcela_total");
        var resto = $("#resto_conta");
        var valor_conta = input_conta.maskMoney('unmasked')[0];
        var dias = 30;
        var data = new Date();

        var pai = "";
        
        if (!$.isNumeric(valor_conta) || valor_conta == 0) {
            pai = input_conta.parents(".form-group");
            pai.find(".msg-erro").html("Esse campo é obrigatório");
            ok_valor = false;
        } else {
            pai = input_conta.parents(".form-group");
            pai.find(".msg-erro").html("");
            ok_valor = true;
        }

        if (!data_conta.val().length) {
            pai = data_conta.parents(".form-group");
            pai.find(".msg-erro").html("Esse campo é obrigatório");
            ok_valor = false;
        } else {
            pai = data_conta.parents(".form-group");
            pai.find(".msg-erro").html("");
            ok_data = true;
        }

        if (ok_data && ok_valor) {
            $("#dados-parcelas").append(
                $("<input>").prop({
                    "type" : "hidden",
                    "name" : "valor_conta[]",
                    "value" : valor_conta
                })
            ).append(
                $("<input>").prop({
                    "type" : "hidden",
                    "name" : "data_conta[]",
                    "value" : data_conta.val()
                })
            );

            if ($.isNumeric(entrada.val()) && parseInt(entrada.val()) === 1) {

                var result = (parseFloat(total_geral.val()) + parseFloat(resto.val())) / (parseInt(total_parcela.val()) + 1);
                entrada.val("0");
                $("#dados-parcelas").append(
                    $("<input>").prop({
                        "type" : "hidden",
                        "name" : "entrada"
                    })
                );

            } else {

                var result = (parseFloat(total_geral.val()) + parseFloat(resto.val())) / (parseInt(total_parcela.val()));

                parcela.val(parseInt(parcela.val()) + 1);
            }

            if (parseInt(parcela.val()) <= parseInt($("#input_parcela_total").val())){

                $('.modal-parcelas-contas').find("#titulo-modal").html("Dados da Parcela Nº " + $("#input_parcela").val());

                data.setDate(data.getDate() + (dias*parseInt(parcela.val())));

                $("#data_conta").val(dataFormatada(data));
                $("#valor_conta").val(number_format(result,2,",","."));

                if (valor_conta < result) {
                    $("#resto_conta").val(result - valor_conta);
                }

            } else {
                requisicao = true;
               $("#btnEnviar").trigger("click");
            }

        }


    });

    $("#form-entrada-insumos").submit(function (event) {

        if (!requisicao) {

            $("#dados-parcelas").html("");

            var id_pag = $("#pagamento").val();
            var total_valor = parseFloat($("#input_total_itens").val());
            var frete = parseFloat($("#frete").maskMoney('unmasked')[0]);
            var desconto = parseFloat($("#desconto").maskMoney('unmasked')[0]);
            var outros = parseFloat($("#outros").maskMoney('unmasked')[0]);

            total_valor += (frete + outros);
            total_valor -= desconto;



            if ($.isNumeric(id_pag) && id_pag !== "0") {

                if (total_valor <= 0) {
                    swal("Atenção", "O valor total está Menor ou igual a R$ 0,00", "warning");
                    event.preventDefault();
                    event.stopPropagation();
                } else {

                    $.ajax({
                        async: false,
                        url: "ajax-requisicoes.php",
                        data: {
                            "gera-contas": "",
                            "id_forma": id_pag
                        },
                        type: "POST",
                        dataType: "json"
                    }).done(function (retorno) {

                        if (retorno["status"]) {

                            var resultado = JSON.parse(retorno["retorno"]);

                            if (resultado.numParcela !== 0 || resultado.entrada !== 0) {

                                $("#input_total_geral").val(total_valor);
                                $("#input_entrada").val(resultado.entrada);
                                $("#input_parcela_total").val(resultado.numParcela);

                                $(".abre-modal-parcelas").trigger("click");

                                event.preventDefault();
                                event.stopPropagation();
                            }


                        } else {
                            swal(retorno["titulo"], retorno["mensagem"], "error");
                        }

                    }).fail(function () {
                        swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
                    });

                }

            }

        }

    });

    $("#form-produtos").submit(function (event) {

        if (!requisicao) {

            $("#dados-parcelas").html("");

            var id_pag = $("#pagamento").val();
            var total_valor = parseFloat($("#input_total_itens").val());
            var frete = parseFloat($("#frete").maskMoney('unmasked')[0]);
            var desconto = parseFloat($("#desconto").maskMoney('unmasked')[0]);
            var outros = parseFloat($("#outros").maskMoney('unmasked')[0]);

            total_valor += (frete + outros);
            total_valor -= desconto;



            if ($.isNumeric(id_pag) && id_pag !== "0") {

                if (total_valor <= 0) {
                    swal("Atenção", "O valor total está Menor ou igual a R$ 0,00", "warning");
                    event.preventDefault();
                    event.stopPropagation();
                } else {

                    $.ajax({
                        async: false,
                        url: "ajax-requisicoes.php",
                        data: {
                            "gera-contas": "",
                            "id_forma": id_pag
                        },
                        type: "POST",
                        dataType: "json"
                    }).done(function (retorno) {

                        if (retorno["status"]) {

                            var resultado = JSON.parse(retorno["retorno"]);

                            if (resultado.numParcela !== 0 || resultado.entrada !== 0) {

                                $("#input_total_geral").val(total_valor);
                                $("#input_entrada").val(resultado.entrada);
                                $("#input_parcela_total").val(resultado.numParcela);

                                $(".abre-modal-parcelas").trigger("click");

                                event.preventDefault();
                                event.stopPropagation();
                            }


                        } else {
                            swal(retorno["titulo"], retorno["mensagem"], "error");
                        }

                    }).fail(function () {
                        swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
                    });

                }

            }

        }

    });
    
    $("#tpDesconto1").change(function () {
        var valor = $("#valor");
        var porcentagem = $("#porcentagem");

        valor.addClass("d-none");
        porcentagem.removeClass("d-none");

        valor.find("input").val();
        porcentagem.find("input").val();

        valor.find("input").prop("disabled", true);
        porcentagem.find("input").prop("disabled", false);
    });

    $("#tpDesconto2").change(function () {
        var valor = $("#valor");
        var porcentagem = $("#porcentagem");

        porcentagem.addClass("d-none");
        valor.removeClass("d-none");

        porcentagem.find("input").val();
        valor.find("input").val();

        porcentagem.find("input").prop("disabled", true);
        valor.find("input").prop("disabled", false);
    });
    
    $('#porcentagem_desconto').keyup(function () {
        var $this = $(this);
        var  valor_procentagem = $this.maskMoney('unmasked')[0];
        var valor = $("#sel-promocao-produto").find(":selected").data("preco");
        var tipo_desc = ($("#tpDesconto1").prop("checked") && !$("#tpDesconto2").prop("checked")) ? 1 : 0;
        var desc_valor = $("#valor_desconto").maskMoney('unmasked')[0].toFixed(2);
        var pai = $this.parents(".form-group");

        if (valor_procentagem < 0 ) {
            $this.val('0,00');
            valor_procentagem = 0.00;
        } else if(valor_procentagem > 100) {
            $this.val('100,00');
            valor_procentagem = 100.00
        }

        if ($("#sel-promocao-produto").prop('selectedIndex') > 0) {

            var $retorno  = atualizaPrecoDesconto(valor, tipo_desc, valor_procentagem, desc_valor);
            var $msg = $retorno.msg;

            $(".msg-erro").html("");
            pai.find(".msg-erro").html($msg);

        }

    });
    
    $('#valor_desconto').keyup(function () {
        var $this = $(this);
        var  valor_desconto = $this.maskMoney('unmasked')[0];
        var valor = $("#sel-promocao-produto").find(":selected").data("preco");
        var tipo_desc = ($("#tpDesconto1").prop("checked") && !$("#tpDesconto2").prop("checked")) ? 1 : 0;
        var pai = $this.parents(".form-group");

        if ($("#sel-promocao-produto").prop('selectedIndex') > 0) {

            if (valor_desconto > valor) {
                valor_desconto = valor;
                $this.val(number_format(valor_desconto, 2, ',', '.'));
            }

            var $retorno  = atualizaPrecoDesconto(valor, tipo_desc, 0, valor_desconto);
            var $msg = $retorno.msg;

            $(".msg-erro").html("");
            pai.find(".msg-erro").html($msg);

        }

    });

    $("#sel-promocao-produto").on("change", function (e) {
        var $this = $(this);
        var valor = $this.find(":selected").data("preco");
        valor = parseFloat(valor).toFixed(2);
        var tipo_desc = ($("#tpDesconto1").prop("checked") && !$("#tpDesconto2").prop("checked")) ? 1 : 0;
        var desc_porc = $("#porcentagem_desconto").maskMoney('unmasked')[0].toFixed(2);
        var desc_valor = $("#valor_desconto").maskMoney('unmasked')[0].toFixed(2);
        var $msg = "";
        var pai = $this.parents(".form-group");

        if (desc_valor > valor) {
            desc_valor = valor;
            $("#valor_desconto").val(number_format(desc_valor, 2, ',', '.'));
        }

        var $retorno  = atualizaPrecoDesconto(valor, tipo_desc, desc_porc, desc_valor);

        $msg = $retorno.msg;

        $(".msg-erro").html("");
        pai.find(".msg-erro").html($msg);

    });

    $(".desconto_promocao").keyup(debounce(function () {
        var $this = $(this);
        var $produto = $("#sel-promocao-produto");
        var tipo_desc = ($("#tpDesconto1").prop("checked") && !$("#tpDesconto2").prop("checked")) ? 1 : 0;
        var desc_porc = $("#porcentagem_desconto").maskMoney('unmasked')[0].toFixed(2);
        var desc_valor = $("#valor_desconto").maskMoney('unmasked')[0].toFixed(2);
        var $msg = "";
        var pai = $this.parents(".form-group");

        if ($produto.prop("selectedIndex") > 0) {

            var valor = $produto.find(":selected").data("preco");
            valor = parseFloat(valor).toFixed(2);

            var $retorno  = atualizaPrecoDesconto(valor, tipo_desc, desc_porc, desc_valor);
            $msg = $retorno.msg;

            $(".msg-erro").html("");
            pai.find(".msg-erro").html($msg);

        }

    }, 300));

    if ($('#sel-pedido').length)
        $('#sel-pedido').multiSelect({
            selectableHeader: "<div class='text-center btn-default'>Pedidos não Selecionados</div>",
            selectionHeader: "<div class='text-center btn-default'>Pedidos Selecionados</div>",
            cssClass: "select-pedidos",
        });

    if($('#sel-pedido-enviados').length) {
        $('#sel-pedido-enviados').multiSelect({
            selectableHeader: "<div class='text-center btn-default'>Entregas não Selecionadas</div>",
            selectionHeader: "<div class='text-center btn-default'>Entregas Selecionadas</div>",
            cssClass: "select-pedidos",
        });

        $("#ms-sel-pedido-enviados .ms-elem-selectable, #ms-sel-pedido-enviados .ms-elem-selection").each(function (index, item) {

            $(item).data('toggle', 'tooltip');
            $(item).data('placement', 'top');
            $(item).data('html', true);
            $(item).tooltip();

        });

    }

    if($("#sel-categorias").length)
        $("#sel-categorias").multiSelect({
            keepOrder: true,
            selectableHeader: "<div class='text-center btn-default'>Categorias não Selecionadas</div>",
            selectionHeader: "<div class='text-center btn-default'>Categorias Selecionadas</div>",
            cssClass: "select-categorias",
            afterSelect: function(values){
                var options_selected = $('.select-categorias').find('.ms-selection .ms-selected:first');
                $('.select-categorias').find('.ms-selection .ms-selected').find('i').remove();

                options_selected.prepend(
                    $('<i>').addClass('fa fa-star')
                );

            },

            afterDeselect: function(values){

                var options_selected = $('.select-categorias').find('.ms-selection .ms-selected:first');
                $('.select-categorias').find('.ms-selection .ms-selected').find('i').remove();

                options_selected.prepend(
                    $('<i>').addClass('fa fa-star')
                );

                console.log(values);

            },

            afterInit: function (container) {

                var options_selected = container.find('.ms-selection .ms-selected:first');

                options_selected.prepend(
                    $('<i>').addClass('fa fa-star')
                );
            }

        });
    
    $('#add-complemento').click(function () {

        $.get('complementos.php', function (retorno) {
            var complemento = $(retorno);

            $('#wrapper-complementos').append(complemento);

            $('#wrapper-complementos').find('.mascara-numero').mask('000');
            $('.wrapper-opcoes').find('.mascara-dinheiro').maskMoney({thousands:'.', decimal:',', allowZero:true});

        });

    });

    $('#wrapper-complementos').on('click', '.add-complemento', function () {
        var $this = $(this);
        var pai = $this.parents('.complemento');

        $.get('opcoes_complemento.php', {"unique": pai.find('input[name="unique[]"]').val()}, function (retorno) {

            var opcao = $(retorno);
            pai.find('.wrapper-opcoes').append(opcao);

            $('.wrapper-opcoes').find('.mascara-dinheiro').maskMoney({thousands:'.', decimal:',', allowZero:true});

        });

    });

    $('#wrapper-complementos').on('click', '.remover-complemento', function () {
        $(this).parent('.complemento').remove();
    });

    $('#wrapper-complementos').on('click', '.remove-opcao', function () {
        $(this).parents('.opcoes-complementos').remove();
    });

    $('#wrapper-complementos').on('change', 'input[type="checkbox"]', function () {
        var input_min = $(this).parents('.complemento').find('input[name="min_cat[]"]');

        if ($(this).prop('checked')) {
            input_min.val(1);
        } else {
            input_min.val('');
        }

    });
    
    $('#exibir_ocultar_complemento').click(function () {

        $('#complemento-cat-roduto').find('.complemento').toggle();

        return false;
    });
    
    $('#btn-add-prod-promocao').click(function () {
        var radio_desc = $('input[name="tpDesconto"]:checked');
        var desc_porc = $('#porcentagem_desconto');
        var desc_valor = $('#valor_desconto');
        var sel_produto = $('#sel-promocao-produto');
        var valor = $('#preco');
        var valor_desconto = $('#preco_desconto');
        var tabela = $('#lista-produto-promocao tbody');
        var ok = false;
        var str_desc = '';

        if (sel_produto.prop('selectedIndex') > 0) {
            sel_produto.parents('.form-group').find(".msg-erro").html('');

            if (radio_desc.val() === '1') {
                if (desc_porc.maskMoney('unmasked')[0] > 0) {
                    str_desc = desc_porc.val() + '%';
                    ok = true;
                }
            } else {
                if (desc_valor.maskMoney('unmasked')[0] > 0) {
                    ok = true;
                    str_desc = 'R$ ' + desc_valor.val();
                }
            }
            
            if (tabela.find('input[name="produto_id[]"][value="'+ sel_produto.val() +'"]').length)
                sel_produto.parents('.form-group').find(".msg-erro").html('Produto já adicionado na promoção');
            else {

                if (ok) {

                    var str_preco = valor.val().replace('.', '');
                    str_preco = parseFloat(str_preco.replace(',', '.'));

                    var str_descontado = valor_desconto.val().replace('.', '');
                    str_descontado = parseFloat(str_descontado.replace(',', '.'));

                    tabela.find('.remover').remove();
                    tabela.append('' +
                        '                                           <tr>\n' +
                        '\n' +
                        '                                                <td>' +
                        ''+ sel_produto.find('option:selected').text() +'' +
                        '</td>\n' +
                        '                                                <td class="text-center">R$ '+ valor.val() +'</td>\n' +
                        '                                                <td class="text-center">'+ str_desc +'</td>\n' +
                        '                                                <td class="text-center">R$ '+ valor_desconto.val() +'</td>\n' +
                        '                                                <td class="text-center">\n' +
                        '                                                    <button class="btn btn-danger remover-produto-promocao"><i class="fa fa-close"></i></button>\n' +
                        '<input type="hidden" name="produto_id[]" value="'+ sel_produto.val() +'" />\n' +
                        '<input type="hidden" name="tipo_desconto[]" value="'+ radio_desc.val() +'" />\n' +
                        '<input type="hidden" name="valor_desconto[]" value="'+ ((radio_desc.val() === '1') ? desc_porc.maskMoney('unmasked')[0] : desc_valor.maskMoney('unmasked')[0]) +'" />\n' +
                        '                                                </td>\n' +
                        '                                                \n' +
                        '                                            </tr>  ');
                }
            }

        } else {
            sel_produto.parents('.form-group').find(".msg-erro").html('Selecione o produto');
        }

        return false;
    });

    $('#lista-produto-promocao tbody').on('click', '.remover-produto-promocao', function () {
        $(this).parents('tr').remove();

        if(!$('#lista-produto-promocao tbody tr').length)
            $('#lista-produto-promocao tbody').html('<tr class="remover"><td colspan="5" class="text-center text-muted">Nenhum produto adicionado</td></tr>');

    });
    
    if ($('.avaliacao-pedido').length) {

        $('.wrapper-resposta-avaliacao').find('.responder-avaliacao').click(function () {
            var wrapper = $(this).parent();

            wrapper.html(
                '                    <div class="form-group">\n' +
                '                        <label for="">Resposta:</label>\n' +
                '                        <textarea autofocus required name="obs" cols="30" rows="4" class="form-control"></textarea>\n' +
                '                    </div>\n' +
                '                    <div class="form-group text-right">\n' +
                '                        <button type="submit" class="btn btn-success">Confirmar <i class="fa fa-check"></i></button>\n' +
                '                    </div>');

            return false;
        });

        $('.avaliacao-pedido').on('submit', '.formRespostaAvaliacao', function () {
            var $this = $(this);
            var form = $(this).serialize();

            $.ajax({
                url: "ajax-requisicoes.php",
                data: form,
                type: "POST",
                dataType: "json"
            }).done(function (retorno) {

                if (retorno['status']) {

                    $this.parent().append('<hr>' +
                        '                        <h4 class="text-uppercase font-weight-bold mb-1">Resposta do restaurante</h4>\n' +
                        '                        <h5 class="text-muted lead">'+ retorno['data_resposta'] +'</h5>\n' +
                        '\n' +
                        '                        <p>'+ retorno['resposta'] +'</p>');

                    $this.parents('.avaliacao-pedido').addClass('bg-light');
                    $this.remove();

                }




            }).fail(function () {
                swal("Erro ao Enviar requisição", "Ocorreu um erro ao enviar a requisição. Atualize a página e tente novamente", "error");
            });

            return false;
        });

    }

});

function atualizaPrecoDesconto(valor = 0.00, tipo_desc = 0, desc_porc = 0.00, desc_valor = 0.00) {
    var $msg = "";
    var valor_novo = 0.00;

    if (tipo_desc === 1) {

        if ($.isNumeric(desc_porc) && desc_porc >= 2.00) {
            valor_novo = valor - (valor / 100 * desc_porc);

            $("#preco").val(number_format (valor, 2, ",", "."));
            $("#preco_desconto").val(number_format (valor_novo, 2, ",", "."));
            $ok = true;
        } else {
            $msg = "Desconto com um valor muito baixo";
            $("#preco").val("");
            $("#preco_desconto").val("");
            $ok = false
        }

    } else {

        if ($.isNumeric(desc_valor)) {
            valor_novo = valor - desc_valor;

            $("#preco").val(number_format (valor, 2, ",", "."));
            $("#preco_desconto").val(number_format (valor_novo, 2, ",", "."));
            $ok = true;
        } else {
            $msg = "Desconto em um intervalo inválido";
            $ok = false;
        }

    }

    return {"status" : $ok, "msg" : $msg};
}

function senhaselecionada(senha){
    //alert(senha);
    document.getElementById('senha').value = senha;
}

function constroiTabelaInsumos(produtos) {
    $tabela = $("#lista-insumo tbody");

    if (produtos.length > 0) {
        $tabela.html("");

        $.each(produtos, function(i, item) {
            item = JSON.parse(item);

            $tabela.append(

                $("<tr>").append(
                    $("<td>").html(item.nomeinsumo)
                ).append(
                    $("<td>").addClass("text-center").html(item.qtdeinsumo)
                ).append(
                $("<td>").addClass("text-center").html("R$ " + item.precoinsumo)
                ).append(
                    $("<td>").addClass("text-center").html("R$ " + item.totalinsumo)
                ).append(
                    $("<td>").addClass("text-center").html(

                        $("<a href>").addClass("btn btn-danger btn-acao btn-excluir-insumo").prop("title", "Excluir Esse Item").html(
                            $("<i>").addClass("fa fa-close")
                        ).data("id", item.idinsumo)

                    )
                )
            );

        });

    } else {
        $tabela.html(
            $("<tr>").html($("<td colspan='5'>").addClass("text-center").html("Nenhum Insumo Adicionado"))
        );
    }

}

function constroiTabelaProdutos(produtos) {
    $tabela = $("#lista-produto tbody");

    if (produtos.length > 0) {
        $tabela.html("");

        $.each(produtos, function(i, item) {
            item = JSON.parse(item);

            $tabela.append(

                $("<tr>").append(
                    $("<td>").html(item.nomeproduto)
                ).append(
                    $("<td>").addClass("text-center").html(item.qtdeproduto)
                ).append(
                    $("<td>").addClass("text-center").html("R$ " + item.precoproduto)
                ).append(
                    $("<td>").addClass("text-center").html("R$ " + item.totalproduto)
                ).append(
                    $("<td>").addClass("text-center").html(

                        $("<a href>").addClass("btn btn-danger btn-acao btn-excluir-produto").prop("title", "Excluir Esse Item").html(
                            $("<i>").addClass("fa fa-close")
                        ).data("id", item.idproduto)

                    )
                )
            );

        });

    } else {
        $tabela.html(
            $("<tr>").html($("<td colspan='5'>").addClass("text-center").html("Nenhum Produto Adicionado"))
        );
    }

}

function constroiTabelaProdutosSaida(produtos) {
    $tabela = $("#lista-produto tbody");

    if (produtos.length > 0) {
        $tabela.html("");

        $.each(produtos, function(i, item) {
            item = JSON.parse(item);

            $tabela.append(

                $("<tr>").append(
                    $("<td>").html(item.nomeproduto)
                ).append(
                    $("<td>").addClass("text-center").html(item.qtdeproduto)
                ).append(
                    $("<td>").addClass("text-center").html("R$ " + item.precoproduto)
                ).append(
                    $("<td>").addClass("text-center").html("R$ " + item.totalproduto)
                ).append(
                    $("<td>").addClass("text-center").html(

                        $("<a href>").addClass("btn btn-danger btn-acao btn-excluir-produto-saida").prop("title", "Excluir Esse Item").html(
                            $("<i>").addClass("fa fa-close")
                        ).data("id", item.idproduto)

                    )
                )
            );

        });

    } else {
        $tabela.html(
            $("<tr>").html($("<td colspan='5'>").addClass("text-center").html("Nenhum Produto Adicionado"))
        );
    }

}

function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

function dataFormatada(data){
    var dia = data.getDate();
    if (dia.toString().length == 1)
        dia = "0"+dia;
    var mes = data.getMonth()+1;
    if (mes.toString().length == 1)
        mes = "0"+mes;
    var ano = data.getFullYear();
    return dia+"/"+mes+"/"+ano;
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}




