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
$conteoVuelos = $crudVuelos->contarVuelosPorEstado($idAerolinea);

// Filtros
$busqueda = $_GET['busqueda'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$estado = $_GET['estado'] ?? '';

if (!empty($busqueda) || !empty($tipo) || $estado !== '') {
    $resultado = $crudVuelos->buscarVuelosGestion($idAerolinea, $busqueda, $tipo, $estado);
} else {
    $resultado = $crudVuelos->listarVuelos($idAerolinea);
}

$vuelos = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}
?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="container">
            <div class="row">

                <?php include '../../layouts/sidebar.php'; ?>

                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-airplane"></i> Gestionar Vuelos</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <div class="d-flex gap-2">
                                <a href="crearVuelo.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Crear Vuelo
                                </a>
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelFiltros">
                                    <i class="bi bi-funnel"></i> Filtros
                                </button>
                            </div>
                            <form class="d-flex" method="GET" role="search">
                                <input class="form-control me-2" type="search" name="busqueda"
                                    placeholder="Buscar por origen o destino"
                                    value="<?php echo htmlspecialchars($busqueda); ?>" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>

                        <!-- PANEL DE FILTROS -->
                        <div class="collapse mb-4" id="panelFiltros">
                            <div class="border rounded-4 p-4 bg-light">
                                <form method="GET">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Origen o destino</label>
                                            <input type="text" class="form-control" name="busqueda"
                                                value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Ciudad">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Tipo de viaje</label>
                                            <select class="form-select" name="tipo">
                                                <option value="">Todos</option>
                                                <option value="idaSolo" <?php echo $tipo == 'idaSolo' ? 'selected' : ''; ?>>Solo ida</option>
                                                <option value="idaVuelta" <?php echo $tipo == 'idaVuelta' ? 'selected' : ''; ?>>Ida y vuelta</option>
                                                <option value="vuelta" <?php echo $tipo == 'vuelta' ? 'selected' : ''; ?>>Vuelta</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Estado</label>
                                            <select class="form-select" name="estado">
                                                <option value="">Todos</option>
                                                <option value="1" <?php echo $estado === '1' ? 'selected' : ''; ?>>Activos</option>
                                                <option value="0" <?php echo $estado === '0' ? 'selected' : ''; ?>>Inactivos</option>
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex gap-2 mt-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Aplicar filtros
                                            </button>
                                            <a href="vuelos.php" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle"></i> Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($vuelos)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                    No hay vuelos para mostrar.
                                </div>
                            <?php else: ?>
                                <?php foreach ($vuelos as $vuelo): ?>
                                    <div class="col-lg-4 col-md-6">
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
                                                            / <?php echo ($vuelo['asientosTotales'] ?? '—'); ?>
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
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php include '../../layouts/footer.php'; ?>