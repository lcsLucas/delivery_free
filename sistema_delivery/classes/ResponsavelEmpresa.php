<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'Usuarios.php';
require_once 'Endereco.php';
require_once 'Empresa.php';

class ResponsavelEmpresa implements Interfaceclasses
{
    private $id;
    private $nome;
    private $empresa;
    private $obs;
    private $fone;
    private $email;
    private $usuario;
    private $endereco;
    private $crud;

    /**
     * ResponsavelEmpresa constructor.
     * @param $nome
     * @param $empresa
     * @param $obs
     * @param $fone
     * @param $email
     * @param $usuario
     * @param $endereco
     */
    public function __construct($nome="", $obs="", $fone="", $email="")
    {
        $this->nome = $nome;
        $this->empresa = new Empresa();
        $this->obs = $obs;
        $this->fone = $fone;
        $this->email = $email;
        $this->usuario = new Usuarios();
        $this->endereco = new Endereco();
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
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param string $empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
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
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param string $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function carregar()
    {
        $crud = new Crud();

        $resp = $crud->Consulta("responsavel_empresa WHERE resp_id = ? LIMIT 1", array($this->id));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["resp_nome"]);
            $this->obs = utf8_encode($resp[0]["resp_obs"]);
            $this->email = utf8_encode($resp[0]["resp_email"]);
            $this->fone = utf8_encode($resp[0]["resp_fone"]);
            $this->endereco->setId($resp[0]["end_id"]);
            $this->empresa->setId($resp[0]["emp_id"]);
            $this->usuario->setId($resp[0]["usu_adm"]);

            $this->endereco->carregar();
            $this->empresa->carregar();
            $this->usuario->carregar2();

            return true;
        }

        return false;
    }

    public function inserir()
    {
        $resp = false;
        /*utiliza a conexão aberta - para funcionar a transação*/
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);
        $this->empresa->setCrud($this->crud);
        $this->usuario->setCrud($this->crud);



        $resp = $this->endereco->inserir();
        if ($resp) {
            $resp = $this->empresa->inserir();
            if ($resp) {

                $resp = $this->usuario->inserir2();

                if ($resp) {

                    $resp = $this->crud->Inserir("responsavel_empresa", array("emp_id",
                        "resp_nome",
                        "resp_obs",
                        "resp_email",
                        "resp_fone",
                        "end_id",
                        "usu_adm"
                    ), array($this->empresa->getId(),
                            utf8_decode($this->nome),
                            utf8_decode($this->obs),
                            utf8_decode($this->email),
                            utf8_decode($this->fone),
                            $this->endereco->getId(),
                            $this->usuario->getId()
                        )
                    );

                    if ($resp) {

                        $resp = $this->crud->Inserir("usuarios_has_empresa",
                                                                                    array(
                                                                                        "idusuarios",
                                                                                        "emp_id"
                                                                                    ),
                                                                                    array(
                                                                                        $this->usuario->getId(),
                                                                                        $this->empresa->getId()
                                                                                    )
                        );
                    }

                }
            }
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        /*utiliza a conexão aberta - para funcionar a transação*/
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);
        $this->empresa->setCrud($this->crud);
        $this->usuario->setCrud($this->crud);

        $resp = $this->endereco->alterar();
        if ($resp) {

            $resp = $this->empresa->alterar();

            if ($resp) {

                $resp = $this->usuario->alterar2();

                if ($resp) {

                    $resp = $this->crud->Altera("responsavel_empresa", array("emp_id",
                        "resp_nome",
                        "resp_obs",
                        "resp_fone",
                        "end_id",
                        "usu_adm"
                    ), array($this->empresa->getId(),
                        utf8_decode($this->nome),
                        utf8_decode($this->obs),
                        utf8_decode($this->fone),
                        $this->endereco->getId(),
                        $this->usuario->getId()
                    ),
                        "resp_id", $this->id
                    );

                }
            }
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        $resp = false;

        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);
        $this->empresa->setCrud($this->crud);
        $this->usuario->setCrud($this->crud);

        $resp_codigos = $this->crud->ConsultaGenerica("SELECT emp_id, end_id, usu_adm FROM responsavel_empresa WHERE resp_id = ? LIMIT 1", array($this->id));

        if ($resp_codigos) {
            $this->usuario->setId($resp_codigos[0]["usu_adm"]);
            $this->empresa->setId($resp_codigos[0]["emp_id"]);
            $this->endereco->setId($resp_codigos[0]["end_id"]);

            $resp = $this->crud->Excluir("responsavel_empresa", "resp_id", $this->id);

            //se apagou usuario
            if ($resp)
                $resp = $this->endereco->excluir();

            //se apagou endereco
            if ($resp)
                $resp = $this->empresa->excluir();

            //se apagou endereco
            if ($resp)
                $resp = $this->usuario->excluir2();

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

        if(!empty($filtro)){
            $sql = "select count(*) total FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id where lower(emp_nome) like ? OR lower(resp_nome) like ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%"));
        } else {
            $resp = $crud->BuscaGenerica("SELECT count(*) total FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id");
        }

        if(!empty($resp)){
            foreach ($resp as $rsr){
                $total = $rsr['total'];
            }
        }

        return  ceil(($total));
    }

	public function quantidadeRegistros2($filtro, $periodo1, $periodo2) {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2) && !empty($filtro)) {

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$sql = "select count(distinct e.emp_id) total FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id where cr.con_dtVencimento BETWEEN ? AND ? AND lower(emp_nome) like ? OR lower(resp_nome) like ? ";
			$resp = $crud->ConsultaGenerica($sql, array($periodo1, $periodo2, "%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%"));

		} elseif(!empty($periodo1) && !empty($periodo2)) {
			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$sql = '
						SELECT COUNT(distinct e.emp_id) total						
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							INNER JOIN contas_receber cr on e.emp_id = cr.emp_id 
						WHERE cr.con_dtCad BETWEEN ? AND ?
					';
			$resp = $crud->ConsultaGenerica($sql, array($periodo1, $periodo2));
		} elseif(!empty($filtro)){
			$sql = "select count(*) total FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id where lower(emp_nome) like ? OR lower(resp_nome) like ? ";
			$resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%"));
		} else {
			$resp = $crud->BuscaGenerica("SELECT count(*) total FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id");
		}

        if(!empty($resp)){
			foreach ($resp as $rsr){
				$total = $rsr['total'];
			}
		}

        return  ceil(($total));
	}

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "SELECT r.resp_id, r.usu_adm, e.emp_id, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id where lower(e.emp_nome) like ? OR lower(resp_nome) like ? order by e.emp_id desc LIMIT ?, ?";

            $res = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $inicio, $fim));
        } else {
            $res = $crud->ConsultaGenerica("SELECT r.resp_id, r.usu_adm, e.emp_id, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id order by e.emp_id desc LIMIT ?, ?;", array($inicio, $fim));
        }

        return $res;
    }

	public function listarPaginacao2($filtro, $periodo1, $periodo2, $inicio, $fim) {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2) && !empty($filtro)) {

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$sql = '
						SELECT e.emp_id, r.resp_id, r.usu_adm, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo, COUNT(DISTINCT e.emp_id)					
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id 
						WHERE cr.con_dtCad BETWEEN ? AND ? AND (lower(emp_nome) like ? OR lower(resp_nome) like ?)
						GROUP BY e.emp_id, r.resp_id, r.usu_adm, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo
						LIMIT ?, ?
					';
			$resp = $crud->ConsultaGenerica($sql, array($periodo1, $periodo2, "%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%", $inicio, $fim));

		} elseif(!empty($periodo1) && !empty($periodo2)) {
			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$sql = '
						SELECT e.emp_id, r.resp_id, r.usu_adm, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo, COUNT(DISTINCT  e.emp_id)					
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id 
						WHERE cr.con_dtCad BETWEEN ? AND ?
						GROUP BY e.emp_id, r.resp_id, r.usu_adm, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo
						LIMIT ?, ?
					';
			$resp = $crud->ConsultaGenerica($sql, array($periodo1, $periodo2, $inicio, $fim));
		} elseif(!empty($filtro)){
			$sql = "SELECT r.resp_id, r.usu_adm, e.emp_id, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id where lower(emp_nome) like ? OR lower(resp_nome) like ? LIMIT $inicio, $fim";
			$resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%"));
		} else {
			$resp = $crud->BuscaGenerica("SELECT r.resp_id, r.usu_adm, e.emp_id, e.emp_nome, resp_nome, resp_email, resp_fone, emp_ativo FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id LIMIT $inicio, $fim");
		}

		return $resp;
	}

    public function recuperaIdEmpresa() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT emp_id FROM responsavel_empresa WHERE usu_adm = ? LIMIT 1", array($this->usuario->getId()));

        if (!empty($resp)) {
            return $resp[0]["emp_id"];
        }

        return false;
    }

}