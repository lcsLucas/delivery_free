<?php


class BaixaInsumo implements Interfaceclasses
{
    private $id;
    private $data_criacao;
    private $insumo;
    private $motivo;
    private $qtde;
    private $idEmpresa;
    private $retorno;

    /**
     * BaixaInsumo constructor.
     * @param $data_criacao
     * @param $insumo
     * @param $motivo
     * @param $qtde
     * @param $idEmpresa
     */
    public function __construct($data_criacao="", $qtde="", $idEmpresa="")
    {
        $this->data_criacao = !empty($data_criacao) ? $data_criacao : date("Y-m-d");
        $this->insumo = new Insumo();
        $this->motivo = new MotivoUso();
        $this->qtde = $qtde;
        $this->idEmpresa = $idEmpresa;
        $this->retorno = "";
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
    public function getInsumo()
    {
        return $this->insumo;
    }

    /**
     * @param string $insumo
     */
    public function setInsumo($insumo)
    {
        $this->insumo = $insumo;
    }

    /**
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param string $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    /**
     * @return string
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * @param string $qtde
     */
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
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
    public function getRetorno()
    {
        return $this->retorno;
    }

    public function inserir()
    {
        // TODO: Implement inserir() method.
    }

    public function alterar()
    {
        // TODO: Implement alterar() method.
    }

    public function excluir()
    {
        // TODO: Implement excluir() method.
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "SELECT count(*) total FROM baixa_uso bu INNER JOIN motivo_uso mu ON bu.mot_id = mu.mot_id INNER JOIN insumo i ON bu.ins_id = i.ins_id where (lower(ins_nome) like ? OR lower(mot_nome) like ?) AND i.emp_id = ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM baixa_uso bu INNER JOIN motivo_uso mu ON bu.mot_id = mu.mot_id INNER JOIN insumo i ON bu.ins_id = i.ins_id WHERE bu.emp_id = ?", array($this->idEmpresa));
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
            $sql = "SELECT bai_dtCad, bai_qtde, ins_nome, mot_nome FROM baixa_uso bu INNER JOIN motivo_uso mu ON bu.mot_id = mu.mot_id INNER JOIN insumo i ON bu.ins_id = i.ins_id where (lower(ins_nome) like ? OR lower(mot_nome) like ?) AND i.emp_id = ? order by bu.bai_id desc LIMIT ?, ?";
            $res = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa, $inicio, $fim));
        } else {
            $res = $crud->ConsultaGenerica("SELECT bai_dtCad, bai_qtde, ins_nome, mot_nome FROM baixa_uso bu INNER JOIN motivo_uso mu ON bu.mot_id = mu.mot_id INNER JOIN insumo i ON bu.ins_id = i.ins_id WHERE bu.emp_id = ? order by bu.bai_id desc LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        // TODO: Implement carregar() method.
    }

    public function darBaixaInsumo() {
        $crud = new Crud(true);
        $resp = $crud->ConsultaGenerica("SELECT ins_estoque_atual, ins_controle_estoque FROM insumo WHERE ins_id = ? AND emp_id = ? LIMIT 1", array($this->insumo->getId(), $this->idEmpresa));

        if (!empty($resp)) {

            if (!empty($resp[0]["ins_controle_estoque"])) {

                $qtde = floatval($resp[0]["ins_estoque_atual"]);

                if (floatval($this->qtde) <= floatval($qtde)) {

                    $resp = $crud->Inserir("baixa_uso",
                                                            array("bai_dtCad",
                                                                  "bai_qtde",
                                                                  "mot_id",
                                                                  "ins_id",
                                                                  "emp_id"
                                                            ),
                                                            array($this->data_criacao,
                                                                  $this->qtde,
                                                                  $this->motivo->getId(),
                                                                  $this->insumo->getId(),
                                                                  $this->idEmpresa
                                                                )
                    );

                    if (!empty($resp)) {

                        $resultado = $qtde - floatval($this->qtde);
                        $resp = $crud->AlteraCondicoes("insumo", array("ins_estoque_atual"), array($resultado), "ins_id = " . $this->insumo->getId() . " AND emp_id = " . $this->idEmpresa);

                    }

                } else {
                    $resp = false;
                    $this->retorno = "Quantidade informada { ". number_format($this->qtde,2,",",",") ." } é maior que a quantidade em estoque { ". number_format($qtde,2,",",",") ." }";
                }

            } else {
                $resp = false;
                $this->retorno = "Esse insumo não tem controle de estoque";
            }

        }

        $crud->executar($resp);
        return $resp;
    }

}