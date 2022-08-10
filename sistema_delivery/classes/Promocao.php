<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class Promocao implements Interfaceclasses
{
    private $id;
    private $nome;
    private $tipo;
    private $data_inicial;
    private $data_final;
    private $cupom;
    private $ativo;
    private $tipo_desconto;
    private $desconto_valor;
    private $desconto_porcentagem;
    private $idEmpresa;
    private $produtos;

    /**
     * Promocao constructor.
     * @param $nome
     * @param $tipo
     * @param $data_inicial
     * @param $data_final
     * @param $cupom
     * @param $ativo
     * @param $tipo_desconto
     * @param $desconto_valor
     * @param $desconto_porcentagem
     */
    public function __construct($nome="", $tipo="", $data_inicial="", $data_final="", $cupom="", $ativo="", $tipo_desconto="", $desconto_valor=0.0, $desconto_porcentagem=0.0)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->data_inicial = $data_inicial;
        $this->data_final = $data_final;
        $this->cupom = $cupom;
        $this->ativo = $ativo;
        $this->tipo_desconto = $tipo_desconto;
        $this->desconto_valor = $desconto_valor;
        $this->desconto_porcentagem = $desconto_porcentagem;
        $this->produtos = array();
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

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getDataInicial()
    {
        return $this->data_inicial;
    }

    /**
     * @param string $data_inicial
     */
    public function setDataInicial($data_inicial)
    {
        $this->data_inicial = $data_inicial;
    }

    /**
     * @return string
     */
    public function getDataFinal()
    {
        return $this->data_final;
    }

    /**
     * @param string $data_final
     */
    public function setDataFinal($data_final)
    {
        $this->data_final = $data_final;
    }

    /**
     * @return string
     */
    public function getCupom()
    {
        return $this->cupom;
    }

    /**
     * @param string $cupom
     */
    public function setCupom($cupom)
    {
        $this->cupom = $cupom;
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
     * @return string
     */
    public function getTipoDesconto()
    {
        return $this->tipo_desconto;
    }

    /**
     * @param string $tipo_desconto
     */
    public function setTipoDesconto($tipo_desconto)
    {
        $this->tipo_desconto = $tipo_desconto;
    }

    /**
     * @return string
     */
    public function getDescontoValor()
    {
        return $this->desconto_valor;
    }

    /**
     * @param string $desconto_valor
     */
    public function setDescontoValor($desconto_valor)
    {
        $this->desconto_valor = $desconto_valor;
    }

    /**
     * @return string
     */
    public function getDescontoPorcentagem()
    {
        return $this->desconto_porcentagem;
    }

    /**
     * @param string $desconto_porcentagem
     */
    public function setDescontoPorcentagem($desconto_porcentagem)
    {
        $this->desconto_porcentagem = $desconto_porcentagem;
    }

    /**
     * @return array
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * @param array $produtos
     */
    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;
    }

    public function inserir()
    {
        $crud = new Crud();
        $resp = $crud->buscaAtributos("count(*) total", "promocao WHERE emp_id = ". $this->idEmpresa ." AND pro_cupom = '". utf8_decode($this->cupom) ."'");

        if (!empty($resp)) {
            if (!empty($resp[0]["total"])) {
                $resp = false;
            }else {
                $resp = $crud->Inserir("promocao",
                    array("pro_nome",
                        "pro_tipo",
                        "pro_dtInicio",
                        "pro_dtFinal",
                        "pro_cupom",
                        "pro_ativo",
                        "pro_desc_valor",
                        "pro_desc_porc",
                        "emp_id",
                        "pro_tipo_desconto"
                    ),
                    array(
                        utf8_decode($this->nome),
                        $this->tipo,
                        trataData($this->data_inicial),
                        trataData($this->data_final),
                        utf8_decode($this->cupom),
                        "1",
                        $this->desconto_valor,
                        $this->desconto_porcentagem,
                        $this->idEmpresa,
                        $this->tipo_desconto
                    )
                );
            }
        }

        return $resp;
    }

    public function inserir2() {
        $crud = new Crud(true);
        $resp = $crud->Inserir("promocao",
            array("pro_nome",
                "pro_tipo",
                "pro_dtInicio",
                "pro_dtFinal",
                "pro_ativo",
                "pro_desc_valor",
                "pro_desc_porc",
                "emp_id",
                "pro_tipo_desconto"
            ),
            array(
                utf8_decode($this->nome),
                $this->tipo,
                trataData($this->data_inicial),
                trataData($this->data_final),
                "1",
                $this->desconto_valor,
                $this->desconto_porcentagem,
                $this->idEmpresa,
                $this->tipo_desconto
            )
        );

        if (!empty($resp) && !empty($this->produtos)) {
            $this->id = $crud->getUltimoCodigo();

            $i = 0;
            $total = count($this->produtos['id']);

            if ($this->produtos['desc_tipo'][$i] === 1) {
                $val1 = $this->produtos['desc_valor'][$i];
                $val2 = null;
            } else {
                $val2 = $this->produtos['desc_valor'][$i];
                $val1 = null;
            }

            while ($i < $total && $resp) {
                $resp = $crud->Inserir('promocao_tem_produtos', array('promocao_id', 'produto_id', 'desc_porcentagem', 'desc_valor', 'tipo_desconto'), array($this->id, $this->produtos['id'][$i], $val1, $val2, $this->produtos['desc_tipo'][$i]));
                $i++;
            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();

        $resp = $crud->buscaAtributos("count(*) total", "promocao WHERE pro_id <> ". $this->id ." AND pro_cupom = '". utf8_decode($this->cupom) ."'");

        if (!empty($resp)) {
            if (!empty($resp[0]["total"])) {
                $this->retorno = "Já existe um modelo com esse nome";
                $resp = false;
            } else {
                $resp = $crud->AlteraCondicoes("promocao",
                    array("pro_nome",
                        "pro_tipo",
                        "pro_dtInicio",
                        "pro_dtFinal",
                        "pro_cupom",
                        "pro_desc_valor",
                        "pro_desc_porc",
                        "emp_id",
                        "pro_tipo_desconto"
                    ),
                    array(
                        utf8_decode($this->nome),
                        $this->tipo,
                        trataData($this->data_inicial),
                        trataData($this->data_final),
                        utf8_decode($this->cupom),
                        $this->desconto_valor,
                        $this->desconto_porcentagem,
                        $this->idEmpresa,
                        $this->tipo_desconto
                    ),
                    "pro_id =" . $this->id . " AND emp_id = " . $this->idEmpresa
                );
            }
        }

        return $resp;
    }

    public function alterar2() {
        $crud = new Crud(true);

        $resp = $crud->AlteraCondicoes("promocao",
            array("pro_nome",
                "pro_dtInicio",
                "pro_dtFinal",
                "pro_desc_valor",
                "pro_desc_porc",
                "pro_tipo_desconto"
            ),
            array(
                utf8_decode($this->nome),
                trataData($this->data_inicial),
                trataData($this->data_final),
                $this->desconto_valor,
                $this->desconto_porcentagem,
                $this->tipo_desconto
            ),
            "pro_id =" . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        if ($resp) {

            $resp = $crud->Excluir('promocao_tem_produtos', 'promocao_id', $this->id);

            if (!empty($resp) && !empty($this->produtos)) {

                $i = 0;
                $total = count($this->produtos['id']);

                if ($this->produtos['desc_tipo'][$i] === 1) {
                    $val1 = $this->produtos['desc_valor'][$i];
                    $val2 = null;
                } else {
                    $val2 = $this->produtos['desc_valor'][$i];
                    $val1 = null;
                }

                while ($i < $total && $resp) {
                    $resp = $crud->Inserir('promocao_tem_produtos', array('promocao_id', 'produto_id', 'desc_porcentagem', 'desc_valor', 'tipo_desconto'), array($this->id, $this->produtos['id'][$i], $val1, $val2, $this->produtos['desc_tipo'][$i]));
                    $i++;
                }

            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud(true);

        $resp = $crud->Excluir("promocao_tem_produtos", "promocao_id", $this->id);

        if ($resp)
            $resp = $crud->ExcluirCondicoes("promocao", "pro_id = ". $this->id ." AND emp_id = " . $this->idEmpresa);

        $crud->executar($resp);
        return $resp;
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

	public function quantidadeRegistros($filtro, $chaves = "") {}


	public function listarPaginacao($filtro, $inicio, $fim, $chaves = "") {}


	public function quantidadeRegistros2($periodo1, $periodo2)
    {
        $crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM promocao p WHERE pro_tipo = 1 AND p.emp_id = ? AND ? >= pro_dtInicio AND ? <= pro_dtFinal", array($this->idEmpresa, $periodo1, $periodo2));

        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM promocao p WHERE pro_tipo = 1 AND p.emp_id = ?", array($this->idEmpresa));
        }

        if(!empty($resp)){
            foreach ($resp as $rsr){
                $total = $rsr['total'];
            }
        }

        return  ceil(($total));
    }

	public function quantidadeRegistros3($periodo1, $periodo2)
	{
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM promocao p WHERE pro_tipo = 0 AND p.emp_id = ? AND ? >= pro_dtInicio AND ? <= pro_dtFinal", array($this->idEmpresa, $periodo1, $periodo2));

		} else {
			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM promocao p WHERE pro_tipo = 0 AND p.emp_id = ?", array($this->idEmpresa));
		}

		if(!empty($resp)){
			foreach ($resp as $rsr){
				$total = $rsr['total'];
			}
		}

		return  ceil(($total));
	}

	public function listarPaginacao2($periodo1, $periodo2, $inicio, $fim)
    {
        $crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->ConsultaGenerica("SELECT * FROM promocao p WHERE pro_tipo = 1 AND p.emp_id = ? AND ? >= pro_dtInicio AND ? <= pro_dtFinal order by p.pro_id desc LIMIT ?, ?", array($this->idEmpresa, $periodo1, $periodo2, $inicio, $fim));

        } else {
            $res = $crud->ConsultaGenerica("SELECT * FROM promocao p WHERE pro_tipo = 1 AND p.emp_id = ? order by p.pro_id desc LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

	public function listarPaginacao3($periodo1, $periodo2, $inicio, $fim)
	{
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->ConsultaGenerica("SELECT * FROM promocao p WHERE pro_tipo = 0 AND p.emp_id = ? AND ? >= pro_dtInicio AND ? <= pro_dtFinal order by p.pro_id desc LIMIT ?, ?", array($this->idEmpresa, $periodo1, $periodo2, $inicio, $fim));

		} else {
			$res = $crud->ConsultaGenerica("SELECT * FROM promocao p WHERE pro_tipo = 0 AND p.emp_id = ? order by p.pro_id desc LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
		}

		return $res;
	}

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("promocao WHERE pro_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["pro_nome"]);
            $this->cupom = utf8_encode($resp[0]["pro_cupom"]);
            $this->tipo = $resp[0]["pro_tipo"];
            $this->data_inicial = date("d/m/Y", strtotime($resp[0]["pro_dtInicio"]));
            $this->data_final = date("d/m/Y", strtotime($resp[0]["pro_dtFinal"]));
            $this->desconto_valor = number_format($resp[0]["pro_desc_valor"], 2, ",", ".");
            $this->desconto_porcentagem = number_format($resp[0]["pro_desc_porc"], 2, ",", ".");
            $this->tipo_desconto = $resp[0]["pro_tipo_desconto"];

            if (intval($this->tipo) === 1) {
                $resp_prod = $crud->ConsultaGenerica('SELECT produto_id, desc_porcentagem, desc_valor, tipo_desconto FROM promocao_tem_produtos WHERE promocao_id = ?', array($this->id));

                if (!empty($resp_prod)) {
                    $array_prod = array();

                    foreach ($resp_prod as $prod) {

                        $array_prod['id'][] = $prod['produto_id'];
                        $array_prod['desc_valor'][] = (intval($prod['tipo_desconto']) === 1) ? floatval($prod['desc_porcentagem']) : floatval($prod['desc_valor']);
                        $array_prod['desc_tipo'][] = intval($prod['tipo_desconto']);

                    }

                    $this->produtos = $array_prod;
                }

            }

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select pro_ativo from promocao where pro_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['pro_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('promocao', array('pro_ativo'), array(utf8_decode($this->ativo)), 'pro_id', $this->id);

        return $resp;
    }

    public function listarRelatorio($periodo1, $periodo2) {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->Consulta("promocao p WHERE pro_tipo = 1 AND p.emp_id = ? AND ? >= pro_dtInicio AND ? <= pro_dtFinal order by p.pro_id desc", array($this->idEmpresa, $periodo1, $periodo2));
		}
		else {
			$res = $crud->Consulta("promocao p WHERE pro_tipo = 1 AND p.emp_id = ? order by p.pro_id desc", array($this->idEmpresa));
		}

		return $res;
	}

	public function listarRelatorio2($periodo1, $periodo2) {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->Consulta("promocao p WHERE pro_tipo = 0 AND p.emp_id = ? AND ? >= pro_dtInicio AND ? <= pro_dtFinal order by p.pro_id desc", array($this->idEmpresa, $periodo1, $periodo2));
		}
		else {
			$res = $crud->Consulta("promocao p WHERE pro_tipo = 0 AND p.emp_id = ? order by p.pro_id desc", array($this->idEmpresa));
		}

		return $res;
	}

}