<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudReservas.php';

$crudReservas = new CrudReservas();
$resultado = $crudReservas->reporteVentas();

$ventas = [];
$totalRecaudado = 0;
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $ventas[] = $fila;
        $totalRecaudado += $fila['precioFinal'];
    }
}

$cantidadVentas = count($ventas);
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="reportes.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>
                        <h3 class="mb-4"><i class="bi bi-cash-stack"></i> Reporte de Ventas</h3>

                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-cart-check fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $cantidadVentas; ?></h2>
                                    <small class="text-muted">Ventas confirmadas</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-cash-coin fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0">$<?php echo number_format($totalRecaudado, 2, ',', '.'); ?></h2>
                                    <small class="text-muted">Total recaudado</small>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-list-ul"></i> Detalle de ventas</h4>

                        <?php if (empty($ventas)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                No hay ventas confirmadas todavía.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Aerolínea</th>
                                            <th>Ruta</th>
                                            <th>Fecha vuelo</th>
                                            <th>Fecha compra</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ventas as $venta): ?>
                                            <tr>
                                                <td><?php echo $venta['idReserva']; ?></td>
                                                <td><?php echo $venta['nombreUsuario']; ?></td>
                                                <td><?php echo $venta['nombreAerolinea']; ?></td>
                                                <td><?php echo $venta['origen']; ?> → <?php echo $venta['destino']; ?></td>
                                                <td><?php echo $venta['fechaSalida']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($venta['fechaReserva'])); ?></td>
                                                <td>$<?php echo number_format($venta['precioFinal'], 2, ',', '.'); ?></td>
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