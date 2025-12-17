<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>


<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Editar Tanques</h3>
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
                <a href="<?php echo getUrl("Tanque", "Tanque", "listar"); ?>">Tanques</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("Tanque", "Tanque", "getUpdate", array("id" => $_GET['id'])); ?>">Editar Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <?php
                while ($tan = pg_fetch_assoc($Tanque)) {

                ?>
                    <!-- <form action="index.php?modulo=Tanque&controlador=Tanque&funcion=postUpdate" method="post"> -->
                    <form action="<?php echo getUrl("Tanque", "Tanque", "postUpdate"); ?>" id="formu" method="post">
                        <div class="card-header">
                            <div class="card-title">Formulario edicion de tanque</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <input type="hidden" name="id_tanque" value="<?php echo $tan["id_tanque"] ?>">
                                    <div class="form-group">
                                        <label for="nombreTanque" class="required">Nombre</label>
                                        <input type="text" class="form-control t" id="nombreTanque" name="nombreTanque" placeholder="Ingrese un nombre para el tanque" value="<?php echo $tan['nombre'] ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="zoocriadero" class="required">Zoocriadero</label>
                                        <select class="form-select form-control" id="zoocriadero" name="zoocriadero" value="<?php echo $tan["id_zoocriadero"] ?>" required>
                                            <option value="">Seleccione...</option>
                                            <?php
                                            while ($zoo = pg_fetch_assoc($zoocriadero)) {
                                                if ($zoo["id_zoocriadero"] == $tan["id_zoocriadero"]) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                echo '<option value="' . $zoo["id_zoocriadero"] . '" ' . "$selected" . '> ' . $zoo["nombre_zoocriadero"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipoTanque" class="required">Tipo de tanque</label>
                                        <select class="form-select form-control" id="tipoTanque" name="tipoTanque" value="<?php echo $tan["id_zoocriadero"] ?>" required>
                                            <option value="">Seleccione...</option>
                                            <?php

                                            while ($tipoT = pg_fetch_assoc($tipoTanque)) {

                                                if ($tipoT["id_tipo_tanque"] == $tan["id_tipo_tanque"]) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }


                                                echo '<option value="' . $tipoT["id_tipo_tanque"] . '" ' . "$selected" . '> ' . $tipoT["nombre"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cantidadPeces" class="required">Cantidad de peces</label>
                                        <input type="text" class="form-control n" id="cantidadPeces" name="cantidadPeces" placeholder="Ingrese la cantidad de peces" value="<?php echo $tan['cantidad_peces'] ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="largoTanque" class="required">Altura del tanque (m)</label>
                                        <input type="text" class="form-control f" id="largoTanque" name="largoTanque" placeholder="Ingrese el largo del tanque en m" value="<?php echo $tan['alto'] ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="anchoTanque" class="required">Ancho del tanque (m)</label>
                                        <input type="text" class="form-control f" id="anchoTanque" name="anchoTanque" placeholder="Ingrese el ancho del tanque en m" value="<?php echo $tan['ancho'] ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="profundidadTanque" class="required">Profundidad del tanque (m)</label>
                                        <input type="text" class="form-control f" id="profundidadTanque" name="profundidadTanque" placeholder="Ingrese la profundidad del tanque en m" value="<?php echo $tan['profundo'] ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="estadoTanque" class="required">Estado tanque</label>
                                        <select class="form-select form-control" id="estadoTanque" name="estadoTanque" value="<?php echo $tan["id_estado_tanque"] ?>">
                                            <option value="">Seleccione...</option>
                                            <?php

                                            while ($estadoT = pg_fetch_assoc($estadoTanque)) {

                                                if ($estadoT["id_estado_tanque"] == $tan["id_estado_tanque"]) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }

                                                echo '<option value="' . $estadoT["id_estado_tanque"] . '" ' . "$selected" . '> ' . $estadoT["nombre"] . '</option>';
                                            }

                                            ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-center">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a class="btn btn-danger" href="<?php echo getUrl("Tanque", "Tanque", "listar"); ?>">Cancelar</a>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script src="js/form-validations.js"></script>
    <script>
        initFormValidation('formu');
    </script>
</body>