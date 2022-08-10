<?php
$usur_system = true;
include '../../config.php';
include_once '../classes/ContaReceber.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

$periodo1 = $periodo2 = '';

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

}

$contas = new ContaReceber();
$contas->setIdEmpresa($_SESSION["_idEmpresa"]);

$todas_contas = $contas->listarRelatorio($periodo1, $periodo2);
$total_contas = 0;
$total_pago = 0;
$total_naopago = 0;

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
$titulo = "Relatório de contas a receber";
$subtitulo = "Relação de todas as contas a receber" . (!empty($periodo1) ? '<br>com o vencimento no período ' . $periodo1. ' a ' . $periodo2 : '');
//chama o topo do relatorio
include './toporelatorio.php';

//inportaçãoes que serão usadas


// dados do relatorio
$html .= '<div class="borda" >';
$html .= '<table width="100%">';

$html .= '<tr>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Código</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Pagamento em</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Valor da Parcela</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Data de Vencimento</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Valor Pago</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Data do Pagamento</b> </td>';
$html .= '</tr>';

if(!empty($todas_contas)){

	//print_r($rldu);

	foreach ($todas_contas as $conta){

		$html .= '<tr>';
		$html .= '<td class="center">'. $conta['con_id'] .'<td/>';
		$html .= '<td class="center">'. ((strcmp($conta["con_dtPago"], $conta["con_dtVencimento"]) === 0) ? 'Dinheiro' : 'Cartão') .'<td/>';
		$html .= '<td class="center">R$ '. number_format($conta["con_valor"], 2, ",", ".") .'<td/>';
		$html .= '<td class="center">'. date("d/m/Y", strtotime($conta["con_dtVencimento"])) .'<td/>';
		$html .= '<td class="center">'. (empty($conta["con_valorPago"]) ? "-" : 'R$ '.number_format($conta["con_valorPago"], 2, ",", "."))  .'<td/>';
		$html .= '<td class="center">'. (empty($conta["con_dtPago"]) ? "-" : date("d/m/Y", strtotime($conta["con_dtPago"]))) .'<td/>';
		$html .= '</tr>';

		$total_contas += $conta["con_valor"];

		if (empty($conta["con_dtPago"]))
			$total_naopago += $conta["con_valor"];
		else
			$total_pago += $conta["con_valorPago"];

	}
}

$html .= '</table>';

$html .= '</div>';

$html .= '<div style="text-align: right; margin-top: 30px; font-size: 18px;"><b>Total Pago: </b> R$ '. number_format($total_pago, 2, ',', '.') .'</div>';
$html .= '<div style="text-align: right;font-size: 18px;"><b>Total Não Pago: </b> R$ '. number_format($total_naopago, 2, ',', '.') .'</div>';
$html .= '<div style="text-align: right; font-size: 18px;"><b>Total Geral: </b> R$ '. number_format($total_contas, 2, ',', '.') .'</div>';

//rodapé
include './rodaperelatorio.php';
//}

