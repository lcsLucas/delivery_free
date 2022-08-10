<?php
$usur_system = true;
include '../../config.php';
include_once '../classes/Avaliacoes.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

$periodo1 = $periodo2 = '';

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

}

$avaliacao = new Avaliacoes();

$avaliacao->setIdEmpresa($_SESSION["_idEmpresa"]);

$todas_avaliacoes = $avaliacao->listarRelatorio($periodo1, $periodo2);

$total_media = 0;

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
$titulo = "Relatório das avaliações do restaurante";
$subtitulo = "Relação de todas avaliações do restaurante" . (!empty($periodo1) ? '<br>no período de ' . $periodo1. ' a ' . $periodo2 : '');
//chama o topo do relatorio
include './toporelatorio.php';

//inportaçãoes que serão usadas


// dados do relatorio
$html .= '<div class="borda" >';
$html .= '<table width="100%">';

$html .= '<tr>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Nº do Pedido</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Data do Pedido</b> </td>'
	. '<td style="background: #F1F1F1;"> <b>Cliente</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Total do Pedido</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Nota</b> </td>';
$html .= '</tr>';

if(!empty($todas_avaliacoes)){

	//print_r($rldu);

	foreach ($todas_avaliacoes as $ava){

		$html .= '<tr>';
		$html .= '<td class="center">'. $ava['idsaida'] .'<td/>';
		$html .= '<td class="center">'.  date('H:i:s d/m/Y', strtotime($ava['data_criacao'])) .'<td/>';
		$html .= '<td>'.  utf8_encode($ava['cli_nome']) .'<td/>';
		$html .= '<td class="center">'.  number_format($ava['total_geral'], 2, ',', '.') .'<td/>';
		$html .= '<td class="center">'.  $ava['classificacao'] .'<td/>';

		$html .= '</tr>';

		$total_media += (int) $ava['classificacao'];

	}
}

$total_media /= count($todas_avaliacoes);

$html .= '</table>';

$html .= '</div>';

$html .= '<div style="text-align: right; font-size: 18px;margin-top: 20px"><b>Classificação Geral: </b> '. number_format($total_media, 2, ',', '.') .'</div>';

//rodapé
include './rodaperelatorio.php';
//}

