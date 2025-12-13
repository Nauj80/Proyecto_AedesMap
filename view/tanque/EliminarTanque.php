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
                <a href="">Tanques</a>
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
                <div class="card-header">
                    <div class="card-title">Formulario creacion de tanque</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nombreTanque">Nombre</label>
                                <input type="text" class="form-control" id="nombreTanque" placeholder="Ingrese un nombre para el tanque">
                            </div>
                            <div class="form-group">
                                <label for="tipoTanque">Tipo de tanque</label>
                                <select class="form-select" id="tipoTanque">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidadPeces">Cantidad de peces</label>
                                <input type="number" class="form-control" id="cantidadPeces" placeholder="Ingrese la cantidad de peces">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="altoTanque">Alto</label>
                                <input type="number" class="form-control" id="altoTanque" placeholder="Ingrese la altura del tanque">
                            </div>
                            <div class="form-group">
                                <label for="anchoTanque">Ancho</label>
                                <input type="number" class="form-control" id="anchoTanque" placeholder="Ingrese el ancho del tanque">
                            </div>
                            <div class="form-group">
                                <label for="profundidadTanque">Profundidad</label>
                                <input type="number" class="form-control" id="profundidadTanque" placeholder="Ingrese la profundidad del tanque">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action text-center">
                    <button class="btn btn-success">Crear</button>
                    <button class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>