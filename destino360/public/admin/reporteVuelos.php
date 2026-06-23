<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudVuelos.php';

$crud = new CrudVuelos();
$resultado = $crud->reporteVuelos();

$vuelos = [];
$activos = 0;
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
        if ($fila['estadoVuelo'] == 1) {
            $activos++;
        }
    }
}

$totalVuelos = count($vuelos);
$inactivos = $totalVuelos - $activos;
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="reportes.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>
                        <h3 class="mb-4"><i class="bi bi-airplane"></i> Reporte de Vuelos</h3>

                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-airplane fs-1 text-primary"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $totalVuelos; ?></h2>
                                    <small class="text-muted">Vuelos totales</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-check-circle fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $activos; ?></h2>
                                    <small class="text-muted">Activos</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-x-circle fs-1 text-danger"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $inactivos; ?></h2>
                                    <small class="text-muted">Inactivos</small>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-list-ul"></i> Detalle de vuelos</h4>

                        <?php if (empty($vuelos)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                No hay vuelos cargados.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Aerolínea</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Disp.</th>
                                            <th>Ocupados</th>
                                            <th>Precio</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($vuelos as $vuelo): ?>
                                            <tr>
                                                <td><?php echo $vuelo['idVuelo']; ?></td>
                                                <td><?php echo $vuelo['nombreAerolinea']; ?></td>
                                                <td><?php echo $vuelo['origen']; ?></td>
                                                <td><?php echo $vuelo['destino']; ?></td>
                                                <td><?php echo $vuelo['fechaSalida']; ?></td>
                                                <td><?php echo $vuelo['asientosTotales']; ?></td>
                                                <td><?php echo $vuelo['asientosDisp']; ?></td>
                                                <td><?php echo $vuelo['asientosOcupados']; ?></td>
                                                <td>$<?php echo number_format($vuelo['precio'], 2, ',', '.'); ?></td>
                                                <td>
                                                    <?php if ($vuelo['estadoVuelo'] == 1): ?>
                                                        <span class="badge bg-success">Activo</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
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