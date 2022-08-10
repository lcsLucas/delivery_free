<?php

if(!isset($format)){
    $format = "A4";
    $tamanhotopo = 30;
    $tamanhoodape = 30;
} else {
    $tamanhotopo = 26;
    $tamanhoodape = 15;
}

$mpdf=new mPDF('c',$format,'','',5,5,$tamanhotopo,$tamanhoodape,5,5); 

//echo '';exit;
if($format == "A4"){
$mpdf->mirrorMargins = 1;
$header = '
    <div style="border-bottom: 3px solid #4A72B2"; >
<table  BGCOLOR=#FFFFFF width="100%" style="vertical-align: bottom; font-family: serif; font-size: 9pt; color: #727376;  margin:0px 0px; "><tr>
<tr>
<td width="600px"  align="center"  >
    <img height="130px" src="../images/logo.png"  />
    <p align="left" style="font-weight: bold; color:#000000; font:26px tahoma;">
		'.'<br/>'.'
                <span>Gerado em '.date("d/m/Y").' às '.date("H:i").'h</span>
    </p>
</td>
<td width="1500px"  align="right"  >
    <p style="font:60px tahoma; margin:0px;text-transform: uppercase;" >'.$titulo.'<p>
    <p style="font:25px tahoma; margin:0px;" >'.$subtitulo.'<p>
</td>
</table></div>
';
$headerE = $header;

}else{    
    
    //landscape
    $mpdf->mirrorMargins = 1;
$header = '
<table  BGCOLOR=#FFFFFF width="100%"  style="border-bottom: 1px solid #727376; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #727376;  margin:0px 0px; "><tr>
<tr>
<td width="300px"  align="center"  >
    <img width="150px" src="../images/logo.png"  />
    <p align="left" style="font-weight: bold; color:#000000; font:16px tahoma;">
		'.'<br/>'.'
                <span>Gerado em '.date("d/m/Y").' às '.date("H:i").'h</span>
    </p>
</td>
<td width="500px"  align="left"  >
    <p style="font:32px tahoma; margin:0px;" >'.$titulo.'<p>
    <p style="font:22px tahoma; margin:0px;" >'.$subtitulo.'<p>
</td>
<td width="1200px" style="text-align: right;"><span style="font-weight: bold; color:#000; font:16px tahoma;">
</td>
<td width="80px">
</td>
</tr>
</table>
';
$headerE = $header;

}


?>
