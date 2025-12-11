<?php
// view/login/Login.php
include_once("../../lib/helpers.php");

// Si ya está logueado, redirigir
if (isset($_SESSION['auth']) && $_SESSION['auth'] == "ok") {
    header("Location: ../../web/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - AedesMap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: linear-gradient(90deg, #003366, #0055aa);
            font-family: Arial, sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 40px;
            width: 420px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="login-box">

            <div class="text-center mb-4">
                <img src="../../web/assets/img/kaiadmin/logo.png" alt="Logo" width="180">
            </div>

            <h3 class="text-center mb-4">Inicio de Sesión</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- CORREGIDO: La ruta correcta al ajax.php -->
            <form action="../../web/ajax.php?modulo=Login&controlador=Login&funcion=login" method="POST">
                <div class="mb-3">
                    <label class="form-label">Número de documento</label>
                    <input type="text" class="form-control" placeholder="Ingresa tu documento" name="documento"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" placeholder="Ingresa tu contraseña"
                        required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary fw-bold">
                        Iniciar Sesión
                    </button>
                </div>

                <div class="text-center">
                    <a href="#" class="fw-bold" style="color:#0056d6;">¿Olvidaste tu contraseña?</a>
                </div>

            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>