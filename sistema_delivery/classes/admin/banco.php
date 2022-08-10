<?php
/** 
Classe de conexao e core do sistema
localhost: manter o atributo mostraerro TRUE
ar: manter o atributo mostraerro sempre FALSE
*/
class Crud {


    var $servidor = "localhost";
    var $usuario = "root";
    var $senha = "";
    var $bd = "ban_delivery";
    var $link = "";

/*
    var $servidor = "localhost";
    var $usuario = "it6ti_usudeliver";
    var $senha = "it6ti2018delivery";
    var $bd = "it6ti_delivery";
    var $link = "";
*/
    var $mostraerro = true;
    private $ultimoCodigo;
    
    /**
    Construtor da classe instancia a classe
    OBS: infelizmente o metodo de translaÃ§Ã£o nÃ£o funciona no ar entÃ£o ele estÃ¡ desativado no momento
    */
    function __construct($transaction = false) {
        $this->conecta();
        if($transaction == TRUE){
            if(!$this->abre_transacao()) {
                printf("Falha ao se conectar com o banco de dados (Open Transaction): %s\n", mysqli_connect_error());
                exit();
            }
        }
        $ultimoCodigo = 0;
    }
    
    function getUltimoCodigo() {
        return $this->ultimoCodigo;
    }

    /**
    Executar metodo de transaction
    */
    private function abre_transacao() {
      $ok = mysqli_begin_transaction($this->link);  
      mysqli_autocommit($this->link, FALSE);
      
      return $ok;
    }
    
    
    function executar($transaction){
        if($transaction == true){
            mysqli_commit($this->link);
        }else{
            mysqli_rollback($this->link);
        }
    }
    
    /**
    Abre a conexÃ£o com o banco de dados
    */
    function conecta(){
        $this->link = new mysqli($this->servidor,$this->usuario,$this->senha,$this->bd);

        if (mysqli_connect_errno()) {
            printf("Falha ao se conectar com o banco de dados: %s\n", mysqli_connect_error());
            exit();
        }
    }
    
    /**
    funÃ§Ã£o retornar o resultado
    */
    function get_result( $Statement ) {
        $RESULT = array();
        $Statement->store_result();
        for ( $i = 0; $i < $Statement->num_rows; $i++ ) {
            $Metadata = $Statement->result_metadata();
            $PARAMS = array();
            while ( $Field = $Metadata->fetch_field() ) {
                $PARAMS[] = &$RESULT[ $i ][ $Field->name ];
            }
            call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );
            $Statement->fetch();
        }
        return $RESULT;
    }
    
    /**
    funÃ§Ã£o type retorna o tipo do valor inserido
    */
    function type($args = [], $bind = false){
        # Essa funÃ§Ã£o retorna o codigo para o valor 
        # Se o $bind for igual a true, ela vai retornar os simbolos
        $type = $binds = "";    
        $i = 1;
        if(($args) != ""){
            foreach($args as $valor){
                switch(gettype($valor)){
                    case 'integer':
                        $type .= 'i';
                        break;
                    case 'double':
                        $type .= 'd';
                        break;
                    case 'string':
                        /*if (array_search($valor, $args) == 'fd_imagem') {
                            $type .= 'b';
                        } else { */
                            $type .= 's';
                        //}
                        break;
                    default:
                        $type .= 's';
                        break;  
                }   
                $binds .= "?";
                if($i < count($args)){
                    $binds .= ", ";     
                }
                $i++;
            }
        }
        if($bind){
            return $binds;  
        }
        return $type;
    }

    /**
    funÃ§Ã£o parametros retorna os valores inseridos
    */
    function parametros($args=[], $sec=false){
        # Essa funÃ§Ã£o retorna os parametros jÃ¡ referenciados
        # Se a variavel $sec for igual a true, ela vai retornar  os campos separados por vÃ­rgulas   
        $type = $this->type($args);    
        $parametro[] = &$type;
        if(($args) != ""){
            foreach($args as $key=>$valor){
                $parametro[] =& $args[$key];    
            }   
        }
        if($sec){
            $campos = implode(', ', array_keys($args)); 
            return $campos; 
        }
        return $parametro;
    }

    /**
    funÃ§Ã£o tratar retorna os atributos da query inserida
    */
    function tratar($atributos){
        $tamanho = count($atributos);
        $str = "";
        for ($i = 0; $i < $tamanho; $i++) {
                $str .= $atributos[$i];
                if ($i < $tamanho - 1) {
                    $str .= ",";
                }
        }
        return $str;
    }

    /**
    funÃ§Ã£o retornacondicao faz a troca da query enviada para o tratamento usando ? para preparo da query
    */
    function retornacondicao($condicao){
        $result = explode("and",strtolower($condicao));
        $contador = count($result);

        $sql = "";
        for($i=0; $i < $contador; $i++){
            $result2 = explode("=",$result[$i]);

            if($contador-1 == $i){
                $sql .= "$result2[0] = ?  ";
            }else{
                $sql .= "$result2[0] = ? and";
            }
        }

        return $sql;
    }

    /**
    funÃ§Ã£o retornavalores pega os valores da query e transforma em uma array para envio nos parametros de troca
    */
    function retornavalores($condicao){
        $result = explode("and",strtolower($condicao));
        $contador = count($result);

        $array = array();

            for($i=0; $i < $contador; $i++){
                $result2 = explode("=",$result[$i]);

                $array[] = $result2[1];
            }

        return $array;
    }
    
    /**
    Inserir passa a tabela os atributos e os valores ele jÃ¡ faz todos os tratamentos nescessarios para o prepare da query
    */
    function Inserir($tabela, $atributos, $valores) {
        
        $campos = $this->tratar($atributos); # tratar os atributos
        $binds = $this->type($valores, TRUE); # aqui passo os simbolos (?) para a consulta
        
        $sql = "INSERT INTO {$tabela} ({$campos}) VALUES ({$binds})";
        
        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //print "Cadastrado com sucesso"; exit;
                    $this->ultimoCodigo = mysqli_insert_id($this->link);
                    return TRUE;
                }
                var_dump($prepare);
            } else {
                if($this->mostraerro == TRUE){
                    die("Erro (execute): " . $this->link->error); exit;
                }
                return FALSE;
            }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }
    
    /**
    Altera passa a tabela os atributos e os valores e condiÃ§Ã£o e atributo da condiÃ§Ã£o ele jÃ¡ faz todos os tratamentos nescessarios para o prepare da query
    */
    function Altera($tabela, $atributos, $valores, $condicao, $atributo) {
        
        $valores[] = $atributo;
        $tamanho = count($atributos);
        $sql = "UPDATE {$tabela}  set ";
        
        for ($i = 0; $i < $tamanho; $i++) {
            $sql .= $atributos[$i] . " = ? ";
            /*if($valores[$i] != NULL){
                $sql .= $atributos[$i] . " = ? ";
            }*/
            if ($i < $tamanho - 1) {
                $sql .= ",";
            }
        }
        
        $sql .= " WHERE $condicao = ?";
        
        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //print "Cadastrado com sucesso"; exit;
                    return TRUE;
                }
            } else {
                if($this->mostraerro == TRUE){
                    die("Erro (execute): " . $this->link->error); exit;
                }
                return FALSE;
            }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }        
        if($this->mostraerro == TRUE){
            die("Erro: (prepare)" . $this->link->error); exit;
        }        
    }
    
    /**
    AlteraCondicoes passa a tabela os atributos e os valores e condiÃ§Ã£o, ele jÃ¡ faz todos os tratamentos nescessarios para o prepare da query
    */
    function AlteraCondicoes($tabela, $atributos, $valores, $condicao) {
        
        $condicao2 = $this->retornacondicao($condicao);
        $valores2 = $this->retornavalores($condicao);
        
        $valores = array_merge($valores,$valores2);
        $tamanho = count($atributos);
        $sql = "UPDATE {$tabela}  set ";
        
        for ($i = 0; $i < $tamanho; $i++) {
            $sql .= $atributos[$i] . " = ? ";
            /*if($valores[$i] != NULL){
                $sql .= $atributos[$i] . " = ? ";
            }*/
            if ($i < $tamanho - 1) {
                $sql .= ",";
            }
        }
        
        $sql .= " WHERE $condicao2";

        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //print "Cadastrado com sucesso"; exit;
                    return TRUE;
                }
            } else {
                if($this->mostraerro == TRUE){
                    die("Erro (execute): " . $this->link->error); exit;
                }
                return FALSE;
            }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }
    
    /**
    Excluir passa a tabela os atributos e os valores e condiÃ§Ã£o, ele jÃ¡ faz todos os tratamentos nescessarios para o prepare da query
    */
    function Excluir($tabela, $atributos, $condicao) {
        
        $valores[] = $condicao;
        $sql = "DELETE FROM $tabela WHERE $atributos = ?";

        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //print "Cadastrado com sucesso"; exit;
                    return TRUE;
                }
            } else {
                if($this->mostraerro == TRUE){
                    die("Erro (execute): " . $this->link->error); exit;
                }
                return FALSE;
            }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }
    
    /**
    Excluir passa a tabela e a condiÃ§Ã£o, ele jÃ¡ faz todos os tratamentos nescessarios para o prepare da query
    */
    function ExcluirCondicoes($tabela, $condicao) {
        
        $condicao2 = $this->retornacondicao($condicao);
        $valores = $this->retornavalores($condicao);
        
        $sql = "DELETE FROM $tabela WHERE $condicao2";
        
        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //print "Cadastrado com sucesso"; exit;
                    return TRUE;
                }
            } else {
                if($this->mostraerro == TRUE){
                    die("Erro (execute): " . $this->link->error); exit;
                }
                return FALSE;
            }
        } else {
             die("Erro: (prepare)" . $this->link->error); exit;   
             return FALSE;
        }
        
    }
    
    
    function comandoGenerico($sql) {        
        if($prepare = $this->link->prepare($sql)){
                if($prepare->execute()){
                    //print "Cadastrado com sucesso"; exit;
                    return TRUE;
                } else {
                    return FALSE;
                }
        } else {
             die("Erro: (prepare)" . $this->link->error); exit;   
             return FALSE;
        }        
    }
    
    /**
    Busca uma busca rapida de um tabela nÃ£o use passando parametros
    */
    function Busca($tabela) {
        
        $sql = "select * from ".$tabela;
        if($prepare = $this->link->prepare($sql)){
                if($prepare->execute()){
                    $result = $this->get_result($prepare);
                    if(!empty($result)){
                        return  ($result);
                    }else{
                        return NULL;
                    }
                }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit; 
             }
             return FALSE;
        }
    }
    
    /**
    BuscaAtributos parametros uma busca rapida de um tabela nÃ£o use passando parametros
    */
    function BuscaAtributos($atributos,$tabela) {
        
        $sql = "select $atributos from " .($tabela);
        
        if($prepare = $this->link->prepare($sql)){
            //if(call_user_func_array(array($prepare, "bind_param"), parametros($valores))){
                if($prepare->execute()){
                    //$prepare->bind_result($result);
                    /* fetch value */
                    $result = $this->get_result($prepare);
                    if(!empty($result)){
                        return  ($result);
                    }else{
                        return NULL;
                    }
                }
            //} else {
                //die("Erro (execute): " . $this->link->error); exit;
              //  return FALSE;
            //}
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }
    
    /**
    BuscaAtributos parametros uma busca rapida de um tabela nÃ£o use passando parametros a nÃ£o ser que sejam fixos
    */
    function BuscaGenerica($sql){
        
        $sql = ($sql);
        
        if($prepare = $this->link->prepare($sql)){
            //if(call_user_func_array(array($prepare, "bind_param"), parametros($valores))){
                if($prepare->execute()){
                    //$prepare->bind_result($result);
                    /* fetch value */
                    $result = $this->get_result($prepare);
                    if(!empty($result)){
                        return  ($result);
                    }else{
                        return NULL;
                    }
                }
            //} else {
                //die("Erro (execute): " . $this->link->error); exit;
              //  return FALSE;
            //}
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }
    
    /*
    novo metodo mais seguro passe o seu SQL completo e os valores a serem substituidos
    */
    public function Consulta($sql,$valores){
        
        $sql = "select * from ".$sql;
        
        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //$prepare->bind_result($result);
                    /* fetch value */
                    $result = $this->get_result($prepare);
                    if(!empty($result)){
                        return  ($result);
                    }else{
                        return NULL;
                    }
                }
            } else {
                die("Erro (execute): " . $this->link->error); exit;
                return FALSE;
            }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }
    
    /*
    novo metodo mais seguro passe o seu SQL completo e os valores a serem substituidos
    */
    public function ConsultaGenerica($sql,$valores){
        
        if($prepare = $this->link->prepare($sql)){
            if(call_user_func_array(array($prepare, "bind_param"), $this->parametros($valores))){
                if($prepare->execute()){
                    //$prepare->bind_result($result);
                    /* fetch value */
                    $result = $this->get_result($prepare);
                    if(!empty($result)){
                        return  ($result);
                    }else{
                        return NULL;
                    }
                }
            } else {
                die("Erro (execute): " . $this->link->error); exit;
                return FALSE;
            }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit;   
             }
             return FALSE;
        }
        
    }

    /**
    lastCode passando a Tabela e o atributo desejdo, retorna o atributo maximo dessa tabela 
    */
    function lastCode($tabela, $atributomax) {
        $sql = "select max($atributomax) as ultimo from $tabela";
        
        if($prepare = $this->link->prepare($sql)){
                if($prepare->execute()){
                     $result = $this->get_result($prepare);
                    //$row = $result->fetch_array(MYSQLI_BOTH);
                    $next_id = $result[0]['ultimo'];
                    return $next_id;
                }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit; 
             }
             return FALSE;
        }
    }

    /**
    proximoID retorna o proximo valor de auto incremento da tabela 
    */
    function proximoID($tabela) {
        
        $sql = "SHOW TABLE STATUS LIKE '$tabela'";
        
        if($prepare = $this->link->prepare($sql)){
                if($prepare->execute()){
                    $result = $this->get_result($prepare);
                    //$row = $result->fetch_array(MYSQLI_BOTH);
                    $next_id = $result[0]['Auto_increment'];
                    return $next_id;
                }
        } else {
             if($this->mostraerro == TRUE){
                die("Erro: (prepare)" . $this->link->error); exit; 
             }
             return FALSE;
        }
        
    }
    
    function desconecta(){
        $this->link->close();
    }
    
    function __destruct() {
        $this->desconecta();
    }
    
}
