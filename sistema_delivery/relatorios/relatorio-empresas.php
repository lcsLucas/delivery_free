<?php
include '../../config.php';
include_once '../classes/Empresa.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

if(isset($_GET['filtro'])){
	$filtro = SQLinjection(filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS));
}

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

}

$empresa = new Empresa();

$todas_empresa = $empresa->listarRelatorio($filtro, $periodo1, $periodo2);

$total_faturamento = 0;
$total_cobranca = 0;

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
$titulo = "Relatório das empresas no Delivery Free";
$subtitulo = "Relação de todas as empresas cadastradas no Delivery Free" . (!empty($periodo1) ? '<br>com faturamento no período ' . $periodo1. ' a ' . $periodo2 : '');
//chama o topo do relatorio
include './toporelatorio.php';

//inportaçãoes que serão usadas


// dados do relatorio
$html .= '<div class="borda" >';
$html .= '<table width="100%">';

$html .= '<tr>'
	. '<td style="background: #F1F1F1;"> <b>Empresa</b> </td>'
	. '<td style="background: #F1F1F1;"> <b>Responsável</b> </td>'
	. '<td style="background: #F1F1F1;"> <b>Fone</b> </td>'
	. '<td style="background: #F1F1F1;" class="center" > <b>Faturamento'. (!empty($periodo1) ? '<br>' . $periodo1. ' a ' . $periodo2 : '') .'</br> </td>'
	. '<td style="background: #F1F1F1;" class="center" > <b>Cobrança'. (!empty($periodo1) ? '<br>' . $periodo1. ' a ' . $periodo2 : '') .'</b> </td>';
$html .= '</tr>';

if(!empty($todas_empresa)){

	//print_r($rldu);

	foreach ($todas_empresa as $emp){

		$total_faturamento += $emp['faturamento'];
		$total_cobranca += $emp['faturamento'] * $emp['emp_comissao'] / 100;

		$html .= '<tr>';
		$html .= '<td>'. utf8_encode($emp['emp_nome']) .'<td/>';
		$html .= '<td >'. utf8_encode($emp['resp_nome']) .'<td/>';
		$html .= '<td >'. $emp['resp_fone'] .'<td/>';
		$html .= '<td class="center">'. (!empty($emp['faturamento']) ? number_format($emp['faturamento'], 2, ',', '.') : '0,00') .'<td/>';
		$html .= '<td class="center">'. (!empty($emp['faturamento']) ? number_format($emp['faturamento'] * $emp['emp_comissao'] /100, 2, ',', '.') : '0,00') .'<td/>';
		$html .= '</tr>';
	}
}

$html .= '</table>';

$html .= '</div>';

$html .= '<div style="text-align: right; margin-top: 30px; font-size: 18px;"><b>Faturamento Total: </b> R$ '. number_format($total_faturamento, 2, ',', '.') .'</div>';
$html .= '<div style="text-align: right; font-size: 18px;"><b>Total da Cobrança: </b> R$ '. number_format($total_cobranca, 2, ',', '.') .'</div>';

//rodapé
include './rodaperelatorio.php';
//}

