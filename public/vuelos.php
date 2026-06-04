<?php 

include '../layouts/header.php'; 


$estadoLogin = !empty($_SESSION['idUsuario']);


require_once '../controllers/crudVuelos.php';

$crud = new CrudVuelos();
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
                                <div class="col-lg-4 col-md-6">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body d-flex flex-column">

                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <img src="assets/img/logosAerolineas/<?php echo htmlspecialchars($vuelo['urlLogo'] ?? 'default-logo.png'); ?>"
                                                     alt="Logo <?php echo htmlspecialchars($vuelo['nombre'] ?? ''); ?>"
                                                     style="max-height: 35px; max-width: 60px; object-fit: contain;">
                                                <small class="text-muted fw-semibold">
                                                    <?php echo htmlspecialchars($vuelo['nombre'] ?? ''); ?>
                                                </small>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="text-center">
                                                    <div class="fw-bold fs-5"><?php echo htmlspecialchars($vuelo['origen'] ?? ''); ?></div>
                                                    <small class="text-muted">Origen</small>
                                                </div>
                                                <i class="bi bi-arrow-right text-primary mx-2"></i>
                                                <div class="text-center">
                                                    <div class="fw-bold fs-5"><?php echo htmlspecialchars($vuelo['destino'] ?? ''); ?></div>
                                                    <small class="text-muted">Destino</small>
                                                </div>
                                            </div>

                                            <ul class="list-unstyled small mb-3 flex-grow-1">
                                                <li class="mb-1">
                                                    <i class="bi bi-calendar-event"></i>
                                                    <?php echo htmlspecialchars($vuelo['fechaSalida'] ?? ''); ?>
                                                    a las <?php echo htmlspecialchars($vuelo['horaSalida'] ?? ''); ?> hs
                                                </li>
                                                <li class="mb-1">
                                                    <i class="bi bi-people"></i>
                                                    Asientos disponibles: <?php echo htmlspecialchars($vuelo['asientosDisponibles'] ?? '0'); ?>
                                                </li>
                                            </ul>

                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <span class="fw-bold fs-5 text-success">
                                                    $<?php echo number_format((float) ($vuelo['precio'] ?? 0), 2, ',', '.'); ?>
                                                </span>
                                                <a href="<?php echo BASE_URL; ?>/public/reserva.php?idVuelo=<?php echo $vuelo['idVuelo'] ?? ''; ?>"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bi bi-bookmark-plus"></i> Reservar
                                                </a>
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

