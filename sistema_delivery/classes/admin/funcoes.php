<?php

/**
 * @author diegO
 * @copyright 2010
 */
function valida_cnpj ( $cnpj ) {
    // Deixa o CNPJ com apenas números
    $cnpj = preg_replace( '/[^0-9]/', '', $cnpj );

    // Garante que o CNPJ é uma string
    $cnpj = (string)$cnpj;

    // O valor original
    $cnpj_original = $cnpj;

    // Captura os primeiros 12 números do CNPJ
    $primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );

    /**
     * Multiplicação do CNPJ
     *
     * @param string $cnpj Os digitos do CNPJ
     * @param int $posicoes A posição que vai iniciar a regressão
     * @return int O
     *
     */
    if ( ! function_exists('multiplica_cnpj') ) {
        function multiplica_cnpj( $cnpj, $posicao = 5 ) {
            // Variável para o cálculo
            $calculo = 0;

            // Laço para percorrer os item do cnpj
            for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
                // Cálculo mais posição do CNPJ * a posição
                $calculo = $calculo + ( $cnpj[$i] * $posicao );

                // Decrementa a posição a cada volta do laço
                $posicao--;

                // Se a posição for menor que 2, ela se torna 9
                if ( $posicao < 2 ) {
                    $posicao = 9;
                }
            }
            // Retorna o cálculo
            return $calculo;
        }
    }

    // Faz o primeiro cálculo
    $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );

    // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
    // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
    $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );

    // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
    // Agora temos 13 números aqui
    $primeiros_numeros_cnpj .= $primeiro_digito;

    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
    $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );

    // Concatena o segundo dígito ao CNPJ
    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;

    // Verifica se o CNPJ gerado é idêntico ao enviado
    if ( $cnpj === $cnpj_original ) {
        return true;
    }
}

function SQLinjection($string) {
    $string = str_replace(" or ", "", $string);
    $string = str_replace("select", "", $string);
    $string = str_replace("delete", "", $string);
    $string = str_replace("truncate", "", $string);
    $string = str_replace("create", "", $string);
    $string = str_replace("insert", "", $string);
    $string = str_replace("drop", "", $string);
    $string = str_replace("update", "", $string);
    $string = str_replace("drop table", "", $string);
    $string = str_replace("show table", "", $string);
    $string = str_replace("applet", "", $string);
    $string = str_replace("object", "", $string);
    $string = str_replace("'", "", $string);
    //$string = str_replace("#", "", $string);
    $string = str_replace("=", "", $string);
    $string = str_replace(";", "", $string);
    //$string = str_replace("*", "", $string);
    $string = str_replace("%", "", $string);
    $string = str_replace("<script", "", $string);
    $string = str_replace("</script", "", $string);
    /* $string = str_replace("<", "", $string);
      $string = str_replace("</", "", $string);
      $string = str_replace(">", "", $string);
      $string = str_replace("/>", "", $string);
      $string = str_replace(",", "", $string);
      $string = strip_tags($string);
      $string = addslashes($string); */
    $string = trim($string);
    return $string;
}

function geraTimestamp($data) {
    $partes = explode('/', $data);
    return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}

function retornaDias($inicio, $fim) {
    // Usa a função criada e pega o timestamp das duas datas:
    $time_inicial = geraTimestamp($inicio);
    $time_final = geraTimestamp($fim);

    // Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial; // 19522800 segundos
    // Calcula a diferença de dias
    $dias = (int) floor($diferenca / (60 * 60 * 24)); // 225 dias

    return $dias;
}

function trataData($dat) {
    $dt = explode("/", $dat);
    $dat = $dt[2] . "-" . $dt[1] . "-" . $dt[0];
    return $dat;
}

function trataDataInv($dat) {
    $dt = explode("-", $dat);
    $dat = $dt[2] . "/" . $dt[1] . "/" . $dt[0];
    return $dat;
}

function tiraacento($texto) {
    $trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ', '%', '?',);
    $porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'Y', '', '',);
    $titletext = str_replace($trocarIsso, $porIsso, $texto);
    return $titletext;
}

function tiraAcentos2($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûÚ';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuu';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
    $string = str_replace(" - ", "-", $string); // retira espaco
    $string = str_replace(" ", "-", $string); // retira espaco
    $string = str_replace("/", "-", $string); // troca / por -
    $string = str_replace(",", "", $string); // troca , por -
    $string = str_replace(".", "", $string);
    $string = str_replace("!", "", $string);
    $string = str_replace("?", "", $string);
    $string = str_replace("@", "", $string);
    $string = str_replace(";", "", $string);
    $string = strtolower($string); // passa tudo para minusculo
    return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}

function tiraAcentos($sub) {
    $acentos = array(
        'À', 'Á', 'Ã', 'Â', 'à', 'á', 'ã', 'â',
        'Ê', 'É',
        'Í', 'í',
        'Ó', 'Õ', 'Ô', 'ó', 'õ', 'ô',
        'Ú', 'Ü', 'Ù',
        'Ç', 'ç',
        'é', 'ê',
        'ú', 'ü', 'ù',
        '@', '#', '(', ')', '!',
        '"', '.', ',', ';', '-',
        ' - ', '?', ' ', '/', '|',
        'ª', 'º','%', '$'
    );
    $remove_acentos = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e',
        'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'o',
        'u', 'u', 'u',
        'c', 'c',
        'e', 'e',
        'u', 'u', 'u',
        '', '', '', '', '',
        '', '', '', '', '',
        '-', '', '-', '', '',
        '', '', '', ''
    );
    return str_replace($acentos, $remove_acentos, urldecode($sub));
}

function validaCPF($cpf) {
    echo "entrou";
    // verifica se e numerico
    if (!is_numeric($cpf)) {
        echo "nao numero";
        exit;
        return false;
    }

    // verifica se esta usando a repeticao de um numero
    if (($cpf == '11111111111') || ($cpf == '22222222222') || ($cpf == '33333333333') || ($cpf == '44444444444') || ($cpf == '55555555555') || ($cpf == '66666666666') || ($cpf == '77777777777') || ($cpf == '88888888888') || ($cpf == '99999999999') || ($cpf == '00000000000')) {
        return false;
    }

    //PEGA O DIGITO VERIFIACADOR
    $dv_informado = substr($cpf, 9, 2);

    for ($i = 0; $i <= 8; $i++) {
        $digito[$i] = substr($cpf, $i, 1);
    }

    //CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
    $posicao = 10;
    $soma = 0;

    for ($i = 0; $i <= 8; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[9] = $soma % 11;

    if ($digito[9] < 2) {
        $digito[9] = 0;
    } else {
        $digito[9] = 11 - $digito[9];
    }

    //CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
    $posicao = 11;
    $soma = 0;

    for ($i = 0; $i <= 9; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[10] = $soma % 11;

    if ($digito[10] < 2) {
        $digito[10] = 0;
    } else {
        $digito[10] = 11 - $digito[10];
    }

    //VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
    $dv = $digito[9] * 10 + $digito[10];
    if ($dv != $dv_informado) {
        return false;
    }

    return true;
}

function validaEmail($mail) {
    if (preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $mail)) {
        return true;
    } else {
        return false;
    }
}

function ValidaData($dat){
    $data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como referência
    $d = $data[0];
    $m = $data[1];
    $y = $data[2];

// verifica se a data é válida!
// 1 = true (válida)
// 0 = false (inválida)
    $res = checkdate($m,$d,$y);
    if ($res == 1){
        return true;
    } else {
        return false;
    }
}

function FormataQuadra($NumeroQuadra){
    $quadra = "";
    if(strlen($NumeroQuadra) == 1){
        $quadra = "000" . $NumeroQuadra;
    }

    if(strlen($NumeroQuadra) == 2){
        $quadra = "00" . $NumeroQuadra;
    }

    if(strlen($NumeroQuadra) == 3){
        $quadra = "0" . $NumeroQuadra;
    }

    if(strlen($NumeroQuadra) > 3){
        $quadra = $NumeroQuadra;
    }

    return $quadra;
}

function FormataLote($NumeroLote){
    $lote = "";
    if(strlen($NumeroLote) == 1){
        $lote = "0000" . $NumeroLote;
    }

    if(strlen($NumeroLote) == 2){
        $lote = "000" . $NumeroLote;
    }

    if(strlen($NumeroLote) == 3){
        $lote = "00" . $NumeroLote;
    }

    if(strlen($NumeroLote) == 4){
        $lote = "0" . $NumeroLote;
    }

    if(strlen($NumeroLote) > 4){
        $lote = $NumeroLote;
    }

    return $lote;
}

function FormataUnidade($NumeroUnidade){
    $Unidade = "";

    if(strlen($NumeroUnidade) == 1){
        $Unidade = "00" . $NumeroUnidade;
    }

    if(strlen($NumeroUnidade) == 2){
        $Unidade = "0" . $NumeroUnidade;
    }

    if(strlen($NumeroUnidade) > 2){
        $Unidade = $NumeroUnidade;
    }

    return $Unidade;
}

function qtdePaginas($qtdeRegistros){
    $paginas = 1;
    while($qtdeRegistros > 500){
        $paginas++;
        $qtdeRegistros = $qtdeRegistros - 500;
    }
    return $paginas;
}

function RetornaLimit($pagina){
    $limit = '0, 500';
    if($pagina == 1){return $limit;}
    $limit = '';
    $limit = ($pagina * 500) - 500;
    return $limit;
}

function Redimensionar($imagem, $name, $largura, $pasta, $limite) {
    $img = imagecreatefromjpeg($imagem);
    $x = imagesx($img);
    $y = imagesy($img);
    $altura = ($largura * $y) / $x;
    $nova = imagecreatetruecolor($largura, $altura);

    if ($x > $limite && $y > $limite) {
        return false;
    } else {
        imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
        imagejpeg($img, "$pasta/$name");
        imagejpeg($nova, "$pasta/thumbs/$name"); //pasta de destino (fotos) mais thumbs, onde   gerado as miniaturas
        imagedestroy($img);
        imagedestroy($nova);
        //return $name;
        return true;
        //print '<p class="msg">Imagem enviada com sucesso</p>';
    }
}

function ValidaResolucaoImagem($imagem, $largura, $altura) {
    $img = imagecreatefromjpeg($imagem);
    $x = imagesx($img);
    $y = imagesy($img);
    if($x==$largura && $y==$altura)
    {
        return true;
    }
    return false;
}


function RedimensionarPng($imagem, $name, $largura, $pasta, $limite) {
    $img = imagecreatefrompng($imagem);
    $x = imagesx($img);
    $y = imagesy($img);
    $altura = ($largura * $y) / $x;
    $nova = imagecreatetruecolor($largura, $altura);

    if ($x > $limite && $y > $limite) {
        return false;
    } else {
        imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
        imagejpeg($img, "$pasta/$name");
        imagejpeg($nova, "$pasta/thumbs/$name"); //pasta de destino (fotos) mais thumbs, onde   gerado as miniaturas
        imagedestroy($img);
        imagedestroy($nova);
        //return $name;
        return true;
        //print '<p class="msg">Imagem enviada com sucesso</p>';
    }
}

function RedimensionarPng2($imagem, $name, $largura, $pasta, $limite, $corta_original = TRUE) {
    $img = imagecreatefrompng($imagem);
    $x = imagesx($img);
    $y = imagesy($img);

    if($corta_original == TRUE){
        $altura = ($largura * $y) / $x;
        $nova = imagecreatetruecolor($largura, $altura);
        imagesavealpha($nova, true);
        $cor_fundo = imagecolorallocatealpha($nova, 0, 0, 0, 127);
        imagefill($nova, 0, 0, $cor_fundo);
    }

    $altura2 = ($this->largura_thumb * $y) / $x;
    $nova2 = imagecreatetruecolor($this->largura_thumb, $altura2);
    imagesavealpha($nova2, true);
    $cor_fundo2 = imagecolorallocatealpha($nova2, 0, 0, 0, 127);
    imagefill($nova2, 0, 0, $cor_fundo2);

    if ($x > $limite && $y > $limite) {
        return false;
    } else {
        if($corta_original == TRUE){
            imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
            imagepng($nova, "$pasta/$name");
            imagedestroy($nova);
        }else{
            move_uploaded_file($imagem, "$pasta/$name");
        }

        imagecopyresampled($nova2, $img, 0, 0, 0, 0, $this->largura_thumb, $altura2, $x, $y);
        imagepng($nova2, "$pasta/thumbs/$name"); //pasta de destino (fotos) mais thumbs, onde   gerado as miniaturas
        imagedestroy($nova2);

        imagedestroy($img);
        return true;
        //print '<p class="msg">Imagem enviada com sucesso</p>';
    }
}

function ValidaImgagem($img)
{
    $size = getimagesize($img);
    if($size[0]<="32" && $size[1]<="32")
    {
        //$size[0]='50';
        //$size[1]='50';
        return $img;
    }
    else null;
}

//$webpage = basename($_SERVER['PHP_SELF']);
$webpage = NULL;

////////////////////////////////////////////////////////////
// MODELO DE PAGINAÇÃO 6

function pagination_six($total_pages,$page, $categoria){

    global $webpage;

    $pagination = '<div class="page_numbers">
                    <ul class="pagination justify-content-center">';

    if($total_pages!=1){

        //the total links visible

        $max_links=7;


        //$max links_marker is the top of the loop
        //$h is the start

        $max_links_marker = $max_links+1;
        $h=1;


        //$link_block is the block of links on the page
        //When this is an integer we need a new block of links

        $link_block=(($page-1)/$max_links);

        //if the page is greater than the top of th loop and link block
        //is an integer

        if(($page>=$max_links_marker)&&(is_int($link_block))){

            //reset the top of the loop to a new link block

            $max_links_marker=$page+$max_links;

            //and set the bottom of the loop

            $h=$max_links_marker-$max_links;
            $prev=$h-1;
        }

        //if not an integer we are still within a link block

        elseif(($page>=$max_links_marker)&&(!is_int($link_block))){

            //round up the link block

            $round_up=ceil($link_block);

            $new_top_link = $round_up*$max_links;

            //and set the top of the loop to the top link

            $max_links_marker=$new_top_link+1;

            //and the bottom of the loop to the top - max links

            $h=$max_links_marker-$max_links;
            $prev=$h-1;
        }

        //if greater than total pages then set the top of the loop to
        // total_pages

        if($max_links_marker>$total_pages){
            $max_links_marker=$total_pages+1;
        }

        //first and prev buttons

        if($page>'1'){
            $pagination.='<li class="page-item"><a class="page-link" href="'.$webpage.'?page=1'. (!empty($categoria) ? $categoria : "") .'"><span>Primeira</span></a></li>
            <li class="page-item"><a class="page-link" href="'.$webpage.'?page='.($page-1).(!empty($categoria) ? $categoria : "").'"><span> << </span></a></li>';
        }

        //provide a link to the previous block of links


        $prev_start = $h-$max_links;
        $prev_end = $h-1;
        if($prev_start <=1){
            $prev_start=1;
        }
        $prev_block = "$prev_start a $prev_end";

        if($page>$max_links){
            $pagination.='<li class="current page-item"><a class="page-link"  href="'.$webpage.'?page='.$prev.(!empty($categoria) ? $categoria : "").'">'.$prev_block.'</a></li>';
        }

        //loop through the results

        for ($i=$h;$i<$max_links_marker;$i++){
            if($i==$page){
                $pagination.= '<li class="page-item active"><a class="current page-link">'.$i.'</a></li>';
            }
            else{
                $pagination.= '<li class="page-item"><a class="page-link" href="'.$webpage.'?page='.$i.(!empty($categoria) ? $categoria : "").'">'.$i.'</a></li>';
            }
        }
        //provide a link to the next block o links

        $next_start = $max_links_marker;
        $next_end = $max_links_marker+$max_links;
        if($next_end >=$total_pages){
            $next_end=$total_pages;
        }
        $next_block = "$next_start a $next_end";
        if($total_pages>$max_links_marker-1){
            $pagination.='<li class="page-item current, n"><a class="page-link" href="'.$webpage.'?page='.$max_links_marker.(!empty($categoria) ? $categoria : "").'">'.$next_block.'</a></li>';
        }

        //link to next and last pages


        if(($page >="1")&&($page!=$total_pages)){
            $pagination.='<li class="page-item"><a class="page-link" href="'.$webpage.'?page='.($page+1).(!empty($categoria) ? $categoria : "").'"><span> >> </span></a></li>
                  <li class="page-item"><a class="page-link" href="'.$webpage.'?page='.$total_pages.(!empty($categoria) ? $categoria : "").'"><span>&Uacute;ltima</span></a></li>';
        }
    }

    //if one page of results

    else{
        $pagination.='<li class="page-item" ><a class="page-link" href="" class="current">1</a></li>';
    }
    $pagination.='</ul>
        </div>';

    return($pagination);
}

function get_client_ip() {
    $ipaddress = '';
    /*if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else*/
    if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

?>