<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Eliminar Tanques</h3>
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
                <a href="<?php echo getUrl("Tanque", "Tanque", "getDelete", array("id" => $_GET["id"])); ?>">Eliminar Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <?php
                while ($tan = pg_fetch_assoc($Tanque)) {

                ?> 
                    <form id="form-eliminar" action="<?php echo getUrl("Tanque", "Tanque", "postDelete"); ?>" method="post">
                        <div class="card-header">
                            <div class="card-title">Eliminar tanque</div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger" role="alert">
                                ¿Seguro que desea eliminar el Tanque: <strong> <?php echo $tan['nombre'] ?></strong> ?
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <input type="hidden" name="id_tanque" value="<?php echo $tan["id_tanque"] ?>">
                                    <div class="form-group">
                                        <label for="nombreTanque">Nombre</label>
                                        <input type="text" class="form-control t" id="nombreTanque" name="nombreTanque" placeholder="Ingrese un nombre para el tanque" value="<?php echo $tan['nombre'] ?>" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="zoocriadero">Zoocriadero</label>
                                        <select class="form-select form-control" id="zoocriadero" name="zoocriadero" value="<?php echo $tan["id_zoocriadero"] ?>" disabled>
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
                                    </div>
                                    <div class="form-group">
                                        <label for="tipoTanque">Tipo de tanque</label>
                                        <select class="form-select form-control" id="tipoTanque" name="tipoTanque" value="<?php echo $tan["id_zoocriadero"] ?>" disabled>
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
                                    </div>

                                    <div class="form-group">
                                        <label for="cantidadPeces">Cantidad de peces</label>
                                        <input type="text" class="form-control" id="cantidadPeces" name="cantidadPeces" placeholder="Ingrese la cantidad de peces" value="<?php echo $tan['cantidad_peces'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="largoTanque">Largo del tanque (m)</label>
                                        <input type="text" class="form-control" id="largoTanque" name="largoTanque" placeholder="Ingrese el largo del tanque en m" value="<?php echo $tan['alto'] ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="anchoTanque">Ancho del tanque (m)</label>
                                        <input type="text" class="form-control" id="anchoTanque" name="anchoTanque" placeholder="Ingrese el ancho del tanque en m" value="<?php echo $tan['ancho'] ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="profundidadTanque">Profundidad del tanque (m)</label>
                                        <input type="text" class="form-control" id="profundidadTanque" name="profundidadTanque" placeholder="Ingrese la profundidad del tanque en m" value="<?php echo $tan['profundo'] ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="estadoTanque">Estado tanque</label>
                                        <select class="form-select form-control" id="estadoTanque" name="estadoTanque" value="<?php echo $tan["id_estado_tanque"] ?>" disabled>
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
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <a class="btn" href="<?php echo getUrl("Tanque", "Tanque", "listar"); ?>">Cancelar</a>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Proyecto_AedesMap/web/js/form-validations.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initFormValidation('form-eliminar');
    });
</script>