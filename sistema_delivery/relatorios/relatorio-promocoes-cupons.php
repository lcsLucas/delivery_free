<?php
$usur_system = true;
include '../../config.php';
include_once '../classes/Promocao.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

$periodo1 = $periodo2 = '';

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

}

$promocao = new Promocao();
$promocao->setIdEmpresa($_SESSION["_idEmpresa"]);

$todas_promocoes = $promocao->listarRelatorio2($periodo1, $periodo2);

//estilo
$html .= '<style>
		strong { color:#424242; font:12px tahoma; font-weight:bold; }
		p { color:#424242; font:13px tahoma; margin:5px 0; }
                b {  color:#000; }
                h3 { color:#000; font:20px tahoma; margin:5px 20px; }
                h4{ color:#000; }
                td { color:#424242; font:12px tahoma; margin: 0; padding: 15px 10px; border-bottom: 1px solid #CCC;}
                td.center{ text-align:center;  }
                table { color:#424242; font:20px tahoma; margin:0; border-spacing: 0}
                .borda { border:1px solid #BBB; margin:0; }
          </style>';

//colocar titulo e subtitulo relatorio
$titulo = "Relatório dos Cupons Promocionais";
$subtitulo = "Relação de todos os cupons promocionais" . (!empty($periodo1) ? '<br>no período de ' . $periodo1. ' a ' . $periodo2 : '');
//chama o topo do relatorio
include './toporelatorio.php';

//inportaçãoes que serão usadas


// dados do relatorio
$html .= '<div class="borda" >';
$html .= '<table width="100%">';

$html .= '<tr>'
	. '<td style="background: #F1F1F1;"> <b>Cupom Promocional</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Data de Início</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Data de Término</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Tipo de Desconto</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Valor do Desconto</b> </td>';
$html .= '</tr>';

if(!empty($todas_promocoes)){

	//print_r($rldu);

	foreach ($todas_promocoes as $prom){

		$html .= '<tr>';
		$html .= '<td>'. utf8_encode($prom["pro_nome"]) .'<td/>';
		$html .= '<td class="center">'. trataDataInv($prom["pro_dtInicio"]) .'<td/>';
		$html .= '<td class="center">'. trataDataInv($prom["pro_dtFinal"]) .'<td/>';
		$html .= '<td class="center">'. (($prom['pro_tipo_desconto'] === '1') ? 'Porcentagem' : 'Valor Fixo') .'<td/>';
		$html .= '<td class="center">'. (($prom['pro_tipo_desconto'] === '1') ? number_format($prom['pro_desc_porc'], 2, ',', '.') . ' %' : 'R$ ' . number_format($prom['pro_desc_valor'], 2, ',', '.')) .'<td/>';
		$html .= '</tr>';

	}
}

$html .= '</table>';

$html .= '</div>';

//rodapé
include './rodaperelatorio.php';
//}

