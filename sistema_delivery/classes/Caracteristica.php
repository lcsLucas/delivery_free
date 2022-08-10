<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';

class Caracteristica implements Interfaceclasses
{

    private $id;
    private $nome;
    private $valor_adicional;
    private $ativo;
    private $idEmpresa;
    private $idTipo;

    /**
     * Caracteristica constructor.
     * @param $nome
     * @param $valor_adicional
     * @param $ativo
     * @param $idEmpresa
     * @param $idTipo
     */
    public function __construct($nome="", $valor_adicional="", $ativo="", $idEmpresa="", $idTipo="")
    {
        $this->nome = $nome;
        $this->valor_adicional = $valor_adicional;
        $this->ativo = $ativo;
        $this->idEmpresa = $idEmpresa;
        $this->idTipo = $idTipo;
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
    public function getValorAdicional()
    {
        return $this->valor_adicional;
    }

    /**
     * @param string $valor_adicional
     */
    public function setValorAdicional($valor_adicional)
    {
        $this->valor_adicional = $valor_adicional;
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
     * @return string
     */
    public function getIdTipo()
    {
        return $this->idTipo;
    }

    /**
     * @param string $idTipo
     */
    public function setIdTipo($idTipo)
    {
        $this->idTipo = $idTipo;
    }

    public function inserir()
    {
        $crud = new Crud();
        $resp = $crud->Inserir("caracteristica", array("car_nome",
                                                              "car_valor",
                                                              "car_ativo",
                                                              "tip_id",
                                                              "emp_id"
                                                            ),
                                                            array(utf8_decode($this->nome),
                                                                  utf8_decode($this->valor_adicional),
                                                                  $this->ativo,
                                                                  $this->idTipo,
                                                                  $this->idEmpresa
                                                                )
        );

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes("caracteristica", array("car_nome",
            "car_valor",
            "tip_id"
        ),
            array(utf8_decode($this->nome),
                utf8_decode($this->valor_adicional),
                $this->idTipo
            ),
            "car_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
        );

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->Excluir("caracteristica", "car_id", $this->id);

        return $resp;
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "SELECT COUNT(*) total FROM caracteristica c INNER JOIN tipo_caracteristicas tc ON c.tip_id = tc.tip_id where (lower(car_nome) like ? OR lower(tip_nome) like ?) AND c.emp_id = ? ";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM caracteristica c INNER JOIN tipo_caracteristicas tc ON c.tip_id = tc.tip_id WHERE c.emp_id = ?", array($this->idEmpresa));
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
            $sql = "SELECT c.car_id, c.car_nome, tc.tip_nome, car_ativo FROM caracteristica c INNER JOIN tipo_caracteristicas tc ON c.tip_id = tc.tip_id where (lower(car_nome) like ? OR lower(tip_nome) like ?) AND c.emp_id = ? order by c.car_nome LIMIT ?, ?";
            $res = $crud->ConsultaGenerica($sql, array("%" . strtolower(tiraacento($filtro)) . "%", "%" . strtolower(tiraacento($filtro)) . "%", $this->idEmpresa, $inicio, $fim));
        } else {
            $res = $crud->ConsultaGenerica("SELECT c.car_id, c.car_nome, tc.tip_nome, car_ativo FROM caracteristica c INNER JOIN tipo_caracteristicas tc ON c.tip_id = tc.tip_id WHERE c.emp_id = ? order by c.car_nome LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {

        $crud = new Crud();
        $resp = $crud->Consulta("caracteristica WHERE car_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["car_nome"]);
            $this->valor_adicional = number_format($resp[0]["car_valor"], 2, ",", ".") ;
            $this->ativo = $resp[0]["car_ativo"];
            $this->idTipo = $resp[0]["tip_id"];

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select car_ativo from caracteristica where car_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['car_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('caracteristica', array('car_ativo'), array(utf8_decode($this->ativo)), 'car_id', $this->id);

        return $resp;
    }

}