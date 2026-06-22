<footer class="bg-secondary text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <img src="<?= BASE_URL ?>/public/assets/img/logo.png" alt="Logo" style="max-height: 50px;" class="mb-3">
                <p class="small text-light">
                    Destino360, tu plataforma para encontrar y reservar vuelos de forma rápida y sencilla.
                </p>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">Navegación</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?= BASE_URL ?>/public/index.php" class="text-light text-decoration-none">Inicio</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/public/vuelos.php" class="text-light text-decoration-none">Vuelos</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/public/aerolineas.php" class="text-light text-decoration-none">Aerolíneas</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/public/novedades.php" class="text-light text-decoration-none">Novedades</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <?php $rolFooter = $_SESSION['rol'] ?? ''; ?>

                <?php if ($rolFooter == 'admin'): ?>
                    <h6 class="fw-bold mb-3">Panel Admin</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/admin/dashboard.php" class="text-light text-decoration-none">Inicio</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/admin/aerolineas.php" class="text-light text-decoration-none">Gestionar Aerolíneas</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/admin/usuarios.php" class="text-light text-decoration-none">Gestionar Usuarios</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/admin/reportes.php" class="text-light text-decoration-none">Reportes</a></li>
                    </ul>

                <?php elseif ($rolFooter == 'CEO'): ?>
                    <h6 class="fw-bold mb-3">Panel CEO</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/ceo/dashboard.php" class="text-light text-decoration-none">Mi Aerolínea</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/ceo/vuelos.php" class="text-light text-decoration-none">Gestionar Vuelos</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/ceo/promociones.php" class="text-light text-decoration-none">Gestionar Promociones</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/ceo/reportes.php" class="text-light text-decoration-none">Reportes</a></li>
                    </ul>

                <?php elseif ($rolFooter == 'user'): ?>
                    <h6 class="fw-bold mb-3">Mi Cuenta</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/perfil.php" class="text-light text-decoration-none">Mi Perfil</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/user/reservas.php" class="text-light text-decoration-none">Mis Reservas</a></li>
                    </ul>

                <?php else: ?>
                    <h6 class="fw-bold mb-3">Cuenta</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/index.php" class="text-light text-decoration-none">Iniciar Sesión</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/registro.php" class="text-light text-decoration-none">Registrarse</a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Acceso</h6>
                <ul class="list-unstyled small">
                    <?php if (!empty($_SESSION['idUsuario'])): ?>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/perfil.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Mi Perfil</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/cerrarSesion.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/public/index.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <hr class="border-light">

        <div class="text-center small text-light">
            © <?php echo date('Y'); ?> Destino360 — Trabajo Práctico Entornos Gráficos
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/public/assets/js/main.js"></script>
</body>
</html>