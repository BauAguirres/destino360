<?php 

include_once '../../seguridad/seguridadCeo.php';


$idUsuario = $_SESSION['idUsuario'];
$idAerolinea = $_SESSION['idAerolinea'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudVuelos.php';
require_once BASE_PATH . 'controllers/crudUsuarios.php';


$crudVuelos = new CrudVuelos();
$crudUsuarios = new CrudUsuarios();


$usuario = $crudUsuarios->obtenerCEO($idUsuario);

$resultado = $crudVuelos->listarVuelos($idAerolinea);

$conteoVuelos = $crudVuelos->contarVuelosPorEstado($idAerolinea);

$vuelos = [];


if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}


$error = '';
$exito = '';

?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="container">
            <div class="row">

                <?php include '../../layouts/sidebar.php'; ?>
                
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">
                        <div class="row align-items-center mx-auto">
                        <h3><i class="bi bi-airplane"></i> Gestionar Vuelos</h3>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <a href="crearVuelo.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Crear Vuelo
                            </a>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar promoción" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                            <div class="col-12 m-auto my-4">
                                <div class="row m-auto">
                                    <?php 
                                    foreach ($vuelos as $vuelo): ?>
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <a href="opcionesVuelo.php?idVuelo=<?php echo $vuelo['idVuelo'] ?>" class="text-decoration-none text-reset">
                                                <div class="card h-100 shadow-sm border-0 rounded-4">
                                                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                                        <span class="fw-semibold">
                                                            <i class="bi bi-airplane-fill text-primary"></i>
                                                            Vuelo #<?php echo $vuelo['idVuelo']; ?>
                                                        </span>
                                                        <?php if (($vuelo['estadoVuelo'] ?? 0) == 1): ?>
                                                            <span class="badge bg-success">Activo</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Inactivo</span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="card-body d-flex flex-column">
                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                            <div class="text-center">
                                                                <div class="fw-bold fs-5"><?php echo $vuelo['origen'] ?? '—'; ?></div>
                                                                <small class="text-muted">Origen</small>
                                                            </div>
                                                            <i class="bi bi-arrow-right text-primary mx-2"></i>
                                                            <div class="text-center">
                                                                <div class="fw-bold fs-5"><?php echo $vuelo['destino'] ?? '—'; ?></div>
                                                                <small class="text-muted">Destino</small>
                                                            </div>
                                                        </div>

                                                        <ul class="list-unstyled small mb-0 flex-grow-1">
                                                            <li class="mb-1">
                                                                <i class="bi bi-people"></i>
                                                                Asientos: <strong><?php echo ($vuelo['asientosDisp'] ?? '—'); ?></strong>
                                                                / <?php echo ($vuelo['asientosTotales'] ?? '—'); ?> disponibles
                                                            </li>
                                                            <li class="mb-1">
                                                                <i class="bi bi-tag"></i>
                                                                Tipo: <?php echo $vuelo['tipoVuelo'] ?? '—'; ?>
                                                            </li>
                                                            <?php if (isset($vuelo['precio'])): ?>
                                                                <li>
                                                                    <i class="bi bi-cash-coin"></i>
                                                                    Precio: $<?php echo number_format((float) $vuelo['precio'], 2, ',', '.'); ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>

                                                    <div class="card-footer bg-transparent text-end">
                                                        <button class="btn btn-sm btn-outline-primary">Ver opciones</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php include '../../layouts/footer.php'; ?>
