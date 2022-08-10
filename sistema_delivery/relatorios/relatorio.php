<?php
include '../../config.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

//estilo
$html .= '<style>
		strong { color:#424242; font:12px tahoma; font-weight:bold; }
		p { color:#424242; font:13px tahoma; margin:5px 0; }
                b {  color:#000; }
                h3 { color:#000; font:20px tahoma; margin:5px 20px; }
                h4{ color:#000; }
                td { color:#424242; font:12px tahoma; margin:5px 0; }
                td.center{ text-align:center }
                table { color:#424242; font:20px tahoma; margin:5px 20px; }
                .borda { border:1px solid #717376; margin:0 5px; }
          </style>';

//colocar titulo e subtitulo relatorio 
$titulo = "Titulo relatorio";
$subtitulo = "Subtitulo relatorio";
//chama o topo do relatorio
include './toporelatorio.php';

//inportaçãoes que serão usadas 


// dados do relatorio
$html .= '<h3>Titulo</h3>';
$html .= '<div class="borda" >';
$html .= '<table width="100%">';

$html .= '<tr>'
        . '<td> <b>teste</b> </td>'
        . '<td class="center" > <b>teste</b> </td>'
        . '<td class="center" > <b>teste</b> </td>';
$html .= '</tr>';

if(isset($rldu)){
    
    //print_r($rldu);
    
    foreach ($rldu as $rsr){    
            $html .= '<tr>';
            $html .= '<td>'.'<td/>';
            $html .= '<td class="center" >'.'<td/>';
            $html .= '<td class="center" >'.'<td/>';
            $html .= '</tr>';      
    }
}        
        
$html .= '</table>';
$html .= '</div><br/>';       
               
//rodapé
include './rodaperelatorio.php';
//}

