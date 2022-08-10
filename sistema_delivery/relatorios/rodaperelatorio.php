<?php

if($format == "A4"){

//$html .= '</table>';
$footer = '<table  BGCOLOR=#FFFFFF width="100%" style="border-bottom: 1px solid #FFFFFF; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #727376;  margin:0px 0px; "><tr>
<td width="550px">
        <p style="font-weight: bold; color:#000000; font:11px tahoma; text-align:center;">
            <center>
                 deliveryfree.com.br | Copyright © Delivery Free - todos os direitos reservados.
            </center>
        </p>
        <p style="font-weight: bold; color:#000000; font:12px tahoma; float:left;">
		{DATE j/m/Y} | Página {PAGENO} de {nb}
	</p>
</td>
<td width="30px" >
<img width="20px" src="../images/logo.png"  />
</td>
</table>';
}else{
    
//$html .= '</table>';
$footer = '<table  BGCOLOR=#FFFFFF width="100%" style="border-bottom: 1px solid #FFFFFF; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #727376;  margin:0px 0px; "><tr>
<td width="550px">
        <p style="font-weight: bold; color:#000000; font:11px tahoma; text-align:center;">
            <center>
                acheinaobra.com.br | Copyright © Achei na Obra - todos os direitos reservados.
            </center>
        </p>
        <p style="font-weight: bold; color:#000000; font:12px tahoma; float:left;">
                {DATE j/m/Y} | Página {PAGENO} de {nb}
        </p>
</td>
<td width="30px" >
<img width="20px" src="../images/logo.png"  />
</td>
</table>';
    
}


$footerE = $footer;

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');
//echo $html;exit;
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

