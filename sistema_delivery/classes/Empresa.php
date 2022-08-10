<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'Endereco.php';
require_once 'vendor/autoload.php';

use WideImage\WideImage;

class Empresa implements Interfaceclasses
{
    private $id;
    private $data_criacao;
    private $nome;
    private $fantasia;
    private $cnpj;
    private $descricao;
    private $ativo;
    private $endereco;
    private $crud;
    private $categorias_empresa;
    private $tempo_espera_1;
    private $tempo_espera_2;
    private $file_logo;
    private $file_favicon;
    private $nome_logo;
    private $nome_favicon;
    private $retorno;
    private $frete;
    private $avaliacoes;
    private $fone1;
    private $fone2;
    private $comissao;

    /**
     * Empresa constructor.
     * @param $nome
     * @param $fantasia
     * @param $cnpj
     * @param $descricao
     * @param $ativo
     */
    public function __construct($nome="", $fantasia="", $cnpj="", $descricao="", $ativo="0")
    {
        $this->data_criacao = date("Y-m-d");
        $this->nome = $nome;
        $this->fantasia = $fantasia;
        $this->cnpj = $cnpj;
        $this->descricao = $descricao;
        $this->ativo = $ativo;
        $this->endereco = new Endereco();
        $this->categorias_empresa = array();
        $this->tempo_espera_1 = $this->tempo_espera_2 = 0;
        $this->file_logo = $this->file_favicon = null;
        $this->nome_logo = $this->file_favicon = '';
        $this->frete = 0.00;
        $this->avaliacoes = null;
        $this->fone1 = $this->fone2 = '';
        $comissao = 0.0;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
    public function getFantasia()
    {
        return $this->fantasia;
    }

    /**
     * @param mixed $fantasia
     */
    public function setFantasia($fantasia)
    {
        $this->fantasia = $fantasia;
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return Endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param Endereco $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return array
     */
    public function getCategoriasEmpresa()
    {
        return $this->categorias_empresa;
    }

    /**
     * @param array $categorias_empresa
     */
    public function setCategoriasEmpresa($categorias_empresa)
    {
        $this->categorias_empresa = $categorias_empresa;
    }

    /**
     * @return int
     */
    public function getTempoEspera1()
    {
        return $this->tempo_espera_1;
    }

    /**
     * @param int $tempo_espera_1
     */
    public function setTempoEspera1($tempo_espera_1)
    {
        $this->tempo_espera_1 = $tempo_espera_1;
    }

    /**
     * @return mixed
     */
    public function getTempoEspera2()
    {
        return $this->tempo_espera_2;
    }

    /**
     * @param mixed $tempo_espera_2
     */
    public function setTempoEspera2($tempo_espera_2)
    {
        $this->tempo_espera_2 = $tempo_espera_2;
    }

    /**
     * @return null
     */
    public function getFileLogo()
    {
        return $this->file_logo;
    }

    /**
     * @param null $file_logo
     */
    public function setFileLogo($file_logo)
    {
        $this->file_logo = $file_logo;
    }

    /**
     * @return mixed
     */
    public function getFileFavicon()
    {
        return $this->file_favicon;
    }

    /**
     * @param mixed $file_favicon
     */
    public function setFileFavicon($file_favicon)
    {
        $this->file_favicon = $file_favicon;
    }

    /**
     * @return string
     */
    public function getNomeLogo()
    {
        return $this->nome_logo;
    }

    /**
     * @param string $nome_logo
     */
    public function setNomeLogo($nome_logo)
    {
        $this->nome_logo = $nome_logo;
    }

    /**
     * @return mixed
     */
    public function getNomeFavicon()
    {
        return $this->nome_favicon;
    }

    /**
     * @param mixed $nome_favicon
     */
    public function setNomeFavicon($nome_favicon)
    {
        $this->nome_favicon = $nome_favicon;
    }

    /**
     * @return mixed
     */
    public function getRetorno()
    {
        return $this->retorno;
    }

    /**
     * @return float
     */
    public function getFrete()
    {
        return $this->frete;
    }

    /**
     * @param float $frete
     */
    public function setFrete($frete)
    {
        $this->frete = $frete;
    }

    /**
     * @return null
     */
    public function getAvaliacoes()
    {
        return $this->avaliacoes;
    }

    /**
     * @param null $avaliacoes
     */
    public function setAvaliacoes($avaliacoes)
    {
        $this->avaliacoes = $avaliacoes;
    }

	/**
	 * @return string
	 */
	public function getFone1()
	{
		return $this->fone1;
	}

	/**
	 * @param string $fone1
	 */
	public function setFone1($fone1)
	{
		$this->fone1 = $fone1;
	}

	/**
	 * @return mixed
	 */
	public function getFone2()
	{
		return $this->fone2;
	}

	/**
	 * @param mixed $fone2
	 */
	public function setFone2($fone2)
	{
		$this->fone2 = $fone2;
	}

	/**
	 * @return mixed
	 */
	public function getComissao()
	{
		return $this->comissao;
	}

	/**
	 * @param mixed $comissao
	 */
	public function setComissao($comissao)
	{
		$this->comissao = $comissao;
	}

    public function inserir()
    {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Inserir("empresa", array("emp_dtCad",
                                                       "emp_nome",
                                                       "emp_razaoSocial",
                                                       "emp_cnpj",
                                                       "emp_descricao",
                                                       "emp_ativo",
                                                       "end_id",
                                                       "emp_comissao",
                                                    ) ,
                                                 array($this->data_criacao,
                                                     utf8_decode($this->fantasia),
                                                     utf8_decode($this->nome),
                                                     $this->cnpj,
                                                     utf8_decode($this->descricao),
                                                     $this->ativo,
                                                     $this->endereco->getId(),
                                                     $this->comissao,
                                                 )
        );
        if ($resp) {
            $this->id = $this->crud->getUltimoCodigo();
        }

        return $resp;
    }

    public function inserir_categorias() {
        $crud = new Crud(true);
        $resp = $crud->Excluir('categoria_tem_empresa', 'emp_id', $this->id);

        if ($resp && !empty($this->categorias_empresa)) {

            $total = count($this->categorias_empresa);

            for ($ind =  0; $ind < $total && $resp; $ind++) {
                $resp = $crud->Inserir('categoria_tem_empresa', array('cat_id', 'emp_id', 'ordem'), array($this->categorias_empresa[$ind], $this->id, $ind+1));
            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Altera("empresa", array("emp_nome",
            "emp_razaoSocial",
            "emp_cnpj",
            "emp_descricao",
            "end_id",
            "emp_comissao",
        ) ,
            array(utf8_decode($this->fantasia),
                utf8_decode($this->nome),
                utf8_encode($this->cnpj),
                utf8_decode($this->descricao),
                $this->endereco->getId(),
                $this->comissao,
            ),
            "emp_id", $this->id
        );

        return $resp;
    }

    public function alterarInformacoes() {
		$retorno = false;
		$this->crud = new Crud(true);
		$this->endereco->setCrud($this->crud);

		$resp = $this->crud->ConsultaGenerica('SELECT end_id FROM empresa WHERE emp_id = ? LIMIT 1', array($this->id));

		if (!empty($resp[0]['end_id'])) {
			$this->endereco->setId($resp[0]['end_id']);
			$retorno = $this->endereco->alterar();
		} else {
			$retorno = $this->endereco->inserir();
		}

		if ($retorno) {
			$retorno = $this->crud->Altera('empresa', array('emp_nome', 'emp_descricao', 'emp_fone1', 'emp_fone2', 'end_id'), array(utf8_decode($this->nome), utf8_decode($this->descricao), $this->fone1, $this->fone2, $this->endereco->getId()), 'emp_id', $this->id);
		}

		$this->crud->executar($retorno);
		return $retorno;
	}

    public function excluir()
    {
        if (empty($this->crud))
            $this->crud = new Crud();

        $resp = $this->crud->Excluir("empresa", "emp_id", $this->id);
        return $resp;
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

    public function listar_ativas($filtro) {
        $crud = new Crud();

        if (!empty($filtro))
        	$resp = $crud->ConsultaGenerica('SELECT e.emp_id, e.emp_logo, e.emp_nome, e.emp_tempo_entrega_1 as tempo1, e.emp_tempo_entrega_2 as tempo2, (SELECT cat_nome FROM categoria_cozinha cc INNER JOIN categoria_tem_empresa cte on cc.cat_id = cte.cat_id WHERE cte.emp_id = e.emp_id LIMIT 1) as categoria, COUNT(a.idavaliacoes) as total_avaliacoes, AVG(a.classificacao) as media_avaliacoes FROM empresa e LEFT JOIN saida s ON e.emp_id = s.emp_id LEFT JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE e.emp_ativo = \'1\' AND (e.emp_nome LIKE ?) GROUP BY e.emp_id, e.emp_logo, e.emp_nome, tempo1, tempo2, categoria ORDER BY media_avaliacoes desc, emp_nome', array("%".strtolower(tiraacento($filtro))."%"));
        else
        	$resp = $crud->BuscaGenerica('SELECT e.emp_id, e.emp_logo, e.emp_nome, e.emp_tempo_entrega_1 as tempo1, e.emp_tempo_entrega_2 as tempo2, (SELECT cat_nome FROM categoria_cozinha cc INNER JOIN categoria_tem_empresa cte on cc.cat_id = cte.cat_id WHERE cte.emp_id = e.emp_id LIMIT 1) as categoria, COUNT(a.idavaliacoes) as total_avaliacoes, AVG(a.classificacao) as media_avaliacoes FROM empresa e LEFT JOIN saida s ON e.emp_id = s.emp_id LEFT JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE e.emp_ativo = \'1\' GROUP BY e.emp_id, e.emp_logo, e.emp_nome, tempo1, tempo2, categoria ORDER BY media_avaliacoes desc, emp_nome');

        return $resp;
    }

    public function listarCategorias() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT cc.cat_id, cc.cat_nome FROM categoria_tem_empresa ce INNER JOIN categoria_cozinha cc ON cc.cat_id = ce.cat_id WHERE emp_id = ? ORDER BY ordem', array($this->id));

        return $resp;
    }

    public function listarCategoriasProdutos() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT c.cat_id, c.cat_nome, COUNT(p.pro_id) FROM categoria_produtos c LEFT JOIN produto p ON c.cat_id = p.cat_id WHERE c.emp_id = ? AND cat_ativo =\'1\' GROUP BY c.cat_id, c.cat_nome HAVING COUNT(p.pro_id) > 0 ORDER BY c.cat_nome', array($this->id));

        return $resp;
    }

    public function listarCategoriasId() {
        $retorno = array();
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT cat_id FROM categoria_tem_empresa WHERE emp_id = ?', array($this->id));

        if (!empty($resp)) {

            foreach ($resp as $result) {
                $retorno[] = $result['cat_id'];
            }

        }

        return $retorno;
    }


    public function quantidadeRegistros($filtro, $chaves = "")
    {
        // TODO: Implement quantidadeRegistros() method.
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        // TODO: Implement listarPaginacao() method.
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("empresa WHERE emp_id = ? LIMIT 1", array($this->id));

        if ($resp) {
            $this->nome = utf8_encode($resp[0]["emp_razaoSocial"]);
            $this->fantasia = utf8_encode($resp[0]["emp_nome"]);
            $this->setCnpj(utf8_encode($resp[0]["emp_cnpj"]));
            if (!empty($resp[0]['emp_comissao']))
            	$this->comissao = number_format($resp[0]['emp_comissao'], 2, ',', '.');

            return true;
        }

        return false;
    }

    public function carregarInformacoes() {
    	$crud = new Crud();
    	$resp = $crud->ConsultaGenerica('SELECT emp_nome, emp_descricao, emp_fone1, emp_fone2, end_id FROM empresa e WHERE e.emp_id = ? LIMIT 1', array($this->id));

    	if (!empty($resp)) {

    		$this->nome = utf8_encode($resp[0]['emp_nome']);
    		$this->descricao = utf8_encode($resp[0]['emp_descricao']);
    		$this->fone1 = $resp[0]['emp_fone1'];
    		$this->fone2 = $resp[0]['emp_fone2'];
    		$this->endereco->setId($resp[0]['end_id']);

    		$this->endereco->carregar();

    		return true;
		}

    	return false;
	}

    public function carregar2() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT e.emp_logo, e.emp_descricao, e.emp_nome, end_id, emp_fone1, emp_fone2, e.emp_tempo_entrega_1 as tempo1, e.emp_tempo_entrega_2 as tempo2, (SELECT cat_nome FROM categoria_cozinha cc INNER JOIN categoria_tem_empresa cte on cc.cat_id = cte.cat_id WHERE cte.emp_id = e.emp_id LIMIT 1) as categoria, COUNT(a.idavaliacoes) as total_avaliacoes, AVG(a.classificacao) as media_avaliacoes FROM empresa e LEFT JOIN saida s ON e.emp_id = s.emp_id LEFT JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE e.emp_id = ? AND e.emp_ativo = \'1\' GROUP BY e.emp_logo, e.emp_descricao, e.emp_nome, tempo1, tempo2, categoria', array($this->id));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]['emp_nome']);
            $this->descricao = utf8_encode($resp[0]['emp_descricao']);
            $this->nome_logo = $resp[0]['emp_logo'];
            $this->tempo_espera_1 = $resp[0]['tempo1'];
            $this->tempo_espera_2 = $resp[0]['tempo2'];
            $this->categorias_empresa = utf8_encode($resp[0]['categoria']);

            $array_avaliacao = array();

            $array_avaliacao['total'] = $resp[0]['total_avaliacoes'];
            $array_avaliacao['media'] = $resp[0]['media_avaliacoes'];
            $this->avaliacoes = $array_avaliacao;

            $this->fone1 = $resp[0]['emp_fone1'];
            $this->fone2 = $resp[0]['emp_fone2'];

            $this->endereco->setId($resp[0]['end_id']);
            $this->endereco->carregar();

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select emp_ativo from empresa where emp_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['emp_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('empresa', array('emp_ativo'), array(utf8_decode($this->ativo)), 'emp_id', $this->id);

        return $resp;
    }

    public function definirTempoEspera() {
        $crud = new Crud();
        $resp = $crud->Altera('empresa', array('emp_tempo_entrega_1', 'emp_tempo_entrega_2'), array($this->tempo_espera_1, $this->tempo_espera_2), 'emp_id', $this->id);

        return $resp;
    }

    public  function definirFrete() {
        $crud = new Crud();
        $resp = $crud->Altera('empresa', array('emp_frete'), array($this->frete), 'emp_id', $this->id);

        return $resp;
    }

    public function recuperarFrete() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT emp_frete FROM empresa WHERe emp_id = ? LIMIT 1', array($this->id));
        return !empty($resp) ?  floatval($resp[0]['emp_frete']) : 0.0;
    }

    public function recuperarTempoEsperaFrete() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT emp_tempo_entrega_1, emp_tempo_entrega_2, emp_frete FROM empresa WHERe emp_id = ? LIMIT 1', array($this->id));

        if (!empty($resp)) {
            $this->tempo_espera_1 = $resp[0]['emp_tempo_entrega_1'];
            $this->tempo_espera_2 = $resp[0]['emp_tempo_entrega_2'];
            $this->frete = number_format($resp[0]['emp_frete'], 2, ',', '.');

            return true;
        }

        return false;
    }

    public function carregarImagens() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT emp_logo, emp_favicon FROM empresa WHERE emp_id = ? LIMIT 1', array($this->id));

        if (!empty($resp)) {

            $this->nome_logo = $resp[0]['emp_logo'];
            $this->nome_favicon = $resp[0]['emp_favicon'];

            return true;
        }

        return false;
    }

    public function salvarImagens() {
        $resp = false;
        $crud = new Crud();
        $nome_file = $this->id."_".date("YmdHis");

        $this->carregarImagens();

        $tipo_principal = ".png";
        $parametro_principal = null;

        if (!empty($this->file_logo['name'])) {

            if (file_exists('../img/restaurantes/logos/' . $this->nome_logo))
                unlink('../img/restaurantes/logos/' . $this->nome_logo);

            if (strcmp('image/jpeg',$this->file_logo['type']) === 0) {
                $tipo_principal = ".jpg";
                $parametro_principal = 90;
            } elseif (strcmp('image/png',$this->file_logo['type']) === 0) {
                $tipo_principal = ".png";
                $parametro_principal = 6;
            }

            $nome_principal = $nome_file . $tipo_principal;

            $image_principal = WideImage::loadFromFile($this->file_logo['tmp_name']);

            $resized_principal = $image_principal->resize(300, 300, 'inside', 'down');
            $resized_principal->saveToFile('../img/restaurantes/logos/'. $nome_principal, $parametro_principal);

            $resp = $crud->Altera('empresa', array('emp_logo'), array($nome_principal), 'emp_id', $this->id);

            if (empty($resp)) {
                unlink('../img/restaurantes/logos/'. $nome_principal);
            }

        }

        $tipo_principal2 = ".png";
        $parametro_principal2 = null;

        if (!empty($this->file_favicon['name'])) {

            if (file_exists('../img/restaurantes/favicon/' . $this->nome_favicon))
                unlink('../img/restaurantes/favicon/' . $this->nome_favicon);

            if (strcmp('image/jpeg',$this->file_favicon['type']) === 0) {
                $tipo_principal2 = ".jpg";
                $parametro_principal2 = 90;
            } elseif (strcmp('image/png',$this->file_favicon['type']) === 0) {
                $tipo_principal2 = ".png";
                $parametro_principal2 = 9;
            }

            $nome_principal2 = $nome_file . $tipo_principal2;

            $image_principal2 = WideImage::loadFromFile($this->file_favicon['tmp_name']);

            $resized_principal2 = $image_principal2->resize(16, 16, 'inside', 'down');
            $resized_principal2->saveToFile('../img/restaurantes/favicon/'. $nome_principal2, $parametro_principal2);

            $resp = $crud->Altera('empresa', array('emp_favicon'), array($nome_principal2), 'emp_id', $this->id);

            if (empty($resp)) {
                unlink('../img/restaurantes/favicon/'. $nome_principal2);
            }

        }

        return $resp;
    }

    public function verificarImagem($file) {
        $retorno = false;

        if (!empty($file["error"]) && $file["error"] !== 4) {

            if ($file["error"] === 1 || $file["error"] === 2)
                $this->retorno = 'O arquivo \''. $file["name"] .'\' excede o tamanho máximo permitido de 1,5MB';
            elseif($file["error"] === 3)
                $this->retorno = 'Não foi possível fazer o upload completo do arquivo, tente novamente';
            elseif($file["error"] === 6)
                $this->retorno = 'Não foi possível fazer o upload do arquivo (pasta temporária ausente)';
            else
                $this->retorno = 'Erro inesperável no upload do arquivo, tente novamente';

        } else if($file["size"] > 1572864) {
            $this->retorno = 'O arquivo \'' . $file["name"] . '\' excede o tamanho máximo permitido de 1,5MB';
        }elseif(strcmp('image/png', $file["type"]) !== 0 && strcmp('image/jpeg', $file["type"]) !== 0) {
            $this->retorno = 'O Tipo do arquivo enviado é inválido. Por favor, envie um arquivo do tipo "jpeg ou png"';
        } else
            $retorno = true;

        return $retorno;
    }

    public function recuperaPedidosAbertos() {
    	$crud = new Crud();
    	$resp = $crud->ConsultaGenerica('SELECT s.idsaida, s.data_criacao, s.total_geral, e.end_rua, e.end_numero, e.end_bairro, e.end_cep FROM saida s INNER JOIN endereco e on s.endereco_id = e.end_id WHERE emp_id = ? AND s.status IS NULL ORDER BY s.idsaida DESC', array($this->id));
		return $resp;
	}

	public function recuperaPedidosPreparando() {
    	$crud = new Crud();
    	$resp = $crud->ConsultaGenerica('SELECT s.idsaida, s.data_criacao, s.total_geral, e.end_rua, e.end_numero, e.end_bairro, e.end_cep FROM saida s INNER JOIN endereco e on s.endereco_id = e.end_id WHERE emp_id = ? AND s.status  = 1 AND entrega_id IS NULL ORDER BY s.idsaida', array($this->id));
		return $resp;
	}

	public function recuperaPedidosEnviados() {
        $array_entrega = array();
        $crud = new Crud();
        //continuar aqui, pegar os pedidos que sairam para entrega
        $resp = $crud->ConsultaGenerica('SELECT e.ent_id, e.ent_dtCad, et.ent_nome FROM entrega e INNER JOIN entregador et ON e.entregador_id = et.ent_id WHERE e.emp_id = ? AND e.ent_status IS NULL', array($this->id));

        if (!empty($resp)) {

            foreach ($resp as $i =>$entrega) {

                $array_entrega[$i]['id'] = $entrega['ent_id'];
                $array_entrega[$i]['data'] = $entrega['ent_dtCad'];
                $array_entrega[$i]['entregador'] = utf8_encode($entrega['ent_nome']);

                $resp_end = $crud->ConsultaGenerica('SELECT e.rua, e.numero, e.bairro FROM entrega_enderecos e WHERE ent_id = ?', array($entrega['ent_id']));

                $string_enderecos = '';

                if (!empty($resp_end)) {

                    foreach ($resp_end as $j => $endereco) {

                        $string_enderecos .=  '* ' . utf8_encode($endereco['rua']) . ', ' . $endereco['numero'] . ' - ' . utf8_encode($endereco['bairro']) . '<br>';

                    }

                }

                $array_entrega[$i]['enderecos'] = $string_enderecos;

            }

        }

        return $array_entrega;
    }

	public function recuperaEntregadores() {
    	$crud = new Crud();
    	$resp = $crud->ConsultaGenerica('SELECT ent_id, ent_nome FROM entregador WHERE emp_id = ? AND ent_ativo = 1 ORDER BY ent_nome', array($this->id));

    	return $resp;
	}

	public function listarRelatorio($filtro, $periodo1, $periodo2) {
		$crud = new Crud(FALSE);

		if(!empty($periodo1) && !empty($periodo2) && !empty($filtro)) {

			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$sql = '
						SELECT e.emp_nome, resp_nome, resp_fone, emp_comissao, COUNT(DISTINCT e.emp_id), SUM(cr.con_valor) faturamento
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id 
						WHERE cr.con_dtCad BETWEEN ? AND ? AND (lower(emp_nome) like ? OR lower(resp_nome) like ?)
						GROUP BY e.emp_nome, resp_nome, resp_fone, emp_comissao
					';
			$resp = $crud->ConsultaGenerica($sql, array($periodo1, $periodo2, "%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%"));

		} elseif(!empty($periodo1) && !empty($periodo2)) {
			$periodo1 = trataData($periodo1);
			$periodo2 = trataData($periodo2);

			$sql = '
						SELECT e.emp_nome, resp_nome, resp_fone, emp_comissao, COUNT(DISTINCT e.emp_id), SUM(cr.con_valor) faturamento
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id 
						WHERE cr.con_dtCad BETWEEN ? AND ?
						GROUP BY e.emp_nome, resp_nome, resp_fone, emp_comissao
					';
			$resp = $crud->ConsultaGenerica($sql, array($periodo1, $periodo2));
		} elseif(!empty($filtro)){
			$sql = "
						SELECT e.emp_nome, resp_nome, resp_fone, emp_comissao, COUNT(DISTINCT e.emp_id), SUM(cr.con_valor) faturamento
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id 
						WHERE lower(emp_nome) like ? OR lower(resp_nome) like ?
						GROUP BY e.emp_nome, resp_nome, resp_fone, emp_comissao
			";
			$resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%"));
		} else {
			$resp = $crud->BuscaGenerica("
						SELECT e.emp_nome, resp_nome, resp_fone, emp_comissao, COUNT(DISTINCT e.emp_id), SUM(cr.con_valor) faturamento
							FROM empresa e INNER JOIN responsavel_empresa r ON e.emp_id = r.emp_id 
							LEFT JOIN contas_receber cr on e.emp_id = cr.emp_id 
						GROUP BY e.emp_nome, resp_nome, resp_fone, emp_comissao
			");
		}

		return $resp;
	}

}