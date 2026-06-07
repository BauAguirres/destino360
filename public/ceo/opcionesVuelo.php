<?php
define('BASE_PATH', __DIR__ . '/../../');
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

include BASE_PATH . 'layouts/header.php';

require_once BASE_PATH . 'controllers/CrudVuelos.php';
require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crudVuelos = new CrudVuelos();
$crudUsuarios = new CrudUsuarios();

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

$idUsuario = $_SESSION['idUsuario'];
$usuario = $crudUsuarios->obtenerCEO($idUsuario);
$idAerolinea = $usuario['idAerolinea'];

$idVuelo = $_GET['idVuelo'] ?? null;
$vuelo = $crudVuelos->obtenerVuelo($idVuelo);

// Verificás que el vuelo pertenezca a SU aerolínea
if (!$vuelo || $vuelo['idAerolinea'] != $idAerolinea) {
    header('Location: dashboard.php?error=No tenés permiso para ver este vuelo');
    exit;
}

// Calcular ocupación (asientos vendidos vs totales)
$totales = (int) ($vuelo['asientosTotales'] ?? 0);
$disponibles = (int) ($vuelo['asientosDisp'] ?? 0);
$vendidos = $totales - $disponibles;
$porcentajeOcupado = $totales > 0 ? round(($vendidos / $totales) * 100) : 0;
?>

    <main>
        <div class="bg-primary-subtle py-3">
            <div class="container shadow-lg p-4 mb-5 bg-body rounded">

                <a href="dashboard.php" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>

                <h1 class="text-center mb-4">Administrar Vuelo</h1>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show w-75 m-auto" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if ($exito): ?>
                    <div class="alert alert-success alert-dismissible fade show w-75 m-auto" role="alert">
                        <?php echo $exito; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="text-center my-4">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
                        <span class="fw-bold fs-2"><?php echo $vuelo['origen']; ?></span>
                        <i class="bi bi-airplane-fill text-primary fs-3"></i>
                        <span class="fw-bold fs-2"><?php echo $vuelo['destino']; ?></span>
                    </div>
                    <?php if (($vuelo['estadoVuelo'] ?? 0) == 1): ?>
                        <span class="badge bg-success fs-6"><i class="bi bi-check-circle"></i> Activo</span>
                    <?php else: ?>
                        <span class="badge bg-danger fs-6"><i class="bi bi-x-circle"></i> Inactivo</span>
                    <?php endif; ?>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-3"><i class="bi bi-box-arrow-right"></i> Salida</h6>
                                <p class="mb-1"><strong>Fecha:</strong> <?php echo $vuelo['fechaSalida'] ?? '— No asignada —'; ?></p>
                                <p class="mb-0"><strong>Hora:</strong> <?php echo $vuelo['horaSalida'] ?? '—'; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-3"><i class="bi bi-box-arrow-in-right"></i> Llegada</h6>
                                <p class="mb-1"><strong>Fecha:</strong> <?php echo $vuelo['fechaLlegada'] ?? '— No asignada —'; ?></p>
                                <p class="mb-0"><strong>Hora:</strong> <?php echo $vuelo['horaLlegada'] ?? '—'; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-3"><i class="bi bi-cash-coin"></i> Precio</h6>
                                <p class="fs-4 fw-bold text-success mb-0">
                                    $<?php echo number_format((float) ($vuelo['precio'] ?? 0), 2, ',', '.'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted mb-0"><i class="bi bi-people"></i> Ocupación</h6>
                            <span class="small">
                                <?php echo $vendidos; ?> vendidos /
                                <?php echo $disponibles; ?> disponibles /
                                <?php echo $totales; ?> totales
                            </span>
                        </div>
                        <div class="progress" style="height: 22px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: <?php echo $porcentajeOcupado; ?>%;"
                                 aria-valuenow="<?php echo $porcentajeOcupado; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo $porcentajeOcupado; ?>%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="actions/desActivarVuelo.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>"
                       class="btn btn-outline-primary"
                       onclick="return confirm('¿Estás seguro que deseas cambiar el estado del vuelo?')">
                        <?php if ($vuelo['estadoVuelo'] == 1): ?>
                            <i class="bi bi-pause-circle"></i> Desactivar
                        <?php else: ?>
                            <i class="bi bi-play-circle"></i> Activar
                        <?php endif; ?>
                    </a>

                    <a href="asignarHorario.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>" class="btn btn-outline-primary">
                        <i class="bi bi-calendar-event"></i> Asignar fecha
                    </a>

                    <a href="eliminarVuelo.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>"
                       class="btn btn-outline-danger"
                       onclick="return confirm('¿Estás seguro que deseas eliminar este vuelo?')">
                        <i class="bi bi-trash"></i> Eliminar
                    </a>
                </div>

            </div>
        </div>
    </main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>