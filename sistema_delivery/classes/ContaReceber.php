<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class ContaReceber implements Interfaceclasses
{

    private $id;
    private $data_criacao;
    private $num_parcela;
    private $data_vencimento;
    private $data_pago;
    private $valor;
    private $valor_pago;
    private $obs;
    private $flag_entrada;
    private $idEntrada;
    private $idEmpresa;

    /**
     * ContaReceber constructor.
     * @param $data_criacao
     * @param $num_parcela
     * @param $data_vencimento
     * @param $data_pago
     * @param $valor
     * @param $valor_pago
     * @param $obs
     * @param $flag_entrada
     * @param $idEntrada
     * @param $idEmpresa
     */
    public function __construct($num_parcela=0, $data_vencimento="", $data_pago="", $valor=0, $valor_pago=0, $obs="", $flag_entrada="", $idEntrada = null)
    {
        $this->data_criacao = date("Y-m-d");
        $this->num_parcela = $num_parcela;
        $this->data_vencimento = $data_vencimento;
        $this->data_pago = $data_pago;
        $this->valor = $valor;
        $this->valor_pago = $valor_pago;
        $this->obs = $obs;
        $this->flag_entrada = $flag_entrada;
        $this->idEntrada = $idEntrada;
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
     * @return int
     */
    public function getNumParcela()
    {
        return $this->num_parcela;
    }

    /**
     * @param int $num_parcela
     */
    public function setNumParcela($num_parcela)
    {
        $this->num_parcela = $num_parcela;
    }

    /**
     * @return string
     */
    public function getDataVencimento()
    {
        return $this->data_vencimento;
    }

    /**
     * @param string $data_vencimento
     */
    public function setDataVencimento($data_vencimento)
    {
        $this->data_vencimento = $data_vencimento;
    }

    /**
     * @return string
     */
    public function getDataPago()
    {
        return $this->data_pago;
    }

    /**
     * @param string $data_pago
     */
    public function setDataPago($data_pago)
    {
        $this->data_pago = $data_pago;
    }

    /**
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return int
     */
    public function getValorPago()
    {
        return $this->valor_pago;
    }

    /**
     * @param int $valor_pago
     */
    public function setValorPago($valor_pago)
    {
        $this->valor_pago = $valor_pago;
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
    public function getFlagEntrada()
    {
        return $this->flag_entrada;
    }

    /**
     * @param string $flag_entrada
     */
    public function setFlagEntrada($flag_entrada)
    {
        $this->flag_entrada = $flag_entrada;
    }

    /**
     * @return null
     */
    public function getIdEntrada()
    {
        return $this->idEntrada;
    }

    /**
     * @param null $idEntrada
     */
    public function setIdEntrada($idEntrada)
    {
        $this->idEntrada = $idEntrada;
    }

    /**
     * @return mixed
     */
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    /**
     * @param mixed $idEmpresa
     */
    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function inserir()
    {
        // TODO: Implement inserir() method.
    }

    public function alterar()
    {
		$crud = new Crud();

		$resp = $crud->AlteraCondicoes("contas_receber",
			array("con_dtVencimento", "con_dtPago", "con_valor", "con_valorPago"),
			array($this->data_vencimento, $this->data_pago, $this->valor,$this->valor_pago),
			"con_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

		return $resp;
    }

    public function excluir()
    {
        // TODO: Implement excluir() method.
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

	public function quantidadeRegistros($filtro, $chaves = "") {}

	public function quantidadeRegistros2($periodo1, $periodo2)
    {
		$crud = new Crud(FALSE);
		$total = 0;

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM contas_receber WHERE emp_id = ? AND con_dtVencimento BETWEEN ? AND ?", array($this->idEmpresa, $periodo1, $periodo2));

		} else {
			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM contas_receber WHERE emp_id = ? ", array($this->idEmpresa));
		}

		if(!empty($resp)){
			foreach ($resp as $rsr){
				$total = $rsr['total'];
			}
		}

		return  ceil(($total));
    }

	public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {}

	public function listarPaginacao2($periodo1, $periodo2, $inicio, $fim)
    {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->Consulta("contas_receber WHERE emp_id = ? AND con_dtVencimento BETWEEN ? AND ? order by con_id desc LIMIT ?, ?;", array($this->idEmpresa, $periodo1, $periodo2, $inicio, $fim));
		}
		else {
			$res = $crud->Consulta("contas_receber WHERE emp_id = ? order by con_id desc LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
		}

		return $res;
    }

	public function listarRelatorio($periodo1='', $periodo2='') {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->Consulta("contas_receber WHERE emp_id = ? AND con_dtVencimento BETWEEN ? AND ? order by con_id desc", array($this->idEmpresa, $periodo1, $periodo2));
		}
		else {
			$res = $crud->Consulta("contas_receber WHERE emp_id = ? order by con_id desc", array($this->idEmpresa));
		}

		return $res;
	}

    public function carregar()
    {
		$crud = new Crud();
		$resp = $crud->Consulta("contas_receber WHERE con_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

		if (!empty($resp)) {
			$this->data_criacao = $resp[0]["con_dtCad"];
			$this->num_parcela = $resp[0]["con_numParcela"];
			$this->data_vencimento = $resp[0]["con_dtVencimento"];
			$this->data_pago = $resp[0]["con_dtPago"];
			$this->valor = $resp[0]["con_valor"];
			$this->valor_pago = $resp[0]["con_valorPago"];
			$this->obs = $resp[0]["con_obs"];

			return true;
		}

		return false;
    }


}