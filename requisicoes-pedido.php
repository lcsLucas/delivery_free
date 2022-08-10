<?php
include_once "config.php";
include_once 'sistema_delivery/classes/Produto.php';
include_once 'sistema_delivery/classes/CarrinhoPedidos.php';
include_once 'sistema_delivery/classes/ItensCarrinho.php';
include_once 'sistema_delivery/classes/Saida.php';
include_once 'sistema_delivery/classes/Avaliacoes.php';

$carrinho = new CarrinhoPedidos();
$saida = new Saida();
$avaliacao = new Avaliacoes();

if (!empty($_SESSION['_idrestaurante'])) {
    $carrinho->setIdEmpresa($_SESSION['_idrestaurante']);
    $saida->setIdEmpresa($_SESSION['_idrestaurante']);
}

$produto = new Produto();
$itens_carrinho = new ItensCarrinho();
$retorno = array();
$array_complementos = array();
$array_idcomplementos = array();
$array_obg = array();
$array_min = array();
$array_max = array();
$array_tipo_comp = array();

if (filter_has_var(INPUT_POST, 'carregar_complementos')) {
    $id = filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT);

    if (!empty($id) && !empty($_SESSION['_idrestaurante'])) {

        $produto->setId($id);
        $produto->setIdEmpresa($_SESSION['_idrestaurante']);
        $retorno['status'] = true;
        $retorno['complementos'] = $produto->carregar_complementos();

    } else {
        $retorno['status'] = false;
        $retorno['mensagem'] = 'Não foi possível recuperar os complementos do produto, por favor tente novamente';
    }

    echo json_encode($retorno);

} else if(filter_has_var(INPUT_POST, 'carregar_complementos_2')) {
    $id = filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT);
    $id_item = filter_input(INPUT_POST, 'item_carrinho', FILTER_VALIDATE_INT);

    if (!empty($id) && !empty($id_item) && !empty($_SESSION['_idrestaurante'])) {

        $produto->setId($id);
        $produto->setIdEmpresa($_SESSION['_idrestaurante']);

        $carrinho->setProdutos($produto->getId());
        $carrinho->setIdCarrinhoItem($id_item);
        $carrinho->setSessao($_SESSION["_hashcarrinho"]);

        $retorno['status'] = true;
        $retorno['complementos'] = $produto->carregar_complementos();
        $retorno['complementos_produto'] = $carrinho->recuperar_complementos_item();

    } else {
        $retorno['status'] = false;
        $retorno['mensagem'] = 'Não foi possível recuperar os complementos do produto, por favor tente novamente';
    }

    echo json_encode($retorno);

} else if (filter_has_var(INPUT_POST, 'add_produto')) {
    $id = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);
    $id_item = filter_input(INPUT_POST, 'item_carrinho_id', FILTER_VALIDATE_INT);
    $qtde = filter_input(INPUT_POST, 'qtde', FILTER_VALIDATE_INT);
    $obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_SPECIAL_CHARS);
    $ok = true;
    $complementos_ok = true;

    if (!empty($id) && !empty($qtde)) {

        $itens_carrinho->setId($id);
        $itens_carrinho->setQtde($qtde);
        $itens_carrinho->setObs($obs);
        $lista = array();

        if (filter_has_var(INPUT_POST, "complementos")) {
            $array_idcomplementos = array_filter($_POST["complementos"]);
            $array_idcomplementos = filter_var_array($array_idcomplementos, FILTER_VALIDATE_INT);

            if (filter_has_var(INPUT_POST, "obrigatorio")) {
                $array_obg = array_filter($_POST["obrigatorio"]);
                $array_obg = filter_var_array($array_obg, FILTER_VALIDATE_INT);
            }

            if (filter_has_var(INPUT_POST, "qtdemin")) {
                $array_min = array_filter($_POST["qtdemin"]);
                $array_min = filter_var_array($array_min, FILTER_VALIDATE_INT);
            }

            if (filter_has_var(INPUT_POST, "qtdemax")) {
                $array_max = array_filter($_POST["qtdemax"]);
                $array_max = filter_var_array($array_max, FILTER_VALIDATE_INT);
            }

            if (filter_has_var(INPUT_POST, "tipo_complemento")) {
                $array_tipo_comp = array_filter($_POST["tipo_complemento"]);
                $array_tipo_comp = filter_var_array($array_tipo_comp, FILTER_VALIDATE_INT);
            }

            if (!empty($array_idcomplementos)) {

                foreach ($array_idcomplementos as $index => $com_id) {

                    $array_opcoes = array();

                    if (filter_has_var(INPUT_POST, 'complemento_' . $com_id)) {
                        $array_opcoes = array_filter($_POST['complemento_' . $com_id]);
                        $array_opcoes = filter_var_array($array_opcoes, FILTER_VALIDATE_INT);
                    }

                    $array_complementos['id'] = $com_id;
                    $total_opcoes = count($array_opcoes);

                    if (!empty($array_obg[$index])) {

                        if (!empty($array_min[$index]) && $array_min[$index] > 1) {

                            if ($total_opcoes < $array_min[$index]) {
                                $retorno['status'] = $complementos_ok = false;
                                $retorno['mensagem'] = 'As seleções dos complementos do produto não foram feitas corretamente, tente novamente';
                            }

                        } else {

                            if (!empty($array_min[$index]) && $total_opcoes < $array_min[$index]) {
                                $retorno['status'] = $complementos_ok = false;
                                $retorno['mensagem'] = 'As seleções dos complementos do produto não foram feitas corretamente, tente novamente';
                            }

                        }

                    }

                    if (!empty($array_max[$index]) && $array_max[$index] > 0) {

                        if ($total_opcoes > $array_max[$index]) {
                            $retorno['status'] = $complementos_ok = false;
                            $retorno['mensagem'] = 'As seleções dos complementos do produto não foram feitas corretamente, tente novamente';
                        }

                    }

                    $array_complementos[] = array(
                        'id' => $array_idcomplementos[$index],
                        'flag_obrigatorio' => !empty($array_obg[$index]) ? 1 : 0,
                        'qtde_min' => !empty($array_min[$index]) ? $array_min[$index] : 0,
                        'qtde_max' => !empty($array_max[$index]) ? $array_max[$index] : 0,
                        'tipo_complemento' => !empty($array_tipo_comp[$index]) ? $array_tipo_comp[$index] : '',
                        'opcoes' => $array_opcoes
                    );

                }

                $itens_carrinho->setComplementos($array_complementos);

            }

        }

        if ($complementos_ok) {

        	$produto->setId($itens_carrinho->getId());

        	$estoque_atual = $produto->recuperarEstoque();
            $qtde_disponivel = $estoque_atual; //chamar uma função para verificar se tem em estoque e se é pra controlar

            if ((!empty($produto->getControleEstoque()) && !empty($qtde_disponivel)) || empty($produto->getControleEstoque())) {

                if (empty($produto->getControleEstoque()) || (!empty($produto->getControleEstoque()) && $qtde <= intval($qtde_disponivel))) {

                    if (empty($_SESSION['_hashcarrinho'])) { // carrinho não existe

                        $sessao = password_hash('carrinhoprodutos' . htmlspecialchars($_SERVER["HTTP_USER_AGENT"]) . htmlspecialchars($_SERVER["REMOTE_ADDR"]), PASSWORD_DEFAULT);
                        $carrinho->setSessao($sessao);

                        if (!$carrinho->iniciaCarrinho()) {//cria carrinho
                            $ok = false;
                        } else {
                            // criado
                            $_SESSION["_hashcarrinho"] = $sessao;
                            $_SESSION['_carrinhoprodutos'] = array();
                            setcookie("_hashcarrinho", $sessao, time() + (86400 * 7), "/", "", 0, 1);//7 dias

                        }

                    } else { //carrinho já existe

                        $carrinho->setSessao($_SESSION["_hashcarrinho"]);

                        if ($carrinho->carregar()) {
                            $lista = $_SESSION["_carrinhoprodutos"];
                        } else {
                            $ok = false;
                        }

                    }

                    if ($ok) {

                        $carrinho->setProdutos($itens_carrinho);

                        if (in_array($id_item, $_SESSION['_carrinhoprodutos'])) {

                            $carrinho->setIdCarrinhoItem($id_item);

                            if ($carrinho->atualizarProduto()) {
                                $retorno['status'] = true;
                                $retorno['mensagem'] = 'Produto alterado com sucesso';
                                $retorno['carrinho'] = $carrinho->recuperaItens($baseurl);
                            } else {
                                $retorno['status'] = false;
                                $retorno['mensagem'] = 'Desculpe, mas não foi possível adicionar o produto ao carrinho, por favor tente novamente';
                            }

                            // verifica se o id do item do carrinho já está na session
                            //item_carrinho_id

                        } else {

                            if ($carrinho->adicionarProduto()) {

                                $lista[] = $carrinho->getIdCarrinhoItem();
                                $_SESSION['_carrinhoprodutos'] = $lista;
                                $retorno['status'] = true;
                                $retorno['mensagem'] = 'Produto adicionado com sucesso';
                                $retorno['carrinho'] = $carrinho->recuperaItens($baseurl);


                            } else {
                                $retorno['status'] = false;
                                $retorno['mensagem'] = 'Desculpe, mas não foi possível adicionar o produto ao carrinho, por favor tente novamente';
                            }

                        }

                    } else {
                        $retorno['status'] = false;
                        $retorno['mensagem'] = 'Desculpe, mas não foi possível adicionar o produto ao carrinho, por favor tente novamente';
                    }

                } else {
                    $retorno['status'] = false;
                    $retorno['mensagem'] = 'Atenção, só temos ' . $qtde_disponivel .' unidades disponíveis desse produto, você deseja continuar?';
                }

            } else {
                $retorno['status'] = false;
                $retorno['mensagem'] = 'Desculpe, mas não temos mais esse produto disponível';
            }

        }

    } else {
        $retorno['status'] = false;
        $retorno['mensagem'] = 'Não foi possível recuperar as informações do produto, por favor tente novamente';
    }

    echo json_encode($retorno);
} else if (filter_has_var(INPUT_POST, 'aplicar_cupom')) {
    $id = filter_input(INPUT_POST, 'codigo_cupom', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($id) && !empty($_SESSION['_idrestaurante']) && !empty($_SESSION["_hashcarrinho"])) {

        $carrinho->setSessao($_SESSION["_hashcarrinho"]);
        $carrinho->setPromocao(strtolower($id));

        if ($carrinho->aplicarCupom()) {
            $retorno['status'] = true;
            $retorno['mensagem'] = 'Cupom aplicado';
            $valor_total = $carrinho->recuperarValores();
            $retorno['valores'] = $carrinho->recuperarDescontoCupom($valor_total['valor_total']);

            if (empty($retorno['valores'])) {
                $retorno['status'] = true;
                $retorno['mensagem'] = 'Ocorreu algum erro ao aplicar o cupom, por favor atualize a páginae tente novamente';
            }

        } else {
            $retorno['status'] = false;
            $retorno['mensagem'] = 'Esse cupom está indisponível no momento';
        }

    }

    echo json_encode($retorno);
} elseif(filter_has_var(INPUT_POST, 'remover_cupom')) {

    if (!empty($_SESSION['_idrestaurante']) && !empty($_SESSION["_hashcarrinho"])) {
        $carrinho->setSessao($_SESSION["_hashcarrinho"]);

        if (!empty($carrinho->removerCupom())) {
            $retorno['status'] = true;
            $retorno['valores'] = $carrinho->recuperarValores();
        } else {
            $retorno['status'] = false;
            $retorno['mensagem'] = 'Ocorreu algum erro ao aplicar o cupom, por favor atualize a páginae tente novamente';
        }

    }

    echo json_encode($retorno);
} elseif(filter_has_var(INPUT_POST, 'finalizar_pedido')) {
    $check_pagamento = filter_input(INPUT_POST, 'check_pagamento', FILTER_VALIDATE_INT);
    $check_endereco = filter_input(INPUT_POST, 'check_endereco', FILTER_VALIDATE_INT);
    $troco = trim(SQLinjection(filter_input(INPUT_POST, 'troco', FILTER_SANITIZE_STRING)));
    $numero_cartao = trim(SQLinjection(filter_input(INPUT_POST, 'numero_cartao', FILTER_SANITIZE_STRING)));
    $nome_titular = trim(SQLinjection(filter_input(INPUT_POST, 'nome_titular', FILTER_SANITIZE_STRING)));
    $validate_cartao = filter_input(INPUT_POST, 'validate_cartao', FILTER_SANITIZE_STRING);
    $codigo_seguranca = filter_input(INPUT_POST, 'codigo_seguranca', FILTER_VALIDATE_INT);

    if (empty($check_pagamento) || empty($check_endereco)) {
        $retorno['status'] = false;
        $retorno['mensagem'] = 'Você não informou todos os dados necessários, por favor verifique o formulário e tente novamente';
    } else {

        if ($check_pagamento === 2) {

            if (empty($numero_cartao) || empty($nome_titular) || empty($validate_cartao) || empty($codigo_seguranca)) {
                $retorno['status'] = false;
                $retorno['mensagem'] = 'Você não informou corretamente os dados do cartão, por favor verifique o formulário e tente novamente';
            } else {
                $numero_cartao = str_replace(' ','', $numero_cartao);

                if (validatecard($numero_cartao))
                    $ok = true;
                else {
                    $retorno['status'] = false;
                    $retorno['mensagem'] = 'O número do cartão de crédito informado é inválido, por favor verifique o formulário e tente novamente';
                }

            }

        } else
            $ok = true;

        if (!empty($ok)) {

            $carrinho->setSessao($_SESSION['_hashcarrinho']);

            $saida->setIdEmpresa($_SESSION['_idrestaurante']);
            $saida->setCliente($_SESSION['_idcliente']);

            if (!empty($troco)) {
            	$troco = str_replace('.', '', $troco);
            	$troco = str_replace(',', '.', $troco);
				$saida->setTroco($troco);
			}

            $saida->setCarrinho($carrinho);
            $saida->setTipoPagamento($check_pagamento);
            $saida->setEndereco($check_endereco);
            $saida->setNumeroCartao($numero_cartao);
            $saida->setNomeTitular($nome_titular);
            $saida->setValidateCartao($validate_cartao);
            $saida->setCodigoCartao($codigo_seguranca);

            if ($saida->verificaCepCliente()) {

				if ($saida->finalizarCarrinho()) {
					$retorno['status'] = true;

					unset(
						$_SESSION['_idrestaurante'],
						$_SESSION['pagina_restaurante'],
						$_SESSION['continuar'],
						$_SESSION['_cupomaplicado'],
						$_SESSION['_hashcarrinho'],
						$_SESSION['_carrinhoprodutos']
					);

				} else {
					$retorno['status'] = false;
					$retorno['mensagem'] = 'Não foi possível realizar o pedido, por favor atualize a página e tente novamente';
				}

			} else {

				$retorno['status'] = false;
				$retorno['mensagem'] = 'Não foi possível realizar o pedido, o restaurante não é da sua cidade';

			}

        }

    }

    sleep(2);
    echo json_encode($retorno);
} elseif(filter_has_var(INPUT_POST, 'avaliar_pedido')) {
    $id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_VALIDATE_INT);
    $classificacao = filter_input(INPUT_POST, 'avaliacao', FILTER_VALIDATE_INT, array('OPTIONS' => array('min_range' => 1, 'max_range' => 5)));
    $obs = trim(SQLinjection(filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING)));

    if (!empty($id_pedido) && !empty($classificacao) && !empty($obs) && !empty($_SESSION['_idcliente'])) {

        $avaliacao->setSaida($id_pedido);
        $avaliacao->setCliente($_SESSION['_idcliente']);
        $avaliacao->setClassificao($classificacao);
        $avaliacao->setObs($obs);

        if ($avaliacao->inserir()) {
            $retorno['status'] = true;
            $retorno['mensagem'] = 'Avaliação realizada com sucesso (Número pedido: #'. str_pad($id_pedido, 5, '0', STR_PAD_LEFT) .')';
        } else {
            $retorno['status'] = false;
            $retorno['mensagem'] = 'Não foi possível fazer a avaliação desse pedido, por favor atualize a página e tente novamente';
        }

    } else {
        $retorno['status'] = false;
        $retorno['mensagem'] = 'Não foi possível recuperar os parametros, por favor atualize a página e tente novamente';
    }

    echo json_encode($retorno);
} elseif(filter_has_var(INPUT_POST, 'excluir_item_carrinho')) {
	$id = filter_input(INPUT_POST, 'produto', FILTER_VALIDATE_INT);
	$id_item = filter_input(INPUT_POST, 'item_carrinho', FILTER_VALIDATE_INT);

	if (!empty($id) && !empty($id_item) && !empty($_SESSION["_hashcarrinho"])) {

		$itens_carrinho->setId($id);
		$carrinho->setSessao($_SESSION["_hashcarrinho"]);
		$carrinho->setProdutos($itens_carrinho);
		$carrinho->setIdCarrinhoItem($id_item);

		if ($carrinho->carregar()) {

			$index = (int) array_search($id_item, $_SESSION['_carrinhoprodutos']);

			if ($index >= 0) {

				if ($carrinho->excluirItemCarrinho()) {
					unset($_SESSION['_carrinhoprodutos'][$index]);
					$retorno['status'] = true;
					$retorno['mensagem'] = 'Produto removido com sucesso';
					$retorno['carrinho'] = $carrinho->recuperaItens($baseurl);
				} else {
					$retorno['status'] = false;
					$retorno['mensagem'] = 'Desculpe, mas não foi possível excluir esse item do carrinho, por favor tente novamente';
				}

			} else {
				$retorno['status'] = false;
				$retorno['mensagem'] = 'Esse produto não está mais no carrinho';
			}

		} else {
			$retorno['status'] = false;
			$retorno['mensagem'] = 'Não foi possível recuperar as informações do produto, por favor tente novamente';
		}

	} else {
		var_dump($carrinho);
		$retorno['status'] = false;
		$retorno['mensagem'] = 'Não foi possível recuperar as informações do produto, por favor tente novamente';
	}

	echo json_encode($retorno);

}

function validatecard($number)
{
    global $type;

    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($cardtype['visa'],$number))
    {
        $type= "visa";
        return 'visa';

    }
    else if (preg_match($cardtype['mastercard'],$number))
    {
        $type= "mastercard";
        return 'mastercard';
    }
    else if (preg_match($cardtype['amex'],$number))
    {
        $type= "amex";
        return 'amex';

    }
    else if (preg_match($cardtype['discover'],$number))
    {
        $type= "discover";
        return 'discover';
    }
    else
    {
        return false;
    }
}
