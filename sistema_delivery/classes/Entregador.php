<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'Endereco.php';

class Entregador implements Interfaceclasses
{
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $fone;
    private $fone2;
    private $obs;
    private $ativo;
    private $endereco;
    private $idEmpresa;
    private $crud;

    public function __construct($nome="", $email="", $telefone="", $fone="", $fone2="", $obs="", $ativo="")
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->fone = $fone;
        $this->fone2 = $fone2;
        $this->obs = $obs;
        $this->ativo = $ativo;
        $this->endereco = new Endereco();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return string
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * @param string $fone
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
    }

    /**
     * @return string
     */
    public function getFone2()
    {
        return $this->fone2;
    }

    /**
     * @param string $fone2
     */
    public function setFone2($fone2)
    {
        $this->fone2 = $fone2;
    }

    /**
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param string $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
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

    public function inserir()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);

        if ($this->endereco->inserir()) {

            $resp = $this->crud->Inserir("entregador",
                array("ent_nome",
                    "ent_email",
                    "ent_telefone",
                    "ent_celular",
                    "ent_celular2",
                    "ent_obs",
                    "ent_ativo",
                    "emp_id",
                    "end_id"

                ),
                array(utf8_decode($this->nome),
                    utf8_decode($this->email),
                    utf8_decode($this->telefone),
                    utf8_decode($this->fone),
                    utf8_decode($this->fone2),
                    utf8_decode($this->obs),
                    $this->ativo,
                    $this->idEmpresa,
                    $this->endereco->getId()
                )
            );
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function alterar()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);

        if ($this->endereco->alterar()) {
            $resp = $this->crud->AlteraCondicoes("entregador",
                array("ent_nome",
                    "ent_email",
                    "ent_telefone",
                    "ent_celular",
                    "ent_celular2",
                    "ent_obs"
                ),
                array(utf8_decode($this->nome),
                    utf8_decode($this->email),
                    utf8_decode($this->telefone),
                    utf8_decode($this->fone),
                    utf8_decode($this->fone2),
                    utf8_decode($this->obs)
                ),
                "ent_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
            );
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        $crud = new Crud();
        $resp = $crud->ExcluirCondicoes("entregador", "ent_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

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
            $sql = "select count(*) total from entregador where (lower(ent_nome) like ? OR lower(ent_email) like ?) AND emp_id = ? ";

            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%", "%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM entregador where emp_id = ? ", array($this->idEmpresa));
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
            $sql = "entregador where (lower(ent_nome) like ? OR lower(ent_email) like ?) AND emp_id = ? order by ent_nome desc LIMIT ?, ?";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%", $this->idEmpresa, $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("entregador WHERE emp_id = ? order by ent_nome desc LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();

        $resp = $crud->Consulta("entregador WHERE ent_id = ? AND emp_id = ?", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["ent_nome"]);
            $this->email = utf8_encode($resp[0]["ent_email"]);
            $this->telefone = utf8_encode($resp[0]["ent_telefone"]);
            $this->fone = utf8_encode($resp[0]["ent_celular"]);
            $this->fone2 = utf8_encode($resp[0]["ent_celular2"]);
            $this->obs = utf8_encode($resp[0]["ent_obs"]);
            $this->endereco->setId(utf8_encode($resp[0]["end_id"]));

            $this->endereco->carregar();

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select ent_ativo from entregador where ent_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['ent_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('entregador', array('ent_ativo'), array(utf8_decode($this->ativo)), 'ent_id', $this->id);

        return $resp;
    }

}