<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudAerolineas.php';
require_once BASE_PATH . 'controllers/crudReservas.php';

$idAerolinea = $_GET['idAerolinea'] ?? null;

if (empty($idAerolinea) || !ctype_digit((string)$idAerolinea)) {
    header('Location: reportes.php');
    exit;
}

$crudAerolineas = new CrudAerolineas();
$crudReservas = new CrudReservas();

$aerolinea = $crudAerolineas->obtenerAerolinea((int)$idAerolinea);

if (!$aerolinea) {
    header('Location: reportes.php');
    exit;
}

$stats = $crudReservas->reporteAerolinea($idAerolinea);
$totalReservas = $stats['totalReservas'] ?? 0;
$ventas = $stats['ventas'] ?? 0;
$recaudado = $stats['recaudado'] ?? 0;

$resultado = $crudReservas->ventasPorVuelo($idAerolinea);
$vuelos = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
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

                        <a href="reportes.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <img src="../assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>"
                                 alt="Logo"
                                 style="max-height: 70px; max-width: 110px; object-fit: contain;">
                            <div>
                                <h3 class="fw-bold mb-1"><?php echo $aerolinea['nombre']; ?></h3>
                                <span class="text-muted"><?php echo $aerolinea['codIATA'] ?? ''; ?></span>
                            </div>
                        </div>

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
                                    <small class="text-muted">Ventas (confirmadas)</small>
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

                        <h4 class="mb-3"><i class="bi bi-airplane"></i> Detalle por vuelo</h4>

                        <?php if (empty($vuelos)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                Esta aerolínea no tiene vuelos cargados.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Fecha</th>
                                            <th>Reservas</th>
                                            <th>Ventas</th>
                                            <th>Recaudado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($vuelos as $vuelo): ?>
                                            <tr>
                                                <td><?php echo $vuelo['idVuelo']; ?></td>
                                                <td><?php echo $vuelo['origen']; ?></td>
                                                <td><?php echo $vuelo['destino']; ?></td>
                                                <td><?php echo $vuelo['fechaSalida']; ?></td>
                                                <td><?php echo $vuelo['reservas'] ?? 0; ?></td>
                                                <td><?php echo $vuelo['ventas'] ?? 0; ?></td>
                                                <td>$<?php echo number_format($vuelo['recaudado'] ?? 0, 2, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include '../../layouts/footer.php'; ?>