<?php 

include '../layouts/header.php'; 


$estadoLogin = !empty($_SESSION['idUsuario']);


require_once '../controllers/crudVuelos.php';
require_once '../controllers/crudPromociones.php';

$crud = new CrudVuelos();
$crudPromociones = new CrudPromociones();


$resultado = $crud->listarVuelosActivos();

$vuelos = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}




?>


<main>
    <div class="bg-primary-subtle py-3">
        <div class="container shadow-lg p-3 mb-5 bg-body rounded">
            <h1 class="text-center my-5">Vuelos</h1>

            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-outline-primary" href="">Filtro</a>
                </div>
                <div class="col-md-6">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar por origen o destino" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>

                <div class="col-12 my-4">
                    <div class="row g-4">
                        <?php if (empty($vuelos)): ?>
                            <div class="col-12 text-center text-muted py-5">
                                <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                No hay vuelos disponibles por el momento.
                            </div>
                        <?php else: ?>
                            <?php foreach ($vuelos as $vuelo): ?>
                                <?php 
                                    $promocion = $crudPromociones->obtenerPromocionVuelos($vuelo['idVuelo']);
                                    $precioOriginal = $vuelo['precio'] ?? 0;
                                    $precioFinal = $precioOriginal;

                                    if (!empty($promocion)) {
                                        $descuento = $promocion['porcDesc'] ?? 0;
                                        $precioFinal = $precioOriginal - ($precioOriginal * ($descuento / 100));
                                    }
                                ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body d-flex flex-column">

                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <img src="assets/img/logosAerolineas/<?php echo $vuelo['urlLogo'] ?? 'default-logo.png'; ?>"
                                                    alt="Logo <?php echo $vuelo['nombre'] ?? ''; ?>"
                                                    style="max-height: 35px; max-width: 60px; object-fit: contain;">
                                                <small class="text-muted fw-semibold">
                                                    <?php echo $vuelo['nombre'] ?? ''; ?>
                                                </small>
                                                <p class="text-muted small mb-0 ms-auto">
                                                    <?php if ($vuelo['tipoVuelo'] === 'idaSolo'): ?>
                                                        Solo ida
                                                    <?php elseif ($vuelo['tipoVuelo'] === 'idaVuelta'): ?>
                                                        Ida y vuelta
                                                    <?php endif; ?>
                                                </p>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="text-center">
                                                    <div class="fw-bold fs-5"><?php echo $vuelo['origen'] ?? ''; ?></div>
                                                    <small class="text-muted">Origen</small>
                                                </div>
                                                <i class="bi bi-arrow-right text-primary mx-2"></i>
                                                <div class="text-center">
                                                    <div class="fw-bold fs-5"><?php echo $vuelo['destino'] ?? ''; ?></div>
                                                    <small class="text-muted">Destino</small>
                                                </div>
                                            </div>

                                            <ul class="list-unstyled small mb-3 flex-grow-1">
                                                <li class="mb-1">
                                                    <i class="bi bi-calendar-event"></i>
                                                    <?php echo $vuelo['fechaSalida'] ?? ''; ?>
                                                    a las <?php echo $vuelo['horaSalida'] ?? ''; ?> hs
                                                </li>
                                                <li class="mb-1">
                                                    <i class="bi bi-people"></i>
                                                    Asientos disponibles: <?php echo $vuelo['asientosDisp'] ?? '0'; ?>
                                                </li>
                                                <?php if (!empty($promocion)): ?>
                                                    <li class="mb-1">
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-tag-fill"></i> <?php echo $promocion['porcDesc']; ?>% OFF - <?php echo htmlspecialchars($promocion['nombrePromo']); ?>
                                                        </span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>

                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <span class="fw-bold fs-5 text-success">
                                                    <?php if (!empty($promocion)): ?>
                                                        $<?php echo number_format((float) $precioFinal, 2, ',', '.'); ?>
                                                        <small class="text-muted text-decoration-line-through ms-2">
                                                            $<?php echo number_format((float) $precioOriginal, 2, ',', '.'); ?>
                                                        </small>
                                                    <?php else: ?>
                                                        $<?php echo number_format((float) $precioOriginal, 2, ',', '.'); ?>
                                                    <?php endif; ?>
                                                </span>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/public/detallesVuelo.php?idVuelo=<?php echo $vuelo['idVuelo'] ?? ''; ?>"
                                                    class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-info-circle"></i> Detalles
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/public/reserva.php?idVuelo=<?php echo $vuelo['idVuelo'] ?? ''; ?>"
                                                    class="btn btn-primary btn-sm">
                                                        <i class="bi bi-bookmark-plus"></i> Reservar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>





<?php include '../layouts/footer.php'; ?>

