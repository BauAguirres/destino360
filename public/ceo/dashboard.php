<?php

include_once '../../seguridad/seguridadCeo.php';

$idUsuario = $_SESSION['idUsuario'];
$idAerolinea = $_SESSION['idAerolinea'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudVuelos.php';
require_once BASE_PATH . 'controllers/crudPromociones.php';
require_once BASE_PATH . 'controllers/crudReservas.php';

$crudVuelos = new CrudVuelos();
$crudUsuarios = new CrudUsuarios();
$crudPromociones = new CrudPromociones();
$crudReservas = new CrudReservas();

$usuario = $crudUsuarios->obtenerCEO($idUsuario);

$conteoVuelos = $crudVuelos->contarVuelosPorEstado($idAerolinea);
$promosPendientes = $crudPromociones->contarPromocionesPendientes($idAerolinea);
$conteoReservas = $crudReservas->contarReservasPorEstado($idAerolinea);

$error = $_GET['error'] ?? '';
$exito = $_GET['exito'] ?? '';
?>


<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">

            <!-- Alertas -->
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

                        <!-- CREDENCIAL DE LA AEROLÍNEA -->
                        <h3 class="mb-4"><i class="bi bi-airplane"></i> Mi Aerolínea</h3>
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-8">
                                <div class="card border-0 shadow rounded-4 overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-4 bg-primary d-flex align-items-center justify-content-center p-3">
                                            <div class="bg-white rounded-3 d-flex align-items-center justify-content-center p-2"
                                                 style="width: 150px; height: 150px;">
                                                <img src="<?= BASE_URL ?>/public/assets/img/logosAerolineas/<?php echo $usuario['urlLogo'] ?? 'default-logo.png'; ?>"
                                                     alt="Logo"
                                                     style="max-width: 95%; max-height: 95%; object-fit: contain;">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-4">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Aerolínea</small>
                                                        <h4 class="fw-bold mb-0"><?php echo $usuario['nombre'] ?? '—'; ?></h4>
                                                    </div>
                                                    <?php $estado = $usuario['estadoUsuario'] ?? null; ?>
                                                    <?php if ($estado == 'verificado'): ?>
                                                        <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verificado</span>
                                                    <?php elseif ($estado == 'pendiente'): ?>
                                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Pendiente</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rechazado</span>
                                                    <?php endif; ?>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Código IATA</small>
                                                        <p class="fw-bold fs-5 mb-0"><?php echo $usuario['codIATA'] ?? '—'; ?></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Código País</small>
                                                        <p class="fw-bold fs-5 mb-0"><?php echo $usuario['codPais'] ?? '—'; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (($usuario['estadoUsuario'] ?? null) == 'verificado'): ?>

                            <!-- RESUMEN DE VUELOS -->
                        <h3 class="mb-4"><i class="bi bi-speedometer2"></i> Resumen de Vuelos</h3>
                        <div class="row g-3 mb-4">

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-airplane-fill fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fs-2 fw-bold"><?= $conteoVuelos['total'] ?? 0 ?></div>
                                            <small class="text-muted">Total de vuelos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                                        </div>
                                        <div>
                                            <div class="fs-2 fw-bold"><?= $conteoVuelos['activos'] ?? 0 ?></div>
                                            <small class="text-muted">Vuelos activos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-clock-history fs-3 text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="fs-2 fw-bold"><?= $conteoVuelos['inactivos'] ?? 0 ?></div>
                                            <small class="text-muted">Vuelos inactivos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- RESUMEN DE RESERVAS -->
                        <h3 class="mb-4"><i class="bi bi-bookmark-check"></i> Resumen de Reservas</h3>
                        <div class="row g-3 mb-4">

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-bookmark-fill fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fs-2 fw-bold lh-1"><?= $conteoReservas['total'] ?? 0 ?></div>
                                            <small class="text-muted">Total de reservas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                                        </div>
                                        <div>
                                            <div class="fs-2 fw-bold lh-1"><?= $conteoReservas['confirmadas'] ?? 0 ?></div>
                                            <small class="text-muted">Confirmadas (con pago)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-clock-history fs-3 text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="fs-2 fw-bold lh-1"><?= $conteoReservas['pendientes'] ?? 0 ?></div>
                                            <small class="text-muted">Pendientes de pago</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ACCESOS RÁPIDOS -->
                        <h3 class="mb-4"><i class="bi bi-lightning-charge"></i> Accesos rápidos</h3>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <a href="<?= BASE_URL ?>/public/ceo/crearVuelo.php" class="btn btn-outline-primary w-100 py-4 rounded-4">
                                    <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                                    Crear vuelo
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?= BASE_URL ?>/public/ceo/crearPromocion.php" class="btn btn-outline-success w-100 py-4 rounded-4">
                                    <i class="bi bi-percent fs-3 d-block mb-2"></i>
                                    Crear promoción
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?= BASE_URL ?>/public/ceo/vuelos.php" class="btn btn-outline-secondary w-100 py-4 rounded-4">
                                    <i class="bi bi-list-ul fs-3 d-block mb-2"></i>
                                    Ver mis vuelos
                                </a>
                            </div>
                        </div>
                        <?php else: ?>

                            <!-- ESTADO DE SOLICITUD (no verificado) -->
                            <h3 class="mb-3"><i class="bi bi-info-circle"></i> Estado de Solicitud</h3>
                            <?php if (($usuario['estadoUsuario'] ?? null) == 'pendiente'): ?>
                                <div class="alert alert-warning d-flex align-items-center gap-2">
                                    <i class="bi bi-clock-history fs-4"></i>
                                    <div>
                                        <strong>Pendiente</strong><br>
                                        Tu solicitud está en proceso de revisión. Esto toma 24-48 horas.
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger d-flex align-items-center gap-2">
                                    <i class="bi bi-x-circle fs-4"></i>
                                    <div>
                                        <strong>Rechazado</strong><br>
                                        Tu solicitud fue rechazada.<br>
                                        <strong>Razón:</strong> <?php echo $usuario['razonRechazo'] ?? '—'; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../../layouts/footerAdmin.php'; ?>