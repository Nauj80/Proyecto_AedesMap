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
            <?php
            // Determinar el controlador actual desde la URL si está presente,
            // en caso contrario usar el valor guardado en la sesión.
            $controller = '';
            if (isset($_GET['controlador'])) {
                $controller = ucwords($_GET['controlador']);
                $_SESSION['controller'] = $controller;
            } elseif (isset($_SESSION['controller'])) {
                $controller = $_SESSION['controller'];
            }
            ?>
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo ($controller === 'Mapa') ? 'active' : ''; ?>">
                    <a href="<?php echo getUrl("Mapa", "Mapa", "listar") ?>">
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
                <?php
                // EL IF DEBE EMPEZAR AQUÍ
                if (tieneModulo("Zoocriaderos") && tienePermiso("Zoocriaderos", "Consultar") || tienePermiso("Zoocriaderos", "Registrar")) {
                    ?>
                    <li class="nav-item <?php echo ($controller === 'Zoocriadero') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#zoocriadero">
                            <i class="fas fa-building"></i>
                            <p>Zoocriaderos</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'Zoocriadero') ? 'show' : ''; ?>" id="zoocriadero">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Zoocriaderos", "Registrar")) { ?>
                                    <li>
                                        <a href="<?= getUrl("Zoocriadero", "Zoocriadero", "registrar") ?>">
                                            <span class="sub-item">Registrar Zoocriadero</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php
                } // EL IF TERMINA AQUÍ
                ?>

                <?php
                if (tieneModulo("Tipo de tanques")) {
                    ?>
                    <li class="nav-item <?php echo ($controller === 'TipoTanques') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#tipotanque">
                            <i class="fas fa-th-large"></i>
                            <p>Tipo de tanques</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'TipoTanques') ? 'show' : ''; ?>" id="tipotanque">
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
                    <li class="nav-item <?php echo ($controller === 'Tanque') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#tanques">
                            <i class="fas fa-fish"></i>
                            <p>Tanques</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'Tanque') ? 'show' : ''; ?>" id="tanques">
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
                    <li class="nav-item <?php echo ($controller === 'TipoActividades') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#tipoactividades">
                            <i class="fas fa-list-alt"></i>
                            <p>Tipos de actividades</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'TipoActividades') ? 'show' : ''; ?>"
                            id="tipoactividades">
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
                    <li class="nav-item <?php echo ($controller === 'ActividadesSeguimiento') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#actividades">
                            <i class="fas fa-pen-square"></i>
                            <p>Actividades en tanques</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'ActividadesSeguimiento') ? 'show' : ''; ?>"
                            id="actividades">
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
                    <li class="nav-item <?php echo ($controller === 'GestionUsuarios') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#usuarios">
                            <i class="fas fa-user"></i>
                            <p>Gestión de usuarios</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'GestionUsuarios') ? 'show' : ''; ?>"
                            id="usuarios">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Gestión de usuarios", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("GestionUsuarios", "GestionUsuarios", "getCreate"); ?>">
                                            <span class="sub-item">Registrar usuario</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Gestión de usuarios", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("GestionUsuarios", "GestionUsuarios", "listar"); ?>">
                                            <span class="sub-item">Cosultar usuario</span>
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
                    <li class="nav-item <?php echo ($controller === 'GestionRoles') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#rol">
                            <i class="fas fa-users-cog"></i>
                            <p>Gestión de roles</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'GestionRoles') ? 'show' : ''; ?>" id="rol">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Gestión de roles", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("GestionRoles", "GestionRoles", "listar"); ?>">
                                            <span class="sub-item">Consultar roles</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Gestión de roles", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("GestionRoles", "GestionRoles", "editar"); ?>">
                                            <span class="sub-item">Editar Roles</span>
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
                    <li class="nav-item <?php echo ($controller === 'Configuracion') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#configuracion">
                            <i class="fas fa-cog"></i>
                            <p>Configuración</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'Configuracion') ? 'show' : ''; ?>"
                            id="configuracion">
                            <ul class="nav nav-collapse">
                                <?php if (tienePermiso("Configuración", "Registrar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("Configuracion", "Configuracion", "verManuales"); ?>">
                                            <span class="sub-item">Manuales</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (tienePermiso("Configuración", "Consultar")) { ?>
                                    <li>
                                        <a href="<?php echo getUrl("Configuracion", "Configuracion", "verManuales"); ?>">
                                            <span class="sub-item">Actualizar perfil</span>
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
                    <li class="nav-item <?php echo ($controller === 'Reportes') ? 'active' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#reportes">
                            <i class="fas fa-newspaper"></i>
                            <p>Reportes</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo ($controller === 'Reportes') ? 'show' : ''; ?>" id="reportes">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="<?php echo getUrl("Reportes", "Reportes", "listSeguimientoActividad"); ?>">
                                        <span class="sub-item">Seguimiento de Actividades</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo getUrl("Reportes", "NacidosMuertes", "listSeguimientoTanques"); ?>">
                                        <span class="sub-item">Nacimientos y muertes por tanque</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="charts/sparkline.html">
                                        <span class="sub-item">Tanques por Zoocriadero</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="charts/sparkline.html">
                                        <span class="sub-item">Actividad por tanque</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item <?php echo ($controller === 'SobreAedesMap') ? 'active' : ''; ?>">
                    <a href="<?php echo getUrl("SobreAedesMap", "SobreAedesMap", "verInfo"); ?>">
                        <i class="fas fa-info"></i>
                        <p>Sobre AedesMap</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>