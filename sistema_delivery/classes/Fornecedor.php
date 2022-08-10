<?php
require_once 'admin/banco.php';
require_once 'admin/funcoes.php';
require_once 'Interfaceclasses.php';
require_once 'Endereco.php';

class Fornecedor implements Interfaceclasses
{
    private $id;
    private $nome;
    private $cnpj;
    private $razao;
    private $email;
    private $telefone;
    private $fone;
    private $fone2;
    private $obs;
    private $ativo;
    private $endereco;
    private $idEmpresa;
    private $crud;

    /**
     * Fornecedor constructor.
     * @param $nome
     * @param $cnpj
     * @param $razao
     * @param $email
     * @param $telefone
     * @param $fone
     * @param $fone2
     * @param $obs
     * @param $ativo
     */
    public function __construct($nome="", $cnpj="", $razao="", $email="", $telefone="", $fone="", $fone2="", $obs="", $ativo="")
    {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->razao = $razao;
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
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return string
     */
    public function getRazao()
    {
        return $this->razao;
    }

    /**
     * @param string $razao
     */
    public function setRazao($razao)
    {
        $this->razao = $razao;
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

    public function inserir()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $this->endereco->setCrud($this->crud);

        if ($this->endereco->inserir()) {

            $resp = $this->crud->Inserir("fornecedor",
                array("for_nome",
                    "for_email",
                    "for_telefone",
                    "for_celular",
                    "for_celular2",
                    "for_obs",
                    "for_ativo",
                    "for_cnpj",
                    "for_razao",
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
                    utf8_decode($this->cnpj),
                    utf8_decode($this->razao),
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
            $resp = $this->crud->AlteraCondicoes("fornecedor",
                array("for_nome",
                    "for_email",
                    "for_telefone",
                    "for_celular",
                    "for_celular2",
                    "for_obs",
                    "for_razao",
                    "for_cnpj",
                    "emp_id",
                    "end_id"
                ),
                array(utf8_decode($this->nome),
                    utf8_decode($this->email),
                    utf8_decode($this->telefone),
                    utf8_decode($this->fone),
                    utf8_decode($this->fone2),
                    utf8_decode($this->obs),
                    utf8_decode($this->razao),
                    utf8_decode($this->cnpj),
                    $this->idEmpresa,
                    $this->endereco->getId()
                ),
                "for_id = " . $this->id . " AND emp_id = " . $this->idEmpresa
            );
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function excluir()
    {
        $resp = false;
        $this->crud = new Crud(true);
        $cod_end = $this->crud->ConsultaGenerica("SELECT end_id FROM fornecedor WHERE for_id = ? AND emp_id = ? LIMIT 1", array($this->id, $this->idEmpresa));

        if  (!empty($cod_end)) {
            $resp = $this->crud->ExcluirCondicoes("fornecedor", "for_id = " . $this->id . " AND emp_id = " . $this->idEmpresa);

            if ($resp)
                $resp = $this->crud->Excluir("endereco", "end_id", $cod_end[0]["end_id"]);
        }

        $this->crud->executar($resp);
        return $resp;
    }

    public function listar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("fornecedor WHERE emp_id = ? AND for_ativo = '1' ORDER BY for_nome", array($this->idEmpresa));

        return $resp;
    }

    public function quantidadeRegistros($filtro, $chaves = "")
    {
        $crud = new Crud(FALSE);

        if(!empty($filtro)){
            $sql = "select count(*) total from fornecedor where (lower(for_nome) like ? OR lower(for_email) like ?) AND emp_id = ?";

            $resp = $crud->ConsultaGenerica($sql, array("%".strtolower(tiraacento($filtro))."%", "%".strtolower(tiraacento($filtro))."%", $this->idEmpresa));
        } else {
            $resp = $crud->ConsultaGenerica("SELECT count(*) total FROM fornecedor WHERE emp_id = ?", array($this->idEmpresa));
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
            $sql = "fornecedor where (lower(for_nome) like ? OR lower(for_email) like ?) AND emp_id = ? order by for_nome desc LIMIT ?, ?";
            $res = $crud->Consulta($sql, array("%".strtolower(tiraacento($filtro))."%","%".strtolower(tiraacento($filtro))."%", $this->idEmpresa, $inicio, $fim));
        }
        else {
            $res = $crud->Consulta("fornecedor WHERE emp_id = ? order by for_nome desc LIMIT ?, ?", array($this->idEmpresa, $inicio, $fim));
        }

        return $res;
    }

    public function carregar()
    {
        $crud = new Crud();
        $resp = $crud->Consulta("fornecedor WHERE for_id = ? AND emp_id = ?", array($this->id, $this->idEmpresa));

        if (!empty($resp)) {
            $this->nome = utf8_encode($resp[0]["for_nome"]);
            $this->email = utf8_encode($resp[0]["for_email"]);
            $this->telefone = utf8_encode($resp[0]["for_telefone"]);
            $this->fone = utf8_encode($resp[0]["for_celular"]);
            $this->fone2 = utf8_encode($resp[0]["for_celular2"]);
            $this->obs = utf8_encode($resp[0]["for_obs"]);
            $this->razao = utf8_encode($resp[0]["for_razao"]);
            $this->cnpj = utf8_encode($resp[0]["for_cnpj"]);
            $this->idEmpresa = utf8_encode($resp[0]["emp_id"]);
            $this->endereco->setId(utf8_encode($resp[0]["end_id"]));

            $this->endereco->carregar();

            return true;
        }

        return false;
    }

    public function modificaAtivo() {
        $crud = new Crud();
        $resp = $crud->ConsultaGenerica("select for_ativo from fornecedor where for_id = ?", array($this->id));
        foreach ($resp as $rs) {
            $this->ativo = $rs['for_ativo'];
        }
        /*Altera o status do banner, se estiver desabilitada, entao habilita, ou vice-versa*/
        if(!empty($this->ativo))
            $this->ativo = 0;
        else
            $this->ativo = 1;

        $resp = $crud->Altera('fornecedor', array('for_ativo'), array(utf8_decode($this->ativo)), 'for_id', $this->id);

        return $resp;
    }

}