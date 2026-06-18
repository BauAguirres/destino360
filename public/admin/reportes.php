<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudReservas.php';
require_once BASE_PATH . 'controllers/crudAerolineas.php';

$crudReservas = new CrudReservas();
$crudAerolineas = new CrudAerolineas();

$stats = $crudReservas->contarReservasGlobal();
$totalReservas = $stats['totalReservas'] ?? 0;
$ventas = $stats['ventas'] ?? 0;

$resultado = $crudAerolineas->listarAerolineas();
$aerolineas = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $aerolineas[] = $fila;
    }
}
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-bar-chart"></i> Reportes</h3>

                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-bookmark-check fs-1 text-primary"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $totalReservas; ?></h2>
                                    <small class="text-muted">Vuelos reservados</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-cash-coin fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $ventas; ?></h2>
                                    <small class="text-muted">Vuelos vendidos (confirmados)</small>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-file-earmark-text"></i> Reportes generales</h4>
                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <a href="reporteVentas.php" class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body text-center">
                                            <i class="bi bi-cash-stack fs-1 text-success mb-2"></i>
                                            <h5 class="fw-bold mb-1">Ventas</h5>
                                            <small class="text-muted">Reservas confirmadas</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="reporteVuelos.php" class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body text-center">
                                            <i class="bi bi-airplane fs-1 text-primary mb-2"></i>
                                            <h5 class="fw-bold mb-1">Vuelos</h5>
                                            <small class="text-muted">Todos los vuelos</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="reporteUsuarios.php" class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people fs-1 text-info mb-2"></i>
                                            <h5 class="fw-bold mb-1">Usuarios</h5>
                                            <small class="text-muted">Usuarios registrados</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-buildings"></i> Reportes por aerolínea</h4>

                        <form class="d-flex mb-4" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar aerolínea" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>

                        <div class="row g-4">
                            <?php if (empty($aerolineas)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                    No hay aerolíneas cargadas.
                                </div>
                            <?php else: ?>
                                <?php foreach ($aerolineas as $aerolinea): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <a href="reporteAerolinea.php?idAerolinea=<?php echo $aerolinea['idAerolinea'] ?>"
                                           class="text-decoration-none text-reset">
                                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <img src="../assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>"
                                                             alt="Logo"
                                                             style="max-height: 60px; max-width: 100px; object-fit: contain;">
                                                        <div>
                                                            <h5 class="fw-bold mb-1"><?php echo $aerolinea['nombre'] ?? 'Sin nombre'; ?></h5>
                                                            <?php if (($aerolinea['estadoAerolinea'] ?? 0) == 1): ?>
                                                                <span class="badge bg-success">Activa</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">Inactiva</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-transparent text-end">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-bar-chart"></i> Ver reporte
                                                    </button>
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


<?php include '../../layouts/footer.php'; ?>