<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
include_once 'Empresa.php';

class CarrinhoPedidos
{
    private $id;
    private $id_carrinho_item;
    private $data_criacao;
    private $sessao;
    private $produtos;
    private $idEmpresa;
    private $crud;
    private $promocao;

    /**
     * CarrinhoPedidos constructor.
     * @param $produtos
     */
    public function __construct($produtos = array())
    {
        $this->produtos = $produtos;
        $this->data_criacao = date('Y-m-d H:i:s');
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
     * @return mixed
     */
    public function getSessao()
    {
        return $this->sessao;
    }

    /**
     * @param mixed $sessao
     */
    public function setSessao($sessao)
    {
        $this->sessao = $sessao;
    }

    /**
     * @return array
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * @param array|ItensCarrinho $produtos
     */
    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;
    }

    /**
     * @return mixed
     */
    public function getCrud()
    {
        return $this->crud;
    }

    /**
     * @param mixed $crud
     */
    public function setCrud($crud)
    {
        $this->crud = $crud;
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
    public function getIdCarrinhoItem()
    {
        return $this->id_carrinho_item;
    }

    /**
     * @param mixed $id_carrinho_item
     */
    public function setIdCarrinhoItem($id_carrinho_item)
    {
        $this->id_carrinho_item = $id_carrinho_item;
    }

    /**
     * @return mixed
     */
    public function getPromocao()
    {
        return $this->promocao;
    }

    /**
     * @param mixed $promocao
     */
    public function setPromocao($promocao)
    {
        $this->promocao = $promocao;
    }

    public function iniciacarrinho() {
        $crud = new Crud();
        $resp = $crud->Inserir("carrinho", array("sessao", "data_criacao", "emp_id"), array(utf8_decode($this->sessao), $this->data_criacao, $this->idEmpresa));

        if (!empty($resp)) {
            $this->id = $crud->getUltimoCodigo();
        }

        return $resp;
    }

    public function carregar() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT idcarrinho FROM carrinho WHERE sessao = ? AND emp_id = ? LIMIT 1', array($this->sessao, $this->idEmpresa));

        if (!empty($resp)) {
            $this->id = $resp[0]['idcarrinho'];
            return true;
        }

        return false;
    }

    public function adicionarProduto() {
        $crud = new Crud(true);
        $resp = $crud->Inserir('carrinho_tem_produto', array('idcarrinho', 'pro_id', 'qtde', 'obs'), array($this->id, $this->produtos->getId(), $this->produtos->getQtde(), utf8_decode($this->produtos->getObs())));

        if (!empty($resp)) {

            $this->id_carrinho_item = $crud->getUltimoCodigo();


            if (!empty($this->produtos->getComplementos())) {

                $complementos = $this->produtos->getComplementos();
                $total_complementos = count($complementos);
                $i = 0;

                while ($i < $total_complementos && $resp) {

                    if (!empty($complementos[$i]['opcoes'])) {

                        $opcoes_complemento = $complementos[$i]['opcoes'];
                        $total_opcoes = count($opcoes_complemento);
                        $j = 0;

                        $campo = ($complementos[$i]['tipo_complemento'] === 1) ? 'cat_com_id' : 'pro_com_id';

                        while ($j < $total_opcoes && $resp) {

                            $resp = $crud->Inserir('complementos_itens_carrinho',
                                array(
                                    'idcarrinho_produto',
                                    'idcarrinho',
                                    'pro_id',
                                    'catcom_id',
                                    $campo,
                                    'tipo',
                                    'qtde'
                                ),
                                array(
                                    $this->id_carrinho_item,
                                    $this->id,
                                    $this->getProdutos()->getId(),
                                    $complementos[$i]['id'],
                                    $opcoes_complemento[$j],
                                    '1',
                                    '1'
                                )
                            );

                            $j++;
                        }

                    }

                    $i++;
                }

            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function atualizarProduto() {
        $crud = new Crud(true);
        $resp = $crud->AlteraCondicoes('carrinho_tem_produto', array('qtde', 'obs'), array($this->produtos->getQtde(), utf8_decode($this->produtos->getObs())), 'idcarrinho = ' . $this->id . ' AND pro_id = ' . $this->produtos->getId() . ' AND idcarrinho_produto = ' . $this->id_carrinho_item);

        if (!empty($resp))
            $resp = $crud->ExcluirCondicoes('complementos_itens_carrinho', 'idcarrinho = ' . $this->id . ' AND pro_id = ' . $this->produtos->getId() . ' AND idcarrinho_produto = ' . $this->id_carrinho_item);

        if (!empty($resp) && !empty($this->produtos->getComplementos())) {

            $complementos = $this->produtos->getComplementos();
            $total_complementos = count($complementos);
            $i = 0;

            while ($i < $total_complementos && $resp) {

                if (!empty($complementos[$i]['opcoes'])) {

                    $opcoes_complemento = $complementos[$i]['opcoes'];
                    $total_opcoes = count($opcoes_complemento);
                    $j = 0;

                    $campo = ($complementos[$i]['tipo_complemento'] === 1) ? 'cat_com_id' : 'pro_com_id';

                    while ($j < $total_opcoes && $resp) {

                        $resp = $crud->Inserir('complementos_itens_carrinho',
                            array(
                                'idcarrinho_produto',
                                'idcarrinho',
                                'pro_id',
                                'catcom_id',
                                $campo,
                                'tipo',
                                'qtde'
                            ),
                            array(
                                $this->id_carrinho_item,
                                $this->id,
                                $this->getProdutos()->getId(),
                                $complementos[$i]['id'],
                                $opcoes_complemento[$j],
                                '1',
                                '1'
                            )
                        );

                        $j++;
                    }

                }

                $i++;
            }

        }

        $crud->executar($resp);
        return $resp;
    }

    /*
     *  Alterar essa função recuperar o id do carrinho e depois chamar a função recuperar itens e arrumar la na tela de listar produtos
     *
     */
    public function carregarCarrinho($baseurl, $calc_desc = false) {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT idcarrinho FROM carrinho WHERE sessao = ? AND emp_id = ?', array($this->sessao, $this->idEmpresa));

        if (!empty($resp)) {
            $this->id = $resp[0]['idcarrinho'];
            $retono_itens =  $this->recuperaItens($baseurl);

            if ($calc_desc) {

                $retono_desconto = $this->recuperarDescontoCupom($retono_itens['total_geral']);

                if (!empty($retono_desconto)) {
                    $retono_itens['total_geral'] = $retono_desconto['valor_total'];
                    $retono_itens['valor_desconto'] = $retono_desconto['valor_desconto'];
                    $retono_itens['cupom'] = $retono_desconto['cupom'];
                }

            }

            return $retono_itens;
        }

        return false;
    }

    public function recuperaItens($baseurl) {
        $crud = new Crud();
        $retorno = array();
        $total_itens = 0.0;

        $sql =
            '
                SELECT ctp.idcarrinho_produto, ctp.qtde, pt.pro_nome, pt.pro_id, IF (ptp.tipo_desconto IS NOT NULL AND DATE_FORMAT(NOW(), "%Y-%m-%d") BETWEEN p.pro_dtInicio AND p.pro_dtFinal, IF(ptp.tipo_desconto = \'1\', pt.pro_valor - pt.pro_valor * desc_porcentagem / 100, pt.pro_valor - desc_valor), pt.pro_valor) as pro_valor, pt.pro_foto, obs
                    FROM produto pt LEFT JOIN promocao_tem_produtos ptp on pt.pro_id = ptp.produto_id LEFT JOIN promocao p on ptp.promocao_id = p.pro_id
                        INNER JOIN carrinho_tem_produto ctp ON pt.pro_id = ctp.pro_id
                            WHERE ctp.idcarrinho = ?
            ';

        $resp = $crud->ConsultaGenerica($sql, array($this->id));

        if (!empty($resp)) {

            foreach ($resp as $iprod => $resp_produto) {
                $produto = array();

                $produto['iditem'] =  $resp_produto['idcarrinho_produto'];
                $produto['idproduto'] =  $resp_produto['pro_id'];
                $produto['nome'] = utf8_encode($resp_produto['pro_nome']);
                $produto['obs'] = utf8_encode($resp_produto['obs']);
                $produto['foto'] = $baseurl . 'img/restaurantes/produtos/thumbs/' . utf8_encode($resp_produto['pro_foto']);
                $produto['preco'] = number_format($resp_produto['pro_valor'], 2, ',',  '.');
                $produto['qtde'] = $resp_produto['qtde'];
                $produto['subTotal'] = filter_var($resp_produto['pro_valor'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * filter_var($resp_produto['qtde'], FILTER_VALIDATE_INT);

                $sql =
                    '
                        SELECT IF (ptc.nome IS NOT NULL, ptc.nome, ctc.nome) as nome, IF (ptc.preco IS NOT NULL, ptc.preco, ctc.preco) as preco
                            FROM carrinho_tem_produto ctp
                                INNER JOIN complementos_itens_carrinho cic ON ctp.idcarrinho_produto = cic.idcarrinho_produto
                                LEFT JOIN produto_tem_complementos ptc ON ptc.pro_com_id = cic.pro_com_id
                                LEFT JOIN categoria_tem_complementos ctc ON ctc.cat_com_id = cic.cat_com_id
                                
                                WHERE cic.idcarrinho = ? AND cic.pro_id = ? AND ctp.idcarrinho_produto = ?
                    ';

                $resp = $crud->ConsultaGenerica($sql, array($this->id, $resp_produto['pro_id'], $resp_produto['idcarrinho_produto']));

                if (!empty($resp)) {

                    $array_complementos = array();

                    foreach ($resp as $icomp => $resp_comp) {
                        $array_complementos['nome'] = (strlen($resp[$icomp]['nome']) <= 20) ? utf8_encode($resp[$icomp]['nome']) : substr(utf8_encode($resp[$icomp]['nome']), 0, 17) . '...';
                        $array_complementos['preco'] = number_format($resp[$icomp]['preco'], 2, ',',  '.');
                        $produto['subTotal'] += (filter_var($resp[$icomp]['preco'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * filter_var($resp_produto['qtde'], FILTER_VALIDATE_INT));
                        $produto['complementos'][] = $array_complementos;
                    }

                }

                $total_itens += $produto['subTotal'];
                $produto['subTotal'] = number_format($produto['subTotal'], 2, ',', '.');

                $retorno['produtos'][] = $produto;
            }

            $empresa = new Empresa();
            $empresa->setId($_SESSION['_idrestaurante']);
            $taxa_entrega = $empresa->recuperarFrete();

            $retorno['total_itens'] = number_format($total_itens, 2, ',', '.');
            $retorno['taxa_entrega'] = number_format($taxa_entrega, 2, ',', '.');
            $retorno['total_geral'] = number_format($total_itens + $taxa_entrega, 2, ',', '.');
        }

        return $retorno;
    }

    function recuperar_complementos_item() {
        $crud = new Crud();
        $retorno = array();
        $resp = $crud->ConsultaGenerica('SELECT catcom_id, pro_com_id, cat_com_id, IF (cat_com_id IS NOT NULL, 1, 2) as tipo FROM complementos_itens_carrinho cic WHERE idcarrinho = (SELECT idcarrinho FROM carrinho WHERE sessao = ? LIMIT 1) AND pro_id = ? AND idcarrinho_produto = ?', array($this->sessao, $this->produtos, $this->id_carrinho_item));

        if (!empty($resp)) {

            foreach ($resp as $complemento) {
                $opcao = ($complemento['tipo'] === 1) ? $complemento['cat_com_id'] : $complemento['pro_com_id'];

                if (empty($retorno[$complemento['catcom_id']])) {
                    $retorno[$complemento['catcom_id']]['tipo'] = $complemento['tipo'];
                    $retorno[$complemento['catcom_id']]['opcoes'] = array($opcao);
                } else {
                    $retorno[$complemento['catcom_id']]['opcoes'][] = $opcao;
                }

            }

        }

        return $retorno;
    }

    public function aplicarCupom(){
        $crud = new Crud();

        $resp = $crud->ConsultaGenerica('SELECT pro_id FROM promocao WHERE emp_id = ? AND pro_ativo = \'1\' AND pro_tipo = \'0\' AND lower(pro_cupom) = ? AND CURDATE() >= pro_dtInicio AND CURDATE() <= pro_dtFinal LIMIT 1', array($this->idEmpresa, $this->promocao));

        if (!empty($resp)) {

            $id_promocao = $resp[0]['pro_id'];
            $resp = $crud->ConsultaGenerica('SELECT idcarrinho FROM carrinho WHERE sessao = ? AND emp_id = ?', array($this->sessao, $this->idEmpresa));

            if (!empty($resp)) {
                $this->id = $resp[0]['idcarrinho'];
                $resp = $crud->Altera('carrinho', array('promocao_id'), array($id_promocao), 'idcarrinho', $this->id);
                if ($resp)
                    $_SESSION['_cupomaplicado'] = $id_promocao;
            }

        }

        return !empty($resp) ? true : false;
    }

    public function removerCupom() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT idcarrinho FROM carrinho WHERE sessao = ? LIMIT 1', array($this->sessao));

        if (!empty($resp)) {
            $this->id = $resp[0]['idcarrinho'];
            $resp = $crud->AlteraCondicoes('carrinho', array('promocao_id'), array(null), 'idcarrinho = ' . $this->id . ' AND emp_id = ' . $this->idEmpresa);
        }

        return $resp;
    }

    public function recuperarValores() {
        $crud = new Crud();
        $retorno = array();

        $sql =
            '
            SELECT sum(tot) as total FROM
                (
                SELECT SUM(ctp.qtde * IF (ptp.tipo_desconto IS NOT NULL AND DATE_FORMAT(NOW(), "%Y-%m-%d") BETWEEN p.pro_dtInicio AND p.pro_dtFinal, IF(ptp.tipo_desconto = \'1\', pt.pro_valor - pt.pro_valor * desc_porcentagem / 100, pt.pro_valor - desc_valor), pt.pro_valor)) as tot
                    FROM produto pt LEFT JOIN promocao_tem_produtos ptp on pt.pro_id = ptp.produto_id 
                    LEFT JOIN promocao p on ptp.promocao_id = p.pro_id
                        INNER JOIN carrinho_tem_produto ctp ON pt.pro_id = ctp.pro_id
                    WHERE ctp.idcarrinho = ?
        
                UNION ALL
        
                SELECT SUM(IF (ptc.preco IS NOT NULL, ptc.preco, ctc.preco) * ctp.qtde) as tot
                    FROM carrinho_tem_produto ctp
                        LEFT JOIN complementos_itens_carrinho cic ON ctp.idcarrinho_produto = cic.idcarrinho_produto
                        LEFT JOIN produto_tem_complementos ptc ON ptc.pro_com_id = cic.pro_com_id
                        LEFT JOIN categoria_tem_complementos ctc ON ctc.cat_com_id = cic.cat_com_id
                WHERE cic.idcarrinho = ?
            ) as consulta
        
        ';

        $resp = $crud->ConsultaGenerica($sql, array($this->id, $this->id));

        if (!empty($resp)) {
            $retorno['valor_total'] = filter_var($resp[0]['total'], FILTER_VALIDATE_FLOAT);

            $resp = $crud->ConsultaGenerica('SELECT emp_frete FROM empresa WHERE emp_id = ? LIMIT 1', array($this->idEmpresa));

            if (!empty($resp)) {

                $resp_frete = $resp[0]['emp_frete'];
                $retorno['valor_total'] += filter_var($resp_frete, FILTER_VALIDATE_FLOAT);

            }

        }

        if (!empty($retorno['valor_total']) && $retorno['valor_total'] > 0)
            $retorno['valor_total'] = number_format($retorno['valor_total'], 2,',','.');
        else
            $retorno['valor_total'] = 0;

        return $retorno;
    }

    public function recuperarDescontoCupom($total_geral) {
        $crud = new Crud();
        $retorno = array();

        $total_geral = str_replace('.', '', $total_geral);
        $total_geral = str_replace(',', '.', $total_geral);
        $total_geral = filter_var($total_geral, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $sql =
            '
                    SELECT p.pro_cupom, p.pro_desc_porc as porc, p.pro_desc_valor as valor, p.pro_tipo_desconto as tipo
                        FROM carrinho c 
                            INNER JOIN promocao p ON c.promocao_id = p.pro_id
                        WHERE c.idcarrinho = ?
                ';

        $resp = $crud->ConsultaGenerica($sql, array($this->id));

        if (!empty($resp)) {
            $resp_desconto = $resp[0];
            $retorno['cupom'] = $resp_desconto['pro_cupom'];

            if (intval($resp_desconto['tipo']) === 1) {
                $val_porc = filter_var($resp_desconto['porc'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $valor_desconto = $total_geral *  $val_porc / 100;

                $retorno['valor_desconto'] = $valor_desconto;
                $retorno['valor_total'] = $total_geral - $valor_desconto;

            } else {
                $val_desc= $resp_desconto['valor'];
                $valor_desconto = filter_var($val_desc, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                $retorno['valor_desconto'] = $valor_desconto;
                $retorno['valor_total'] = $total_geral - $valor_desconto;
            }

        }

        if (!empty($retorno['valor_desconto']))
            $retorno['valor_desconto'] = number_format($retorno['valor_desconto'], 2,',','.');

        if (!empty($retorno['valor_total']) && $retorno['valor_total'] > 0)
            $retorno['valor_total'] = number_format($retorno['valor_total'], 2,',','.');

        if (empty($retorno['valor_desconto']))
            $retorno['valor_desconto'] = 0;

        if (empty($retorno['valor_total']))
            $retorno['valor_total'] = 0;

        if (empty($retorno['valor_desconto']) && empty($retorno['valor_total']))
            $retorno = array();

        return $retorno;
    }

    public function excluirItemCarrinho() {
    	$crud = new Crud();
    	$resp = $crud->ExcluirCondicoes('carrinho_tem_produto', 'idcarrinho = ' . $this->id . ' AND pro_id = ' . $this->produtos->getId() . ' AND idcarrinho_produto = ' . $this->id_carrinho_item);

    	return $resp;
	}

}