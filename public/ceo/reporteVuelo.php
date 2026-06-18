<?php
define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

$idAerolinea = $_SESSION['idAerolinea'];

require_once BASE_PATH . 'controllers/crudVuelos.php';
require_once BASE_PATH . 'controllers/crudReservas.php';

$idVuelo = $_GET['idVuelo'] ?? null;

if (empty($idVuelo) || !ctype_digit((string)$idVuelo)) {
    header('Location: reporteOcupacion.php');
    exit;
}

$crudVuelos = new CrudVuelos();
$crudReservas = new CrudReservas();

$vuelo = $crudVuelos->obtenerVuelo((int)$idVuelo);

if (!$vuelo || $vuelo['idAerolinea'] != $idAerolinea) {
    header('Location: reporteOcupacion.php?error=No tenés permiso para ver este vuelo');
    exit;
}

$stats = $crudReservas->reporteVuelo($idVuelo);
$totalReservas = $stats['totalReservas'] ?? 0;
$ventas = $stats['ventas'] ?? 0;
$recaudado = $stats['recaudado'] ?? 0;

$resultado = $crudReservas->reservasPorVuelo($idVuelo);
$reservas = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $reservas[] = $fila;
    }
}

$total = (int)($vuelo['asientosTotales'] ?? 0);
$disponibles = (int)($vuelo['asientosDisp'] ?? 0);
$ocupados = $total - $disponibles;
$porcentaje = $total > 0 ? round(($ocupados / $total) * 100) : 0;

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include BASE_PATH . 'layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="reporteOcupacion.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>

                        <div class="text-center mb-4">
                            <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
                                <span class="fw-bold fs-2"><?php echo $vuelo['origen']; ?></span>
                                <i class="bi bi-airplane-fill text-primary fs-3"></i>
                                <span class="fw-bold fs-2"><?php echo $vuelo['destino']; ?></span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar-event"></i>
                                <?php echo $vuelo['fechaSalida'] ?? '— sin fecha —'; ?>
                                <?php echo $vuelo['horaSalida'] ?? ''; ?>
                            </p>
                        </div>

                        <div class="row g-3 mb-5">
                            <div class="col-md-3">
                                <div class="border rounded-4 p-3 text-center">
                                    <i class="bi bi-cash-coin fs-2 text-success"></i>
                                    <h4 class="fw-bold mb-0">$<?php echo number_format($recaudado, 2, ',', '.'); ?></h4>
                                    <small class="text-muted">Recaudado</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded-4 p-3 text-center">
                                    <i class="bi bi-cart-check fs-2 text-success"></i>
                                    <h4 class="fw-bold mb-0"><?php echo $ventas; ?></h4>
                                    <small class="text-muted">Ventas</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded-4 p-3 text-center">
                                    <i class="bi bi-bookmark-check fs-2 text-primary"></i>
                                    <h4 class="fw-bold mb-0"><?php echo $totalReservas; ?></h4>
                                    <small class="text-muted">Reservas</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded-4 p-3 text-center">
                                    <i class="bi bi-people fs-2 text-primary"></i>
                                    <h4 class="fw-bold mb-0"><?php echo $ocupados; ?>/<?php echo $total; ?></h4>
                                    <small class="text-muted">Ocupación</small>
                                </div>
                            </div>
                        </div>

                        <div class="border-0 bg-light p-3 rounded mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-muted mb-0"><i class="bi bi-bar-chart"></i> Ocupación del vuelo</h6>
                                <span class="small"><?php echo $ocupados; ?> vendidos / <?php echo $disponibles; ?> disponibles</span>
                            </div>
                            <div class="progress" style="height: 22px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: <?php echo $porcentaje; ?>%;">
                                    <?php echo $porcentaje; ?>%
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-person-lines-fill"></i> Reservas del vuelo</h4>

                        <?php if (empty($reservas)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Este vuelo todavía no tiene reservas.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Email</th>
                                            <th>Pasajeros</th>
                                            <th>Fecha compra</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reservas as $reserva): ?>
                                            <?php $pasajeros = (int)$reserva['cantidadMayores'] + (int)$reserva['cantidadMenores']; ?>
                                            <tr>
                                                <td><?php echo $reserva['idReserva']; ?></td>
                                                <td><?php echo $reserva['nombreUsuario']; ?></td>
                                                <td><?php echo $reserva['email']; ?></td>
                                                <td><?php echo $pasajeros; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($reserva['fechaReserva'])); ?></td>
                                                <td>$<?php echo number_format($reserva['precioFinal'], 2, ',', '.'); ?></td>
                                                <td>
                                                    <?php if ($reserva['estadoReserva'] == 'confirmada'): ?>
                                                        <span class="badge bg-success">Confirmada</span>
                                                    <?php elseif ($reserva['estadoReserva'] == 'cancelada'): ?>
                                                        <span class="badge bg-danger">Cancelada</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark">Pendiente</span>
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


<?php include BASE_PATH . 'layouts/footer.php'; ?>