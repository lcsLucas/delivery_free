<?php

include_once "config.php";
include_once 'sistema_delivery/classes/admin/banco.php';
include_once 'sistema_delivery/classes/admin/funcoes.php';
include_once 'sistema_delivery/classes/Interfaceclasses.php';
include_once 'sistema_delivery/classes/Cliente.php';
include_once 'sistema_delivery/classes/Endereco.php';

$cliente = new Cliente();
$endereco = new Endereco();

$retorno = array(
    "status" => false,
    "mensagem" => "",
    "titulo" => ""
);

if(htmlspecialchars(SQLinjection($_SERVER["REQUEST_METHOD"])) === 'POST') {//requisição do tipo POST

    if (filter_has_var(INPUT_POST, "btnCadastro")) {
        $nome = trim(SQLinjection(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS)));
        $usuario = trim(SQLinjection(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS)));
        $email = trim(SQLinjection(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)));
        $celular = trim(SQLinjection(filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_SPECIAL_CHARS)));
        $celular2 = trim(SQLinjection(filter_input(INPUT_POST, 'celular2', FILTER_SANITIZE_SPECIAL_CHARS)));
        $data_nascimento = trim(SQLinjection(filter_input(INPUT_POST, 'nascimento', FILTER_SANITIZE_SPECIAL_CHARS)));
        $ckTermos = filter_has_var(INPUT_POST, "ckTermos") ? 1 : 0;
        $senha = trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS));
        $senha2 = trim(filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_SPECIAL_CHARS));

        if (empty($nome) || empty($email) || empty($usuario) || empty($celular) || empty($senha) || empty($ckTermos)) {
            $retorno["titulo"] = "Campos Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem campos não preenchidos ou preenchidos incorretamente!";
        } else if(strcmp($senha, $senha2) !== 0) {
            $retorno["titulo"] = "As senhas não batem";
            $retorno["status"] = false;
            $retorno["mensagem"] = "As senhas informadas estão diferentes, por favor corrija";
        } else {

            $cliente->setNome($nome);
            $cliente->setUsuario($usuario);
            $cliente->setEmail($email);
            $cliente->setFone($celular);
            $cliente->setFone2($celular2);

            if ($data_nascimento) 
            	$cliente->setNascimento(trataData($data_nascimento));
            
            $cliente->setSenha($senha);
            $cliente->setAtivo(1);
            $cliente->setFlagDelivery(1);

            if ($cliente->verificausuarioSite()) {
                if (!empty($cliente->inserirSite())) {
                    $_SESSION["_logado"] = true;
                    $_SESSION["_idcliente"] = $cliente->getId();
                    $retorno["titulo"] = "Cadastro Realizado";
                    $retorno["status"] = true;
                    $retorno["mensagem"] = "Seu cadastro foi realizado com sucesso!";

                    if (!empty($_SESSION['ultima_pagina'])) {
                        $retorno['pagina_redirecionada'] = $_SESSION['ultima_pagina'];

                        if (!empty($_SESSION['continuar']))
                            unset($_SESSION['continuar']);

                    }else
                        $retorno['pagina_redirecionada'] = $baseurl . 'minha-conta';

                } else {
                    $retorno["titulo"] = "Erro ao fazer o cadastro";
                    $retorno["status"] = false;
                    $retorno["mensagem"] = "Não foi possível realizar o cadastro. Atualize a página e tente novamente";
                }
            } else {
                $retorno = $cliente->getRetorno();
            }

        }

        echo json_encode($retorno, JSON_FORCE_OBJECT);

    } else if(filter_has_var(INPUT_POST, "btnLogin")) {
        $usuario = trim(SQLinjection(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS)));
        $senha = trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS));

        if (empty($usuario) || empty($senha)) {
            $retorno["titulo"] = "Campos Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem campos não preenchidos ou preenchidos incorretamente!";
        } else {

            $cliente->setUsuario($usuario);
            $cliente->setSenha($senha);

            if ($cliente->fazerLoginSite()) {
                $_SESSION["_logado"] = true;
                $_SESSION["_idcliente"] = $cliente->getId();
                $retorno["titulo"] = "Login Realizado";
                $retorno["status"] = true;
                $retorno["mensagem"] = "Seu login foi realizado com sucesso!";

                if (!empty($_SESSION['ultima_pagina'])) {
                    $retorno['pagina_redirecionada'] = $_SESSION['ultima_pagina'];

                    if (!empty($_SESSION['continuar']))
                        unset($_SESSION['continuar']);

                } elseif(!empty($_SESSION['pagina_restaurante'])) {
					$retorno['pagina_redirecionada'] = $_SESSION['pagina_restaurante'];

					if (!empty($_SESSION['continuar']))
						unset($_SESSION['continuar']);
				} else
                    $retorno['pagina_redirecionada'] = $baseurl . 'minha-conta';

            } else {
                $retorno = $cliente->getRetorno();
            }

        }
        echo json_encode($retorno, JSON_FORCE_OBJECT);
    } else if(filter_has_var(INPUT_POST, "btnAlterar")) {
        $nome = trim(SQLinjection(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS)));
        $celular = trim(SQLinjection(filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_SPECIAL_CHARS)));
        $celular2 = trim(SQLinjection(filter_input(INPUT_POST, 'celular2', FILTER_SANITIZE_SPECIAL_CHARS)));
        $data_nascimento = trim(SQLinjection(filter_input(INPUT_POST, 'nascimento', FILTER_SANITIZE_SPECIAL_CHARS)));

        if (empty($nome) || empty($celular)) {
            $retorno["titulo"] = "Campos Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem campos não preenchidos ou preenchidos incorretamente!";
        } else {
            $cliente->setId($_SESSION["_idcliente"]);
            $cliente->setNome($nome);
            $cliente->setFone($celular);

            if (!empty($celular2))
            	$cliente->setFone2($celular2);

            if (!empty($data_nascimento))
            	$cliente->setNascimento(trataData($data_nascimento));

            if ($cliente->alterarDadosSite()) {
                $retorno["titulo"] = "Sucesso";
                $retorno["status"] = true;
                $retorno["mensagem"] = "Seus dados foram alterados com sucesso!";
            } else {
                $retorno["titulo"] = "Erro";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível realizar a alteração. Atualize a página e tente novamente";
            }
        }

        echo json_encode($retorno, JSON_FORCE_OBJECT);
    } else if(filter_has_var(INPUT_POST, "btnAlteraSenha")) {
        $senha = trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS));
        $senha2 = trim(filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_SPECIAL_CHARS));
        $senha_nova = trim(filter_input(INPUT_POST, 'senha_nova', FILTER_SANITIZE_SPECIAL_CHARS));

        if (empty($senha) || empty($senha2) || empty($senha_nova)) {
            $retorno["titulo"] = "Campos Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem campos não preenchidos ou preenchidos incorretamente!";
        } else if(strcmp($senha_nova, $senha2) !== 0) {
            $retorno["titulo"] = "As senhas não batem";
            $retorno["status"] = false;
            $retorno["mensagem"] = "As senhas informadas estão diferentes, por favor corrija";
        } else {
            $cliente->setId($_SESSION["_idcliente"]);
            $cliente->setSenha($senha_nova);

            if (!empty($cliente->alteraSenhaSite($senha))) {
                $retorno["titulo"] = "Sucesso";
                $retorno["status"] = true;
                $retorno["mensagem"] = "Senha alterada com sucesso!";
            } else if(!empty($cliente->getRetorno())){
                $retorno = $cliente->getRetorno();
            } else{
                $retorno["titulo"] = "Erro";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível alterar a senha, atualize a página e tente novamente!";
            }

        }
        echo json_encode($retorno, JSON_FORCE_OBJECT);
    } else if(filter_has_var(INPUT_POST, "btnAddEndereco")) {
        $descricao = trim(SQLinjection(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS)));
        $rua = trim(SQLinjection(filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_SPECIAL_CHARS)));
        $bairro = trim(SQLinjection(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS)));
        $cep = trim(SQLinjection(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_SPECIAL_CHARS)));
        $numero = trim(SQLinjection(filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT)));
        $id_cidade = trim(SQLinjection(filter_input(INPUT_POST, 'selCidade', FILTER_VALIDATE_INT)));

        if (empty($descricao) || empty($rua) || empty($bairro) || empty($cep) || empty($numero)) {
            $retorno["titulo"] = "Campos Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem campos não preenchidos ou preenchidos incorretamente!";
        } else {
            $endereco->setRua($rua);
            $endereco->setBairro($bairro);
            $endereco->setCep($cep);
            $endereco->setNumero($numero);
            $endereco->setDescricao($descricao);
            $endereco->getCidade()->setId($id_cidade);
            $cliente->setId($_SESSION["_idcliente"]);
            $cliente->setEndereco($endereco);

            if (!empty($cliente->adicionaEnderecoSite())) {
                $array_extra = array();
                $todos_enderecos = $cliente->listarEnderecosSite();

                if (!empty($todos_enderecos)) {
                    foreach ($todos_enderecos as $item) {
                        $array_extra[] = array(
                            "id" => $item["end_id"],
                            "rua" => utf8_encode($item["end_rua"]),
                            "numero" => $item["end_numero"],
                            "descricao" => utf8_encode($item["end_descricao"]),
                            "cidade" => utf8_encode($item["cid_nome"]),
                            "favorito" => $item["end_favorito"]
                        );
                    }
                }


                $retorno["titulo"] = "Sucesso";
                $retorno["status"] = true;
                $retorno['url_finalizar'] = $baseurl . 'finalizar-pedido';
                $retorno["mensagem"] = "Endereço adicionado com sucesso!";
                $retorno["extra"] = $array_extra;
            } else if(!empty($cliente->getRetorno())){
                $retorno = $cliente->getRetorno();
            } else {
                $retorno["titulo"] = "Erro";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível adicionar o endereço, atualize a página e tente novamente!";
            }


        }
        echo json_encode($retorno, JSON_FORCE_OBJECT);
    } else if(filter_has_var(INPUT_POST, "excluir_endereco")) {
        $id_endereco = trim(SQLinjection(filter_input(INPUT_POST, 'endereco_id', FILTER_VALIDATE_INT)));

        if (empty($id_endereco)) {
            $retorno["titulo"] = "Parametros Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem parametros não preenchidos ou preenchidos incorretamente, atualize a página e tente novamente!";
        } else {
            $cliente->setId($_SESSION["_idcliente"]);
            $cliente->getEndereco()->setId($id_endereco);

            if ($cliente->DesativaEnderecoSite()) {
                $array_extra = array();
                $todos_enderecos = $cliente->listarEnderecosSite();

                if (!empty($todos_enderecos)) {
                    foreach ($todos_enderecos as $item) {
                        $array_extra[] = array(
                            "id" => $item["end_id"],
                            "rua" => utf8_encode($item["end_rua"]),
                            "numero" => $item["end_numero"],
                            "descricao" => utf8_encode($item["end_descricao"]),
                            "cidade" => utf8_encode($item["cid_nome"]),
                            "favorito" => $item["end_favorito"]
                        );
                    }
                }

                $retorno["titulo"] = "Sucesso";
                $retorno["status"] = true;
                $retorno["mensagem"] = "Endereço Excluído com sucesso!";
                $retorno["extra"] = $array_extra;
            } else {
                $retorno["titulo"] = "Erro";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível excluir o endereço, atualize a página e tente novamente!";
            }

        }
        echo json_encode($retorno, JSON_FORCE_OBJECT);
    } else if(filter_has_var(INPUT_POST, "favorita-endereco")) {
        $id_endereco = trim(SQLinjection(filter_input(INPUT_POST, 'endereco_id', FILTER_VALIDATE_INT)));

        if (empty($id_endereco)) {
            $retorno["titulo"] = "Parametros Incorretos";
            $retorno["status"] = false;
            $retorno["mensagem"] = "Existem parametros não preenchidos ou preenchidos incorretamente, atualize a página e tente novamente!";
        } else {
            $cliente->setId($_SESSION["_idcliente"]);
            $cliente->getEndereco()->setId($id_endereco);

            if ($cliente->favoritarEndereco()) {
                $retorno["status"] = true;
            } else {
                $retorno["titulo"] = "Erro";
                $retorno["status"] = false;
                $retorno["mensagem"] = "Não foi possível favoritar o endereço, atualize a página e tente novamente!";
            }

        }

        echo json_encode($retorno, JSON_FORCE_OBJECT);
    }

} else if(htmlspecialchars(SQLinjection($_SERVER["REQUEST_METHOD"])) === 'GET') {//requisição do tipo POST
    if(filter_has_var(INPUT_GET, "sair")) {
        session_destroy();
        header("Location: ./login");
        exit;
    }
}