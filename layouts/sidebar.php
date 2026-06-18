<?php
$paginaActual = basename($_SERVER['PHP_SELF']);
$rol = $_SESSION['rol'] ?? '';
$_SESSION['estadoUsuario'] = 'verificado' ?? null;
?>
<div class="col-md-3 col-lg-2 mb-3">
    <div class="shadow-lg p-3 bg-body rounded">
        <div class="nav flex-column gap-2">

            <?php if ($rol == 'admin'): ?>
                <strong class="mx-2 mb-2">Panel Admin</strong>

                <a href="<?= BASE_URL ?>/public/admin/dashboard.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="bi bi-house"></i> Inicio
                </a>
                <a href="<?= BASE_URL ?>/public/admin/aerolineas.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'aerolineas.php' ? 'active' : ($paginaActual == 'crearAerolinea.php' ? 'active' : '') ?>">
                    <i class="bi bi-airplane"></i> Gestionar Aerolíneas
                </a>
                <a href="<?= BASE_URL ?>/public/admin/promociones.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'promociones.php' ? 'active' : '' ?>">
                    <i class="bi bi-percent"></i> Aprobar Promociones
                </a>
                <a href="<?= BASE_URL ?>/public/admin/usuarios.php"
                    class="btn btn-outline-primary text-start <?= $paginaActual == 'usuarios.php' ? 'active' : ($paginaActual == 'solicitudes.php' ? 'active' : '') ?>">
                        <i class="bi bi-people"></i> Gestionar Usuarios
                    </a>
                <a href="<?= BASE_URL ?>/public/admin/novedades.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'novedades.php' ? 'active' : ($paginaActual == 'crearNovedad.php' ? 'active' : '') ?>">
                    <i class="bi bi-megaphone"></i> Gestionar Novedades
                </a>
                <a href="<?= BASE_URL ?>/public/admin/reportes.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'reportes.php' ? 'active' : '' ?>">
                    <i class="bi bi-graph-up"></i> Reportes
                </a>

            <?php elseif ($rol == 'CEO'): ?>
                <strong class="mx-2 mb-2">Panel CEO</strong>

                <a href="<?= BASE_URL ?>/public/ceo/dashboard.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="bi bi-house"></i> Mi Aerolínea
                </a>
                <a href="<?= BASE_URL ?>/public/perfil.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'perfil.php' ? 'active' : '' ?>">
                    <i class="bi bi-person"></i> Información Personal
                </a>
                <?php if (($_SESSION['estadoUsuario'] ?? null) == 'verificado'): ?>
                    <a href="<?= BASE_URL ?>/public/ceo/vuelos.php"
                       class="btn btn-outline-primary text-start <?= $paginaActual == 'vuelos.php' ? 'active' : '' ?>">
                        <i class="bi bi-airplane"></i> Gestionar Vuelos
                    </a>
                    <a href="<?= BASE_URL ?>/public/ceo/promociones.php"
                       class="btn btn-outline-primary text-start <?= $paginaActual == 'promociones.php' ? 'active' : '' ?>">
                        <i class="bi bi-percent"></i> Gestionar Promociones
                    </a>
                    <a href="<?= BASE_URL ?>/public/ceo/reportes.php"
                       class="btn btn-outline-primary text-start <?= $paginaActual == 'reportes.php' ? 'active' : '' ?>">
                        <i class="bi bi-graph-up"></i> Reportes
                    </a>
                <?php endif; ?>

            <?php elseif ($rol == 'user'): ?>
                <strong class="mx-2 mb-2">Mi Cuenta</strong>

                <a href="<?= BASE_URL ?>/public/perfil.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'perfil.php' ? 'active' : '' ?>">
                    <i class="bi bi-person"></i> Mi Perfil
                </a>
                <a href="<?= BASE_URL ?>/public/user/reservas.php"
                   class="btn btn-outline-primary text-start <?= $paginaActual == 'reservas.php' ? 'active' : '' ?>">
                    <i class="bi bi-bookmark-check"></i> Mis Reservas
                </a>

            <?php endif; ?>

            <a href="<?= BASE_URL ?>/public/seguridad.php"
               class="btn btn-outline-primary text-start <?= $paginaActual == 'seguridad.php' ? 'active' : '' ?>">
                <i class="bi bi-shield-lock"></i> Seguridad
            </a>
            <a href="<?= BASE_URL ?>/public/cerrarSesion.php"
               class="btn btn-outline-danger text-start">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>

        </div>
    </div>
</div>