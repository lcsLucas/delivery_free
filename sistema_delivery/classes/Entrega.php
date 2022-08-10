<?php


class Entrega
{
    private $id;
    private $data_criacao;
    private $entregador;
    private $pedidos;
    private $idEmpresa;
    private $status;
    private $enderecos;
    private $crud;

    /**
     * Entrega constructor.
     * @param $entregador
     * @param $pedidos
     * @param $status
     * @param $enderecos
     */
    public function __construct($entregador = null, $pedidos = null, $status = null, $enderecos = null)
    {
        $this->entregador = $entregador;
        $this->pedidos = $pedidos;
        $this->status = $status;
        $this->enderecos = $enderecos;
        $this->data_criacao = date('Y-m-d H:i:s');
        $this->crud = null;
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
     * @return null
     */
    public function getEntregador()
    {
        return $this->entregador;
    }

    /**
     * @param null $entregador
     */
    public function setEntregador($entregador)
    {
        $this->entregador = $entregador;
    }

    /**
     * @return null
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * @param null $pedidos
     */
    public function setPedidos($pedidos)
    {
        $this->pedidos = $pedidos;
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
     * @return null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    /**
     * @param null $enderecos
     */
    public function setEnderecos($enderecos)
    {
        $this->enderecos = $enderecos;
    }

	/**
	 * @return null
	 */
	public function getCrud()
	{
		return $this->crud;
	}

	/**
	 * @param null $crud
	 */
	public function setCrud($crud)
	{
		$this->crud = $crud;
	}

    public function inserir() {
        $crud = new Crud(true);
        $retorno = false;

        $resp_enderecos = $crud->BuscaGenerica('SELECT end_rua, end_numero, end_cep, end_bairro, cid_nome, et.est_sigla FROM endereco e INNER JOIN cidade c ON e.cid_id = c.cid_id INNER JOIN estado et ON c.est_sigla = et.est_sigla INNER JOIN saida s ON s.endereco_id = e.end_id WHERE s.emp_id = '. $this->idEmpresa .' AND s.idsaida IN ('. implode(',', $this->pedidos) .')');

        if (!empty($resp_enderecos)) {

            $resp = $crud->Inserir('entrega', array('ent_dtCad', 'entregador_id', 'emp_id'), array($this->data_criacao, $this->entregador, $this->idEmpresa));

            if ($resp) {

                $this->id = $crud->getUltimoCodigo();

                $i = 0;
                $total = count($this->pedidos);

                while ($i < $total && $resp) {
                    $resp = $crud->AlteraCondicoes('saida', array('entrega_id'), array($this->id), 'emp_id = ' . $this->idEmpresa . ' AND idsaida = ' . $this->pedidos[$i]);
                    $i++;
                }

                if ($resp) {

                    $j = 0;
                    $total2 = count($resp_enderecos);

                    while ($j < $total2 && $resp) {
                        $resp = $crud->Inserir('entrega_enderecos',
                            array(
                                'rua',
                                'numero',
                                'cep',
                                'bairro',
                                'cidade',
                                'estado',
                                'ent_id'
                            ),
                            array(
                                $resp_enderecos[$j]['end_rua'],
                                $resp_enderecos[$j]['end_numero'],
                                $resp_enderecos[$j]['end_cep'],
                                $resp_enderecos[$j]['end_bairro'],
                                $resp_enderecos[$j]['cid_nome'],
                                $resp_enderecos[$j]['est_sigla'],
                                $this->id
                            )
                        );

                        $j++;
                    }

                }

            }

        }

        if (!empty($resp))
            $retorno = $resp;


        $crud->executar($retorno);
        return $retorno;
    }

    public function finalizarEntregas() {
		$this->crud = new Crud(true);
		$saida = new Saida();
		$saida->setCrud($this->crud);

        $i = 0;
        $total = count($this->pedidos);

        do
        {

            $resp = $this->crud->AlteraCondicoes('entrega', array('ent_status'), array('1'), 'ent_id = ' . $this->pedidos[$i]);

			if ($resp) {
				$saida->setEntrega($this->pedidos[$i]);
				$resp = $saida->gerarContasReceber();
			}

            $i++;

        } while($i < $total && $resp);


		$this->crud->executar($resp);
        return $resp;
    }

}