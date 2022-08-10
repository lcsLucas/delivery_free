<?php

// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

if (!empty($usur_system))
	$nome_session = md5('seg_deliveryfree_sistema' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
else
	$nome_session = md5('seg_deliveryfree' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

session_name($nome_session);
ob_start();
session_start();

$baseurl = "http://localhost:8080/delivery_free/";
$uri = true;
$valor_uri = "delivery_free";

$POS_URI_ID = 1;

$localhost = TRUE;
