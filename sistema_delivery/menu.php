<?php 
require_once './classes/Menu.php';
require_once './classes/SubMenu.php';

$menus = new Menu();
$submenus = new SubMenu();

?>


<!-- Navegação -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="principal.php">Painel Administrativo</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            <li class="nav-item <?= ( "Home" == $menu )? "active" : "" ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="principal.php">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            <?php

                if (empty($usu->getTipoEmpresa())) {
                    $listamenus = $menus->constroiMenus($usu->getTipo());
                } else {
                    $listamenus = $menus->constroiMenusEmpresa($usu->getId());
                }


                if (isset($listamenus)) {
                    foreach ($listamenus as $rsmenus) {
                        if (empty($usu->getTipoEmpresa())) {
                            $listasubmenus = $submenus->constroiSubMenus($usu->getTipo(), $rsmenus['idmenu']);
                        } else {
                            $listasubmenus = $submenus->constroiSubMenusEmpresa($usu->getId(), $rsmenus['idmenu']);
                        }
                        ?>

                        <?php
                        if (empty($listasubmenus)) {//menu sem sub menu
                            ?>
                            <li class="nav-item <?= utf8_encode($rsmenus['descricao_menu']) == $menu ? "active" : "" ?>"
                                data-toggle="tooltip" data-placement="right"
                                title="<?php echo utf8_encode($rsmenus['descricao_menu']); ?>">
                                <a class="nav-link" href="<?php if ($rsmenus['url'] == "") {
                                    echo 'javascript:void(0);';
                                } else {
                                    echo $rsmenus['url'];
                                } ?>">
                                    <?php
                                    if (!empty($rsmenus["icone"])) {
                                        ?>
                                        <i class="fa fa-fw <?= utf8_encode($rsmenus["icone"]) ?>"></i>
                                        <?php
                                    }
                                    ?>
                                    <span class="nav-link-text"><?php echo utf8_encode($rsmenus['descricao_menu']); ?></span>
                                </a>
                            </li>
                            <?php
                        } else { //menu com submenu
                            ?>

                            <li class="nav-item" data-toggle="tooltip" data-placement="right"
                                title="<?php echo utf8_encode($rsmenus['descricao_menu']); ?>">
                                <a class="nav-link nav-link-collapse collapsed" <?= utf8_encode($rsmenus['descricao_menu']) == $menu ? "aria-expended=\"true\"" : "" ?>
                                   data-toggle="collapse" href="#<?= $rsmenus['idmenu'] ?>"
                                   data-parent="#exampleAccordion">
                                    <?php
                                    if (!empty($rsmenus["icone"])) {
                                        ?>
                                        <i class="fa fa-fw <?= utf8_encode($rsmenus["icone"]) ?>"></i>
                                        <?php
                                    }
                                    ?>
                                    <span class="nav-link-text"><?php echo utf8_encode($rsmenus['descricao_menu']); ?></span>
                                </a>
                                <ul class="sidenav-second-level collapse <?= (utf8_encode($rsmenus['descricao_menu']) == $menu) ? "show" : "" ?>"
                                    id="<?= $rsmenus['idmenu'] ?>">
                                    <?php
                                    foreach ($listasubmenus as $rssubmenus) {
                                        ?>
                                        <li class="<?= (strcasecmp(utf8_encode($rssubmenus['descricao_submenu']), $submenu) === 0) ? "active" : "" ?>" >
                                            <a href="<?php echo $rssubmenus['url']; ?>"><?php echo utf8_encode($rssubmenus['descricao_submenu']); ?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                    }
                }

            ?>

        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-envelope"></i>
                    <span class="d-lg-none">Messages
                    <span class="badge badge-pill badge-primary">12 New</span>
                  </span>
                    <span class="indicator text-primary d-none d-lg-block">
                    <i class="fa fa-fw fa-circle"></i>
                  </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">New Messages:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>David Miller</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>Jane Smith</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>John Doe</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">View all messages</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="d-lg-none">Alerts
                    <span class="badge badge-pill badge-warning">6 New</span>
                  </span>
                    <span class="indicator text-warning d-none d-lg-block">
                    <i class="fa fa-fw fa-circle"></i>
                  </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">New Alerts:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                    <span class="text-success">
                      <strong>
                        <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
                    </span>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                    <span class="text-danger">
                      <strong>
                        <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
                    </span>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                    <span class="text-success">
                      <strong>
                        <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
                    </span>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">View all alerts</a>
                </div>
            </li>
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0 mr-lg-2">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Buscar por...">
                        <span class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                    </div>
                </form>
            </li>
            <li class="nav-item ml-4">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>SAIR</a>
            </li>
        </ul>
    </div>
</nav>

