<?php 

include_once '../../seguridad/seguridadAdmin.php';

$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudAerolineas.php';
require_once BASE_PATH . 'controllers/crudPromociones.php';

$crudAerolinea = new CrudAerolineas();
$crudUsuarios = new CrudUsuarios();
$crudPromociones = new CrudPromociones();

$usuario = $crudUsuarios->obtenerUsuario($idUsuario);

// Conteos globales del sistema
$totalAerolineas = $crudAerolinea->contarAerolineas();
$promosPendientes = $crudPromociones->contarPendientesGlobal();
$ceosPendientes = $crudUsuarios->contarCeosPendientes();
$totalUsuarios = $crudUsuarios->contarUsuarios();

$error = $_GET['error'] ?? '';
$exito = $_GET['exito'] ?? '';
?>


<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($exito): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $exito ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">

                <!-- SIDEBAR -->
                <?php include '../../layouts/sidebar.php'; ?>

                <!-- CONTENIDO -->
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <strong class="d-block mb-4 fs-5">Bienvenido, <?php echo $usuario['nombreUsuario']; ?>!</strong>

                        <h3 class="mb-4"><i class="bi bi-speedometer2"></i> Resumen del Sistema</h3>
                        <div class="row g-3 mb-5">

                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                    <i class="bi bi-airplane-fill fs-2 text-primary"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $totalAerolineas ?? 0 ?></div>
                                    <small class="text-muted">Aerolíneas</small>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                    <i class="bi bi-percent fs-2 text-warning"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $promosPendientes ?? 0 ?></div>
                                    <small class="text-muted">Promos a aprobar</small>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                    <i class="bi bi-person-check fs-2 text-info"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $ceosPendientes ?? 0 ?></div>
                                    <small class="text-muted">Solicitudes de CEO</small>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                    <i class="bi bi-people-fill fs-2 text-success"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $totalUsuarios ?? 0 ?></div>
                                    <small class="text-muted">Usuarios</small>
                                </div>
                            </div>

                        </div>

                        <!-- Accesos rápidos -->
                        <h3 class="mb-4"><i class="bi bi-lightning-charge"></i> Accesos rápidos</h3>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <a href="crearAerolinea.php" class="btn btn-outline-primary w-100 py-4 rounded-4">
                                    <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                                    Crear aerolínea
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="promociones.php" class="btn btn-outline-warning w-100 py-4 rounded-4">
                                    <i class="bi bi-percent fs-3 d-block mb-2"></i>
                                    Aprobar promos
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="novedades.php" class="btn btn-outline-success w-100 py-4 rounded-4">
                                    <i class="bi bi-megaphone fs-3 d-block mb-2"></i>
                                    Novedades
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="reportes.php" class="btn btn-outline-secondary w-100 py-4 rounded-4">
                                    <i class="bi bi-graph-up fs-3 d-block mb-2"></i>
                                    Reportes
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../../layouts/footerAdmin.php'; ?>