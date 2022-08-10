<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class CategoriaProdutos implements Interfaceclasses
{
    private $id;
    private $nome;
    private $descricao;
    private $ativo;
    private $idEmpresa;
    private $complementos;

    /**
     * CategoriaProdutos constructor.
     * @param $nome
     * @param $descricao
     * @param $ativo
     * @param $idEmpresa
     */
    public function __construct($nome="", $descricao="", $ativo="", $idEmpresa="")
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->ativo = $ativo;
        $this->idEmpresa = $idEmpresa;
        $this->complementos = array();
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
     * @param mixed $idCategoria
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
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

    public function inserir()
    {
        $crud = new Crud();
        $resp = $crud->Inserir("categoria_produtos",
            array("cat_nome",
                  "cat_descricao",
                  "cat_ativo",
                  "emp_id"
                ),
            array(utf8_decode($this->nome),
                utf8_decode($this->descricao),
                  $this->ativo,
                  $this->idEmpresa
            )
        );

        if ($resp && !empty($this->complementos)) {
        	$this->id = $crud->getUltimoCodigo();
            $complementos = $this->complementos;
            $total = count($complementos);
            $i = 0;

            while ($i < $total && $resp) {

                $resp = $crud->Inserir('categoria_complementos',
                    array(
                        'catcom_nome',
                        'catcom_obrigatorio',
                        'catcom_qtdemin',
                        'catcom_qtdemax',
                        'cat_pro_id',
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
                            $preco = filter_var(str_replace(",", ".", $preco), FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

                            $resp = $crud->Inserir('categoria_tem_complementos',
                                array(
                                    'cat_id',
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

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes("categoria_produtos", array(
            "cat_nome", "cat_descricao"),
            array(utf8_decode($this->nome), utf8_decode($this->descricao)),
            "cat_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        if ($resp)
            $resp = $crud->ExcluirCondicoes('categoria_complementos', 'cat_pro_id = ' . $this->id . ' AND emp_id = ' . $this->idEmpresa);

        if ($resp && !empty($this->complementos)) {
            $complementos = $this->complementos;
            $total = count($complementos);
            $i = 0;

            while ($i < $total && $resp) {

                $resp = $crud->Inserir('categoria_complementos',
                    array(
                        'catcom_nome',
                        'catcom_obrigatorio',
                        'catcom_qtdemin',
                        'catcom_qtdemax',
                        'cat_pro_id',
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
                            $preco = filter_var(str_replace(",", ".", $preco), FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

                            $resp = $crud->Inserir('categoria_tem_complementos',
                                array(
                                    'cat_id',
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

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("categoria_produtos", "cat_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("categoria_produtos WHERE emp_id = ? ORDER BY cat_nome", array($this->idEmpresa));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "select count(*) total from categoria_produtos where lower(ins_nome) like ? AND emp_id = ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%"), $this->idEmpresa);
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM categoria_produtos WHERE emp_id = ?", array($this->idEmpresa));
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
        $crud = new Crud();

        if(!empty($filtro)){
            $sql = "categoria_produtos where lower(cat_nome) like ? AND emp_id = ? order by cat_nome LIMIT ?, ?;";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%", $this->idEmpresa, $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("categoria_produtos WHERE emp_id = ? order by cat_nome LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("categoria_produtos WHERE cat_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["cat_nome"]);
            $this->descricao = html_entity_decode(utf8_encode($resp[0]["cat_descricao"]));
            $this->ativo = $resp[0]["cat_ativo"];

            if ($resp) {

                $resp_comp = $crud->Consulta('categoria_complementos WHERE cat_pro_id = ? AND emp_id = ? ORDER BY catcom_obrigatorio DESC', array($this->id, $this->idEmpresa));

                if (!empty($resp_comp)) {

                    foreach ($resp_comp as $i => $comp) {

                        $resp_opcoes = $crud->Consulta('categoria_tem_complementos WHERE cat_id = ? AND catcom_id = ?', array($this->id, $comp['catcom_id']));

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

    public function carregar_complementos() {
        $crud = new Crud();

        $resp_comp = $crud->Consulta('categoria_complementos WHERE cat_pro_id = ? AND emp_id = ? ORDER BY catcom_obrigatorio DESC', array($this->id, $this->idEmpresa));

        if (!empty($resp_comp)) {

            foreach ($resp_comp as $i => $comp) {

                $resp_opcoes = $crud->Consulta('categoria_tem_complementos WHERE cat_id = ? AND catcom_id = ?', array($this->id, $comp['catcom_id']));

                if (!empty($resp_opcoes)) {
                    $comp['opcoes'] = $resp_opcoes;
                    $resp_comp[$i] = $comp;
                }

            }

        }

        return $resp_comp;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select cat_ativo from categoria_produtos where cat_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['cat_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('categoria_produtos', array('cat_ativo'), array(utf8_decode($this->ativo)), 'cat_id', $this->id);

        return $resp;
    }

}