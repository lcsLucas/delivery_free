<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'UnidadeMedida.php';
require_once 'vendor/autoload.php';

use WideImage\WideImage;

class Produto implements Interfaceclasses
{
    private $id;
    private $nome;
    private $dtCad;
    private $controle_estoque;
    private $obs;
    private $ativo;
    private $custo;
    private $preco;
    private $idUnidade;
    private $idCategoria;
    private $idFornecedor;
    private $idEmpresa;
    private $file_imagem;
    private $nome_imagem;
    private $retorno;
    private $complementos;
    private $qtde;

    /**
     * Produto constructor.
     * @param $nome
     * @param $dtCad
     * @param $controle_estoque
     * @param $obs
     * @param $idUnidade
     * @param $idCategoria
     * @param $idFornecedor
     * @param $idEmpresa
     */
    public function __construct($nome = "", $controle_estoque = "", $obs = "", $idUnidade = "", $idCategoria = "", $idFornecedor = "", $idEmpresa = "")
    {
        $this->nome = $nome;
        $this->dtCad = date("Y-m-d");
        $this->controle_estoque = $controle_estoque;
        $this->obs = $obs;
        $this->idUnidade = $idUnidade;
        $this->idCategoria = $idCategoria;
        $this->idFornecedor = $idFornecedor;
        $this->idEmpresa = $idEmpresa;
        $this->custo = 0.00;
        $this->preco = 0.00;
        $this->retorno = $this->nome_imagem = $this->file_imagem = '';
        $this->complementos = array();
        $this->qtde = 0;
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
    public function getDtCad()
    {
        return $this->dtCad;
    }

    /**
     * @param string $dtCad
     */
    public function setDtCad($dtCad)
    {
        $this->dtCad = $dtCad;
    }

    /**
     * @return string
     */
    public function getControleEstoque()
    {
        return $this->controle_estoque;
    }

    /**
     * @param string $controle_estoque
     */
    public function setControleEstoque($controle_estoque)
    {
        $this->controle_estoque = $controle_estoque;
    }

    /**
     * @return mixed
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param mixed $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    /**
     * @return string
     */
    public function getIdUnidade()
    {
        return $this->idUnidade;
    }

    /**
     * @param string $idUnidade
     */
    public function setIdUnidade($idUnidade)
    {
        $this->idUnidade = $idUnidade;
    }

    /**
     * @return string
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * @param string $idCategoria
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    /**
     * @return string
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param string $idFornecedor
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
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
     * @return float
     */
    public function getCusto()
    {
        return $this->custo;
    }

    /**
     * @param float $custo
     */
    public function setCusto($custo)
    {
        $this->custo = $custo;
    }

    /**
     * @return float
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param float $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    /**
     * @return mixed
     */
    public function getFileImagem()
    {
        return $this->file_imagem;
    }

    /**
     * @param mixed $file_imagem
     */
    public function setFileImagem($file_imagem)
    {
        $this->file_imagem = $file_imagem;
    }

    /**
     * @return mixed
     */
    public function getNomeImagem()
    {
        return $this->nome_imagem;
    }

    /**
     * @param mixed $nome_imagem
     */
    public function setNomeImagem($nome_imagem)
    {
        $this->nome_imagem = $nome_imagem;
    }

    /**
     * @return string
     */
    public function getRetorno()
    {
        return $this->retorno;
    }

    /**
     * @return array
     */
    public function getComplementos()
    {
        return $this->complementos;
    }

    /**
     * @param array $complementos
     */
    public function setComplementos($complementos)
    {
        $this->complementos = $complementos;
    }

    /**
     * @return int
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * @param int $qtde
     */
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
    }

    public function inserir()
    {
        $crud = new Crud(true);
        $resp = $crud->Inserir(
            "produto",
            array(
                "pro_nome",
                "pro_dtCad",
                "pro_descricao",
                "pro_controle_estoque",
                "pro_ativo",
                "pro_custo",
                "pro_valor",
                "uni_id",
                "cat_id",
                "for_id",
                "emp_id"
            ),
            array(
                utf8_decode($this->nome),
                utf8_decode($this->dtCad),
                utf8_decode($this->obs),
                utf8_decode($this->controle_estoque),
                utf8_decode($this->ativo),
                $this->custo,
                $this->preco,
                $this->idUnidade,
                $this->idCategoria,
                !empty($this->idFornecedor) ? $this->idFornecedor : NULL,
                $this->idEmpresa
            )
        );

        if ($resp && !empty($this->file_imagem)) {
            $this->id = $crud->getUltimoCodigo();
            $nomeimg = $this->id . "_" . date("YmdHis");

            $nome_final = $this->salvarImagem($nomeimg);

            $resp = $crud->Altera("produto", array("pro_foto"), array(utf8_decode($nome_final)), "pro_id", $this->id);

            if (empty($resp))
                $this->excluirImagens($nome_final);
        }

        if ($resp && !empty($this->complementos)) {
            $complementos = $this->complementos;
            $total = count($complementos);
            $i = 0;

            while ($i < $total && $resp) {

                $resp = $crud->Inserir(
                    'categoria_complementos',
                    array(
                        'catcom_nome',
                        'catcom_obrigatorio',
                        'catcom_qtdemin',
                        'catcom_qtdemax',
                        'pro_id',
                        'emp_id'
                    ),
                    array(
                        utf8_decode($complementos[$i]['nome']),
                        $complementos[$i]['flag_obrigatorio'],
                        $complementos[$i]['qtde_min'],
                        $complementos[$i]['qtde_max'],
                        $this->id,
                        $this->idEmpresa
                    )
                );

                if ($resp) {
                    $idcomplemento = $crud->getUltimoCodigo();

                    if (!empty($complementos[$i]['opcoes'])) {
                        $opcoes = $complementos[$i]['opcoes'];
                        $j = 0;
                        $total_opcoes = count($opcoes['nome']);

                        while ($j < $total_opcoes && $resp) {

                            $nome = $opcoes['nome'][$j];
                            $descricao = !empty($opcoes['descricao'][$j]) ? $opcoes['descricao'][$j] : '';
                            $preco = !empty($opcoes['preco'][$j]) ? $opcoes['preco'][$j] : 0;

                            $preco = str_replace(".", "", $preco);
                            $preco = filter_var(str_replace(",", ".", $preco), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                            $resp = $crud->Inserir(
                                'produto_tem_complementos',
                                array(
                                    'pro_id',
                                    'catcom_id',
                                    'nome',
                                    'descricao',
                                    'preco',
                                ),
                                array(
                                    $this->id,
                                    $idcomplemento,
                                    utf8_decode($nome),
                                    utf8_decode($descricao),
                                    $preco,
                                )
                            );

                            $j++;
                        }

                        if (empty($resp))
                            $resp = $crud->Excluir('categoria_complementos', 'catcom_id', $idcomplemento);
                    }
                }

                $i++;
            }
        }

        $crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud(true);

        $resp = $crud->AlteraCondicoes(
            "produto",
            array(
                "pro_nome",
                "pro_dtCad",
                "pro_descricao",
                "pro_controle_estoque",
                "pro_custo",
                "pro_valor",
                "uni_id",
                "cat_id",
                "for_id",
                "emp_id"
            ),
            array(
                utf8_decode($this->nome),
                utf8_decode($this->dtCad),
                utf8_decode($this->obs),
                utf8_decode($this->controle_estoque),
                $this->custo,
                $this->preco,
                $this->idUnidade,
                $this->idCategoria,
                !empty($this->idFornecedor) ? $this->idFornecedor : NULL,
                $this->idEmpresa
            ),
            "pro_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        if ($resp && !empty($this->file_imagem)) {

            $resp = $crud->ConsultaGenerica("SELECT pro_foto from produto WHERE pro_id = ? LIMIT 1", array($this->id));

            if (!empty($resp)) {

                if (!empty($resp[0]['pro_foto'])) {
                    $this->nome_imagem = $resp[0]['pro_foto'];
                    $this->excluirImagens($this->nome_imagem);
                }

                $nomeimg = $this->id . "_" . date("YmdHis");
                $nome_final = $this->salvarImagem($nomeimg);

                $resp = $crud->Altera("produto", array("pro_foto"), array(utf8_decode($nome_final)), "pro_id", $this->id);

                if (empty($resp))
                    $this->excluirImagens($nome_final);
            }
        }

        if ($resp)
            $resp = $crud->ExcluirCondicoes('categoria_complementos', 'pro_id = ' . $this->id . ' AND emp_id = ' . $this->idEmpresa);

        if ($resp && !empty($this->complementos)) {
            $complementos = $this->complementos;
            $total = count($complementos);
            $i = 0;

            while ($i < $total && $resp) {

                $resp = $crud->Inserir(
                    'categoria_complementos',
                    array(
                        'catcom_nome',
                        'catcom_obrigatorio',
                        'catcom_qtdemin',
                        'catcom_qtdemax',
                        'pro_id',
                        'emp_id'
                    ),
                    array(
                        utf8_decode($complementos[$i]['nome']),
                        $complementos[$i]['flag_obrigatorio'],
                        $complementos[$i]['qtde_min'],
                        $complementos[$i]['qtde_max'],
                        $this->id,
                        $this->idEmpresa
                    )
                );

                if ($resp) {
                    $idcomplemento = $crud->getUltimoCodigo();

                    if (!empty($complementos[$i]['opcoes'])) {
                        $opcoes = $complementos[$i]['opcoes'];
                        $j = 0;
                        $total_opcoes = count($opcoes['nome']);

                        while ($j < $total_opcoes && $resp) {

                            $nome = $opcoes['nome'][$j];
                            $descricao = !empty($opcoes['descricao'][$j]) ? $opcoes['descricao'][$j] : '';
                            $preco = !empty($opcoes['preco'][$j]) ? $opcoes['preco'][$j] : 0;

                            $preco = str_replace(".", "", $preco);
                            $preco = filter_var(str_replace(",", ".", $preco), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                            $resp = $crud->Inserir(
                                'produto_tem_complementos',
                                array(
                                    'pro_id',
                                    'catcom_id',
                                    'nome',
                                    'descricao',
                                    'preco',
                                ),
                                array(
                                    $this->id,
                                    $idcomplemento,
                                    utf8_decode($nome),
                                    utf8_decode($descricao),
                                    $preco,
                                )
                            );

                            $j++;
                        }

                        if (empty($resp))
                            $resp = $crud->Excluir('categoria_complementos', 'catcom_id', $idcomplemento);
                    }
                }

                $i++;
            }
        }

        $crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->Excluir("produto", "pro_id", $this->id);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("produto p INNER JOIN unidade_medida um ON p.uni_id = um.uni_id WHERE emp_id = ? AND pro_ativo = ?", array($this->idEmpresa, 1));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if (!empty($filtro)) {
            $sql = "SELECT COUNT(*) total FROM produto i INNER JOIN categoria_produtos ci ON i.cat_id = ci.cat_id where (lower(pro_nome) like ? OR lower(cat_nome) like ?) AND i.emp_id = ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM produto i INNER JOIN categoria_produtos ci ON i.cat_id = ci.cat_id WHERE i.emp_id = ?", array($this->idEmpresa));
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
            $sql = "SELECT p.pro_id, p.pro_nome, p.pro_valor, cp.cat_nome, pro_ativo FROM produto p INNER JOIN categoria_produtos cp ON p.cat_id = cp.cat_id where (lower(pro_nome) like ? OR lower(cat_nome) like ?) AND p.emp_id = ? order by p.pro_nome LIMIT ?, ?";
            $res = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa, $inicio, $fim));
        } else {
            $res = $crud->ConsultaGenerica("SELECT p.pro_id, p.pro_nome, p.pro_valor, cp.cat_nome, pro_ativo FROM produto p INNER JOIN categoria_produtos cp ON p.cat_id = cp.cat_id WHERE p.emp_id = ? order by p.pro_nome LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("produto WHERE pro_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = $resp[0]["pro_nome"];
            $this->dtCad = $resp[0]["pro_dtCad"];
            $this->obs = $resp[0]["pro_descricao"];
            $this->controle_estoque = $resp[0]["pro_controle_estoque"];
            $this->custo = number_format($resp[0]["pro_custo"], 2, ",", ".");
            $this->preco = number_format($resp[0]["pro_valor"], 2, ",", ".");
            $this->idUnidade = $resp[0]["uni_id"];
            $this->idCategoria = $resp[0]["cat_id"];
            $this->idFornecedor = $resp[0]["for_id"];
            $this->idEmpresa = $resp[0]["emp_id"];
            $this->nome_imagem = $resp[0]['pro_foto'];

            if ($resp) {

                $resp_comp = $crud->Consulta('categoria_complementos WHERE pro_id = ? AND emp_id = ? ORDER BY catcom_obrigatorio DESC', array($this->id, $this->idEmpresa));

                if (!empty($resp_comp)) {

                    foreach ($resp_comp as $i => $comp) {

                        $resp_opcoes = $crud->Consulta('produto_tem_complementos WHERE pro_id = ? AND catcom_id = ?', array($this->id, $comp['catcom_id']));

                        if (!empty($resp_opcoes)) {
                            $comp['opcoes'] = $resp_opcoes;
                            $resp_comp[$i] = $comp;
                        }
                    }

                    $this->complementos = $resp_comp;
                }
            }

            return true;
        }

        return false;
    }

    function carregar_complementos()
    {
        $crud = new Crud();
        $complementos_categoria = array();
        $complementos_produto = array();

        $resp_comp = $crud->ConsultaGenerica('SELECT catcom_id, catcom_nome, catcom_obrigatorio, catcom_qtdemin, catcom_qtdemax FROM categoria_complementos WHERE cat_pro_id = (SELECT cat_id FROM produto WHERE pro_id = ? LIMIT 1) AND emp_id = ? ORDER BY catcom_obrigatorio DESC', array($this->id, $this->idEmpresa));

        if (!empty($resp_comp)) {

            foreach ($resp_comp as $i => $comp) {

                $complementos_categoria[$i]['id'] = $comp['catcom_id'];
                $complementos_categoria[$i]['nome'] = $comp['catcom_nome'];
                $complementos_categoria[$i]['obrigatorio'] = empty($comp['catcom_obrigatorio']) ? false : true;
                $complementos_categoria[$i]['qtdemin'] = $comp['catcom_qtdemin'];
                $complementos_categoria[$i]['qtdemax'] = $comp['catcom_qtdemax'];
                $complementos_categoria[$i]['tipo_complemento'] = 1;

                $resp_opcoes = $crud->Consulta('categoria_tem_complementos WHERE catcom_id = ?', array($comp['catcom_id']));

                if (!empty($resp_opcoes)) {

                    foreach ($resp_opcoes as $opcoes) {

                        $array_opcoes = array();

                        $array_opcoes['id'] = $opcoes['cat_com_id'];
                        $array_opcoes['nome'] = $opcoes['nome'];
                        $array_opcoes['descricao'] = $opcoes['descricao'];
                        $array_opcoes['preco'] = !empty($opcoes['preco']) && floatval($opcoes['preco']) > 0 ? 'R$ ' . number_format($opcoes['preco'], 2, ',', '.') : '';

                        $complementos_categoria[$i]['opcoes'][] = $array_opcoes;
                    }
                }
            }
        }

        $resp_comp = $crud->ConsultaGenerica('SELECT catcom_id, catcom_nome, catcom_obrigatorio, catcom_qtdemin, catcom_qtdemax FROM categoria_complementos WHERE pro_id = ? AND emp_id = ? ORDER BY catcom_obrigatorio DESC', array($this->id, $this->idEmpresa));

        if (!empty($resp_comp)) {

            foreach ($resp_comp as $i => $comp) {

                $complementos_produto[$i]['id'] = $comp['catcom_id'];
                $complementos_produto[$i]['nome'] = $comp['catcom_nome'];
                $complementos_produto[$i]['obrigatorio'] = empty($comp['catcom_obrigatorio']) ? false : true;
                $complementos_produto[$i]['qtdemin'] = $comp['catcom_qtdemin'];
                $complementos_produto[$i]['qtdemax'] = $comp['catcom_qtdemax'];
                $complementos_produto[$i]['tipo_complemento'] = 2;

                $resp_opcoes = $crud->Consulta('produto_tem_complementos WHERE pro_id = ? AND catcom_id = ?', array($this->id, $comp['catcom_id']));

                if (!empty($resp_opcoes)) {

                    foreach ($resp_opcoes as $opcoes) {

                        $array_opcoes = array();

                        $array_opcoes['id'] = $opcoes['pro_com_id'];
                        $array_opcoes['nome'] = $opcoes['nome'];
                        $array_opcoes['descricao'] = $opcoes['descricao'];
                        $array_opcoes['preco'] = !empty($opcoes['preco']) && floatval($opcoes['preco']) > 0 ? 'R$ ' . number_format($opcoes['preco'], 2, ',', '.') : '';

                        $complementos_produto[$i]['opcoes'][] = $array_opcoes;
                    }
                }
            }
        }

        return array_merge($complementos_categoria, $complementos_produto);
    }

    function verificarImagem($file)
    {
        $retorno = false;

        if (!empty($file["error"]) && $file["error"] !== 4) {

            if ($file["error"] === 1 || $file["error"] === 2)
                $this->retorno = 'O arquivo \'' . $file["name"] . '\' excede o tamanho máximo permitido de 1,5MB';
            elseif ($file["error"] === 3)
                $this->retorno = 'Não foi possível fazer o upload completo do arquivo, tente novamente';
            elseif ($file["error"] === 6)
                $this->retorno = 'Não foi possível fazer o upload do arquivo (pasta temporária ausente)';
            else
                $this->retorno = 'Erro inesperável no upload do arquivo, tente novamente';
        } else if ($file["size"] > 1572864) {
            $this->retorno = 'O arquivo \'' . $file["name"] . '\' excede o tamanho máximo permitido de 1,5MB';
        } elseif (strcmp('image/png', $file["type"]) !== 0 && strcmp('image/jpeg', $file["type"]) !== 0) {
            $this->retorno = 'O Tipo do arquivo enviado é inválido. Por favor, envie um arquivo do tipo "jpeg ou png"';
        } else
            $retorno = true;

        return $retorno;
    }

    public function modificaAtivo()
    {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select pro_ativo from produto where pro_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['pro_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if (!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('produto', array('pro_ativo'), array(utf8_decode($this->ativo)), 'pro_id', $this->id);

        return $resp;
    }

    private function excluirImagens($nome_img)
    {

        if (file_exists('../img/restaurantes/produtos/' . $nome_img))
            unlink('../img/restaurantes/produtos/' . $nome_img);

        if (file_exists('../img/restaurantes/produtos/thumbs/' . $nome_img))
            unlink('../img/restaurantes/produtos/thumbs/' . $nome_img);
    }

    private function salvarImagem($nome_file)
    {

        try {

            $tipo_principal = ".jpg";
            $parametro_principal = null;

            if (strcmp('image/jpeg', $this->file_imagem['type']) === 0) {
                $tipo_principal = ".jpg";
                $parametro_principal = 90;
            } elseif (strcmp('image/png', $this->file_imagem['type']) === 0) {
                $tipo_principal = ".png";
                $parametro_principal = 9;
            }

            $nome_principal = $nome_file . $tipo_principal;

            $image_principal = WideImage::loadFromFile($this->file_imagem['tmp_name']);

            $resized_principal = $image_principal->resize(640, 480, 'inside');
            $resized_principal->saveToFile('../img/restaurantes/produtos/' . $nome_principal, $parametro_principal);

            $resized_principal = $image_principal->resize(250, 250, 'inside');
            $resized_principal->saveToFile('../img/restaurantes/produtos/thumbs/' . $nome_principal, $parametro_principal);
        } catch (\Exception $e) {
            echo 'ERRO ! imagem corrompida: ' . $e->getMessage();
            die;
        }



        return $nome_principal;
    }

    public function recuperarEstoque()
    {
        $crud = new Crud();

        $resp = $crud->ConsultaGenerica('SELECT pro_controle_estoque, pro_estoque_atual FROM produto WHERE pro_id = ? LIMIT 1', array($this->id));

        if (!empty($resp)) {

            $this->controle_estoque = $resp[0]['pro_controle_estoque'];

            if (!empty(!empty($resp[0]['pro_estoque_atual'])))
                return (int) $resp[0]['pro_estoque_atual'];
        }

        return 0;
    }
}
