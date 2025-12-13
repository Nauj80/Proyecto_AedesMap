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
                <a href="">Tanques</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("Tanque", "Tanque", "getUpdate"); ?>">Editar Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <?php
                while ($tan = pg_fetch_assoc($Tanque)) {

                ?>
                    <form action="index.php?modulo=Tanque&controlador=Tanque&funcion=postUpdate" method="post">
                        <div class="card-header">
                            <div class="card-title">Formulario edicion de tanque</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <input type="hidden" name="id" value="<?php echo $tan["id_tanque"] ?>">
                                    <div class="form-group">
                                        <label for="zoocriadero">Zoocriadero</label>
                                        <select class="form-select" id="zoocriadero" name="zoocriadero" value="<?php echo $tan["id_zoocriadero"] ?>" required>
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
                                        <select class="form-select" id="tipoTanque" name="tipoTanque" value="<?php echo $tan["id_zoocriadero"] ?>" required>
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
                                        <input type="text" class="form-control" id="cantidadPeces" name="cantidadPeces" placeholder="Ingrese la cantidad de peces" value="<?php echo $tan['cantidad_peces'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="altoTanque">Altura del tanque (cm)</label>
                                        <input type="text" class="form-control" id="altoTanque" name="altoTanque" placeholder="Ingrese la altura del tanque en cm" value="<?php echo $tan['alto'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="anchoTanque">Ancho del tanque (cm)</label>
                                        <input type="text" class="form-control" id="anchoTanque" name="anchoTanque" placeholder="Ingrese el ancho del tanque en cm" value="<?php echo $tan['ancho'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="profundidadTanque">Profundidad del tanque (cm)</label>
                                        <input type="text" class="form-control" id="profundidadTanque" name="profundidadTanque" placeholder="Ingrese la profundidad del tanque en cm" value="<?php echo $tan['profundo'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-center">
                            <button type="submit" class="btn btn-success">Crear</button>
                            <a class="btn btn-danger" href="<?php echo getUrl("Tanque", "Tanque", "list"); ?>">Cancelar</a>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>