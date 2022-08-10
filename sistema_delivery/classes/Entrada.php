<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'FormPagto.php';
require_once 'ItemCompra.php';

class Entrada implements Interfaceclasses
{
    private $id;
    private $data;
    private $data_criacao;
    private $total;
    private $desconto;
    private $observacao;
    private $frete;
    private $outros;
    private $ativo;
    private $pagamento;
    private $idEmpresa;
    private $numero_nota;
    private $valor_contas;
    private $data_contas;
    private $conta_entrada;
    private $tipo;

    /**
     * Entrada constructor.
     * @param $data
     * @param $total
     * @param $desconto
     * @param $observacao
     * @param $frete
     * @param $outros
     * @param $ativo
     * @param $pagamento
     * @param $idEmpresa
     */
    public function __construct($data="", $total=0, $desconto=0, $observacao="", $frete=0, $outros=0, $ativo="", $pagamento= null, $fornecedor = null, $idEmpresa="", $numero_nota=0)
    {
        $this->data = $data;
        $this->data_criacao = date("Y-m-d");
        $this->total = $total;
        $this->desconto = $desconto;
        $this->observacao = $observacao;
        $this->frete = $frete;
        $this->outros = $outros;
        $this->ativo = $ativo;
        $this->pagamento = !empty($pagamento) ? $pagamento : new FormPagto();
        $this->idEmpresa = $idEmpresa;
        $this->numero_nota = $numero_nota;
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * @param string $data_criacao
     */
    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;
    }

    /**
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param string $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * @param string $desconto
     */
    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
    }

    /**
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param string $observacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }

    /**
     * @return string
     */
    public function getFrete()
    {
        return $this->frete;
    }

    /**
     * @param string $frete
     */
    public function setFrete($frete)
    {
        $this->frete = $frete;
    }

    /**
     * @return string
     */
    public function getOutros()
    {
        return $this->outros;
    }

    /**
     * @param string $outros
     */
    public function setOutros($outros)
    {
        $this->outros = $outros;
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
    public function getPagamento()
    {
        return $this->pagamento;
    }

    /**
     * @param string $pagamento
     */
    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
    }

    /**
     * @return string
     */
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    /**
     * @param string $idEmpresa
     */
    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    /**
     * @return string
     */
    public function getNumeroNota()
    {
        return $this->numero_nota;
    }

    /**
     * @param string $numero_nota
     */
    public function setNumeroNota($numero_nota)
    {
        $this->numero_nota = !empty($numero_nota) ? $numero_nota : 0;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getValorContas()
    {
        return $this->valor_contas;
    }

    /**
     * @param mixed $valor_contas
     */
    public function setValorContas($valor_contas)
    {
        $this->valor_contas = $valor_contas;
    }

    /**
     * @return mixed
     */
    public function getDataContas()
    {
        return $this->data_contas;
    }

    /**
     * @param mixed $data_contas
     */
    public function setDataContas($data_contas)
    {
        $this->data_contas = $data_contas;
    }

    /**
     * @return mixed
     */
    public function getContaEntrada()
    {
        return $this->conta_entrada;
    }

    /**
     * @param mixed $conta_entrada
     */
    public function setContaEntrada($conta_entrada)
    {
        $this->conta_entrada = $conta_entrada;
    }

    public function inserir(){}

    public function inserir_insumos()
    {
        $resp = false;
        $crud = new Crud(true);

        if (!empty($_SESSION["_insumosentrada"])) {

            $itens_entrada = $_SESSION["_insumosentrada"];

            $resp = $crud->Inserir("entrada",
                array(
                    "data_criacao",
                    "data",
                    "desconto",
                    "observacao",
                    "frete",
                    "outros_valores",
                    "ativo",
                    "codigo_nota",
                    "pag_id",
                    "emp_id",
                    "tipo"
                ),
                array(
                    $this->data_criacao,
                    $this->data,
                    $this->desconto,
                    utf8_decode($this->observacao),
                    $this->frete,
                    $this->outros,
                    1,
                    $this->numero_nota,
                    $this->pagamento->getId(),
                    $this->idEmpresa,
                    $this->tipo
                )
            );

            if ($resp) {

                $this->id = $crud->getUltimoCodigo();

                $item_compra = new ItemCompra();

                foreach ($itens_entrada as $id => $item) {
                    $item_compra->setId($id);
                    $item_compra->setPreco($item["precoinsumo"]);
                    $item_compra->setQtde($item["qtdeinsumo"]);

                    $resp = $crud->Inserir("entrada_insumos",
                        array("ins_id",
                            "ent_id",
                            "itens_qtde",
                            "itens_valor"
                        ),
                        array(
                            $item_compra->getId(),
                            $this->id,
                            $item_compra->getQtde(),
                            $item_compra->getPreco()
                        )
                    );

                    if (!$resp) {
                        break;
                    } else {

                        $resp = $crud->ConsultaGenerica("SELECT ins_controle_estoque, ins_estoque_atual total FROM insumo WHERE ins_id = ? AND emp_id = ? LIMIT 1", array($item_compra->getId(), $this->idEmpresa));

                        if (!empty($resp)) {

                            if (!empty($resp[0]["ins_controle_estoque"])) {

                                $qtde = floatval($resp[0]["total"]);
                                $resultado = $qtde + floatval($item_compra->getQtde());
                                $resp = $crud->AlteraCondicoes("insumo", array("ins_estoque_atual"), array($resultado), "ins_id = " . $item_compra->getId() . " AND emp_id = " . $this->idEmpresa);

                            }

                        }

                    }

                }

                if ($resp && !empty($this->valor_contas)) {

                    foreach ($this->valor_contas as $id_conta => $valor) {

                        $valor_conta = $valor;
                        $valor_conta = str_replace(".", "", $valor_conta);
                        $valor_conta = str_replace(",", ".", $valor_conta);

                        $data_conta = $this->data_contas[$id_conta];

                        if ($id_conta === 0 && !empty($this->conta_entrada)) {

                            $resp = $crud->Inserir("contas_pagar",
                                                                        array(
                                                                            "con_dtCad",
                                                                            "con_numParcela",
                                                                            "con_dtVencimento",
                                                                            "con_valor",
                                                                            "con_entrada",
                                                                            "ent_id",
                                                                            "emp_id"
                                                                        ),
                                                                        array(
                                                                            date("Y-m-d"),
                                                                            $this->id,
                                                                            trataData($data_conta),
                                                                            $valor_conta,
                                                                            "1",
                                                                            $this->id,
                                                                            $this->idEmpresa
                                                                        )
                            );

                        } else {

                            $resp = $crud->Inserir("contas_pagar",
                                array(
                                    "con_dtCad",
                                    "con_numParcela",
                                    "con_dtVencimento",
                                    "con_valor",
                                    "ent_id",
                                    "emp_id"
                                ),
                                array(
                                    date("Y-m-d"),
                                    $this->id,
                                    trataData($data_conta),
                                    $valor_conta,
                                    $this->id,
                                    $this->idEmpresa
                                )
                            );

                        }

                        if (!$resp)
                            break;

                    }

                }

            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function inserir_produtos()
    {
        $resp = false;
        $crud = new Crud(true);

        if (!empty($_SESSION["_produtosentrada"])) {

            $itens_entrada = $_SESSION["_produtosentrada"];

            $resp = $crud->Inserir("entrada",
                array(
                    "data_criacao",
                    "data",
                    "desconto",
                    "observacao",
                    "frete",
                    "outros_valores",
                    "ativo",
                    "codigo_nota",
                    "pag_id",
                    "emp_id",
                    "tipo"
                ),
                array(
                    $this->data_criacao,
                    $this->data,
                    $this->desconto,
                    utf8_decode($this->observacao),
                    $this->frete,
                    $this->outros,
                    1,
                    $this->numero_nota,
                    $this->pagamento->getId(),
                    $this->idEmpresa,
                    $this->tipo
                )
            );

            if ($resp) {
                $this->id = $crud->getUltimoCodigo();

                $item_compra = new ItemCompra();

                foreach ($itens_entrada as $id => $item) {
                    $item_compra->setId($id);
                    $item_compra->setPreco($item["precoproduto"]);
                    $item_compra->setQtde($item["qtdeproduto"]);

                    $resp = $crud->Inserir("entrada_produtos",
                        array("pro_id",
                            "ent_id",
                            "itens_qtde",
                            "itens_valor"
                        ),
                        array(
                            $item_compra->getId(),
                            $this->id,
                            $item_compra->getQtde(),
                            $item_compra->getPreco()
                        )
                    );

                    if (!$resp) {
                        break;
                    } else {
                        $resp = $crud->ConsultaGenerica("SELECT pro_controle_estoque, pro_estoque_atual total FROM produto WHERE pro_id = ? AND emp_id = ? LIMIT 1", array($item_compra->getId(), $this->idEmpresa));

                        if (!empty($resp)) {

                            if (!empty($resp[0]["pro_controle_estoque"])) {

                                $qtde = floatval($resp[0]["total"]);
                                $resultado = $qtde + floatval($item_compra->getQtde());
                                $resp = $crud->AlteraCondicoes("produto", array("pro_estoque_atual"), array($resultado), "pro_id = " . $item_compra->getId() . " AND emp_id = " . $this->idEmpresa);

                            }

                        }
                    }

                }

                if ($resp && !empty($this->valor_contas)) {

                    foreach ($this->valor_contas as $id_conta => $valor) {

                        $valor_conta = $valor;
                        $valor_conta = str_replace(".", "", $valor_conta);
                        $valor_conta = str_replace(",", ".", $valor_conta);

                        $data_conta = $this->data_contas[$id_conta];

                        if ($id_conta === 0 && !empty($this->conta_entrada)) {

                            $resp = $crud->Inserir("contas_pagar",
                                array(
                                    "con_dtCad",
                                    "con_numParcela",
                                    "con_dtVencimento",
                                    "con_valor",
                                    "con_entrada",
                                    "ent_id",
                                    "emp_id"
                                ),
                                array(
                                    date("Y-m-d"),
                                    $this->id,
                                    trataData($data_conta),
                                    $valor_conta,
                                    "1",
                                    $this->id,
                                    $this->idEmpresa
                                )
                            );

                        } else {

                            $resp = $crud->Inserir("contas_pagar",
                                array(
                                    "con_dtCad",
                                    "con_numParcela",
                                    "con_dtVencimento",
                                    "con_valor",
                                    "ent_id",
                                    "emp_id"
                                ),
                                array(
                                    date("Y-m-d"),
                                    $this->id,
                                    trataData($data_conta),
                                    $valor_conta,
                                    $this->id,
                                    $this->idEmpresa
                                )
                            );

                        }

                        if (!$resp)
                            break;

                    }

                }

            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();

        $resp = $crud->AlteraCondicoes("entrada",
            array(
                "data_criacao",
                "data",
                "desconto",
                "observacao",
                "frete",
                "outros_valores",
                "ativo",
                "codigo_nota",
                "pag_id",
                "emp_id"
            ),
            array(
                $this->data_criacao,
                $this->data,
                $this->desconto,
                utf8_decode($this->observacao),
                $this->frete,
                $this->outros,
                1,
                $this->numero_nota,
                $this->pagamento->getId(),
                $this->idEmpresa
            ),
            "ent_id = " . $this->id ." AND emp_id =". $this->idEmpresa
        );

        if ($resp && !empty($this->valor_contas)) {

            $resp = $crud->ExcluirCondicoes("contas_pagar", " ent_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

            if ($resp && !empty($this->valor_contas)) {

                foreach ($this->valor_contas as $id_conta => $valor) {

                    $valor_conta = $valor;
                    $valor_conta = str_replace(".", "", $valor_conta);
                    $valor_conta = str_replace(",", ".", $valor_conta);

                    $data_conta = $this->data_contas[$id_conta];

                    $flag_entrada = "0";
                    if (!empty($this->conta_entrada)) {
                        $flag_entrada = "1";
                    }

                    $resp = $crud->Inserir("contas_pagar",
                        array(
                            "con_dtCad",
                            "con_numParcela",
                            "con_dtVencimento",
                            "con_valor",
                            "con_entrada",
                            "ent_id",
                            "emp_id"
                        ),
                        array(
                            date("Y-m-d"),
                            $id_conta + 1,
                            trataData($data_conta),
                            $valor_conta,
                            $flag_entrada,
                            $this->id,
                            $this->idEmpresa
                        )
                    );

                    if (!$resp)
                        break;

                }

            }

        }


        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("entrada", "ent_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc", array($this->idEmpresa));

        return $resp;
    }

	public function quantidadeRegistros($filtro, $chaves = ""){}

	public function quantidadeRegistros3($periodo1, $periodo2)
    {
        $crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){
			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);
			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id WHERE e.emp_id = ? AND data BETWEEN ? AND ?", array($this->idEmpresa, $periodo1, $periodo2));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id WHERE e.emp_id = ?", array($this->idEmpresa));
        }

        if(!empty($resp)){
            foreach ($resp as $rsr){
                $total = $rsr['total'];
            }
        }

        return  ceil(($total));
    }

	public function listarPaginacao($filtro, $inicio, $fim, $chaves = ""){}

	public function listarPaginacao3($periodo1, $periodo2, $inicio, $fim)
    {
        $crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){
			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? AND data BETWEEN ? AND ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc LIMIT ?, ?;", array($this->idEmpresa, $periodo1, $periodo2, $inicio, $fim));
        }
        else {
            $res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function quantidadeRegistros2($periodo1, $periodo2)
    {
        $crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){
			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$resp = $crud->ConsultaGenerica("SELECT count(*) total FROM entrada e INNER JOIN entrada_produtos ep ON e.ent_id = ep.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id WHERE e.emp_id = ? AND data BETWEEN ? AND ?", array($this->idEmpresa, $periodo1, $periodo2));

        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM entrada e INNER JOIN entrada_produtos ep ON e.ent_id = ep.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id WHERE e.emp_id = ?", array($this->idEmpresa));
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

			$res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_produtos ep ON e.ent_id = ep.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? AND data BETWEEN ? AND ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc LIMIT ?, ?;", array($this->idEmpresa, $periodo1, $periodo2, $inicio, $fim));
        }
        else {
            $res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_produtos ep ON e.ent_id = ep.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("entrada WHERE ent_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->id = $resp[0]["ent_id"];
            $this->numero_nota = $resp[0]["codigo_nota"];
            $this->data = $resp[0]["data"];
            $this->pagamento->setId($resp[0]["pag_id"]);
            $this->observacao = $resp[0]["observacao"];
            $this->frete = $resp[0]["frete"];
            $this->desconto = $resp[0]["desconto"];
            $this->outros = $resp[0]["outros_valores"];

            return true;
        }

        return false;
    }

    public function recuperaInsumos() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT ins_nome nomeinsumo,itens_qtde qtdeinsumo, itens_valor precoinsumo, SUM(itens_qtde*itens_valor) totalinsumo FROM entrada_insumos ei INNER JOIN insumo i ON ei.ins_id = i.ins_id INNEr JOIN entrada e ON ei.ent_id = e.ent_id WHERE e.ent_id = ? AND e.emp_id = ? GROUP BY nomeinsumo,itens_qtde, itens_valor ORDER BY i.ins_nome", array($this->id, $this->idEmpresa));

        return $resp;
    }

    public function recuperaProdutos() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("SELECT pro_nome nomeproduto,itens_qtde qtdeproduto, itens_valor precoproduto, SUM(itens_qtde*itens_valor) totalproduto FROM entrada_produtos ep INNER JOIN produto p ON ep.pro_id = p.pro_id INNEr JOIN entrada e ON ep.ent_id = e.ent_id WHERE e.ent_id = ? AND e.emp_id = ? GROUP BY nomeproduto,itens_qtde, itens_valor ORDER BY p.pro_nome", array($this->id, $this->idEmpresa));

        return $resp;
    }

	public function listarRelatorio($periodo1='', $periodo2='') {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? AND data BETWEEN ? AND ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc", array($this->idEmpresa, $periodo1, $periodo2));
		}
		else {
			$res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_insumos ei ON e.ent_id = ei.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc", array($this->idEmpresa));
		}

		return $res;
	}

	public function listarRelatorio2($periodo1='', $periodo2='') {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2)){

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_produtos ep ON e.ent_id = ep.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? AND data BETWEEN ? AND ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc", array($this->idEmpresa, $periodo1, $periodo2));
		}
		else {
			$res = $crud->ConsultaGenerica("SELECT e.ent_id, e.data, e.desconto, e.frete, e.outros_valores, pag_nome, SUM(itens_valor*itens_qtde) + frete + outros_valores - desconto total FROM entrada e INNER JOIN entrada_produtos ep ON e.ent_id = ep.ent_id INNER JOIN forma_pagto p ON e.pag_id = p.pag_id  WHERE e.emp_id = ? group by e.ent_id, e.data, e.desconto, e.frete, e.outros_valores order by e.ent_id desc", array($this->idEmpresa));
		}

		return $res;
	}

}