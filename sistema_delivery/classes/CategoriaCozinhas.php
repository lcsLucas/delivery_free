<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'vendor/autoload.php';

use WideImage\WideImage;

class CategoriaCozinhas implements Interfaceclasses
{
    private $id;
    private $nome;
    private $resumo;
    private $descricao;
    private $file_imagem;
    private $nome_imagem;
    private $retorno;
    private $status;

    /**
     * CategoriaCozinhas constructor.
     * @param $nome
     * @param $resumo
     * @param $descricao
     * @param $file_imagem
     * @param $nome_imagem
     */
    public function __construct($nome='', $resumo='', $descricao='', $file_imagem='', $nome_imagem='', $status = '0')
    {
        $this->nome = $nome;
        $this->resumo = $resumo;
        $this->descricao = $descricao;
        $this->file_imagem = $file_imagem;
        $this->nome_imagem = $nome_imagem;
        $this->retorno = '';
        $this->status = $status;
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
    public function getResumo()
    {
        return $this->resumo;
    }

    /**
     * @param string $resumo
     */
    public function setResumo($resumo)
    {
        $this->resumo = $resumo;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return string
     */
    public function getFileImagem()
    {
        return $this->file_imagem;
    }

    /**
     * @param string $file_imagem
     */
    public function setFileImagem($file_imagem)
    {
        $this->file_imagem = $file_imagem;
    }

    /**
     * @return string
     */
    public function getNomeImagem()
    {
        return $this->nome_imagem;
    }

    /**
     * @param string $nome_imagem
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function inserir()
    {
        $crud = new Crud(true);

        $resp = $crud->Inserir('categoria_cozinha',
            array(
                'cat_nome',
                'cat_resumo',
                'cat_descricao',
                'cat_status'
            ),
            array(
                utf8_decode($this->nome),
                utf8_decode($this->resumo),
                utf8_decode($this->descricao),
                $this->status
            )
        );

        if ($resp && !empty($this->file_imagem)) {
            $this->id = $crud->getUltimoCodigo();
            $nomeimg = $this->id."_".date("YmdHis");

            $nome_final = $this->salvarImagem($nomeimg);

            $resp = $crud->Altera("categoria_cozinha", array("cat_img"), array(utf8_decode($nome_final)), "cat_id", $this->id);

            if (empty($resp))
                $this->excluirImagens($nome_final);

        }

        $crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud(true);

        $resp = $crud->Altera('categoria_cozinha',
            array(
                'cat_nome',
                'cat_resumo',
                'cat_descricao'
            ),
            array(
                utf8_decode($this->nome),
                utf8_decode($this->resumo),
                utf8_decode($this->descricao)
            ),
            'cat_id', $this->id
        );

        if ($resp && !empty($this->file_imagem)) {

            $resp = $crud->ConsultaGenerica("SELECT cat_img From categoria_cozinha WHERE cat_id = ? LIMIT 1", array($this->id));

            if (!empty($resp)) {

                if (!empty($resp[0]['cat_img'])) {
                    $this->nome_imagem = $resp[0]['cat_img'];
                    $this->excluirImagens($this->nome_imagem);
                }

                $nomeimg = $this->id."_".date("YmdHis");
                $nome_final = $this->salvarImagem($nomeimg);

                $resp = $crud->Altera("categoria_cozinha", array("cat_img"), array(utf8_decode($nome_final)), "cat_id", $this->id);

                if (empty($resp))
                    $this->excluirImagens($nome_final);
            }

        }

        $crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        if (!empty($this->id)) {
            $crud = new Crud(true);
            $resp = false;
            if($this->id) {
                $resp = $crud->ConsultaGenerica("SELECT cat_img From categoria_cozinha WHERE cat_id = ? LIMIT 1", array($this->id));
                if(!empty($resp) && !empty($resp[0]["cat_img"])) {
                    $this->nome_imagem = $resp[0]["cat_img"];

                    $resp = $crud->Excluir('categoria_cozinha', 'cat_id', $this->id);
                    if($resp) {
                        $this->excluirImagens($this->nome_imagem);
                    }
                }
            }

            $crud->executar($resp);
            return $resp;
        }

        return false;
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

    public function listar_ativos_empresa($array_cat) {
        $crud = new Crud();
        if (!empty($array_cat))
        $resp = $crud->BuscaAtributos('cat_id, cat_nome', 'categoria_cozinha WHERE cat_status = \'1\' AND cat_id NOT IN ('. implode(',', $array_cat) .')');
        else
            $resp = $crud->BuscaAtributos('cat_id, cat_nome', 'categoria_cozinha WHERE cat_status = \'1\'');

        return $resp;
    }

    public function listar_produtos() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica('SELECT distinct pt.pro_id, pt.pro_nome, pt.pro_descricao, pt.pro_valor, IF (ptp.tipo_desconto IS NOT NULL AND DATE_FORMAT(NOW(), "%Y-%m-%d") BETWEEN p.pro_dtInicio AND p.pro_dtFinal, IF(ptp.tipo_desconto = \'1\', pt.pro_valor - pt.pro_valor * ptp.desc_porcentagem / 100, pt.pro_valor - ptp.desc_valor), NULL) as valor_promocao, pt.pro_foto FROM produto pt LEFT JOIN promocao_tem_produtos ptp on pt.pro_id = ptp.produto_id LEFT JOIN promocao p on ptp.promocao_id = p.pro_id WHERE cat_id = ? AND pt.pro_ativo = \'1\' AND ((pro_controle_estoque = \'1\' AND pro_estoque_atual > 0) OR pro_controle_estoque <> \'1\')', array($this->id));


        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $total = 0;
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "select count(*) total from categoria_cozinha where lower(cat_nome) like ?";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%"));
        } else {
            $resp = $crud->BuscaAtributos('count(*) total', 'categoria_cozinha');
        }

        if(!empty($resp) && !empty($resp[0]['total']))
            $total = $resp[0]['total'];

        return  ceil(($total));
    }

    public function listarPaginacao($filtro, $inicio, $fim, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "categoria_cozinha where lower(cat_nome) like ? order by cat_nome LIMIT ?, ?";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%", $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("categoria_cozinha order by cat_nome LIMIT ?, ?;", array($inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta('categoria_cozinha WHERE cat_id = ? LIMIT 1', array($this->id));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]['cat_nome']);
            $this->resumo = utf8_encode($resp[0]['cat_resumo']);
            $this->descricao = htmlspecialchars_decode(utf8_encode($resp[0]['cat_descricao']));
            $this->nome_imagem = utf8_encode($resp[0]['cat_img']);

            return true;
        }

        return false;
    }

    function verificarImagem($file) {
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

    private function salvarImagem($nome_file) {

        $tipo_principal = ".jpg";
        $parametro_principal = null;

        if (strcmp('image/jpeg',$this->file_imagem['type']) === 0) {
            $tipo_principal = ".jpg";
            $parametro_principal = 90;
        } elseif (strcmp('image/png',$this->file_imagem['type']) === 0) {
            $tipo_principal = ".png";
            $parametro_principal = 9;
        }

        $nome_principal = $nome_file . $tipo_principal;

        $image_principal = WideImage::loadFromFile($this->file_imagem['tmp_name']);

        $resized_principal = $image_principal->resize(640, 480, 'inside', 'down');
        $resized_principal->saveToFile('../img/categoria_cozinhas/'. $nome_principal, $parametro_principal);

        $resized_principal = $image_principal->resize(250, 188, 'inside','down');
        $resized_principal->saveToFile('../img/categoria_cozinhas/thumbs/' . $nome_principal, $parametro_principal);

        return $nome_principal;
    }

    private function excluirImagens($nome_img) {

        if (file_exists("../img/categoria_cozinhas/" . $nome_img))
            unlink("../img/categoria_cozinhas/" . $nome_img);

        if (file_exists("../img/categoria_cozinhas/thumbs/" . $nome_img))
            unlink("../img/categoria_cozinhas/thumbs/" . $nome_img);

    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select cat_status from categoria_cozinha where cat_id = ? LIMIT 1", array($this->id));

        if (!empty($resp) && !empty($resp[0]['cat_status']))
            $this->status = $resp[0]['cat_status'];

        if(!empty($this->status))
            $this->status = 0;
        else
            $this->status = 1;

        $resp = $crud->Altera('categoria_cozinha', array('cat_status'), array(utf8_decode($this->status)), 'cat_id', $this->id);

        return $resp;
    }

}