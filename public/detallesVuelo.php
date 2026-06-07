<?php
include '../layouts/header.php';

require_once '../controllers/crudVuelos.php';

$idVuelo = $_GET['idVuelo'] ?? null;


$crud = new CrudVuelos();
$vueloIda = $crud->obtenerVuelo($idVuelo);

if (empty($vueloIda)) {
    header("Location: " . BASE_URL . "/public/vuelos.php");
    exit;
}

$vueloVuelta = null;
if (!empty($vueloIda['idVueloRelacionado'])) {
    $vueloVuelta = $crud->obtenerVuelo((int) $vueloIda['idVueloRelacionado']);
}

$esIdaYVuelta = $vueloVuelta !== null;

$precioIda = $vueloIda['precio'] ?? 0;
$precioVuelta = $esIdaYVuelta ? $vueloVuelta['precio'] ?? 0 : 0;
$precioPorPasajero = $precioIda + $precioVuelta;
?>


<main>
    <div class="bg-primary-subtle py-5">
        <div class="row m-auto p-2">
            <div class="col-lg-8 col-12 m-auto">
                <div class="container shadow-lg p-5 bg-body rounded">

                    <a href="<?php echo BASE_URL; ?>/public/vuelos.php" class="btn btn-outline-primary mb-3">
                        <i class="bi bi-arrow-left"></i> Volver a vuelos
                    </a>

                    <h1 class="mb-2"><i class="bi bi-airplane-fill"></i> Detalle del vuelo</h1>
                    <span class="badge <?php echo $esIdaYVuelta ? 'bg-info text-dark' : 'bg-secondary'; ?> mb-4">
                        <?php echo $esIdaYVuelta ? 'Ida y vuelta' : 'Solo ida'; ?>
                    </span>

                    <div class="p-4 border-0 mb-4 bg-primary-subtle">
                        <h5 class="mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de IDA</h5>

                        <div class="row text-center mb-3">
                            <div class="col-md-5">
                                <small class="text-muted">ORIGEN</small>
                                <p class="fw-bold fs-4 text-dark"><?php echo $vueloIda['origen'] ?? ''; ?></p>
                            </div>
                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-right" style="font-size: 24px; color: #0d6efd;"></i>
                            </div>
                            <div class="col-md-5">
                                <small class="text-muted">DESTINO</small>
                                <p class="fw-bold fs-4 text-dark"><?php echo $vueloIda['destino'] ?? ''; ?></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row text-center">
                            <div class="col-md-4">
                                <small class="text-muted">SALIDA</small>
                                <p class="fw-bold text-dark mb-0"><?php echo $vueloIda['fechaSalida'] ?? ''; ?></p>
                                <p class="text-primary fw-bold"><?php echo $vueloIda['horaSalida'] ?? ''; ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">LLEGADA</small>
                                <p class="fw-bold text-dark mb-0"><?php echo $vueloIda['fechaLlegada'] ?? '-'; ?></p>
                                <p class="text-primary fw-bold"><?php echo $vueloIda['horaLlegada'] ?? ''; ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">PRECIO</small>
                                <p class="fw-bold fs-5">$<?php echo number_format($precioIda, 2, ',', '.'); ?></p>
                            </div>
                        </div>

                        <p class="text-muted small mb-0 mt-2">
                            <i class="bi bi-people"></i>
                            Asientos disponibles: <?php echo $vueloIda['asientosDisp'] ?? '0'; ?>
                        </p>
                    </div>

                    <?php if ($esIdaYVuelta): ?>
                        <div class=" p-4 border-0 mb-4 bg-primary-subtle">
                            <h5 class="mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de VUELTA</h5>

                            <div class="row text-center mb-3">
                                <div class="col-md-5">
                                    <small class="text-muted">ORIGEN</small>
                                    <p class="fw-bold fs-4 text-dark"><?php echo $vueloVuelta['origen'] ?? ''; ?></p>
                                </div>
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-arrow-right" style="font-size: 24px; color: #0d6efd;"></i>
                                </div>
                                <div class="col-md-5">
                                    <small class="text-muted">DESTINO</small>
                                    <p class="fw-bold fs-4 text-dark"><?php echo $vueloVuelta['destino'] ?? ''; ?></p>
                                </div>
                            </div>

                            <hr>

                            <div class="row text-center">
                                <div class="col-md-4">
                                    <small class="text-muted">SALIDA</small>
                                    <p class="fw-bold text-dark mb-0"><?php echo $vueloVuelta['fechaSalida'] ?? ''; ?></p>
                                    <p class="text-primary fw-bold"><?php echo $vueloVuelta['horaSalida'] ?? ''; ?></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">LLEGADA</small>
                                    <p class="fw-bold text-dark mb-0"><?php echo $vueloVuelta['fechaLlegada'] ?? '-'; ?></p>
                                    <p class="text-primary fw-bold"><?php echo $vueloVuelta['horaLlegada'] ?? ''; ?></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">PRECIO</small>
                                    <p class="fw-bold fs-5">$<?php echo number_format($precioVuelta, 2, ',', '.'); ?></p>
                                </div>
                            </div>

                            <p class="text-muted small mb-0 mt-2">
                                <i class="bi bi-people"></i>
                                Asientos disponibles: <?php echo $vueloVuelta['asientosDisp'] ?? '0'; ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- PRECIO POR PASAJERO -->
                    <div class=" bg-light border-0 mb-4">
                        <?php if ($esIdaYVuelta): ?>
                            <div class="d-flex justify-content-between">
                                <span>Ida por pasajero</span>
                                <span>$<?php echo number_format($precioIda, 2, ',', '.'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Vuelta por pasajero</span>
                                <span>$<?php echo number_format($precioVuelta, 2, ',', '.'); ?></span>
                            </div>
                            <hr>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">PRECIO POR PASAJERO</h5>
                            <p class="fw-bold fs-3 mb-0 text-success">
                                $<?php echo number_format($precioPorPasajero, 2, ',', '.'); ?>
                            </p>
                        </div>
                    </div>

                    <a href="<?php echo BASE_URL; ?>/public/reserva.php?idVuelo=<?php echo $idVuelo; ?>"
                       class="btn btn-primary w-100 py-3 fw-bold fs-5">
                        <i class="bi bi-ticket"></i> Reservar este vuelo
                    </a>

                </div>
            </div>
        </div>
    </div>
</main>


<?php include '../layouts/footer.php'; ?>