<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Editar Tipo de Tanque</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="index.php">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "listar"); ?>">Tipo de Tanque</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "getUpdate", array("id" => $_GET['id'])); ?>">Editar Tipo de Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <form action="<?php echo getUrl("TipoTanques", "TipoTanques", "postUpdate"); ?>" id="formu" method="post">
                    <!-- <form action="index.php?modulo=TipoTanques&controlador=TipoTanques&funcion=postUpdate" id="formu" method="post"> -->
                    <?php
                    while ($tt = pg_fetch_assoc($tipoTanque)) {
                    ?>
                        <div class="card-header">
                            <div class="card-title">Formulario edicion tipo de tanque</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 ms-auto me-auto">
                                    <div class="form-group">
                                        <label for="nombreTipoTanque">Nombre *</label>
                                        <input type="text" class="form-control" name="id" value="<?php echo $tt['id_tipo_tanque'] ?>" hidden>
                                        <input type="text" class="form-control t" name="nombreTipoTanque" id="nombreTipoTanque" placeholder="Ingrese un nombre para el tipo de tanque" value="<?php echo $tt['nombre'] ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 ms-auto me-auto">
                                    <?php

                                    print_r(
                                        '
                                        <div class="form-group">
                                            <label for="estadoTipoTanque">Estado tipo de tanque *</label>
                                            <select class="form-select form-control" id="estadoTipoTanque" name="estadoTipoTanque" value="<?php echo $tan["id_estado_tanque"] ?>" required>
                                                <option value="">Seleccione...</option>
                                        '
                                    );

                                    while ($estadoT = pg_fetch_assoc($estadoTipoTanque)) {

                                        if ($estadoT["id_estado_tipo_tanque"] == $tt["id_estado_tipo_tanque"]) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }

                                        echo '<option value="' . $estadoT["id_estado_tipo_tanque"] . '" ' . "$selected" . '> ' . $estadoT["nombre"] . '</option>';
                                    }
                                    print_r(
                                        '.
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    '
                                    );

                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-center">
                            <button class="btn btn-primary">Actualizar</button>
                            <a class="btn btn-danger" href="<?php echo getUrl("TipoTanques", "TipoTanques", "listar"); ?>">Cancelar</a>
                        </div>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script src="js/form-validations.js"></script>
    <script>
        initFormValidation('formu');
    </script>
</body>