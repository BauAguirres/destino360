<?php 
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudPromociones.php';

$crudPromociones = new CrudPromociones();
$resultado = $crudPromociones->listarPromocionesEstadoDist('pendiente');

$promociones = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $promociones[] = $fila;
    }
}

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

                <?php include '../../layouts/sidebar.php'; ?>

                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-percent"></i> Administrar Promociones</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <a href="solicitudesPromos.php" class="btn btn-warning">
                                <i class="bi bi-clock-history"></i> Solicitudes Pendientes
                            </a>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar promoción" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($promociones)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-percent fs-1 d-block mb-2"></i>
                                    No hay promociones para mostrar.
                                </div>
                            <?php else: ?>
                                <?php foreach ($promociones as $promocion): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <a href="opcionesPromo.php?idPromo=<?php echo $promocion['idPromo'] ?>"
                                           class="text-decoration-none text-reset">
                                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                                    <span class="fw-semibold text-truncate">
                                                        <?php echo $promocion['nombrePromo'] ?? 'Sin nombre'; ?>
                                                    </span>
                                                    <?php $estado = $promocion['estadoPromo'] ?? 'rechazado'; ?>
                                                    <?php if ($estado == 'aprobado'): ?>
                                                        <span class="badge bg-success">Aprobada</span>
                                                    <?php elseif ($estado == 'pendiente'): ?>
                                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Rechazada</span>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="card-body text-center d-flex flex-column">
                                                    <?php if (!empty($promocion['nombre'])): ?>
                                                        <div class="text-muted small mb-2">
                                                            <i class="bi bi-airplane"></i> <?php echo $promocion['nombre']; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="my-2">
                                                        <span class="display-4 fw-bold text-primary">
                                                            <?php echo $promocion['porcDesc'] ?? '0'; ?>%
                                                        </span>
                                                        <div class="text-muted small">de descuento</div>
                                                    </div>

                                                    <ul class="list-unstyled small mb-0 text-start mt-auto">
                                                        <li class="mb-1">
                                                            <i class="bi bi-calendar-check text-success"></i>
                                                            Desde: <?php echo $promocion['fechaInicio'] ?? '—'; ?>
                                                        </li>
                                                        <li>
                                                            <i class="bi bi-calendar-x text-danger"></i>
                                                            Hasta: <?php echo $promocion['fechaFin'] ?? '—'; ?>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="card-footer bg-transparent text-end">
                                                    <button class="btn btn-sm btn-outline-primary">Ver opciones</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../../layouts/footerAdmin.php'; ?>