<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Crear Tanques</h3>
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
                <a href="<?php echo getUrl("Tanque", "Tanque", "getCreate"); ?>">Crear Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <form action="<?php echo getUrl("Tanque", "Tanque", "postCreate"); ?>" id="formu" method="post">
                    <div class="card-header">
                        <div class="card-title">Formulario creacion de tanque</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="nombreTanque" class="required">Nombre</label>
                                    <input type="text" class="form-control t" id="nombreTanque" name="nombreTanque" placeholder="Ingrese un nombre para el tanque" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="zoocriadero" class="required">Zoocriadero</label>
                                    <select class="form-select form-control" id="zoocriadero" name="zoocriadero" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        while ($zoo = pg_fetch_assoc($zoocriadero)) {

                                            echo '<option value="' . $zoo["id_zoocriadero"] . '"> ' . $zoo["nombre_zoocriadero"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="tipoTanque" class="required">Tipo de tanque</label>
                                    <select class="form-select form-control" id="tipoTanque" name="tipoTanque" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        while ($tipoT = pg_fetch_assoc($tipoTanque)) {

                                            echo '<option value="' . $tipoT["id_tipo_tanque"] . '"> ' . $tipoT["nombre"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cantidadPeces" class="required">Cantidad de peces</label>
                                    <input type="text" class="form-control n" id="cantidadPeces" name="cantidadPeces" placeholder="Ingrese la cantidad de peces">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="altoTanque" class="required">Altura del tanque (cm)</label>
                                    <input type="text" class="form-control f" id="altoTanque" name="altoTanque" placeholder="Ingrese la altura del tanque en cm">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="anchoTanque" class="required">Ancho del tanque (cm)</label>
                                    <input type="text" class="form-control f" id="anchoTanque" name="anchoTanque" placeholder="Ingrese el ancho del tanque en cm">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="profundidadTanque" class="required">Profundidad del tanque (cm)</label>
                                    <input type="text" class="form-control f" id="profundidadTanque" name="profundidadTanque" placeholder="Ingrese la profundidad del tanque en cm">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-center">
                        <button type="submit" class="btn btn-primary">Crear</button>
                        <a class="btn btn-danger" href="<?php echo getUrl("Tanque", "Tanque", "listar"); ?>">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/form-validations.js"></script>
    <script>
        // initialize validation for this form
        initFormValidation('formu');
    </script>
</body>