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
                <form action="index.php?modulo=TipoTanques&controlador=TipoTanques&funcion=postCreate" method="post">
                    <div class="card-header">
                        <div class="card-title">Formulario creacion tipo de tanques</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 ms-auto me-auto">
                                <div class="form-group">
                                    <label for="nombreTipoTanque">Nombre</label>
                                    <input type="text" class="form-control" name="nombreTipoTanque" id="nombreTipoTanque" placeholder="Ingrese un nombre para el tipo de tanque" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-center">
                        <button type="submit" class="btn btn-success">Crear</button>

                        <a class="btn btn-danger" href="<?php echo getUrl("TipoTanques", "TipoTanques", "list"); ?>">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>