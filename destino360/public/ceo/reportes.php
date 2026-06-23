<?php
define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

$idAerolinea = $_SESSION['idAerolinea'];

require_once BASE_PATH . 'controllers/crudReservas.php';

$crudReservas = new CrudReservas();

$stats = $crudReservas->reporteAerolinea($idAerolinea);
$totalReservas = $stats['totalReservas'] ?? 0;
$ventas = $stats['ventas'] ?? 0;
$recaudado = $stats['recaudado'] ?? 0;

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include BASE_PATH . 'layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-bar-chart"></i> Reportes de mi Aerolínea</h3>

                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-cash-coin fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0">$<?php echo number_format($recaudado, 2, ',', '.'); ?></h2>
                                    <small class="text-muted">Total recaudado</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-cart-check fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $ventas; ?></h2>
                                    <small class="text-muted">Ventas confirmadas</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-bookmark-check fs-1 text-primary"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $totalReservas; ?></h2>
                                    <small class="text-muted">Reservas totales</small>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-file-earmark-text"></i> Reportes disponibles</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="reporteVentas.php" class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body text-center">
                                            <i class="bi bi-cash-stack fs-1 text-success mb-2"></i>
                                            <h5 class="fw-bold mb-1">Ventas</h5>
                                            <small class="text-muted">Reservas confirmadas de mi aerolínea</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="reporteOcupacion.php" class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people fs-1 text-primary mb-2"></i>
                                            <h5 class="fw-bold mb-1">Ocupación</h5>
                                            <small class="text-muted">Asientos vendidos por vuelo</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>