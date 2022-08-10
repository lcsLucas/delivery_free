$(document).ready(function(){

    window.addEventListener('keydown', function (e) {
        var code = e.which || e.keyCode;
        if (code == 112) {
            e.preventDefault();
            window.open(baseurl + 'help');
        }

        return true;
    });

    var $body = $('body');
    var $window = $(window);
    var $html = $('html');
    var step_complementos = null;
    var total_complementos = 0;

    $('#load').fadeOut(function () {
        $(this).remove();
        $body.css('overflow','auto');
    });

    /*corrigi bug dropdown dentro de uma tabela*/

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( 'overflow', 'inherit');
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( 'overflow', 'auto');
    });

    if($(".mascara-celular").length)
        $('.mascara-celular').mask('(00) 00000-0000');

    if($(".mascara-data").length)
        $('.mascara-data').mask('00/00/0000');

    if($(".mascara-cep").length)
        $('.mascara-cep').mask('00000-000');

    if($(".mascara-numero").length)
        $('.mascara-numero').mask('00000');

    if($(".mascara-dinheiro").length)
        $(".mascara-dinheiro").maskMoney({thousands:'.', decimal:','});

    if ($(".datepicker").length) {
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            startDate: "01/01/1950",
            endDate: "31/12/2015",
            language: "pt-BR"
        });
    }

    if($("#f-login").length)
        $("#f-login").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }, submitHandler: function (form) {

                $.ajax({
                    type: "POST",
                    url: "requisicoes-conta.php",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $(form).find("input").prop("disabled", true);
                        $(form).find("button.btn").html("Aguarde... <i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center").prop("disabled", true);
                    }
                }).done(function (retorno) {
                    var classe ="alert-zebra alert-error";
                    if (retorno.status) {
                        $(form).find("input").val("");
                        location.href = retorno.pagina_redirecionada;
                    } else {
                        new $.Zebra_Dialog(retorno.mensagem, {
                            custom_class: classe,
                            title: retorno.titulo
                        });

                        $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                        $(form).find("input").prop("disabled", false);
                    }

                }).fail(function () {
                    new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                        custom_class: 'alert-zebra alert-error',
                        title: 'Erro na requisição'
                    });

                    $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                    $(form).find("input").prop("disabled", false);
                });

            }
        });

    if($("#f-cadastro").length)
        $("#f-cadastro").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                var url = "cadastro";
                $(form).find("input").prop("disabled", true);
                $(form).find("button.btn").html("Aguarde... <i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center").prop("disabled", true);

                if (typeof(Storage) !== undefined) {
                    localStorage.setItem("nome", $(form).find("#cad-nome").val());
                    localStorage.setItem("email", $(form).find("#cad-email").val());
                }else {
                    url = url + "?email=" + $(form).find("#cad-email").val() + "&nome=" + $(form).find("#cad-nome").val();
                }

                location.href = url;
                return false;
            }
        });

    if ($("#f-senha-conta").length)
        $("#f-senha-conta").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
            },
            rules: {
                senha2: {
                    equalTo: "#senha_nova"
                }
            }, messages: {
                senha2: {
                    equalTo: "As senha não batem"
                }
            }, submitHandler: function (form) {

                $.ajax({
                    type: "POST",
                    url: "requisicoes-conta.php",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $(form).find("input").prop("disabled", true);
                        $(form).find("button.btn").html("Aguarde... <i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center").prop("disabled", true);
                    }
                }).done(function (retorno) {

                    var div_alert = $("<div>").addClass("alert mt-0 mb-4 text-center").html(
                        $("<h5>").addClass("alert-heading mb-0 text-uppercase").html(retorno.titulo)
                    ).append(
                        $("<hr>").addClass("my-2")
                    ).append(
                        $("<p>").addClass("mb-0").html(retorno.mensagem)
                    );

                    $("#form-cadastro .alert").remove();

                    if (retorno.status) {
                        $(form).find("input").val("");
                        div_alert.addClass("alert-success");
                    } else {
                        div_alert.addClass("alert-danger");
                    }

                    $("#divisor").after(
                        div_alert
                    );

                    $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                    $(form).find("input").prop("disabled", false);

                    var body = $("html, body");
                    body.stop().animate({scrollTop: $("#divisor").offset().top
                    }, 500);

                }).fail(function () {
                    $("#form-cadastro .alert").remove();
                    new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                        custom_class: 'alert-zebra alert-error',
                        title: 'Erro na requisição'
                    });

                    $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                    $(form).find("input").not(".not-enable").prop("disabled", false);
                });

            }
        });

    if ($("#f-dados-conta").length)
        $("#f-dados-conta").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
            }, submitHandler: function (form) {

                $.ajax({
                    type: "POST",
                    url: "requisicoes-conta.php",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $(form).find("input").prop("disabled", true);
                        $(form).find("button.btn").html("Aguarde... <i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center").prop("disabled", true);
                    }
                }).done(function (retorno) {
                    var div_alert = $("<div>").addClass("alert mt-0 mb-4 text-center").html(
                        $("<h5>").addClass("alert-heading mb-0 text-uppercase").html(retorno.titulo)
                    ).append(
                        $("<hr>").addClass("my-2")
                    ).append(
                        $("<p>").addClass("mb-0").html(retorno.mensagem)
                    );
                    $("#form-cadastro .alert").remove();

                    if (retorno.status) {
                        div_alert.addClass("alert-success");
                    } else {
                        div_alert.addClass("alert-danger");
                    }

                    $("#form-cadastro").prepend(
                        div_alert
                    );

                    $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                    $(form).find("input:not(#email):not(#usuario)").prop("disabled", false);

                    var body = $("html, body");
                    body.stop().animate({scrollTop: $("#form-cadastro").offset().top - 30
                    }, 500);

                }).fail(function () {
                    $("#form-cadastro .alert").remove();
                    new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                        custom_class: 'alert-zebra alert-error',
                        title: 'Erro na requisição'
                    });

                    $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                    $(form).find("input:not(#email):not(#usuario)").not(".not-enable").prop("disabled", false);
                });
            }
        });

    if($("#f-cria-conta").length)
        $("#f-cria-conta").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {

                if (element.parents('.form-group').length) {
                    element.parents('.form-group').first().append(error);
                } else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }

            },
            rules: {
                senha2: {
                    equalTo: "#senha"
                }
            }, messages: {
                senha2: {
                    equalTo: "As senha não batem"
                }
            }, submitHandler: function (form) {

                $.ajax({
                    type: "POST",
                    url: "requisicoes-conta.php",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $(form).find("input").prop("disabled", true);
                        $(form).find("button.btn").html("Aguarde... <i class=\"fa fa-spinner fa-spin\"></i>").addClass("text-center").prop("disabled", true);
                    }
                }).done(function (retorno) {
                    var classe ="alert-zebra alert-error";
                    $(form).find("input").prop("disabled", false);

                    if (retorno.status) {
                        localStorage.setItem("nome", "");
                        localStorage.setItem("email", "");
                        $(form).find("input").val("");
                        $("#ckTermos").prop("checked", false);

                        location.href = retorno.pagina_redirecionada;
                    } else {
                        new $.Zebra_Dialog(retorno.mensagem, {
                            custom_class: classe,
                            title: retorno.titulo
                        });

                        $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                        $(form).find("input").prop("disabled", false);
                    }

                }).fail(function () {

                    new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                        custom_class: 'alert-zebra alert-error',
                        title: 'Erro na requisição'
                    });

                    $(form).find("button.btn").html("Confirmar <i class=\"fas fa-check\"></i>").prop("disabled", false);
                    $(form).find("input").prop("disabled", false);
                });

                return false;
            }
        });

    if($("#galeria-imagens").length) {
        $("#galeria-imagens").owlCarousel({
            loop: true,
            autoplay: true,
            responsiveClass:true,
            nav: false,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                500: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    }

    if($("#f-cria-conta").length) {

        if (localStorage.getItem("nome") !== undefined && localStorage.getItem("nome") !== "") {
            $("#nome").val(localStorage.getItem("nome"));
            $("#usuario").focus();
        } else
            $("#nome").focus();

        if (localStorage.getItem("email") !== undefined && localStorage.getItem("email") !== "") {
            $("#email").val(localStorage.getItem("email"));
        }

    }

    $('#accordionCategoria').collapse({
        toggle: false
    }).on("hide.bs.collapse", function (e) {
        var icone = $(e.target).siblings('.card-header').find('button i');
        //icone.addClass("fa-rotate-90 fa-flip-horizontal");

    }).on("show.bs.collapse",function (e) {
        var icone = $(e.target).siblings('.card-header').find('button i');
        //icone.removeClass("fa-rotate-90 fa-flip-horizontal");
    });

    if($("#listar-endereco").length) {
        $("#listar-endereco").on("click", ".excluir-endereco", function () {

            $.ajax({
                type: "POST",
                url: "requisicoes-conta.php",
                dataType: "json",
                data: {
                    "endereco_id": $(this).data("id"),
                    "excluir_endereco": ""
                },
                beforeSend: function () {
                    $(".btn").prop("disabled", true).addClass("disabled");
                }
            }).done(function (retorno) {

                new $.Zebra_Dialog(retorno["mensagem"], {
                    custom_class: 'alert-zebra alert-error',
                    title: retorno["titulo"],
                    onClose: function () {

                        if (retorno.status) {
                            atualizaEnderecos(retorno.extra);
                        }
                        $(".btn").prop("disabled", false).removeClass("disabled");
                    }
                });

            }).fail(function () {
                new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                    custom_class: 'alert-zebra alert-error',
                    title: 'Erro na requisição'
                });
                $(".btn").prop("disabled", false).removeClass("disabled");
            });


            return false;
        });

        $("#listar-endereco").on("click", ".alterar-favorito", function () {
            var $this = $(this);
            $.ajax({
                type: "POST",
                url: "requisicoes-conta.php",
                dataType: "json",
                data: {
                    "favorita-endereco": "",
                    "endereco_id": $this.data("id")
                },
                beforeSend: function () {
                    $this.html("<i class=\"fa fa-spinner fa-spin\"></i>");
                }
            }).done(function (retorno) {

                if (retorno.status) {
                    var star_ativa = $("#listar-endereco").find(".endereco-ativo");

                    star_ativa.removeClass("endereco-ativo")
                        .find("i").removeClass("fa").addClass("far");

                    $this.addClass("endereco-ativo").html("<i class=\"fa fa-star\"></i>");
                } else {
                    $this.html("<i class=\"far fa-star\"></i>");
                }

            }).fail(function () {
                $this.html("<i class=\"far fa-star\"></i>");
                new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                    custom_class: 'alert-zebra alert-error',
                    title: 'Erro na requisição'
                });
            });

            return false;
        });

    }

    if ($("#verifica-cep").length) {
        jQuery.validator.addMethod("valida-cep", function(value, element) {
            return this.optional(element) || /^[0-9]{5}-[0-9]{3}$/.test(value);
        }, "Por favor, digite um CEP válido");

        $("#verifica-cep").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
            },
            submitHandler: function (form) {

                var cep = $("#input-busca-cep").val();
                cep = cep.replace("-", "");

                $.ajax({
                    type: "GET",
                    url: "https://viacep.com.br/ws/"+ cep +"/json/",
                    dataType: "json",
                    beforeSend: function () {
                        $(form).find("button").prop("disabled", true);
                    }
                }).done(function(retorno) {
                    $(form).find("button").prop("disabled", false);

                    if (retorno.erro) {
                        abreEndereco();
                    } else {

                        if (retorno.ibge === "3541406") {
                            $("#rua").val(retorno.logradouro);
                            $("#cep").val(retorno.cep);
                            $("#cep-hidden").val(retorno.cep);
                            $("#bairro").val(retorno.bairro);
                            $("#numero").val("");

                            abreEndereco();
                        } else {
                            new $.Zebra_Dialog('Por favor informe um CEP da cidade de Presidente Prudente', {
                                custom_class: 'alert-zebra alert-error',
                                title: 'CEP não permitido',
                                onClose: function() {
                                    fechaEndereco();
                                }
                            });

                        }

                    }

                }).fail(function() {
                    $(form).find("button").prop("disabled", false);
                    fechaEndereco();
                });

                return false;
            }
        });
    }

    if ($("#add-endereco").length)
        $("#add-endereco").validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
            }, submitHandler: function (form) {

                $.ajax({
                    type: "POST",
                    url: "requisicoes-conta.php",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $(form).find("input, select").prop("disabled", true);
                        $(form).find(".btn").addClass("text-center disabled").prop("disabled", true);
                        $(form).find("#btnAddEndereco").html("Aguarde... <i class=\"fa fa-spinner fa-spin\"></i>");
                    }
                }).done(function (retorno) {

                    new $.Zebra_Dialog(retorno["mensagem"], {
                        custom_class: 'alert-zebra alert-error',
                        title: retorno["titulo"],
                        onClose: function () {

                            if (retorno.status) {

                                var query = location.search.slice(1);
                                var param = query.search('continuar-pedido=');

                                if (param >= 0) {
                                    location.href = retorno.url_finalizar;
                                    return;
                                }

                                $(form).find("input").val("");
                                $("#input-busca-cep").val("");
                                atualizaEnderecos(retorno.extra);
                                fechaEndereco();
                            }

                            $(form).find(".btn").prop("disabled", false).removeClass("disabled");
                            $(form).find("input, select").prop("disabled", false);
                            $(form).find("#cep, #selEstado").prop("disabled", true);
                            $(form).find("#btnAddEndereco").html("Confirmar");

                        }
                    });


                }).fail(function () {
                    new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                        custom_class: 'alert-zebra alert-error',
                        title: 'Erro na requisição'
                    });

                    $(form).find(".btn").prop("disabled", false).removeClass("disabled");
                    $(form).find("input:not(#cep), select").prop("disabled", false);
                    $(form).find("#btnAddEndereco").html("Confirmar");
                });

            }
        });

    $("#btnVoltar").click(function () {
        fechaEndereco();
        return false;
    });

    const carrinho = $("#carrinho");
    const conteudo_restaurante = $('#conteudo-restaurante');
    var min_height = 0;
    var max_height = 0;

    if (carrinho.length) {

        min_height = conteudo_restaurante.offset().top;
        max_height = conteudo_restaurante.height() + conteudo_restaurante.offset().top - carrinho.height();

        var scroll = function() {
            var scroll_window = $window.scrollTop();

            if (scroll_window < min_height) {

                carrinho.css({
                    'position': 'absolute',
                    'top': 0,
                    'bottom': ''
                });

            } else if(scroll_window >= min_height && scroll_window < max_height) {

                carrinho.css({
                    'position' : 'fixed',
                    'top': '20px',
                    'bottom': ''
                });

            } else {

                carrinho.css({
                    'position' : 'absolute',
                    'top': '',
                    'bottom': 0
                });

            }

        };

        scroll();
        $window.scroll(scroll);
        $window.resize(function () {

            min_height = conteudo_restaurante.offset().top;
            max_height = conteudo_restaurante.height() + conteudo_restaurante.offset().top - carrinho.height();

            scroll();
        });

    }

    $('.link-produto').click(function () {
        const $this = $(this);
        const id_produto = $this.find('input[name="pro_id"]').val();
        const modalProduto = $('#modalSelecaoProduto');

        $.ajax({
            type: 'POST',
            url: baseurl + 'requisicoes-pedido.php',
            dataType: 'json',
            data: {
                'carregar_complementos': '',
                'produto': id_produto
            },
            beforeSend: function () {
                $('#load-produto').removeClass('d-none');
            }
        }).done(function (retorno) {
            $('#load-produto').addClass('d-none');

            if  (retorno['status']) {
                total_complementos = 0;

                var titulo = $this.find('input[name="pro_nome"]').val();
                titulo += ' (R$ '+ number_format($this.find('input[name="pro_valor"]').val(), 2, ',', '.') +')';

                if (retorno.complementos.length) {
                    $('#voltar_comp').addClass('d-none');

                    step_complementos = $("#steps-complementos").steps({
                        enableAllSteps: false,
                        enableKeyNavigation: false,
                        enablePagination: false,
                        enableFinishButton: false,
                        onStepChanging: function (event, currentIndex, newIndex) {

                            var qtdemin = parseInt(step_complementos.find('.body:eq(' + currentIndex + ') input[name="qtdemin[]"]').val());
                            var qtdemax = parseInt(step_complementos.find('.body:eq(' + currentIndex + ') input[name="qtdemax[]"]').val());
                            var obrigatorio = ((step_complementos.find('.body:eq(' + currentIndex + ') input[name="obrigatorio[]"]').val() === '1') ? true : false);
                            var label_error = $('#modalSelecaoProduto').find('label.error');
                            var retorno = true;
                            var inputs = step_complementos.find('.body:eq(' + currentIndex + ') input[type="radio"]:checked, .body:eq(' + currentIndex + ') input[type="checkbox"]:checked');

                            if (obrigatorio) {
                                if (qtdemin > 1) {
                                    if (inputs.length < qtdemin) {
                                        label_error.html('Selecione no mínimo ' + qtdemin + ' de opções');
                                        retorno = false;
                                    }
                                }  else {
                                    if (inputs.length < qtdemin) {
                                        label_error.html('Selecione uma opção');
                                        retorno = false;
                                    }
                                }
                            }

                            if (qtdemax > 0) {
                                if (inputs.length > qtdemax) {
                                    label_error.html('Você selecionou '+ inputs.length +', e o máximo permitido é ' + qtdemax + ' opções');
                                    retorno = false;
                                }
                            }

                            return retorno;
                        }, onStepChanged: function (event, currentIndex, priorIndex) {
                            if (currentIndex > 0)
                                $('#voltar_comp').removeClass('d-none');
                            else
                                $('#voltar_comp').addClass('d-none');
                        }
                    });

                    modalProduto.find('.modal-body').removeClass('d-none').addClass('d-block');

                    $.each(retorno.complementos, function (i, complemento) {

                        var id = complemento.id;
                        var titulo = complemento.nome;
                        var obrigatorio = complemento.obrigatorio;
                        var qtdemin = parseInt(complemento.qtdemin);
                        var qtdemax = parseInt(complemento.qtdemax);
                        var input = 'radio';

                        if (obrigatorio) {

                            if (qtdemin <= 1 && qtdemax <= 1)
                                titulo += '<sup class="text-lowercase">(Escolha uma opção)</sup>';
                            else if(qtdemin > 1 && qtdemax <= 1) {
                                titulo += '<sup class="text-lowercase">(Escolha ' + qtdemin + ' opções no mínimo)</sup>';
                                input = 'checkbox';
                            } else if(qtdemin > 1 && qtdemax > 1) {
                                titulo += '<sup class="text-lowercase">(Escolha de ' + qtdemin + ' até ' + qtdemax + ' opções)</sup>';
                                input = 'checkbox';
                            }

                        } else {

                            if (qtdemax > 1 && qtdemin < 1) {
                                titulo += '<sup class="text-lowercase">(Escolha até ' + qtdemax + ' opções)</sup>';
                                input = 'checkbox';
                            } else if (qtdemax === 1 && qtdemin < 1) {
                                titulo += '<sup class="text-lowercase">(Opcional)</sup>';
                                input = 'radio';
                            }
                        }

                        var estrutura = '<h6 class="titulo-complemento">'+ titulo +'</h6>';
                        estrutura += '<input type="hidden" name="complementos[]" value="'+ id +'" />';
                        estrutura += '<input type="hidden" name="qtdemin[]" value="'+ qtdemin +'" />';
                        estrutura += '<input type="hidden" name="qtdemax[]" value="'+ qtdemax +'" />';
                        estrutura += '<input type="hidden" name="tipo_complemento[]" value="'+ complemento.tipo_complemento +'" />';
                        estrutura += '<input type="hidden" name="obrigatorio[]" value="'+ ((obrigatorio) ? '1' : '0') +'" />';

                        $.each(complemento.opcoes, function (i, opcao) {
                            estrutura += '<div class="form-check clearfix">';
                            estrutura += '<input class="form-check-input" type="'+ input +'" name="complemento_'+ complemento.id +'[]" id="opcao-'+ opcao.id +'" value="'+ opcao.id +'">';
                            estrutura += '<label class="form-check-label d-block" for="opcao-'+ opcao.id +'">' + opcao.nome  + ' <span class="float-right text-muted">'+ opcao.preco +'</span></label>';
                            estrutura += '</div>';
                        });

                        // Add step
                        step_complementos.steps("add", {
                            title: titulo,
                            content: estrutura
                        });
                        total_complementos += 1;

                    });

                } else {

                    modalProduto.find('.modal-body').removeClass('d-block').addClass('d-none');

                }

                modalProduto.find('.modal-title').html(titulo);
                modalProduto.find('img').prop('src', $this.find('img').prop('src'));
                modalProduto.find('input[name="produto_id"]').val(id_produto);

                modalProduto.find('input[name="obs"]').val('');
                modalProduto.find('input[name="qtde"]').val('1');
                modalProduto.modal('show');

            } else {
                new $.Zebra_Dialog(retorno['mensagem'], {
                    custom_class: 'alert-zebra alert-error',
                    title: 'Erro na requisição'
                });
            }

        }).fail(function () {
            $('#load-produto').addClass('d-none');

            new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                custom_class: 'alert-zebra alert-error',
                title: 'Erro na requisição'
            });

        });

    });

    $('#prosseguir_comp').click(function () {

        if (null === step_complementos) {
            var form = $(this).parents('form');
            adicionarProduto(form.serialize());
            min_height = conteudo_restaurante.offset().top;
            max_height = conteudo_restaurante.height() + conteudo_restaurante.offset().top - carrinho.height();
        } else {
            if (step_complementos.steps('getCurrentIndex') < total_complementos - 1)
                step_complementos.steps('next');
            else {
                var currentIndex = step_complementos.steps('getCurrentIndex');

                var qtdemin = parseInt(step_complementos.find('.body:eq(' + currentIndex + ') input[name="qtdemin[]"]').val());
                var qtdemax = parseInt(step_complementos.find('.body:eq(' + currentIndex + ') input[name="qtdemax[]"]').val());
                var obrigatorio = ((step_complementos.find('.body:eq(' + currentIndex + ') input[name="obrigatorio[]"]').val() === '1'));
                var label_error = $('#modalSelecaoProduto').find('label.error');
                var retorno = true;
                var inputs = step_complementos.find('.body:eq(' + currentIndex + ') input[type="radio"]:checked, .body:eq(' + currentIndex + ') input[type="checkbox"]:checked');

                if (obrigatorio) {

                    if (qtdemin > 1) {

                        if (inputs.length < qtdemin) {
                            label_error.html('Selecione no mínimo ' + qtdemin + ' opções');
                            retorno = false;
                        }

                    } else {

                        if (inputs.length < qtdemin) {
                            label_error.html('Selecione uma opção');
                            retorno = false;
                        }

                    }

                }

                if (qtdemax > 0) {

                    if (inputs.length > qtdemax) {
                        label_error.html('Você selecionou ('+ inputs.length +') opções mais que o permitido (' + qtdemax + ')');
                        retorno = false;
                    }

                }

                if (retorno) {
                    var form = step_complementos.parents('form');
                    adicionarProduto(form.serialize());
                    min_height = conteudo_restaurante.offset().top;
                    max_height = conteudo_restaurante.height() + conteudo_restaurante.offset().top - carrinho.height();
                }
            }
        }

    });

    $('#voltar_comp').click(function () {
        if (!(null === step_complementos))
            step_complementos.steps('previous');
    });

    $('#modalSelecaoProduto').on('show.bs.modal', function (event) {
        $('body').css('overflow', 'hidden');
        $(this).find('.error').html('');
    });

    $('#modalSelecaoProduto').on('hidden.bs.modal', function (e) {
        if ($("#steps-complementos").hasClass()) {
            $("#steps-complementos").steps("destroy");
            var pai = $("#steps-complementos").parent();
            $("#steps-complementos").remove();
            pai.append($('#steps-complementos'));
        }
        $("#steps-complementos").html("");
        step_complementos = null;
        $('body').css('overflow', 'auto');
        $(this).find('input[name="item_carrinho_id"]').val('');
        $('#voltar_comp').addClass('d-none');
    });

    $('.number-spinner').on('click', 'button', function () {
        var $this = $(this);
        var input = $('.number-spinner').find('input');
        var antigo_valor = parseInt(input.val());
        var novo_valor = 1;

        if ($this.hasClass('btn-down')) {
            if (antigo_valor > 1)
                novo_valor = antigo_valor - 1;
        } else
                novo_valor = antigo_valor + 1;

         input.val(novo_valor);

        return false;
    });

    $('#carrinho').on('click', '.editar-produto', function () {
        var $this = $(this);
        var id_item_carrinho = $(this).siblings('input[name="id_item_carrinho"]').val();
        var id_produto = $(this).siblings('input[name="id_produto"]').val();
        var obs_produto = $(this).siblings('input[name="obs_produto"]').val();
        var foto_produto = $(this).siblings('input[name="foto_produto"]').val();
        var qtde_produto = $(this).siblings('input[name="qtde_produto"]').val();
        const modalProduto = $('#modalSelecaoProduto');

        $.ajax({
            type: 'POST',
            url: baseurl + 'requisicoes-pedido.php',
            dataType: 'json',
            data: {
                'carregar_complementos_2': '',
                'produto': id_produto,
                'item_carrinho': id_item_carrinho
            },beforeSend: function () {
                $('#load-produto').removeClass('d-none');
            }

        }).done(function (retorno) {

            $('#load-produto').addClass('d-none');

            if  (retorno['status']) {
                total_complementos = 0;

                var titulo = $this.siblings('input[name="nome_produto"]').val();
                titulo += ' (R$ '+ $this.siblings('input[name="preco_produto"]').val() +')';

                if (retorno.complementos.length) {
                    $('#voltar_comp').addClass('d-none');

                    step_complementos = $("#steps-complementos").steps({
                        enableAllSteps: false,
                        enableKeyNavigation: false,
                        enablePagination: false,
                        enableFinishButton: false,
                        onStepChanging: function (event, currentIndex, newIndex) {

                            var qtdemin = parseInt(step_complementos.find('.body:eq(' + currentIndex + ') input[name="qtdemin[]"]').val());
                            var qtdemax = parseInt(step_complementos.find('.body:eq(' + currentIndex + ') input[name="qtdemax[]"]').val());
                            var obrigatorio = ((step_complementos.find('.body:eq(' + currentIndex + ') input[name="obrigatorio[]"]').val() === '1') ? true : false);
                            var label_error = $('#modalSelecaoProduto').find('label.error');
                            var retorno = true;
                            var inputs = step_complementos.find('.body:eq(' + currentIndex + ') input[type="radio"]:checked, .body:eq(' + currentIndex + ') input[type="checkbox"]:checked');

                            if (obrigatorio) {
                                if (qtdemin > 1) {
                                    if (inputs.length < qtdemin) {
                                        label_error.html('Selecione no mínimo ' + qtdemin + ' de opções');
                                        retorno = false;
                                    }
                                }  else {
                                    if (inputs.length < qtdemin) {
                                        label_error.html('Selecione uma opção');
                                        retorno = false;
                                    }
                                }
                            }

                            if (qtdemax > 0) {
                                if (inputs.length > qtdemax) {
                                    label_error.html('Você selecionou '+ inputs.length +', e o máximo permitido é ' + qtdemax + ' opções');
                                    retorno = false;
                                }
                            }

                            return retorno;
                        }, onStepChanged: function (event, currentIndex, priorIndex) {
                            if (currentIndex > 0)
                                $('#voltar_comp').removeClass('d-none');
                            else
                                $('#voltar_comp').addClass('d-none');
                        }
                    });

                    modalProduto.find('.modal-body').removeClass('d-none').addClass('d-block');

                    var array_comp_produto = retorno.complementos_produto;

                    $.each(retorno.complementos, function (i, complemento) {

                        var id = complemento.id;
                        var titulo = complemento.nome;
                        var obrigatorio = complemento.obrigatorio;
                        var qtdemin = parseInt(complemento.qtdemin);
                        var qtdemax = parseInt(complemento.qtdemax);
                        var input = 'radio';

                        if (obrigatorio) {

                            if (qtdemin <= 1 && qtdemax <= 1)
                                titulo += '<sup class="text-lowercase">(Escolha uma opção)</sup>';
                            else if(qtdemin > 1 && qtdemax <= 1) {
                                titulo += '<sup class="text-lowercase">(Escolha ' + qtdemin + ' opções no mínimo)</sup>';
                                input = 'checkbox';
                            } else if(qtdemin > 1 && qtdemax > 1) {
                                titulo += '<sup class="text-lowercase">(Escolha de ' + qtdemin + ' até ' + qtdemax + ' opções)</sup>';
                                input = 'checkbox';
                            }

                        } else {

                            if (qtdemax > 1 && qtdemin < 1) {
                                titulo += '<sup class="text-lowercase">(Escolha até ' + qtdemax + ' opções)</sup>';
                                input = 'checkbox';
                            } else if (qtdemax === 1 && qtdemin < 1) {
                                titulo += '<sup class="text-lowercase">(Opcional)</sup>';
                                input = 'radio';
                            }
                        }

                        var estrutura = '<h6 class="titulo-complemento">'+ titulo +'</h6>';
                        estrutura += '<input type="hidden" name="complementos[]" value="'+ id +'" />';
                        estrutura += '<input type="hidden" name="qtdemin[]" value="'+ qtdemin +'" />';
                        estrutura += '<input type="hidden" name="qtdemax[]" value="'+ qtdemax +'" />';
                        estrutura += '<input type="hidden" name="tipo_complemento[]" value="'+ complemento.tipo_complemento +'" />';
                        estrutura += '<input type="hidden" name="obrigatorio[]" value="'+ ((obrigatorio) ? '1' : '0') +'" />';

                        var opcoes_produto = array_comp_produto[id];

                        $.each(complemento.opcoes, function (i, opcao) {

                            var escolhido = '';

                            if (undefined !== opcoes_produto)
                                if (parseInt(opcoes_produto.tipo) === parseInt(complemento.tipo_complemento)) {

                                    if ((opcoes_produto.opcoes.length)) {

                                        $.each(opcoes_produto.opcoes, function (j, opcao_produto) {

                                            if (parseInt(opcao.id) === parseInt(opcao_produto))
                                                    escolhido = 'checked';

                                        });

                                    }

                                }

                            estrutura += '<div class="form-check clearfix">';
                            estrutura += '<input class="form-check-input" type="'+ input +'" '+ escolhido +' name="complemento_'+ complemento.id +'[]" id="opcao-'+ opcao.id +'" value="'+ opcao.id +'">';
                            estrutura += '<label class="form-check-label d-block" for="opcao-'+ opcao.id +'">' + opcao.nome  + ' <span class="float-right text-muted">'+ opcao.preco +'</span></label>';
                            estrutura += '</div>';
                        });

                        // Add step
                        step_complementos.steps("add", {
                            title: titulo,
                            content: estrutura
                        });
                        total_complementos += 1;

                    });

                } else {

                    modalProduto.find('.modal-body').removeClass('d-block').addClass('d-none');

                }

                modalProduto.find('.modal-title').html(titulo);
                modalProduto.find('img').prop('src', foto_produto);
                modalProduto.find('input[name="produto_id"]').val(id_produto);
                modalProduto.find('input[name="item_carrinho_id"]').val(id_item_carrinho);
                modalProduto.find('#obs').val(obs_produto);
                modalProduto.find('#qtde').val(qtde_produto);

                modalProduto.modal('show');

            } else {
                new $.Zebra_Dialog(retorno['mensagem'], {
                    custom_class: 'alert-zebra alert-error',
                    title: 'Erro na requisição'
                });
            }

        }).fail(function () {
            $('#load-produto').addClass('d-none');

            $('#modalSelecaoProduto').modal('hide');

            new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
                custom_class: 'alert-zebra alert-error',
                title: 'Erro na requisição'
            });
        });
        
    });

    $('#carrinho').on('click', '.excluir-produto', function () {
        var $this = $(this);
        var id_item_carrinho = $(this).siblings('input[name="id_item_carrinho"]').val();
        var id_produto = $(this).siblings('input[name="id_produto"]').val();

        $.ajax({
            type: 'POST',
            url: baseurl + 'requisicoes-pedido.php',
            dataType: 'json',
            data: {
                'excluir_item_carrinho': '',
                'produto': id_produto,
                'item_carrinho': id_item_carrinho
            }, beforeSend: function () {
                $('#load-produto').removeClass('d-none');
            }

        }).done(function (retorno) {
            recarregaCarrinho(retorno);
            min_height = conteudo_restaurante.offset().top;
            max_height = conteudo_restaurante.height() + conteudo_restaurante.offset().top - carrinho.height();
        }).fail(function () {
            
        });

    });
    
    $('#aplicar-cupom').click(function () {
        var $this = $(this);
        var codigo = $('#codigo-cupom');
        var pai = codigo.parents('.input-group');

        if (codigo.val() !== '') {

            $.ajax({
                type: 'POST',
                url: 'requisicoes-pedido.php',
                data: {
                    'aplicar_cupom': '',
                    'codigo_cupom': codigo.val()
                },
                dataType: 'json',
                beforeSend: function () {
                    $this.html($('<i>').addClass('fa fa-spinner fa-spin')).prop('disabled', true);
                    codigo.prop('disabled', true);
                }
            }).done(function (retorno) {
                $this.html('Aplicar Cupom').prop('disabled', false);


                if (retorno['status']) {

                    pai.siblings('label.retorno').remove();
                    codigo.prop('disabled', true);
                    $this.removeClass('bg-secondary').addClass('bg-success').html('Cupom Aplicado').prop('disabled', true);
                    $('<a href="javascript:void(0)" id="remover-cupom">').html('remover cupom').insertAfter(pai);

                    var cupom = $('#valor-cupom');
                    var total = $('#valor-geral');

                    total.html('R$ ' + retorno.valores.valor_total);
                    cupom.html('-R$ ' + retorno.valores.valor_desconto);
                    cupom.parent('p').removeClass('d-none');

                } else {
                    codigo.prop('disabled', false);
                    $('#remover-cupom').remove();

                    if (pai.siblings('label.retorno').length)
                        pai.siblings('label.retorno').html(retorno['mensagem']).removeClass('text-success').addClass('text-danger');
                    else
                        $('<label class="retorno text-danger">').html(retorno['mensagem']).insertAfter(pai);
                }

            }).fail(function () {
                codigo.prop('disabled', false);
                $('#remover-cupom').remove();

                if (pai.siblings('label.retorno').length)
                    pai.siblings('label.retorno').html('Erro ao tentar aplicar o cupom, por favor tente novamente').removeClass('text-success').addClass('text-danger');
                else
                    $('<label class="retorno text-danger">').html('Erro ao tentar aplicar o cupom, por favor tente novamente').insertAfter(pai);

                $this.html('Aplicar cupom').removeClass('bg-success').addClass('bg-secondary').prop('disabled', false);
            });

        }

    });

    $('#tabela-produtos-checkout').on('click', '#remover-cupom', function () {
        var $this = $(this);
        var btn_aplicar = $('#aplicar-cupom');
        var codigo = $('#codigo-cupom');
        var pai = codigo.parents('.input-group');

        $.ajax({
            type: 'POST',
            url: 'requisicoes-pedido.php',
            data: {
                'remover_cupom': ''
            },
            dataType: 'json',
            beforeSend: function () {
                $this.prop('disabled', true);
            }
        }).done(function (retorno) {

            if (retorno.status) {
                btn_aplicar.html('Aplicar cupom').removeClass('bg-success').addClass('bg-secondary').prop('disabled', false);
                codigo.prop('disabled', false).val('').focus();
                $this.remove();

                var cupom = $('#valor-cupom');
                var total = $('#valor-geral');

                total.html('R$ ' + retorno.valores.valor_total);
                cupom.html('');
                cupom.parent('p').addClass('d-none');

            } else {
                if (pai.siblings('label.retorno').length)
                    pai.siblings('label.retorno').html('Erro ao tentar remover o cupom, por favor tente novamente').removeClass('text-success').addClass('text-danger');
                else
                    $('<label class="retorno text-danger">').html('Erro ao tentar remover o cupom, por favor tente novamente').insertAfter(pai);
            }
            
        }).fail(function () {
            if (pai.siblings('label.retorno').length)
                pai.siblings('label.retorno').html('Erro ao tentar remover o cupom, por favor tente novamente').removeClass('text-success').addClass('text-danger');
            else
                $('<label class="retorno text-danger">').html('Erro ao tentar remover o cupom, por favor tente novamente').insertAfter(pai);
        });

    });

    if ($('#wrapper-card').length) {

        $('.wrapper-check input[type="radio"]').change(function () {
            var wrapper = $(this).data('target');

            $('#mostrar-cartao input, #mostrar-dinheiro input').val('');
            $('#mostrar-cartao, #mostrar-dinheiro').addClass('d-none');
            $(wrapper).removeClass('d-none');
            $(wrapper).find('input').first().focus();

        });

        /*$('#mostrar-cartao input').on('paste', function (e) {
            e.preventDefault();
        });*/

        $('#form-pedido').card({
            // a selector or DOM element for the container
            // where you want the card to appear
            container: '#wrapper-card', // *required*

            formSelectors: {
                numberInput: 'input#number', // optional — default input[name="number"]
                expiryInput: 'input#expiry', // optional — default input[name="expiry"]
                cvcInput: 'input#cvc', // optional — default input[name="cvc"]
                nameInput: 'input#name' // optional - defaults input[name="name"]
            },
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'João da silva',
                expiry: '••/••',
                cvc: '•••'
            },
            messages: {
                validDate: 'Validade', // optional - default 'valid\nthru'
                monthYear: 'MM/AA', // optional - default 'month/year'
            },
            // all of the other options from above
        });

    }

    $('#mostrar-enderecos').click(function () {
        $('#wrapper-enderecos').removeClass('d-none');
        $('#endereco-selecionado').addClass('d-none');
        return false;
    });

    $('#wrapper-enderecos').on('change', 'input[type="radio"]', function () {
        $('#wrapper-enderecos').addClass('d-none');
        $('#endereco-selecionado').removeClass('d-none').find('span').html($(this).siblings('label').html());
    });

    if ($('#form-pedido').length) {
        var flag_enviado = false;
        $('#form-pedido').validate({
            ignore: 'input[type="hidden"][required], :hidden:not(input[name="check_pagamento"])',
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error d-block m-0',
            errorPlacement: function (error, element) {
                if (element.parents('.form-group').length) {
                    element.parents('.form-group').first().append(error);
                } else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
                $(window).scrollTop(error.offset().top - 150);
            }, submitHandler: function (form) {

                if (!flag_enviado) {

                    $.ajax({
                        type: 'POST',
                        url: 'requisicoes-pedido.php',
                        data: $(form).serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            flag_enviado = true;
                            $(form).find('#mostrar-cartao input[type="text"]:visible, #mostrar-cartao input[type="tel"]:visible').prop('disabled', true);
                            $(form).find('button[type="submit"]').html('Aguarde... ').append($('<i>').addClass('fa fa-spinner fa-spin')).prop('disabled', true);
                        }
                    }).done(function (retorno) {

                        if (retorno.status) {

                            var div_sucesso = $('<div>').prop('id', 'wrapper-sucesso');
                            var titulo = $('<h3>').html('Pedido realizado com sucesso');
                            var texto = $('<p>').html('O seu pedido já foi encaminhado para o restaurante,<br>aguarde até ele ser confirmado. Voce pode acompanhar no link abaixo<br><a href="meus-pedidos" class="btn btn-link">Acompanhar Pedido</a>');

                            var svg =
                                '<svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">\n' +
                                '  <path id="successAnimationResult" fill="#D8D8D8" d="M35,60 C21.1928813,60 10,48.8071187 10,35 C10,21.1928813 21.1928813,10 35,10 C48.8071187,10 60,21.1928813 60,35 C60,48.8071187 48.8071187,60 35,60 Z M23.6332378,33.2260427 L22.3667622,34.7739573 L34.1433655,44.40936 L47.776114,27.6305926 L46.223886,26.3694074 L33.8566345,41.59064 L23.6332378,33.2260427 Z"/>\n' +
                                '  <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#979797" stroke-width="2" stroke-linecap="round" fill="transparent"/>\n' +
                                '  <polyline id="successAnimationCheck" stroke="#979797" stroke-width="2" points="23 34 34 43 47 27" fill="transparent"/>\n' +
                                '</svg>';

                            $($html, $body).stop().animate({
                                'scrollTop': 160,
                            }, 500, function () {
                                $('#conteudo').find('header').remove();

                                div_sucesso
                                    .append(svg)
                                    .append(titulo)
                                    .append(texto);

                                $(form).html(div_sucesso);
                            });

                        } else {
                            new $.Zebra_Dialog(retorno.mensagem, {
                                custom_class: 'alert-zebra alert-error',
                                title: 'Erro ao realizar o pedido'
                            });
                        }

                    }).fail(function () {

                    }).always(function () {
                        flag_enviado = false;
                        $(form).find('#mostrar-cartao input[type="text"]:visible, #mostrar-cartao input[type="tel"]:visible').prop('disabled', false);
                        $(form).find('button[type="submit"]')
                            .html('')
                            .append('Finalizar Pedido')
                            .append('<i style="position: absolute;top: 50%;right: 10px;transform: translateY(-50%);" class="ml-4 fas fa-fw fa-check-circle"></i>')
                            .prop('disabled', false);
                    });

                }

                return false;
            }
        });

        jQuery.validator.addMethod("validate_card", function(value, element) {
            return !element.classList.contains('jp-card-invalid');
        }, "campo inválido");

    }

    if ($('#wrapper-avaliacoes-pendentes').length) {
        const avaliacoes_pendentes = $('#wrapper-avaliacoes-pendentes');

        avaliacoes_pendentes.find('.avaliacao > label:not(.rating)').hover(function () {
            var icon = $(this).prevAll().children('i');
            $(this).nextAll().children('i.fas').removeClass('fas').addClass('far');
            $(icon).removeClass('far').addClass('fas');
            $(this).children('i').removeClass('far').addClass('fas');
        }, function () {

            avaliacoes_pendentes.find('.avaliacao').find(':not(.rating)').children('i.fas').removeClass('fas').addClass('far');
            avaliacoes_pendentes.find('.avaliacao').find('.rating').children('i.far').removeClass('far').addClass('fas');

        });

        avaliacoes_pendentes.find('.avaliacao input[type="radio"]').change(function () {
            var parent = $(this).parent();
            var label_selected = parent.prevAll();
            var icons = label_selected.children('i');

            $(this).parents('.avaliacao').find('.rating').removeClass('rating');
            //avaliacoes_pendentes.nextAll().find('.avaliacao').find('.fas').removeClass('fas').addClass('far');

            $(label_selected).addClass('rating');
            parent.addClass('rating');

            $(icons).removeClass('far').addClass('fas');
            parent.children('i').removeClass('far').addClass('fas');
        });

        $('#toggle-pedidos-pendentes').click(function () {
            var $this = $(this);
            var body = $this.parent().siblings('.body');
            body.fadeToggle(function () {

                if (body.is(':visible')) {
                    $this.html('ocultar');
                } else {
                    $this.html('mostrar');
                }

            });

            return false;
        });

    }

    if ($('.form-avaliacao').length) {

        $('.form-avaliacao').submit(function () {
            var $this = $(this);

            $.ajax({
                type: 'POST',
                url: baseurl + 'requisicoes-pedido.php',
                dataType: 'json',
                data: $this.serialize(),
                beforeSend: function () {
                    $this.find('button[type="submit"]').html($('<i>').addClass('fa fa-spinner fa-spin')).prop('disabled', true);
                }
            }).done(function (retorno) {

                if (retorno['status']) {
                    $this.parent().html($('<div>').addClass('alert alert-success m-0').html(retorno['mensagem']));
                }

            }).fail(function () {

            }).always(function () {
                $this.find('button[type="submit"]').html('Avaliar').prop('disabled', false);
            });

            return false;
        });

    }

    if ($('#formParceiro').length) {

        $('#formParceiro').validate({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                if ($(form).valid) {
                    $(form).find('button[type="submit"]').prop('disabled', true).html('Aguarde...').append($("<i>").addClass("fa fa-spinner fa-spin float-right"));
                    return true;
                }

            }
        });

        $('.mascara-cep').mask('00000-000', {placeholder: '_____ - ___'});
        jQuery.validator.addMethod("cep", function(value, element) {
            return this.optional(element) || /^[0-9]{5}-[0-9]{3}$/.test(value);
        }, "Por favor, digite um CEP válido");

        $('#formParceiro').find('#cep').blur(function () {
            const grupo_input = $('#endereco, #bairro, #cidade, #complemento');

            if ($(this).valid()) {

                $.ajax({
                    type: "GET",
                    url: "https://viacep.com.br/ws/" + $(this).val() + "/json/",
                    dataType: "json",
                    timeout: 5000,
                    beforeSend: function () {
                        grupo_input.siblings('label').find('i').remove();
                        grupo_input.siblings('label').append($('<i>').addClass('fa-li fa fa-spinner fa-spin').css({
                            'position': 'relative',
                            'left': '0',
                            'top': '0',
                            'right': '0',
                            'font-size': '.7rem'
                        }));
                    }
                }).done(function (retorno) {
                    $("#endereco").val(retorno.logradouro);
                    $("#bairro").val(retorno.bairro);
                    $("#cidade").val(retorno.localidade);
                    $("#complemento").val(retorno.complemento);
                    $('#estado option[value="' + retorno.uf + '"]').prop('selected', true);

                    grupo_input.siblings('label').find('i').remove();
                    $('#numero').focus();

                }).fail(function () {
                    grupo_input.siblings('label').find('i').remove();
                });

            } else
                $(this).focus();
        });

    }

});

function recarregaCarrinho(retorno) {
    $('#load-produto').addClass('d-none');
    $('#modalSelecaoProduto').modal('hide');

    if (retorno.status) {
        $('#load-produto').addClass('d-none');

        var carrinho = $('#carrinho .card-body');
        var footer = $('#carrinho .card-footer');

        carrinho.html('');

        if (retorno.carrinho) {

            if (retorno.carrinho.produtos) {

                carrinho.find('#vazio').remove();
                carrinho.siblings('.card-footer').removeClass('d-none');

                var produto_adicionado = retorno.carrinho.produtos;

                $.each(produto_adicionado, function (index1, produto) {

                    var string_comp = '';

                    if (produto.complementos) {

                        var  complementos = produto.complementos;

                        $.each(complementos, function (index2, comp) {

                            var preco_comp = (comp.preco !== '0,00') ? '<span class="float-right">+R$ '+ comp.preco +'</span>' : '';

                            string_comp += '<p class="text-muted m-0 font-weight-light">- '+ comp.nome + preco_comp +'</p>\n';

                        });


                    }

                    var estrutura1 =
                        '<div class="carrinho-item d-flex py-4 d-flex align-items-center justify-content-center px-2 flex-row flex-nowrap border-bottom">\n' +
                        '<div class="informacoes d-flex flex-row flex-wrap">\n' +
                        '<span class="d-inline-block font-weight-light pr-3 item-qtde">'+ ((produto.qtde > 9) ? produto.qtde : '0'+produto.qtde) +'</span>\n' +
                        '<span class="d-inline-block font-weight-bold item-nome">'+ produto.nome +'</span>\n' +
                        '<span class="d-inline-block font-weight-bold item-preco text-right">R$ '+ produto.preco +'</span>\n';

                    var estrutura2 =
                        '<div class="complementos ml-5 w-100 clearfix pr-3">\n' + string_comp;

                    var estrutura3 =
                        '</div>\n' +
                        '</div>\n' +
                        '<div class="d-flex align-items-center justify-content-center editar-item flex-column">\n' +
                        '<a class="btn btn-outline-primary border-0 btn-sm editar-produto" href="javascript:void(0)">\n' +
                        '<i class="fas fa-pen d-inline-block "></i>\n' +
                        '</a>\n' +
                        '<a class="btn btn-outline-danger border-0 btn-sm excluir-produto" href="javascript:void(0)">\n' +
                        '<i class="fas fa-times d-inline-block "></i>\n' +
                        '</a>\n' +
                        '<input type="hidden" name="id_item_carrinho" value="'+ produto.iditem +'">\n' +
                        '<input type="hidden" name="id_produto" value="'+ produto.idproduto +'">\n' +
                        '<input type="hidden" name="nome_produto" value="'+ produto.nome +'">\n' +
                        '<input type="hidden" name="preco_produto" value="'+ produto.preco +'">\n' +
                        '<input type="hidden" name="obs_produto" value="'+ produto.obs +'">\n' +
                        '<input type="hidden" name="foto_produto" value="'+ produto.foto +'">\n' +
                        '<input type="hidden" name="qtde_produto" value="'+ produto.qtde +'">\n' +
                        '</div>\n' +
                        '</div>';

                    carrinho.append(estrutura1 + estrutura2 + estrutura3);

                });

                footer.find('#taxa-entrega').html('R$ ' + retorno.carrinho.taxa_entrega);
                footer.find('#total-itens').html('R$ ' + retorno.carrinho.total_itens);
                footer.find('#total-geral').html('R$ ' + retorno.carrinho.total_geral);


            } else {

                carrinho.html(
                    '                                        <div id="vazio">\n' +
                    '                                            <img src="'+ baseurl +'img/carrinho-vazio.svg" alt="">\n' +
                    '                                            Seu carrinho está vazio\n' +
                    '                                        </div>');
                footer.addClass('d-none');

            }

        } else {

        }


    } else {

        new $.Zebra_Dialog(retorno['mensagem'], {
            custom_class: 'alert-zebra alert-error',
            title: 'Erro ao adicionar o produto'
        });

    }
}

function adicionarProduto(form) {

    $.ajax({
        type: 'POST',
        url: baseurl + 'requisicoes-pedido.php',
        dataType: 'json',
        data: form,
        beforeSend: function () {
            $('#load-produto').removeClass('d-none');
        }
    }).done(function (retorno) {
        recarregaCarrinho(retorno);

    }).fail(function () {
        $('#load-produto').addClass('d-none');

        $('#modalSelecaoProduto').modal('hide');

        new $.Zebra_Dialog('Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente', {
            custom_class: 'alert-zebra alert-error',
            title: 'Erro na requisição'
        });

    });

}

function abreEndereco() {
    var efeito = $("#efeito");
    var cep = $("#dados-cep");
    var endereco = $("#dados-endereco");

    efeito.animate({
        "height": "390px",
        queue: false
    }, 400);

    cep
        .animate({
            left: "-100%",
            opacity: 0,
            queue: false
        },500, function () {
            $(this).css("display", "none")
        });

    endereco
        .css("display", "block")
        .animate({
            right: 0,
            opacity: 1,
            queue: false
        },500, function () {
            $("#descricao").focus();
        });

}

function fechaEndereco() {
    var efeito = $("#efeito");
    var cep = $("#dados-cep");
    var endereco = $("#dados-endereco");

    efeito.animate({
        "height": "150px",
        queue: false
    }, 400);

    endereco
        .animate({
            right: "-100%",
            opacity: 0,
            queue: false
        }, 500, function () {
            $(this).css("display", "none")
        });

    cep
        .css("display", "block")
        .animate({
            left: 0,
            opacity: 1,
            queue: false
        }, 500);
}

function atualizaEnderecos(enderecos) {
    var tabela = $("#table-enderecos tbody");
    tabela.html(
        $("<tr>").html(
            $("<td>").html(
                $("<i>").addClass("fa fa-spinner fa-spin")
            ).addClass("text-center")
        )
    );

    if (Object.getOwnPropertyNames(enderecos).length) {
        $.each(enderecos, function (index, endereco) {
            var tr = $("<tr>");
            var td_descricao = $("<td>").addClass("border-right-0 align-middle");
            var td_divisor = $("<td>").addClass("border-right-0 border-left-0 align-middle");
            var td_endereco = $("<td>").addClass("border-right-0 border-left-0 align-middle");
            var td_acoes = $("<td>").addClass("border-left-0 align-middle text-center");

            /*td_descricao*/
            var classe_icone = (endereco.favorito) ? "fa" : "far";
            var link_star = $("<a href>");
            var icone_star = $("<i>").addClass("fa-star").addClass(classe_icone);
            link_star.html(icone_star).addClass("alterar-favorito").data("id", endereco.id);
            var p_descricao = $("<p>").addClass("m-0 text-center ml-3 d-inline font-weight-normal").html(endereco.descricao);
            
            if (endereco.favorito)
                link_star.addClass("endereco-ativo");

            td_descricao.append(link_star);
            td_descricao.append(p_descricao);
            tr.append(td_descricao);

            /*td_divisor*/
            var span_divisor = $("<span>").addClass("divisor-tabela");
            td_divisor.append(span_divisor);
            tr.append(td_divisor);

            /*td_endereco*/
            var p_endereco = $("<p>").addClass("m-0").html(
                endereco.rua +", "+ endereco.numero +" - "+ endereco.cidade
            );
            td_endereco.append(p_endereco);
            tr.append(td_endereco);

            /*td_acoes*/
            var div_drop = $("<div>").addClass("dropdown show");
            var link_drop = $("<a>").addClass("btn btn-primary dropdown-toggle").attr({
                "href": "#",
                "aria-haspopup": "true",
                "aria-expanded": "false",
                "data-toggle": "dropdown"
            }).html("Ações");

            var div_dropmenu = $("<div>").addClass("dropdown-menu dropdown-menu-right");
            div_dropmenu
                .append(
                    $("<a href='#'>").addClass("dropdown-item excluir-endereco").html("Excluir Endereço").data("id", endereco.id)
                ).append(
                    $("<a href='#'>").addClass("dropdown-item").html("Restaurantes Próximos")
                );

            div_drop.append(link_drop).append(div_dropmenu);
            td_acoes.append(div_drop);

            tr.append(td_acoes);

            if (index === "0")
                tabela.html(tr);
            else
                tabela.append(tr);
        });

        $('.dropdown-toggle').dropdown();
    } else {
        tabela.html(
            $("<tr>").append(
                $("<td>").html("Nenhum endereço cadastrado").addClass("text-center")
            )
        )
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
}

function number_format(numero, decimal, decimal_separador, milhar_separador) {
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
        prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
        sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
        dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
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