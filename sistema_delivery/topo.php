<?php
$usur_system = true;
include '../config.php';
include 'valida.php';

require_once './classes/Menu.php';
require_once './classes/SubMenu.php';

$menus = new Menu();
$submenus = new SubMenu();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- inicio SB -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Painel Administrativo</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Fim SB -->

    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= $baseurl ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseurl ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $baseurl ?>/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= $baseurl ?>/img/favicon/safari-pinned-tab.svg" color="#a90e12">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <?php

        include "menu.php";

        ?>
        <div class="content-wrapper">
            <div class="container-fluid">