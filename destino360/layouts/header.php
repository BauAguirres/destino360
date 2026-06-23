<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$idUsuario = $_SESSION['idUsuario'] ?? '';
$rol = $_SESSION['rol'] ?? '';

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../');
}

require_once BASE_PATH . 'config/app.php';

$emailRecordado = $_COOKIE['emailRecordado'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
</head>
<body>

    <header>
        <nav class="navbar navbar-dark navbar-expand-lg bg-secondary">
            <div class="container">
                <a href="<?= BASE_URL ?>/public/index.php" class="navbar-brand">
                    <img src="<?= BASE_URL ?>/public/assets/img/logo.png" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/public/vuelos.php">Vuelos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/public/aerolineas.php">Aerolineas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/public/novedades.php">Novedades</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <?php if ($rol == 'CEO'): ?>
                                <a class="nav-link" href="<?= BASE_URL ?>/public/ceo/dashboard.php">Dashboard</a>
                            <?php elseif ($rol == 'admin'): ?>
                                <a class="nav-link" href="<?= BASE_URL ?>/public/admin/dashboard.php">Dashboard</a>
                            <?php elseif ($rol == 'user'): ?>
                                <a class="nav-link" href="<?= BASE_URL ?>/public/user/profile.php">Mi Perfil</a>
                            <?php else: ?>
                                <button class="btn btn-light btn-sm px-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                </button>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php if (empty($rol)): ?>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Iniciar sesión</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= BASE_URL ?>/public/login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="<?php echo $emailRecordado; ?>"
                                       placeholder="Ingrese su correo electrónico" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Ingrese su contraseña" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="recordar" id="recordar"
                                       <?php echo !empty($emailRecordado) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="recordar">Recordar mi email</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                            <a href="recuperarContraseña.php" class="text-decoration-none d-block mt-3 text-center">¿Olvidaste tu contraseña?</a>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <span>¿No tenés cuenta?</span>
                        <a href="<?= BASE_URL ?>/public/registro.php" class="ms-1">Registrate</a>
                        <span class="mx-2">|</span>
                        <a href="<?= BASE_URL ?>/public/registroCEO.php">¿Sos CEO?</a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['login'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var loginModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                    loginModal.show();
                });
            </script>
        <?php endif; ?>
    <?php endif; ?>