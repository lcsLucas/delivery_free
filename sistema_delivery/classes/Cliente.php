<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'Endereco.php';

class Cliente implements Interfaceclasses
{
    private $id;
    private $data_criacao;
    private $nome;
    private $email;
    private $telefone;
    private $fone;
    private $fone2;
    private $obs;
    private $ativo;
    private $endereco;
    private $idEmpresa;
    private $usuario;
    private $senha;
    private $nascimento;
    private $flag_delivery;
    private $crud;
    private $retorno;

    /**
     * Cliente constructor.
     * @param $nome
     * @param $email
     * @param $telefone
     * @param $fone
     * @param $fone2
     * @param $obs
     * @param $ativo
     * @param $endereco
     * @param $idEmpresa
     * @param $usuario
     * @param $senha
     * @param $nascimento
     * @param $crud
     */
    public function __construct($nome = "", $email = "", $telefone = "", $fone = "", $fone2 = "", $obs = "", $ativo = "", $endereco = null, $idEmpresa = 0, $usuario = "", $senha = "", $nascimento = null, $crud = null, $flag_delivery = "")
    {
        $this->data_criacao = date("Y-m-d");
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->fone = $fone;
        $this->fone2 = $fone2;
        $this->obs = $obs;
        $this->ativo = $ativo;
        $this->endereco = !empty($endereco) ? $endereco : new Endereco();
        $this->idEmpresa = $idEmpresa;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->nascimento = $nascimento;
        $this->crud = $crud;
        $this->flag_delivery = $flag_delivery;
        $this->retorno = array();
        $this->retorno["titulo"] = "";
        $this->retorno["mensagem"] = "";
        $this->retorno["status"] = false;
        $this->retorno["extra"] = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return false|string
     */
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * @param false|string $data_criacao
     */
    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return string
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * @param string $fone
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
    }

    /**
     * @return string
     */
    public function getFone2()
    {
        return $this->fone2;
    }

    /**
     * @param string $fone2
     */
    public function setFone2($fone2)
    {
        $this->fone2 = $fone2;
    }

    /**
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param string $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    /**
     * @return string
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param string $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return null
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param null $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return int
     */
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    /**
     * @param int $idEmpresa
     */
    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return string
     */
    public function getNascimento()
    {
        return $this->nascimento;
    }

    /**
     * @param string $nascimento
     */
    public function setNascimento($nascimento)
    {
        $this->nascimento = $nascimento;
    }

    /**
     * @return null
     */
    public function getCrud()
    {
        return $this->crud;
    }

    /**
     * @param null $crud
     */
    public function setCrud($crud)
    {
        $this->crud = $crud;
    }

    /**
     * @return string
     */
    public function getFlagDelivery()
    {
        return $this->flag_delivery;
    }

    /**
     * @param string $flag_delivery
     */
    public function setFlagDelivery($flag_delivery)
    {
        $this->flag_delivery = $flag_delivery;
    }

    /**
     * @return array
     */
    public function getRetorno()
    {
        return $this->retorno;
    }

    public function inserir()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);

        if ($this->endereco->inserir()) {

            $resp = $this->crud->Inserir(
                "cliente",
                array(
                    "cli_nome",
                    "cli_dtCad",
                    "cli_email",
                    "cli_telefone",
                    "cli_celular",
                    "cli_celular2",
                    "cli_obs",
                    "cli_ativo",
                    "emp_id",
                    "end_id"
                ),
                array(
                    utf8_decode($this->nome),
                    $this->data_criacao,
                    utf8_decode($this->email),
                    utf8_decode($this->telefone),
                    utf8_decode($this->fone),
                    utf8_decode($this->fone2),
                    utf8_decode($this->obs),
                    $this->ativo,
                    $this->idEmpresa,
                    $this->endereco->getId()
                )
            );
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function verificausuarioSite()
    {
        $this->crud = new Crud(true);

        $resp = $this->crud->ConsultaGenerica("SELECT count(*) total FROM cliente WHERE cli_email = ? AND flag_delivery IS NOT NULL LIMIT 1", array($this->email));

        if (!empty($resp) && empty($resp[0]["total"])) {

            $resp = $this->crud->ConsultaGenerica("SELECT count(*) total FROM cliente WHERE cli_usuario = ? AND flag_delivery IS NOT NULL LIMIT 1", array($this->usuario));

            if (!empty($resp) && empty($resp[0]["total"]))
                return true;
            else {
                $this->retorno["titulo"] = "Login já cadastrado";
                $this->retorno["status"] = false;
                $this->retorno["mensagem"] = "O login informado já existe, caso você já possua um cadastrado faça o login na sua conta";
            }
        } else {
            $this->retorno["titulo"] = "Email já cadastrado";
            $this->retorno["status"] = false;
            $this->retorno["mensagem"] = "O email informado já existe, caso você já possua um cadastrado faça o login na sua conta";
        }

        if (empty($this->retorno["titulo"])) {
            $this->retorno["titulo"] = "Erro na requisição";
            $this->retorno["status"] = false;
            $this->retorno["mensagem"] = "Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente";
        }

        return false;
    }

    public function recupeDadosSite()
    {
        $this->crud = new Crud();
        $resp = $this->crud->ConsultaGenerica("SELECT cli_nome, cli_email, cli_usuario, cli_nascimento, cli_celular, cli_celular2 FROM cliente WHERE cli_id = ? LIMIT 1", array($this->id));
        if (!empty($resp)) {
            $this->nome = $resp[0]["cli_nome"];
            $this->email = $resp[0]["cli_email"];
            $this->usuario = $resp[0]["cli_usuario"];
            $this->fone = $resp[0]["cli_celular"];
            $this->fone2 = $resp[0]["cli_celular2"];

            if (!empty($resp[0]["cli_nascimento"]))
                $this->nascimento = Date("d/m/Y", strtotime($resp[0]["cli_nascimento"]));

            return true;
        }

        return false;
    }

    public function fazerLoginSite()
    {
        $this->crud = new Crud();
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $resp = $this->crud->ConsultaGenerica("SELECT cli_id, cli_senha FROM cliente WHERE cli_email = ? AND flag_delivery IS NOT NULL LIMIT 1", array($this->email));

            if (!empty($resp[0]["cli_senha"])) {

                if (password_verify($this->senha, $resp[0]["cli_senha"])) {
                    $this->id = $resp[0]["cli_id"];
                    return true;
                } else {
                    $this->retorno["titulo"] = "Dados inválidos";
                    $this->retorno["status"] = false;
                    $this->retorno["mensagem"] = "Por favor verique seu login e senha e tente novamente";
                }
            } else {
                $this->retorno["titulo"] = "Dados inválidos";
                $this->retorno["status"] = false;
                $this->retorno["mensagem"] = "Por favor verique seu login e senha e tente novamente";
            }
        } else if (!empty($this->usuario)) {
            $resp = $this->crud->ConsultaGenerica("SELECT cli_id, cli_senha FROM cliente WHERE cli_usuario = ? AND flag_delivery IS NOT NULL LIMIT 1", array($this->usuario));

            if (password_verify($this->senha, $resp[0]["cli_senha"])) {
                $this->id = $resp[0]["cli_id"];
                return true;
            } else {
                $this->retorno["titulo"] = "Dados inválidos";
                $this->retorno["status"] = false;
                $this->retorno["mensagem"] = "Por favor verique seu login e senha e tente novamente";
            }
        } else {
            $this->retorno["titulo"] = "Erro na requisição";
            $this->retorno["status"] = false;
            $this->retorno["mensagem"] = "Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente";
        }
        return false;
    }

    public function adicionaEnderecoSite()
    {
        $this->crud = new Crud(true);
        $resp = $this->crud->ConsultaGenerica("SELECT COUNT(*) total FROM cliente c INNER JOIN cliente_tem_endereco ce ON c.cli_id = ce.cli_id INNER JOIN endereco e ON ce.end_id = e.end_id WHERE c.cli_id = ? AND e.end_cep = ? AND e.end_numero = ? AND e.end_ativo = '1' LIMIT 1", array($this->id, $this->endereco->getCep(), $this->endereco->getNumero()));

        if (!empty($resp) && !empty($resp[0]["total"])) {
            $this->retorno["titulo"] = "Endereço já cadastrado";
            $this->retorno["status"] = false;
            $this->retorno["mensagem"] = "O endereço informado já está cadastro!";
        } else if (!empty($resp) && empty($resp[0]["total"])) {

            $resp = $this->crud->ConsultaGenerica("SELECT COUNT(*) total FROM cliente_tem_endereco ce INNER JOIN endereco e ON ce.end_id = e.end_id WHERE ce.cli_id = ? AND e.end_ativo = '1' LIMIT 5", array($this->id));

            if (!empty($resp) && intval($resp[0]["total"]) < 5) {

                if ($this->endereco->inserir()) {

                    if (intval($resp[0]["total"]) === 0)
                        $this->crud->Altera("endereco", array("end_favorito"), array("1"), "end_id", $this->endereco->getId());

                    $resp = $this->crud->Inserir(
                        "cliente_tem_endereco",
                        array("cli_id", "end_id"),
                        array($this->id, $this->endereco->getId())
                    );

                    $this->crud->executar($resp);
                    return $resp;
                }
            } else if (!empty($resp) && intval($resp[0]["total"]) >= 5) {
                $this->retorno["titulo"] = "Limite de endereços atingidos";
                $this->retorno["status"] = false;
                $this->retorno["mensagem"] = "Você atingiu o limite de (5) endereços cadastrados!";
            }
        }

        $this->crud->executar($resp);
        return false;
    }

    public function listarEnderecosSite()
    {
        $this->crud = new Crud(true);
        $resp = $this->crud->ConsultaGenerica("SELECT e.end_id, e.end_rua, e.end_numero, e.end_descricao, e.end_favorito, c.cid_nome FROM endereco e INNER JOIN cidade c ON e.cid_id = c.cid_id INNER JOIN cliente_tem_endereco ce ON ce.end_id = e.end_id WHERE ce.cli_id = ? AND e.end_ativo = '1' ORDER BY end_favorito DESC", array($this->id));

        return $resp;
    }

    public function favoritarEndereco()
    {
        $this->crud = new Crud(true);
        $resp = $this->crud->ConsultaGenerica("SELECT COUNT(*) total FROM endereco e INNER JOIN cliente_tem_endereco ce ON e.end_id = ce.end_id WHERE e.end_id = ? AND ce.cli_id = ? LIMIT 1", array($this->endereco->getId(), $this->id));

        if (!empty($resp[0]["total"])) {
            $resp = $this->crud->Altera("endereco e INNER JOIN cliente_tem_endereco ce ON e.end_id = ce.end_id", array("e.end_favorito"), array(null), "ce.cli_id", $this->id);
            if ($resp)
                $resp = $this->crud->Altera("endereco", array("end_favorito"), array("1"), "end_id", $this->endereco->getId());

            $this->crud->executar($resp);
            return $resp;
        }
    }

    public function inserirSite()
    {
        $this->crud = new Crud();

        $resp = $this->crud->Inserir(
            "cliente",
            array(
                "cli_dtCad",
                "cli_nome",
                "cli_email",
                "cli_celular",
                "cli_celular2",
                "cli_ativo",
                "cli_usuario",
                "cli_senha",
                "cli_nascimento",
                "flag_delivery"
            ),
            array(
                $this->data_criacao,
                utf8_decode($this->nome),
                utf8_decode($this->email),
                utf8_decode($this->fone),
                utf8_decode($this->fone2),
                $this->ativo,
                utf8_decode($this->usuario),
                utf8_decode(password_hash($this->senha, PASSWORD_DEFAULT)),
                $this->nascimento,
                "1"
            )
        );

        if (!empty($resp))
            $this->id = $this->crud->getUltimoCodigo();

        return $resp;
    }

    public function alterarDadosSite()
    {
        $this->crud = new Crud();

        $resp = $this->crud->Altera(
            "cliente",
            array(
                "cli_nome",
                "cli_celular",
                "cli_celular2",
                "cli_nascimento"
            ),
            array(
                utf8_decode($this->nome),
                utf8_decode($this->fone),
                utf8_decode($this->fone2),
                $this->nascimento
            ),
            "cli_id",
            $this->id
        );

        return $resp;
    }

    public function alteraSenhaSite($senha_atual)
    {
        $this->crud = new Crud();

        $resp = $this->crud->ConsultaGenerica("SELECT cli_senha FROM cliente WHERE cli_id = ? AND flag_delivery IS NOT NULL LIMIT 1", array($this->id));

        if (!empty($resp[0]["cli_senha"])) {

            if (password_verify($senha_atual, $resp[0]["cli_senha"])) {
                $resp = $this->crud->Altera(
                    "cliente",
                    array("cli_senha"),
                    array(utf8_decode(password_hash($this->senha, PASSWORD_DEFAULT))),
                    "cli_id",
                    $this->id
                );

                return $resp;
            } else {
                $this->retorno["titulo"] = "Erro";
                $this->retorno["status"] = false;
                $this->retorno["mensagem"] = "A senha informada está diferente da atual";
            }
        }

        if (empty($this->retorno)) {
            $this->retorno["titulo"] = "Erro na requisição";
            $this->retorno["status"] = false;
            $this->retorno["mensagem"] = "Ocorreu um erro ao realizar a requisição com o servidor. Por favor atualize a página e tente novamente";
        }


        return false;
    }

    public function DesativaEnderecoSite()
    {
        $this->crud = new Crud();
        $resp = $this->crud->ConsultaGenerica("SELECT COUNT(*) total FROM endereco e INNER JOIN cliente_tem_endereco ce ON e.end_id = ce.end_id WHERE e.end_id = ? AND ce.cli_id = ? LIMIT 1", array($this->endereco->getId(), $this->id));

        if (!empty($resp[0]["total"])) {
            $resp = $this->crud->Altera("endereco", array("end_ativo"), array("0"), "end_id", $this->endereco->getId());
            return $resp;
        }
        return false;
    }

    public function alterar()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);

        if ($this->endereco->alterar()) {
            $resp = $this->crud->AlteraCondicoes(
                "cliente",
                array(
                    "cli_nome",
                    "cli_email",
                    "cli_telefone",
                    "cli_celular",
                    "cli_celular2",
                    "cli_obs",
                    "emp_id"
                ),
                array(
                    utf8_decode($this->nome),
                    utf8_decode($this->email),
                    utf8_decode($this->telefone),
                    utf8_decode($this->fone),
                    utf8_decode($this->fone2),
                    utf8_decode($this->obs),
                    $this->idEmpresa
                ),
                "cli_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
            );
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $cod_end = $this->crud->ConsultaGenerica("SELECT end_id FROM cliente WHERE cli_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($cod_end)) {
            $resp = $this->crud->ExcluirCondicoes("cliente", "cli_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

            /*obns: excluir endereços*/
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if (!empty($filtro)) {
            $sql = "select count(*) total from cliente where (lower(cli_nome) like ? OR lower(cli_email) like ?) AND emp_id = ?";

            $resp = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM cliente WHERE emp_id = ?", array($this->idEmpresa));
        }

        if (!empty($resp)) {
            foreach ($resp as $rsr) {
                $total = $rsr['total'];
            }
        }

        return  ceil(($total));
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if (!empty($filtro)) {
            $sql = "cliente where (lower(cli_nome) like ? OR lower(cli_email) like ?) AND emp_id = ? order by cli_nome desc LIMIT ?, ?";
            $res = $crud->Consulta($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa, $inicio, $fim));
        } else {
            $res = $crud->Consulta("cliente WHERE emp_id = ? order by cli_nome desc LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("cliente WHERE cli_id = ? AND emp_id = ?", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = $resp[0]["cli_nome"];
            $this->email = $resp[0]["cli_email"];
            $this->telefone = $resp[0]["cli_telefone"];
            $this->fone = $resp[0]["cli_celular"];
            $this->fone2 = $resp[0]["cli_celular2"];
            $this->obs = $resp[0]["cli_obs"];
            $this->idEmpresa = $resp[0]["emp_id"];
            $this->endereco->setId($resp[0]['end_id']);

            $this->endereco->carregar();


            return true;
        }

        return false;
    }

    public function carregarSite()
    {
        $crud = new Crud;

        if (!empty($this->id)) {

            $resp = $crud->ConsultaGenerica('SELECT cli_nome FROM cliente WHERE cli_id = ? AND flag_delivery IS NOT NULL LIMIT 1', array($this->id));

            if (!empty($resp)) {
                $this->nome = $resp[0]['cli_nome'];
                return true;
            }
        }

        return false;
    }

    public function modificaAtivo()
    {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select cli_ativo from cliente where cli_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['cli_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if (!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('cliente', array('cli_ativo'), array(utf8_decode($this->ativo)), 'cli_id', $this->id);

        return $resp;
    }
}
