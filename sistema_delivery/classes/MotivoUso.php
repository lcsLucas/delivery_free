<?php
/**
 * Created by PhpStorm.
 * User: it6
 * Date: 03/09/2018
 * Time: 13:20
 */

class MotivoUso implements Interfaceclasses
{
    private $id;
    private $nome;
    private $idEmpresa;

    /**
     * MotivoUso constructor.
     * @param $nome
     * @param $idEmpresa
     */
    public function __construct($nome="", $idEmpresa="")
    {
        $this->nome = $nome;
        $this->idEmpresa = $idEmpresa;
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

    public function inserir()
    {
        $crud = new Crud();
        $resp = $crud->Inserir("motivo_uso",
                                                    array(
                                                        "mot_nome",
                                                        "emp_id"
                                                    ),
                                                    array(
                                                        utf8_decode($this->nome),
                                                        $this->idEmpresa
                                                    )
        );

        return $resp;
    }

    public function alterar()
    {
        $crud = new Crud();
        $resp = $crud->AlteraCondicoes("motivo_uso",
            array(
                "mot_nome",
                "emp_id"
            ),
            array(
                utf8_decode($this->nome),
                $this->idEmpresa
            ),
        "mot_id = ". $this->id ." AND emp_id = " . $this->idEmpresa
        );

        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("motivo_uso", "mot_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("motivo_uso WHERE emp_id = ?", array($this->idEmpresa));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "select count(*) total from motivo_uso where lower(mot_nome) like ? AND emp_id = ?";
            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM motivo_uso WHERE emp_id = ?", array($this->idEmpresa));
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
            $sql = "motivo_uso where lower(mot_nome) like ? AND emp_id = ? order by mot_id LIMIT ?, ?;";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%", $this->idEmpresa, $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("motivo_uso WHERE emp_id = ? order by mot_id LIMIT ?, ?;", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("motivo_uso WHERE mot_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["mot_nome"]);

            return true;
        }

        return false;
    }


}