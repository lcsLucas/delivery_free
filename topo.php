<?php

include_once "config.php";
include_once 'sistema_delivery/classes/Cliente.php';

$cliente = new Cliente();
$nome = 'Visitante';

if (!empty($_SESSION['_idcliente'])) {
    $cliente->setId($_SESSION['_idcliente']);
    $cliente->carregarSite();

    if (!empty($cliente->getNome())) {
        $partes_nome = explode(' ', $cliente->getNome());
        $nome = $partes_nome[0];
    }

}

?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Free</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseurl ?>vendor/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $baseurl ?>css/fundamental.css">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= $baseurl ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseurl ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $baseurl ?>/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= $baseurl ?>/img/favicon/safari-pinned-tab.svg" color="#a90e12">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

</head>
<body>

<div id="tudo">

<div id="load">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>

<header class="bg-cor-principal" id="cabecalho">

    <div class="container">

        <nav id="menu" class="navbar navbar-expand-md navbar-light">
            <a id="brand-nav" class="navbar-brand brand" href="<?= $baseurl ?>">
                Delivery Free
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <form action="<?= $baseurl ?>restaurantes" id="form-pesquisa" class="form-inline my-2 mx-auto my-lg-0">
                    <div class="input-group">
                        <input id="input-form" class="form-control" placeholder="O que você está procurando?" type="text" name="filtro" value="<?= filter_has_var(INPUT_GET, 'filtro') ? filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_SPECIAL_CHARS) : '' ?>">
                        <span class="input-group-btn">
                            <button type="button" id="btn-form" class="btn bg-cor-principal border border-0 text-white">
                              <i class="fa fa-search"></i>
                            </button>
                      </span>
                    </div>
                </form>

                <div <?= !empty($_SESSION["_logado"]) ? "id=\"abre-tooltip\"" : "" ?> class="ml-auto d-flex align-items-center position-relative">

                    <div class="justify-content-center">
                        <a id="link-conta" class="text-white" href="<?= $baseurl ?>login">
                            <p class="my-0">Olá, <strong><?= $nome ?></strong></p>
                            <p class="my-0 text-right">
                                Minha Conta
                                <i class="fas fa-sort-down"></i>
                            </p>
                        </a>

                        <div class="arrow_box">

                            <ul id="menu-usuario" class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="<?= $baseurl ?>minha-conta">Minhas Informações</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $baseurl ?>meus-enderecos">Meus Endereços</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $baseurl ?>meus-pedidos">Pedidos Realizados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $baseurl ?>minhas-avaliacoes">Minhas Avaliações</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $baseurl ?>sair">Sair</a>
                                </li>
                            </ul>

                        </div>

                    </div>

                    <div class="justify-content-center">

                        <a class="text-white pl-2" href="<?= $baseurl ?>login">
                            <i class="fas fa-user fa-pull-right fa-border m-0"></i>
                        </a>

                    </div>

                </div>

                <div id="escurece-pagina"></div>

            </div>

        </nav>

        <?php

            if (!empty($_SESSION['_logado'])) {

                ?>

                <nav id="opcoes">

                    <div class="row">

                        <div class="col-4 text-center">

                            <a class="opcao-item" href="<?= $baseurl ?>listar-restaurantes">
                                <i class="fas fa-utensils"></i> Restaurantes
                            </a>

                        </div>
                        <div class="col-4 text-center">

                            <a class="opcao-item" href="<?= $baseurl ?>meus-pedidos">
                                <i class="fas fa-clipboard-list"></i> Pedidos Realizados
                            </a>

                        </div>
                        <div class="col-4 text-center">

                            <a class="opcao-item" href="<?= $baseurl ?>minhas-avaliacoes">
                                <i class="fas fa-star"></i> Minhas Avaliações
                            </a>

                        </div>

                    </div>

                </nav>

        <?php

            }

        ?>

    </div>

</header>

<div id="conteudo" class="">