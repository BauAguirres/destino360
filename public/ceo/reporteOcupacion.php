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
$resultado = $crudReservas->ocupacionVuelosAerolinea($idAerolinea);

$vuelos = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include BASE_PATH . 'layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="reportes.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>
                        <h3 class="mb-4"><i class="bi bi-people"></i> Reporte de Ocupación</h3>

                        <?php if (empty($vuelos)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                No tenés vuelos cargados.
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
                                            <th>Ocupados / Total</th>
                                            <th>Ocupación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($vuelos as $vuelo): ?>
                                            <?php
                                                $total = (int)$vuelo['asientosTotales'];
                                                $ocupados = (int)$vuelo['ocupados'];
                                                $porcentaje = $total > 0 ? round(($ocupados / $total) * 100) : 0;
                                            ?>
                                            <tr onclick="window.location='reporteVuelo.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>'" style="cursor: pointer;">
                                                <td><?php echo $vuelo['idVuelo']; ?></td>
                                                <td><?php echo $vuelo['origen']; ?></td>
                                                <td><?php echo $vuelo['destino']; ?></td>
                                                <td><?php echo $vuelo['fechaSalida']; ?></td>
                                                <td><?php echo $ocupados; ?> / <?php echo $total; ?></td>
                                                <td style="min-width: 140px;">
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                             style="width: <?php echo $porcentaje; ?>%;">
                                                            <?php echo $porcentaje; ?>%
                                                        </div>
                                                    </div>
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