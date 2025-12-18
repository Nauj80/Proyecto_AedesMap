<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Eliminar Tipo de Tanque</h3>
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
                <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "getDelete", array("id" => $_GET["id"])); ?>">Eliminar Tipo de Tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-ms-12">
            <div class="card">
                <form action="<?php echo getUrl("TipoTanques", "TipoTanques", "postDelete"); ?>" class="form-eliminar" method="post">
                    <?php
                    while ($tt = pg_fetch_assoc($tipoTanque)) {
                    ?>
                        <div class="card-header">
                            <div class="card-title">Inhabilitar tipo de tanque</div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger" role="alert">
                                ¿Seguro que desea inhabilitar el Tipo de Tanque: <strong> <?php echo $tt['nombre'] ?></strong> ?
                            </div>
                            <div class="row">
                                <div class="col-md-4 ms-auto me-auto">
                                    <div class="form-group">
                                        <label for="nombreTipoTanque">Nombre</label>
                                        <input type="text" class="form-control" name="id" value="<?php echo $tt['id_tipo_tanque'] ?>" hidden>
                                        <input type="text" class="form-control" name="nombreTipoTanque" id="nombreTipoTanque" placeholder="Ingrese un nombre para el tipo de tanque" value="<?php echo $tt['nombre'] ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-center">
                            <button class="btn btn-danger">Inhabilitar</button>
                            <a class="btn btn-secundary" href="<?php echo getUrl("TipoTanques", "TipoTanques", "listar"); ?>">Cancelar</a>
                        </div>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.form-eliminar');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenimos el envío tradicional del formulario

                const url = form.action;
                const formData = new FormData(form);

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data && data.data.redirect) {
                            window.location.href = data.data.redirect; // Redireccionamos a la lista
                        } else {
                            alert(data.message || 'Ocurrió un error al intentar inhabilitar el registro.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>