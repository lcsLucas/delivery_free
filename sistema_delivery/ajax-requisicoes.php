<?php
	$usur_system = true;
    include '../config.php';
    include_once './classes/admin/banco.php';
    include_once './classes/admin/funcoes.php';
    include_once './classes/Interfaceclasses.php';
    include_once './classes/ItemCompra.php';
    include_once './classes/ItemSaida.php';
    include_once './classes/FormPagto.php';
    include_once './classes/Avaliacoes.php';

    $retorno = array();
    $item_compra = new ItemCompra();
    $item_compra->setIdEmp($_SESSION["_idEmpresa"]);

    $item_saida = new ItemSaida();
    $item_saida->setIdEmp($_SESSION["_idEmpresa"]);

    $pagamento = new FormPagto();
    $pagamento->setIdEmpresa($_SESSION["_idEmpresa"]);

    $avaliacao = new Avaliacoes();
    $avaliacao->setIdEmpresa($_SESSION["_idEmpresa"]);

    if(htmlspecialchars(SQLinjection($_SERVER["REQUEST_METHOD"])) === 'POST') {//requisição do tipo POST

        if (filter_has_var(INPUT_POST, "addInsumo")) {
            $id_insumo = trim(SQLinjection(filter_input(INPUT_POST, 'insumo', FILTER_VALIDATE_INT)));
            $qtde = filter_input(INPUT_POST, 'qtde', FILTER_VALIDATE_FLOAT);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);

            if (empty($id_insumo) || empty($qtde) || empty($preco)) {
                $retorno["titulo"] = "Erro ao Adicionar Produto";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Existem Campos Obrigatórios Não Preenchidos ou Preenchidos Incorretamente!";
            } else {
                $item_compra->setId($id_insumo);
                $item_compra->setQtde($qtde);
                $item_compra->setPreco($preco);

                if ($item_compra->verificaInsumo()) {

                    if (empty($_SESSION["_hashsession"])) {
                        $_SESSION["_hashsession"] = password_hash(htmlspecialchars($_SERVER["HTTP_USER_AGENT"]) . htmlspecialchars($_SERVER["REMOTE_ADDR"]) . $item_compra->getIdEmp(), PASSWORD_DEFAULT);
                    }

                        $produto = array(
                            "qtdeinsumo" => $item_compra->getQtde(),
                            "precoinsumo" => $item_compra->getPreco()
                        );

                        if (empty($_SESSION["_insumosentrada"][$item_compra->getId()])) {
                            $_SESSION["_insumosentrada"][$item_compra->getId()] = $produto;

                            $retorno_produtos = array();
                            $total = 0.000;
                            $subTotal = 0.000;

                            foreach ($_SESSION["_insumosentrada"] as $id => $itens_session) {
                                $item_compra->setId($id);

                                if ($item_compra->carregaNomeInsumo()) {

                                    $subTotal = $itens_session["qtdeinsumo"] * $itens_session["precoinsumo"];
                                    $total += $subTotal;

                                    $retorno_produtos[] = json_encode(array(
                                        "idinsumo" => $item_compra->getId(),
                                        "nomeinsumo" => $item_compra->getNome(),
                                        "qtdeinsumo" => number_format($itens_session["qtdeinsumo"],2,",","."),
                                        "precoinsumo" => number_format($itens_session["precoinsumo"],2,",","."),
                                        "totalinsumo" => number_format($subTotal,2,",",".")
                                    ),JSON_FORCE_OBJECT);

                                } else{
                                    $retorno["titulo"] = "Erro ao Recuperar Insumos";
                                    $retorno["status"] = false;
                                    $retorno["mensagem"] = "Não foi possível recuperar informações de alguns insumos, por favor atualize a página";
                                }

                            }

                            if (empty($retorno)) {

                                $retorno["status"] = true;
                                $retorno["totalGeral"] = number_format($total,2,",",".");
                                $retorno["totalGeral2"] = $total;
                                $retorno["produtos"] = $retorno_produtos;

                            }


                        } else {
                            $retorno["titulo"] = "Erro ao Adicionar Insumo";
                            $retorno["status"] = false;
                            $retorno["mensagem"] = "Esse Insumo Já Foi Adicionado, caso queria alterá-lo remová-o e adicione novamente";
                        }


                } else {
                    $retorno["titulo"] = "Erro ao Adicionar o Insumo";
                    $retorno["status"] = false;
                    $retorno["mensagem"] = "Insumo Não encontrado, atualize a página e tente novamente";
                }
            }

        } else if (filter_has_var(INPUT_POST, "addProduto")) {

            $id_produto = trim(SQLinjection(filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT)));
            $qtde = filter_input(INPUT_POST, 'qtde', FILTER_VALIDATE_FLOAT);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);

            if (empty($id_produto) || empty($qtde) || empty($preco)) {
                $retorno["titulo"] = "Erro ao Adicionar Produto";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Existem Campos Obrigatórios Não Preenchidos ou Preenchidos Incorretamente!";
            } else {

                $item_compra->setId($id_produto);
                $item_compra->setQtde($qtde);
                $item_compra->setPreco($preco);

                if ($item_compra->verificaProduto()) {

                    if (empty($_SESSION["_hashsession"])) {
                        $_SESSION["_hashsession"] = password_hash(htmlspecialchars($_SERVER["HTTP_USER_AGENT"]) . htmlspecialchars($_SERVER["REMOTE_ADDR"]) . $item_compra->getIdEmp(), PASSWORD_DEFAULT);
                    }

                    $produto = array(
                        "qtdeproduto" => $item_compra->getQtde(),
                        "precoproduto" => $item_compra->getPreco()
                    );

                    if (empty($_SESSION["_produtosentrada"][$item_compra->getId()])) {
                        $_SESSION["_produtosentrada"][$item_compra->getId()] = $produto;

                        $retorno_produtos = array();
                        $total = 0.000;
                        $subTotal = 0.000;

                        foreach ($_SESSION["_produtosentrada"] as $id => $itens_session) {

                            $item_compra->setId($id);

                            if ($item_compra->carregaNomeProduto()) {

                                $subTotal = $itens_session["qtdeproduto"] * $itens_session["precoproduto"];
                                $total += $subTotal;

                                $retorno_produtos[] = json_encode(array(
                                    "idproduto" => $item_compra->getId(),
                                    "nomeproduto" => $item_compra->getNome(),
                                    "qtdeproduto" => number_format($itens_session["qtdeproduto"],2,",","."),
                                    "precoproduto" => number_format($itens_session["precoproduto"],2,",","."),
                                    "totalproduto" => number_format($subTotal,2,",",".")
                                ),JSON_FORCE_OBJECT);

                            } else {
                                $retorno["titulo"] = "Erro ao Recuperar Produtos";
                                $retorno["status"] = false;
                                $retorno["mensagem"] = "Não foi possível recuperar informações de alguns produtos, por favor atualize a página";
                            }

                        }

                        if (empty($retorno)) {

                            $retorno["status"] = true;
                            $retorno["totalGeral"] = number_format($total,2,",",".");
                            $retorno["totalGeral2"] = $total;
                            $retorno["produtos"] = $retorno_produtos;

                        }

                    } else {
                        $retorno["titulo"] = "Erro ao Adicionar Produto";
                        $retorno["status"] = false;
                        $retorno["mensagem"] = "Esse Produto Já Foi Adicionado, caso queria alterá-lo remová-o e adicione novamente";
                    }


                } else {
                    $retorno["titulo"] = "Erro ao Adicionar o Produto";
                    $retorno["status"] = false;
                    $retorno["mensagem"] = "Produto Não encontrado, atualize a página e tente novamente";
                }

            }

        } else if (filter_has_var(INPUT_POST, "addProdutoSaida")) {

            $id_produto = trim(SQLinjection(filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT)));
            $qtde = filter_input(INPUT_POST, 'qtde', FILTER_VALIDATE_FLOAT);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);

            if (empty($id_produto) || empty($qtde) || empty($preco)) {
                $retorno["titulo"] = "Erro ao Adicionar Produto";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Existem Campos Obrigatórios Não Preenchidos ou Preenchidos Incorretamente!";
            } else {

                $item_saida->setId($id_produto);
                $item_saida->setQtde($qtde);
                $item_saida->setPreco($preco);

                if ($item_saida->verificaProduto()) {

                    if (empty($_SESSION["_hashsession"])) {
                        $_SESSION["_hashsession"] = password_hash(htmlspecialchars($_SERVER["HTTP_USER_AGENT"]) . htmlspecialchars($_SERVER["REMOTE_ADDR"]) . $item_saida->getIdEmp(), PASSWORD_DEFAULT);
                    }

                    $produto = array(
                        "qtdeproduto" => $item_saida->getQtde(),
                        "precoproduto" => $item_saida->getPreco()
                    );

                    if (empty($_SESSION["_produtossaidas"][$item_saida->getId()])) {
                        $_SESSION["_produtossaidas"][$item_saida->getId()] = $produto;

                        $retorno_produtos = array();
                        $total = 0.000;
                        $subTotal = 0.000;

                        foreach ($_SESSION["_produtossaidas"] as $id => $itens_session) {

                            $item_saida->setId($id);

                            if ($item_saida->carregaNomeProduto()) {

                                $subTotal = $itens_session["qtdeproduto"] * $itens_session["precoproduto"];
                                $total += $subTotal;

                                $retorno_produtos[] = json_encode(array(
                                    "idproduto" => $item_saida->getId(),
                                    "nomeproduto" => $item_saida->getNome(),
                                    "qtdeproduto" => number_format($itens_session["qtdeproduto"],2,",","."),
                                    "precoproduto" => number_format($itens_session["precoproduto"],2,",","."),
                                    "totalproduto" => number_format($subTotal,2,",",".")
                                ),JSON_FORCE_OBJECT);

                            } else {
                                $retorno["titulo"] = "Erro ao Recuperar Produtos";
                                $retorno["status"] = false;
                                $retorno["mensagem"] = "Não foi possível recuperar informações de alguns produtos, por favor atualize a página";
                            }

                        }

                        if (empty($retorno)) {

                            $retorno["status"] = true;
                            $retorno["totalGeral"] = number_format($total,2,",",".");
                            $retorno["totalGeral2"] = $total;
                            $retorno["produtos"] = $retorno_produtos;

                        }

                    } else {
                        $retorno["titulo"] = "Erro ao Adicionar Produto";
                        $retorno["status"] = false;
                        $retorno["mensagem"] = "Esse Produto Já Foi Adicionado, caso queria alterá-lo remová-o e adicione novamente";
                    }


                } else {
                    $retorno["titulo"] = "Erro ao Adicionar o Produto";
                    $retorno["status"] = false;
                    $retorno["mensagem"] = "Produto Não encontrado, atualize a página e tente novamente";
                }

            }

        }else if (filter_has_var(INPUT_POST, "remInsumo")) {
            $id_insumo = trim(SQLinjection(filter_input(INPUT_POST, 'insumo', FILTER_VALIDATE_INT)));

            if (empty($id_insumo)) {
                $retorno["titulo"] = "Erro ao Remover o Insumo";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Existem parametros não informados. Atualize a página e tente novamente";
            } else {
                $item_compra->setId($id_insumo);

                if (!empty($_SESSION["_insumosentrada"][$id_insumo])) {
                    unset($_SESSION["_insumosentrada"][$id_insumo]);

                    $retorno_produtos = array();
                    $total = 0.000;
                    $subTotal = 0.000;

                    foreach ($_SESSION["_insumosentrada"] as $id => $itens_session) {
                        $item_compra->setId($id);

                        if ($item_compra->carregaNomeInsumo()) {

                            $subTotal = $itens_session["qtdeinsumo"] * $itens_session["precoinsumo"];
                            $total += $subTotal;

                            $retorno_produtos[] = json_encode(array(
                                "idinsumo" => $item_compra->getId(),
                                "nomeinsumo" => $item_compra->getNome(),
                                "qtdeinsumo" => number_format($itens_session["qtdeinsumo"],2,",","."),
                                "precoinsumo" => number_format($itens_session["precoinsumo"],2,",","."),
                                "totalinsumo" => number_format($subTotal,2,",",".")
                            ),JSON_FORCE_OBJECT);

                        } else{
                            $retorno["titulo"] = "Erro ao Recuperar Insumos";
                            $retorno["status"] = false;
                            $retorno["mensagem"] = "Não foi possível recuperar informações de alguns insumos, por favor atualize a página";
                        }

                    }

                    if (empty($retorno)) {

                        $retorno["status"] = true;
                        $retorno["totalGeral"] = number_format($total,2,",",".");
                        $retorno["produtos"] = $retorno_produtos;

                    }

                }

            }
        } else if(filter_has_var(INPUT_POST, "remProduto")) {

            $id_produto = trim(SQLinjection(filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT)));

            if (empty($id_produto)) {
                $retorno["titulo"] = "Erro ao Remover o Produto";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Existem parametros não informados. Atualize a página e tente novamente";
            } else {

                $item_compra->setId($id_produto);

                if (!empty($_SESSION["_produtosentrada"][$id_produto])) {

                    unset($_SESSION["_produtosentrada"][$id_produto]);
                    $retorno_produtos = array();
                    $total = 0.000;
                    $subTotal = 0.000;

                    foreach ($_SESSION["_produtosentrada"] as $id => $itens_session) {

                        $item_compra->setId($id);

                        if ($item_compra->carregaNomeProduto()) {

                            $subTotal = $itens_session["qtdeproduto"] * $itens_session["precoproduto"];
                            $total += $subTotal;

                            $retorno_produtos[] = json_encode(array(
                                "idproduto" => $item_compra->getId(),
                                "nomeproduto" => $item_compra->getNome(),
                                "qtdeproduto" => number_format($itens_session["qtdeproduto"],2,",","."),
                                "precoproduto" => number_format($itens_session["precoproduto"],2,",","."),
                                "totalproduto" => number_format($subTotal,2,",",".")
                            ),JSON_FORCE_OBJECT);

                        } else{
                            $retorno["titulo"] = "Erro ao Recuperar Produtos";
                            $retorno["status"] = false;
                            $retorno["mensagem"] = "Não foi possível recuperar informações de alguns produtos, por favor atualize a página";
                        }

                    }

                    if (empty($retorno)) {

                        $retorno["status"] = true;
                        $retorno["totalGeral"] = number_format($total,2,",",".");
                        $retorno["produtos"] = $retorno_produtos;

                    }

                }

            }

        } else if(filter_has_var(INPUT_POST, "remProdutoSaida")) {

            $id_produto = trim(SQLinjection(filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT)));

            if (empty($id_produto)) {
                $retorno["titulo"] = "Erro ao Remover o Produto";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Existem parametros não informados. Atualize a página e tente novamente";
            } else {

                $item_saida->setId($id_produto);

                if (!empty($_SESSION["_produtossaidas"][$id_produto])) {

                    unset($_SESSION["_produtossaidas"][$id_produto]);
                    $retorno_produtos = array();
                    $total = 0.000;
                    $subTotal = 0.000;

                    foreach ($_SESSION["_produtossaidas"] as $id => $itens_session) {

                        $item_saida->setId($id);

                        if ($item_saida->carregaNomeProduto()) {

                            $subTotal = $itens_session["qtdeproduto"] * $itens_session["precoproduto"];
                            $total += $subTotal;

                            $retorno_produtos[] = json_encode(array(
                                "idproduto" => $item_saida->getId(),
                                "nomeproduto" => $item_saida->getNome(),
                                "qtdeproduto" => number_format($itens_session["qtdeproduto"],2,",","."),
                                "precoproduto" => number_format($itens_session["precoproduto"],2,",","."),
                                "totalproduto" => number_format($subTotal,2,",",".")
                            ),JSON_FORCE_OBJECT);

                        } else{
                            $retorno["titulo"] = "Erro ao Recuperar Produtos";
                            $retorno["status"] = false;
                            $retorno["mensagem"] = "Não foi possível recuperar informações de alguns produtos, por favor atualize a página";
                        }

                    }

                    if (empty($retorno)) {

                        $retorno["status"] = true;
                        $retorno["totalGeral"] = number_format($total,2,",",".");
                        $retorno["produtos"] = $retorno_produtos;

                    }

                }

            }

        } else if(filter_has_var(INPUT_POST, "gera-contas")) {
            $id_pagto = filter_input(INPUT_POST, "id_forma", FILTER_VALIDATE_INT);

            if (!empty($id_pagto)) {

                $pagamento->setId($id_pagto);
                if($pagamento->recuperaNumParcelas()) {

                    $retorno["status"] = true;
                    $retorno["retorno"] = json_encode(
                                                        array(
                                                            "numParcela" => $pagamento->getNumParcela(),
                                                            "entrada" => intval($pagamento->getFlagEntrada())
                                                        )
                                                        ,JSON_FORCE_OBJECT);

                } else {
                    $retorno["titulo"] = "Erro ao recuperar informações da forma de pagamento";
                    $retorno["status"] = false;
                    $retorno["mensagem"] = "Não foi possível recuperar informações da forma de pagamento, por favor atualize a página";
                }

            } else {
                $retorno["titulo"] = "Erro ao recuperar informações da forma de pagamento";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível recuperar informações da forma de pagamento, por favor atualize a página";
            }

        } elseif(filter_has_var(INPUT_POST, 'responder_avaliacao')) {
            $id_avaliacao = filter_input(INPUT_POST, "id_avaliacao", FILTER_VALIDATE_INT);
            $obs = trim(filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_SPECIAL_CHARS));

            if (!empty($id_avaliacao) && !empty($obs)) {

                $avaliacao->setId($id_avaliacao);
                $avaliacao->setResposta($obs);

                if ($avaliacao->responderAvaliacao()) {
                    $retorno["status"] = true;
                    $retorno['resposta'] = $avaliacao->getResposta();
                    $retorno['data_resposta'] = $avaliacao->getDataResposta();
                } else {
                    $retorno["titulo"] = "Erro ao responder a avaliação";
                    $retorno["status"] = false;
                    $retorno["mensagem"] = "Não foi possível responder a avaliação, por favor atualize a página e tente novamente";
                }

            } else {
                $retorno["titulo"] = "Erro ao recuperar informações da avaliação";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível recuperar informações da avaliação, por favor atualize a página";
            }

        }

    }

    if (empty($retorno)) {
        $retorno["titulo"] = "Erro na Requisição";
        $retorno["status"] =false;
        $retorno["mensagem"] = "Ocorreu um erro ao Fazer a requisição.";
    }

    echo json_encode($retorno);