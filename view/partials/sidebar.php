<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <a href="../web/index.php" class="logo">
                <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="35">
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#mapa" class="collapsed" aria-expanded="false">
                        <i class="fas fa-map-marked-alt"></i>
                        <p>Visualización del mapa</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Módulos</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#zoocriadero">
                        <i class="fas fa-building"></i>
                        <p>Zoocriaderos</p>
                        <span class="caret"></span>
                    </a>
                    <?php
                    if (tieneModulo("Zoocriaderos")) {
                    ?>
                        <div class="collapse" id="zoocriadero">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Zoocriaderos", "Registrar")) { ?>
                                    <li>
                                        <a href="<?= getUrl("Zoocriadero", "Zoocriadero", "registrar") ?>">
                                            <span class="sub-item">Registrar Zoocriadero</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Zoocriaderos", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "listar"); ?>">

                                            <span class="sub-item">Consultar Zoocriaderos</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </li>

                <?php
                if (tieneModulo("Tipo de tanques")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#tipotanque">
                            <i class="fas fa-th-large"></i>
                            <p>Tipo de tanques</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="tipotanque">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Tipo de tanques", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "getCreate"); ?>">
                                            <span class="sub-item">Crear Tipo de Tanque</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Tipo de tanques", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "listar"); ?>">
                                            <span class="sub-item">Consultar Tipos de Tanque</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Tanques")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#tanques">
                            <i class="fas fa-fish"></i>
                            <p>Tanques</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="tanques">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Tanques", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("Tanque", "Tanque", "getCreate"); ?>">
                                            <span class="sub-item">Crear Tanque</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Tanques", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("Tanque", "Tanque", "listar"); ?>">
                                            <span class="sub-item">Consultar Tanques</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Tipo de actividades")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#tipoactividades">
                            <i class="fas fa-list-alt"></i>
                            <p>Tipos de actividades</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="tipoactividades">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Tipo de actividades", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("TipoActividades", "TipoActividades", "create") ?>">
                                            <span class="sub-item">Registro de actividad</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Tipo de actividades", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("TipoActividades", "TipoActividades", "listar") ?>">
                                            <span class="sub-item">Lista de actividades</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Actividades en tanques")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#actividades">
                            <i class="fas fa-pen-square"></i>
                            <p>Actividades en tanques</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="actividades">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Actividades en tanques", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("ActividadesSeguimiento", "Actividades", "create") ?>">
                                            <span class="sub-item">Registro de seguimiento</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Actividades en tanques", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("ActividadesSeguimiento", "Actividades", "listar") ?>">
                                            <span class="sub-item">Lista de seguimientos</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Gestión de usuarios")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#usuarios">
                            <i class="fas fa-user"></i>
                            <p>Gestión de usuarios</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="usuarios">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Gestión de usuarios", "Registrar")) { ?>
                                    <li>
                                        <a href="maps/googlemaps.html">
                                            <span class="sub-item">Google Maps</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Gestión de usuarios", "Consultar")) { ?>
                                    <li>
                                        <a href="maps/jsvectormap.html">
                                            <span class="sub-item">Jsvectormap</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Gestión de roles")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#rol">
                            <i class="fas fa-users-cog"></i>
                            <p>Gestión de roles</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="rol">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Gestión de roles", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("GestionRoles", "GestionRoles", "listar"); ?>">
                                            <span class="sub-item">Permisos del rol</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Gestión de roles", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("GestionRoles", "GestionRoles", "listar"); ?>">
                                            <span class="sub-item">Consultar Roles</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Configuración")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#configuracion">
                            <i class="fas fa-cog"></i>
                            <p>Configuración</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="configuracion">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Configuración", "Registrar")) { ?>
                                    <li>
                                        <a href="charts/charts.html">
                                            <span class="sub-item">Chart Js</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Configuración", "Consultar")) { ?>
                                    <li>
                                        <a href="charts/sparkline.html">
                                            <span class="sub-item">Sparkline</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>

                <?php
                if (tieneModulo("Reportes")) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#reportes">
                            <i class="fas fa-newspaper"></i>
                            <p>Reportes</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="reportes">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Reportes", "Registrar")) { ?>
                                    <li>
                                        <a href="charts/charts.html">
                                            <span class="sub-item">Chart Js</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Reportes", "Consultar")) { ?>
                                    <li>
                                        <a href="charts/sparkline.html">
                                            <span class="sub-item">Sparkline</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>
                <li class="nav-item">
                    <a href="<?php echo getUrl("SobreAedesMap", "SobreAedesMap", "verInfo"); ?>">
                        <i class="fas fa-info"></i>
                        <p>Sobre AedesMap</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>