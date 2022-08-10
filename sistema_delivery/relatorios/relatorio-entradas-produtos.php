<?php
$usur_system = true;
include '../../config.php';
include_once '../classes/Entrada.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

$periodo1 = $periodo2 = '';

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

}

$entrada = new Entrada();
$entrada->setIdEmpresa($_SESSION["_idEmpresa"]);

$todas_entradas = $entrada->listarRelatorio2($periodo1, $periodo2);
$total_entradas = 0;
$total_frete = 0;
$total_desconto = 0;

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
$titulo = "Relatório das Entradas de produtos";
$subtitulo = "Relação de todas as entrada de produtos" . (!empty($periodo1) ? '<br>no período de ' . $periodo1. ' a ' . $periodo2 : '');
//chama o topo do relatorio
include './toporelatorio.php';

//inportaçãoes que serão usadas


// dados do relatorio
$html .= '<div class="borda" >';
$html .= '<table width="100%">';

$html .= '<tr>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Nº da Entrada</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Data da Entrada</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Forma de Pagamento</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Frete</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Desconto</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Total</b> </td>';
$html .= '</tr>';

if(!empty($todas_entradas)){

	//print_r($rldu);

	foreach ($todas_entradas as $ent){

		$html .= '<tr>';
		$html .= '<td class="center">'. $ent['ent_id'] .'<td/>';
		$html .= '<td class="center">'.  trataDataInv($ent["data"]) .'<td/>';
		$html .= '<td class="center">'.  utf8_encode($ent["pag_nome"]) .'<td/>';
		$html .= '<td class="center">'.  number_format($ent["frete"], 2, ",", ".") .'<td/>';
		$html .= '<td class="center">'.  number_format($ent["desconto"], 2, ",", ".") .'<td/>';
		$html .= '<td class="center">'.  number_format($ent["total"], 2, ",", ".") .'<td/>';

		$html .= '</tr>';

		$total_entradas += $ent["total"];
		$total_desconto += $ent["desconto"];
		$total_frete += $ent["frete"];

	}
}

$html .= '</table>';

$html .= '</div>';

$html .= '<div style="text-align: right; margin-top: 30px; font-size: 18px;"><b>Total de Frete: </b> R$ '. number_format($total_frete, 2, ',', '.') .'</div>';
$html .= '<div style="text-align: right;font-size: 18px;"><b>Total de Desconto: </b> R$ '. number_format($total_desconto, 2, ',', '.') .'</div>';
$html .= '<div style="text-align: right; font-size: 18px;"><b>Total Geral: </b> R$ '. number_format($total_entradas, 2, ',', '.') .'</div>';

//rodapé
include './rodaperelatorio.php';
//}

