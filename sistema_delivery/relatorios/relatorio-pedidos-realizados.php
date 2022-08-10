<?php
$usur_system = true;
include '../../config.php';
include_once '../classes/Saida.php';
//if(isset($_POST['filtrar'])){
include("pdf/mpdf.php");
//$format = "A4-L";

$html = "";

$periodo1 = $periodo2 = '';

if(!empty($_GET['periodo1']) && !empty($_GET['periodo2'])){

	$periodo1 = filter_input(INPUT_GET, 'periodo1', FILTER_SANITIZE_SPECIAL_CHARS);
	$periodo2 = filter_input(INPUT_GET, 'periodo2', FILTER_SANITIZE_SPECIAL_CHARS);

}

$saida = new Saida();

$saida->setIdEmpresa($_SESSION["_idEmpresa"]);

$todos_pedidos = $saida->listarRelatorio($periodo1, $periodo2);
$total_pedidos = 0;

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
$titulo = "Relatório de Pedidos Realizados";
$subtitulo = "Relação de todos os pedidos realizados" . (!empty($periodo1) ? '<br>no período de ' . $periodo1. ' a ' . $periodo2 : '');
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
	. '<td style="background: #F1F1F1;"> <b>Endereço</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Valor</b> </td>'
	. '<td class="center" style="background: #F1F1F1;"> <b>Status</b> </td>';
$html .= '</tr>';

if(!empty($todos_pedidos)){

	//print_r($rldu);

	foreach ($todos_pedidos as $ped){

		$str_status = 'aguardando';
		$class_status = 'badge-info';

		if (!empty($ped['entrega_id'])) {

			if (!empty($ped['ent_status']) && intval($ped['ent_status']) === 1) {
				$str_status = 'pedido entregue';
				$class_status = 'badge-success';
			} else if (!empty($ped['ent_status']) && intval($ped['ent_status']) === 2) {
				$str_status = 'pedido não entregue';
				$class_status = 'badge-danger';
			} else {
				$str_status = 'saiu para entrega';
				$class_status = 'badge-warning';
			}

		} else {

			if(intval($ped['status']) === 1) {
				$str_status = 'pedido em andamento';
				$class_status = 'badge-warning';
			} elseif(intval($ped['status']) === 2) {
				$str_status = 'pedido cancelado';
				$class_status = 'badge-danger';
			}

		}

		$html .= '<tr>';
		$html .= '<td class="center">'. $ped['idsaida'] .'<td/>';
		$html .= '<td class="center">'.  date('H:i:s d/m/Y', strtotime($ped['data_criacao'])) .'<td/>';
		$html .= '<td>'.  utf8_encode($ped['cli_nome']) .'<td/>';
		$html .= '<td>'.  utf8_encode($ped['end_rua']) .', '. $ped['end_numero'] .'<br>'. utf8_encode($ped['end_bairro']) . ' - ' . $ped['end_cep'] .'<td/>';
		$html .= '<td class="center">'.  number_format($ped['total_geral'], 2, ',', '.') .'<td/>';
		$html .= '<td class="center"><span class="badge '. $class_status .'">'. $str_status .'</span><td/>';

		$html .= '</tr>';

		$total_pedidos += $ped["total_geral"];

	}
}

$html .= '</table>';

$html .= '</div>';

$html .= '<div style="text-align: right; font-size: 18px;"><b>Total Geral: </b> R$ '. number_format($total_pedidos, 2, ',', '.') .'</div>';

//rodapé
include './rodaperelatorio.php';
//}

