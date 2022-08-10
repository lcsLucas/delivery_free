<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class Saida
{
    private $id;
    private $data_criacao;
    private $total_geral;
    private $total_itens;
    private $taxa_entrega;
    private $nome_promocao;
    private $cupom_promocao;
    private $tipo_desconto_promocao;
    private $valor_promocao;
    private $idEmpresa;
    private $cliente;
    private $carrinho;
    private $entrega;
    private $endereco;
    private $itens_saida;
    private $tipo_pagamento;
    private $troco;
    private $numero_cartao;
    private $nome_titular;
    private $validate_cartao;
    private $codigo_cartao;
    private $status;
    private $crud;

    /**
     * Saida constructor.
     * @param $total_geral
     * @param $total_itens
     * @param $taxa_entrega
     * @param $nome_promocao
     * @param $cupom_promocao
     * @param $tipo_desconto_promocao
     * @param $valor_promocao
     * @param $cliente
     * @param $carrinho
     * @param $entrega
     * @param $endereco
     * @param $itens_saida
     * @param $tipo_pagamento
     * @param $troco
     * @param $numero_cartao
     * @param $nome_titular
     * @param $validate_cartao
     * @param $codigo_cartao
     */
    public function __construct($total_geral=0, $total_itens=0, $taxa_entrega=0, $nome_promocao=null, $cupom_promocao=null, $tipo_desconto_promocao=null, $valor_promocao=null, $cliente=null, $carrinho=null, $entrega=null, $endereco=null, $itens_saida=null, $tipo_pagamento=null, $troco=null, $numero_cartao=null, $nome_titular=null, $validate_cartao=null, $codigo_cartao=null)
    {
        $this->data_criacao = date('Y-m-d H:i:s');
        $this->total_geral = $total_geral;
        $this->total_itens = $total_itens;
        $this->taxa_entrega = $taxa_entrega;
        $this->nome_promocao = $nome_promocao;
        $this->cupom_promocao = $cupom_promocao;
        $this->tipo_desconto_promocao = $tipo_desconto_promocao;
        $this->valor_promocao = $valor_promocao;
        $this->cliente = $cliente;
        $this->carrinho = $carrinho;
        $this->entrega = $entrega;
        $this->endereco = $endereco;
        $this->itens_saida = $itens_saida;
        $this->tipo_pagamento = $tipo_pagamento;
        $this->troco = $troco;
        $this->numero_cartao = $numero_cartao;
        $this->nome_titular = $nome_titular;
        $this->validate_cartao = $validate_cartao;
        $this->codigo_cartao = $codigo_cartao;
        $this->status = null;
        $this->crud = null;
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
     * @return mixed
     */
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * @param mixed $data_criacao
     */
    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;
    }

    /**
     * @return mixed
     */
    public function getTotalGeral()
    {
        return $this->total_geral;
    }

    /**
     * @param mixed $total_geral
     */
    public function setTotalGeral($total_geral)
    {
        $this->total_geral = $total_geral;
    }

    /**
     * @return mixed
     */
    public function getTotalItens()
    {
        return $this->total_itens;
    }

    /**
     * @param mixed $total_itens
     */
    public function setTotalItens($total_itens)
    {
        $this->total_itens = $total_itens;
    }

    /**
     * @return mixed
     */
    public function getTaxaEntrega()
    {
        return $this->taxa_entrega;
    }

    /**
     * @param mixed $taxa_entrega
     */
    public function setTaxaEntrega($taxa_entrega)
    {
        $this->taxa_entrega = $taxa_entrega;
    }

    /**
     * @return mixed
     */
    public function getNomePromocao()
    {
        return $this->nome_promocao;
    }

    /**
     * @param mixed $nome_promocao
     */
    public function setNomePromocao($nome_promocao)
    {
        $this->nome_promocao = $nome_promocao;
    }

    /**
     * @return mixed
     */
    public function getCupomPromocao()
    {
        return $this->cupom_promocao;
    }

    /**
     * @param mixed $cupom_promocao
     */
    public function setCupomPromocao($cupom_promocao)
    {
        $this->cupom_promocao = $cupom_promocao;
    }

    /**
     * @return mixed
     */
    public function getTipoDescontoPromocao()
    {
        return $this->tipo_desconto_promocao;
    }

    /**
     * @param mixed $tipo_desconto_promocao
     */
    public function setTipoDescontoPromocao($tipo_desconto_promocao)
    {
        $this->tipo_desconto_promocao = $tipo_desconto_promocao;
    }

    /**
     * @return mixed
     */
    public function getValorPromocao()
    {
        return $this->valor_promocao;
    }

    /**
     * @param mixed $valor_promocao
     */
    public function setValorPromocao($valor_promocao)
    {
        $this->valor_promocao = $valor_promocao;
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
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getCarrinho()
    {
        return $this->carrinho;
    }

    /**
     * @param mixed $carrinho
     */
    public function setCarrinho($carrinho)
    {
        $this->carrinho = $carrinho;
    }

    /**
     * @return mixed
     */
    public function getEntrega()
    {
        return $this->entrega;
    }

    /**
     * @param mixed $entrega
     */
    public function setEntrega($entrega)
    {
        $this->entrega = $entrega;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return mixed
     */
    public function getItensSaida()
    {
        return $this->itens_saida;
    }

    /**
     * @param mixed $itens_saida
     */
    public function setItensSaida($itens_saida)
    {
        $this->itens_saida = $itens_saida;
    }

    /**
     * @return mixed
     */
    public function getTipoPagamento()
    {
        return $this->tipo_pagamento;
    }

    /**
     * @param mixed $tipo_pagamento
     */
    public function setTipoPagamento($tipo_pagamento)
    {
        $this->tipo_pagamento = $tipo_pagamento;
    }

    /**
     * @return mixed
     */
    public function getTroco()
    {
        return $this->troco;
    }

    /**
     * @param mixed $troco
     */
    public function setTroco($troco)
    {
        $this->troco = $troco;
    }

    /**
     * @return mixed
     */
    public function getNumeroCartao()
    {
        return $this->numero_cartao;
    }

    /**
     * @param mixed $numero_cartao
     */
    public function setNumeroCartao($numero_cartao)
    {
        $this->numero_cartao = $numero_cartao;
    }

    /**
     * @return mixed
     */
    public function getNomeTitular()
    {
        return $this->nome_titular;
    }

    /**
     * @param mixed $nome_titular
     */
    public function setNomeTitular($nome_titular)
    {
        $this->nome_titular = $nome_titular;
    }

    /**
     * @return mixed
     */
    public function getValidateCartao()
    {
        return $this->validate_cartao;
    }

    /**
     * @param mixed $validate_cartao
     */
    public function setValidateCartao($validate_cartao)
    {
        $this->validate_cartao = $validate_cartao;
    }

    /**
     * @return mixed
     */
    public function getCodigoCartao()
    {
        return $this->codigo_cartao;
    }

    /**
     * @param mixed $codigo_cartao
     */
    public function setCodigoCartao($codigo_cartao)
    {
        $this->codigo_cartao = $codigo_cartao;
    }

	/**
	 * @return null
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @param null $status
	 */
	public function setStatus($status)
	{
		$this->status = $status;
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

    public function finalizarCarrinho() {
        $crud = new Crud(true);
        $retorno = false;
        $total_geral = $total_itens = 0.0;

        $sql =
            '
                SELECT 
                    idcarrinho, 
                    pro_nome, 
                    pro_cupom, 
                    pro_tipo_desconto as tipo_desconto, 
                    IF (pro_tipo_desconto = 1, pro_desc_porc, pro_desc_valor) as valor,
                    e.emp_frete
                FROM `carrinho` c 
                    LEFT JOIN `promocao` p 
                    ON c.promocao_id = p.pro_id
                    INNER JOIN empresa e ON e.emp_id = c.emp_id
                WHERE c.sessao = ? AND c.emp_id = ? 
                LIMIT 1
            ';

        $resp = $crud->ConsultaGenerica($sql, array($this->carrinho->getSessao(), $this->idEmpresa));

        if (!empty($resp)) {

            $this->carrinho = $resp[0]['idcarrinho'];
            $this->setNomePromocao($resp[0]['pro_nome']);
            $this->setCupomPromocao($resp[0]['pro_cupom']);
            $this->setTipoDescontoPromocao($resp[0]['tipo_desconto']);
            $this->setValorPromocao($resp[0]['valor']);

            if (!empty($resp[0]['emp_frete']))
            	$this->setTaxaEntrega($resp[0]['emp_frete']);
            else
            	$this->setTaxaEntrega(0);

			$parametros = array(
				'data_criacao',
				'taxa_entrega',
				'promocao_nome',
				'promocao_cupom',
				'promocao_tipo_desconto',
				'promocao_valor',
				'tipo_pagamento',
				'emp_id',
				'cli_id',
				'idcarrinho',
				'endereco_id'
			);

			$valores = array(
				$this->data_criacao,
				$this->taxa_entrega,
				$this->nome_promocao,
				$this->cupom_promocao,
				$this->tipo_desconto_promocao,
				$this->valor_promocao,
				$this->tipo_pagamento,
				$this->idEmpresa,
				$this->cliente,
				$this->carrinho,
				$this->endereco
			);

			if ($this->tipo_pagamento === 1) {
				$parametros[] = 'troco';
				$valores[] = $this->troco;
			} else {
				$parametros[] = 'cartao_ultimos_digitos';
				$valores[] = substr($this->numero_cartao, -4);
			}

            $result = $crud->Inserir('saida', $parametros, $valores);

            if ($result) {
            	$this->id = $crud->getUltimoCodigo();

				$sql =
					'
                    SELECT ctp.idcarrinho_produto, pt.pro_id, ctp.qtde, pt.pro_nome ,pt.pro_valor, pt.pro_controle_estoque, pt.pro_estoque_atual, obs, p.pro_nome as prom_nome, ptp.tipo_desconto as prom_tipo, IF (ptp.tipo_desconto = \'1\', ptp.desc_porcentagem, ptp.desc_valor) as prom_desconto, IF (ptp.tipo_desconto IS NOT NULL AND DATE_FORMAT(NOW(), "%Y-%m-%d") BETWEEN p.pro_dtInicio AND p.pro_dtFinal, IF(ptp.tipo_desconto = \'1\', pt.pro_valor - pt.pro_valor * desc_porcentagem / 100, pt.pro_valor - desc_valor), pt.pro_valor) as prom_valor
                        FROM produto pt LEFT JOIN promocao_tem_produtos ptp on pt.pro_id = ptp.produto_id LEFT JOIN promocao p on ptp.promocao_id = p.pro_id
                            INNER JOIN carrinho_tem_produto ctp ON pt.pro_id = ctp.pro_id
                                WHERE ctp.idcarrinho = ?
                	';

				$resp_produtos = $crud->ConsultaGenerica($sql, array($this->carrinho));

				if (!empty($resp_produtos)) {
					$i = 0;
					$total = count($resp_produtos);

					while ($i < $total && $result) {
						$result = $crud->Inserir('saida_produtos',
							array(
								'idsaida',
								'carrinho_pro_id',
								'qtde',
								'preco',
								'nome',
								'obs',
								'prom_nome',
								'prom_tipo',
								'prom_desconto',
								'prom_valor'
							),
							array(
								$this->id,
								$resp_produtos[$i]['pro_id'],
								$resp_produtos[$i]['qtde'],
								$resp_produtos[$i]['pro_valor'],
								$resp_produtos[$i]['pro_nome'],
								$resp_produtos[$i]['obs'],
								$resp_produtos[$i]['prom_nome'],
								$resp_produtos[$i]['prom_tipo'],
								$resp_produtos[$i]['prom_desconto'],
								$resp_produtos[$i]['prom_valor']
							)
						);

						$subTotal = 0.0;

						if ($result) {

							$id_item_saida = $crud->getUltimoCodigo();
							$subTotal = filter_var(!empty($resp_produtos[$i]['prom_valor']) ? $resp_produtos[$i]['prom_valor'] : $resp_produtos[$i]['pro_valor'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * filter_var($resp_produtos[$i]['qtde'], FILTER_VALIDATE_INT);

							$sql =
								'
								SELECT IF (ptc.nome IS NOT NULL, ptc.nome, ctc.nome) as nome, IF (ptc.preco IS NOT NULL, ptc.preco, ctc.preco) as preco
									FROM carrinho_tem_produto ctp
										INNER JOIN complementos_itens_carrinho cic ON ctp.idcarrinho_produto = cic.idcarrinho_produto
										LEFT JOIN produto_tem_complementos ptc ON ptc.pro_com_id = cic.pro_com_id
										LEFT JOIN categoria_tem_complementos ctc ON ctc.cat_com_id = cic.cat_com_id

										WHERE cic.idcarrinho = ? AND cic.pro_id = ? AND ctp.idcarrinho_produto = ?
								';

							$resp_comp = $crud->ConsultaGenerica($sql, array($this->carrinho, $resp_produtos[$i]['pro_id'], $resp_produtos[$i]['idcarrinho_produto']));
							$j = 0;
							$total2 = count($resp_comp);

							while ($j < $total2 && $result) {
								$result = $crud->Inserir('complementos_itens_saida', array('id_prod_saida', 'idsaida', 'nome', 'preco'), array($id_item_saida, $this->id, $resp_comp[$j]['nome'], $resp_comp[$j]['preco']));

								if ($result)
									$subTotal += (filter_var($resp_comp[$j]['preco'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * filter_var($resp_produtos[$i]['qtde'], FILTER_VALIDATE_INT));

								$j++;
							}

						}

						if ($result) {
							if (!empty($resp_produtos[$i]['pro_controle_estoque']))
								$result = $crud->Altera('produto', array('pro_estoque_atual'), array($resp_produtos[$i]['pro_estoque_atual'] - $resp_produtos[$i]['qtde']), 'pro_id', $resp_produtos[$i]['pro_id']);
						}

						$total_itens += $subTotal;

						$i++;
					} //while produtos

					$total_geral = filter_var($this->taxa_entrega, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + $total_itens;

					if (!empty($this->valor_promocao)) {

						if (intval($this->tipo_desconto_promocao) === 1) {
							$val_porc = filter_var($this->valor_promocao, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
							$valor_desconto = $total_geral *  $val_porc / 100;
						} else {
							$val_desc= $this->valor_promocao;
							$valor_desconto = filter_var($val_desc, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
						}

						$total_geral -= $valor_desconto;

					}

				}

			}

			if ($result) {
				$total_itens = str_replace('.', '', $total_itens);
				$total_itens = str_replace(',', '.', $total_itens);

				$total_geral = str_replace('.', '', $total_geral);
				$total_geral = str_replace(',', '.', $total_geral);

				$result = $crud->Altera('saida', array('total_geral', 'total_itens'), array($total_geral, $total_itens), 'idsaida', $this->id);
			}

			$retorno = !empty($result) ? true : false;

        }

        $crud->executar($retorno);
        return $retorno;
    }

    public function carregarPedidoCliente() {
    	$crud = new Crud();
    	$resp = $crud->ConsultaGenerica('SELECT s.*, e.emp_nome, et.ent_status FROM saida s INNER JOIN empresa e on s.emp_id = e.emp_id LEFT JOIN entrega et ON s.entrega_id = et.ent_id WHERE cli_id = ? ORDER BY status, s.idsaida DESC', array($this->cliente));

    	return $resp;
	}

	public function carregarPedidoId() {
		$crud = new Crud();
		$resp = $crud->ConsultaGenerica('SELECT s.*, e.end_rua, e.end_numero, e.end_numero, e.end_bairro, e.end_cep, c.cli_nome, c.cli_celular, c.cli_celular2, c.cli_telefone, entrega_id, ent_status FROM saida s LEFT JOIN entrega ent ON s.entrega_id = ent.ent_id INNER JOIN endereco e on s.endereco_id = e.end_id INNER JOIN cliente c on s.cli_id = c.cli_id WHERE s.idsaida = ? AND s.emp_id = ?', array($this->id, $this->idEmpresa));

		if (!empty($resp)) {

			$this->data_criacao = $resp[0]['data_criacao'];
			$this->total_geral = $resp[0]['total_geral'];
			$this->total_itens = $resp[0]['total_itens'];
			$this->taxa_entrega = $resp[0]['taxa_entrega'];
			$this->nome_promocao = utf8_encode($resp[0]['promocao_nome']);
			$this->cupom_promocao = utf8_encode($resp[0]['promocao_cupom']);
			$this->tipo_desconto_promocao = utf8_encode($resp[0]['promocao_tipo_desconto']);
			$this->valor_promocao = utf8_encode($resp[0]['promocao_valor']);
			$this->numero_cartao = $resp[0]['cartao_ultimos_digitos'];
			$this->troco = $resp[0]['troco'];
			$this->status = $resp[0]['status'];
			$this->tipo_pagamento = $resp[0]['tipo_pagamento'];

			$cliente = array();

			$cliente['nome'] = utf8_encode($resp[0]['cli_nome']);
			$cliente['celular1'] = $resp[0]['cli_celular'];
			$cliente['celular2'] = $resp[0]['cli_celular2'];

			$this->cliente = $cliente;

			$entrega = array();

			$entrega['id'] = $resp[0]['entrega_id'];
			$entrega['status'] = $resp[0]['ent_status'];
			$this->entrega = $entrega;

			$endereco = array();

			$endereco['rua'] = utf8_encode($resp[0]['end_rua']);
			$endereco['numero'] = $resp[0]['end_numero'];
			$endereco['bairro']  = utf8_encode($resp[0]['end_bairro']);
			$endereco['cep'] = $resp[0]['end_cep'];

			$this->endereco = $endereco;

			return true;
		}

		return false;
	}

	public function recuperaItens($idsaida) {
    	$crud = new Crud();
    	$resp = $crud->ConsultaGenerica('SELECT * FROM saida_produtos WHERE idsaida = ?', array($idsaida));
		return $resp;
	}

	public function recuperaComplementos($idproduto) {
		$crud = new Crud();
		$resp = $crud->ConsultaGenerica('SELECT nome, preco FROM complementos_itens_saida WHERE id_prod_saida = ?', array($idproduto));
		return $resp;
	}

	public function alterarStatus() {
		$crud = new Crud();
		$resp = $crud->AlteraCondicoes('saida', array('status'), array($this->status), 'idsaida = ' . $this->id . ' AND emp_id = ' . $this->idEmpresa);
		return $resp;
	}

	public function listarEmpresa() {
		$crud = new Crud();
		$resp = $crud->ConsultaGenerica('SELECT s.idsaida, s.data_criacao, s.total_geral, s.status, e.end_rua, e.end_numero, e.end_numero, e.end_bairro, e.end_cep, c.cli_nome, entrega_id, ent_status FROM saida s LEFT JOIN entrega ent ON s.entrega_id = ent.ent_id INNER JOIN endereco e on s.endereco_id = e.end_id INNER JOIN cliente c on s.cli_id = c.cli_id WHERE s.emp_id = ? ORDER BY s.idsaida DESC', array($this->idEmpresa));
		return $resp;
	}

	public function gerarContasReceber() {
		$retorno = false;
		$resp = $this->crud->ConsultaGenerica('SELECT idsaida, total_geral, tipo_pagamento, emp_id FROM saida WHERE entrega_id = ?', array($this->entrega));

		if (!empty($resp)) {

			// cadastrar as contas

			foreach ($resp as $i => $saida) {

				$parametros =
					array(
						'con_dtCad',
						'con_numParcela',
						'con_valor',
						'con_ativo',
						'idsaida',
						'emp_id'
					);

				$valores =
					array(
						date('Y-m-d'),
						1,
						$saida['total_geral'],
						'1',
						$saida['idsaida'],
						$saida['emp_id']
					);

				if (intval($saida['tipo_pagamento']) === 1) {

					$parametros[] = 'con_valorPago';
					$valores[] = $saida['total_geral'];

					$parametros[] = 'con_dtVencimento';
					$valores[] = date('Y-m-d');

					$parametros[] = 'con_dtPago';
					$valores[] = date('Y-m-d');


				} else {

					$parametros[] = 'con_dtVencimento';
					$valores[] = date('Y-m-d', strtotime(date('Y-m-d') . '+ 31days'));

				}

				$retorno = $this->crud->Inserir('contas_receber', $parametros, $valores);

				if (!$retorno)
					return false;

			}

		}

		return $retorno;
	}

	public function listarRelatorio($periodo1, $periodo2) {
		$crud = new Crud();
		$resp = $crud->ConsultaGenerica('SELECT s.idsaida, s.data_criacao, s.total_geral, s.status, e.end_rua, e.end_numero, e.end_numero, e.end_bairro, e.end_cep, c.cli_nome, entrega_id, ent_status FROM saida s LEFT JOIN entrega ent ON s.entrega_id = ent.ent_id INNER JOIN endereco e on s.endereco_id = e.end_id INNER JOIN cliente c on s.cli_id = c.cli_id WHERE s.emp_id = ? ORDER BY s.idsaida DESC', array($this->idEmpresa));
		return $resp;
	}

	public function verificaCepCliente() {
		$crud = new Crud();
		$encontrado = false;

		$resp = $crud->ConsultaGenerica('SELECT end_cep FROM endereco e INNER JOIN empresa e2 on e.end_id = e2.end_id WHERE e2.emp_id = ? LIMIT 1', array($this->idEmpresa));

		if (!empty($resp)) {

			$cep_empresa = $resp[0]['end_cep'];

			$resp = $crud->ConsultaGenerica('SELECT end_cep FROM endereco e INNER JOIN cliente_tem_endereco cte on e.end_id = cte.end_id WHERE cte.cli_id = ?', array($this->cliente));

			if (!empty($resp)) {

				$ceps_cliente = $resp;

				$i = 0;
				$total = count($ceps_cliente);

				while ($i < $total && !$encontrado) {

					$cep = $ceps_cliente[$i]['end_cep'];

					if (strcasecmp(substr($cep_empresa, 0, 2), substr($cep, 0, 2)) === 0)
						$encontrado = true;

					$i++;
				}

			}

		}

		return $encontrado;
	}

}