<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Crear Tipo de Tanque</h3>
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
                <a href="">Tipo de Tanque</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "getCreate"); ?>">Crear Tipo de Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <form action="<?php echo getUrl("TipoTanques", "TipoTanques", "postCreate"); ?>" id="formu" method="post">
                    <div class="card-header">
                        <div class="card-title">Formulario creacion tipo de tanques</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 ms-auto me-auto">
                                <div class="form-group">
                                    <label for="nombreTipoTanque" class="required">Nombre</label>
                                    <input type="text" class="form-control" name="nombreTipoTanque" id="nombreTipoTanque" placeholder="Ingrese un nombre para el tipo de tanque" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-center">
                        <button type="submit" class="btn btn-primary">Crear</button>

                        <a class="btn btn-danger" href="<?php echo getUrl("TipoTanques", "TipoTanques", "listar"); ?>">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Proyecto_AedesMap/web/js/form-validations.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initFormValidation('formu');
    });
</script>