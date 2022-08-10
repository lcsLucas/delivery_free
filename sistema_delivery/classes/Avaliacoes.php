<?php
	require_once 'admin/banco.php';
	require_once 'admin/funcoes.php';
	require_once 'Interfaceclasses.php';

    class Avaliacoes
    {
        private $id;
        private $data_criacao;
        private $idEmpresa;
        private $cliente;
        private $saida;
        private $classificao;
        private $obs;
        private $data_resposta;
        private $resposta;

        /**
         * Avaliacoes constructor.
         * @param $cliente
         * @param $saida
         */
        public function __construct($cliente=null, $saida=null, $classificao = null, $obs = null)
        {
            $this->data_criacao = date('Y-m-d H:i:s');
            $this->cliente = $cliente;
            $this->saida = $saida;
            $this->classificao = $classificao;
            $this->obs = $obs;
            $this->data_resposta = date('Y-m-d H:i:s');
            $this->resposta = '';
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
        public function getCliente()
        {
            return $this->cliente;
        }

        /**
         * @param null $cliente
         */
        public function setCliente($cliente)
        {
            $this->cliente = $cliente;
        }

        /**
         * @return null
         */
        public function getSaida()
        {
            return $this->saida;
        }

        /**
         * @param null $saida
         */
        public function setSaida($saida)
        {
            $this->saida = $saida;
        }

        /**
         * @return null
         */
        public function getClassificao()
        {
            return $this->classificao;
        }

        /**
         * @param null $classificao
         */
        public function setClassificao($classificao)
        {
            $this->classificao = $classificao;
        }

        /**
         * @return null
         */
        public function getObs()
        {
            return $this->obs;
        }

        /**
         * @param null $obs
         */
        public function setObs($obs)
        {
            $this->obs = $obs;
        }

        /**
         * @return false|string
         */
        public function getDataResposta()
        {
            return $this->data_resposta;
        }

        /**
         * @param false|string $data_resposta
         */
        public function setDataResposta($data_resposta)
        {
            $this->data_resposta = $data_resposta;
        }

        /**
         * @return string
         */
        public function getResposta()
        {
            return $this->resposta;
        }

        /**
         * @param string $resposta
         */
        public function setResposta($resposta)
        {
            $this->resposta = $resposta;
        }

        public function recuperaAvaliacoes() {
            $crud = new Crud();
            $retorno = array();
            $resp = $crud->ConsultaGenerica('SELECT s.idsaida, s.data_criacao, s.total_geral, e.emp_nome, a.classificacao, a.obs FROM saida s INNER JOIN empresa e ON s.emp_id = e.emp_id INNER JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE s.cli_id = ? ORDER BY s.idsaida DESC', array($this->cliente));

            if (!empty($resp))
                $retorno['avaliados'] = $resp;

            $resp = $crud->ConsultaGenerica('SELECT s.idsaida, s.data_criacao, s.total_geral, e.emp_nome FROM saida s INNER JOIN empresa e ON s.emp_id = e.emp_id LEFT JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE s.cli_id = ? AND a.idsaida IS NULL AND s.entrega_id IS NOT NULL ORDER BY s.idsaida DESC', array($this->cliente));

            if (!empty($resp))
                $retorno['naoavaliados'] = $resp;

            return $retorno;
        }

        public function recuperarAvaliacoesEmpresa() {
            $crud = new Crud();
            $retorno = array();
            $resp = $crud->ConsultaGenerica('SELECT s.idsaida, a.idavaliacoes, s.data_criacao, s.total_geral, c.cli_nome, a.classificacao, a.obs, a.data_resposta, a.resposta FROM saida s INNER JOIN cliente c ON s.cli_id = c.cli_id INNER JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE s.emp_id = ? AND a.data_resposta IS NOT NULL ORDER BY a.idavaliacoes DESC', array($this->idEmpresa));

            if (!empty($resp))
                $retorno['respondidos'] = $resp;

            $resp = $crud->ConsultaGenerica('SELECT s.idsaida, a.idavaliacoes, s.data_criacao, s.total_geral, c.cli_nome, a.classificacao, a.obs FROM saida s INNER JOIN cliente c ON s.cli_id = c.cli_id INNER JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE s.emp_id = ? AND a.data_resposta IS NULL ORDER BY a.idavaliacoes DESC', array($this->idEmpresa));

            if (!empty($resp))
                $retorno['naorespondidos'] = $resp;

            return $retorno;
        }

        public function inserir() {
            $crud = new Crud();
            $resp = $crud->Inserir('avaliacoes', array('data_criacao', 'idsaida', 'cli_id', 'classificacao', 'obs'), array($this->data_criacao, $this->saida, $this->cliente, $this->classificao, utf8_decode($this->obs)));

            return $resp;
        }

        public function responderAvaliacao() {
            $crud = new Crud();
            $resp = $crud->Altera('avaliacoes', array('data_resposta', 'resposta', 'idusuarios'), array($this->data_resposta, utf8_decode($this->resposta), $_SESSION['_idusuario']), 'idavaliacoes', $this->id);

            return $resp;
        }

        public function recuperarAvaliacoesRespondidas() {
            $crud = new Crud();
            $resp = $crud->ConsultaGenerica('SELECT s.idsaida, a.idavaliacoes, a.data_criacao, s.total_geral, c.cli_nome, a.classificacao, a.obs, a.data_resposta, a.resposta FROM saida s INNER JOIN cliente c ON s.cli_id = c.cli_id INNER JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE s.emp_id = ? AND a.data_resposta IS NOT NULL ORDER BY a.idavaliacoes DESC', array($this->idEmpresa));

            return $resp;
        }

        public function listarRelatorio($periodo1, $periodo2) {
			$crud = new Crud();
			$resp = $crud->ConsultaGenerica('SELECT s.idsaida, a.idavaliacoes, s.data_criacao, s.total_geral, c.cli_nome, a.classificacao, a.obs FROM saida s INNER JOIN cliente c ON s.cli_id = c.cli_id INNER JOIN avaliacoes a ON s.idsaida = a.idsaida WHERE s.emp_id = ? ORDER BY s.idsaida DESC', array($this->idEmpresa));

			return $resp;
		}

    }