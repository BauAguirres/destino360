<?php 

include_once '../../seguridad/seguridadCeo.php';

$idUsuario = $_SESSION['idUsuario'];
$idAerolinea = $_SESSION['idAerolinea'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudPromociones.php';
require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crudPromociones = new CrudPromociones();
$crudUsuarios = new CrudUsuarios();

$usuario = $crudUsuarios->obtenerCEO($idUsuario);

// Filtros
$busqueda = $_GET['busqueda'] ?? '';
$estado = $_GET['estado'] ?? '';

if (!empty($busqueda) || !empty($estado)) {
    $resultadoPromociones = $crudPromociones->buscarPromociones($idAerolinea, $busqueda, $estado);
} else {
    $resultadoPromociones = $crudPromociones->listarPromociones($idAerolinea);
}

$promociones = [];
if ($resultadoPromociones) {
    while ($fila = mysqli_fetch_assoc($resultadoPromociones)) {
        $promociones[] = $fila;
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
                        <h3 class="mb-4"><i class="bi bi-percent"></i> Gestionar Promociones</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <div class="d-flex gap-2">
                                <a href="crearPromocion.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Crear Promoción
                                </a>
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelFiltros">
                                    <i class="bi bi-funnel"></i> Filtros
                                </button>
                            </div>
                            <form class="d-flex" method="GET" role="search">
                                <input class="form-control me-2" type="search" name="busqueda"
                                       placeholder="Buscar promoción"
                                       value="<?php echo $busqueda; ?>" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>

                        <div class="collapse mb-4" id="panelFiltros">
                            <div class="border rounded-4 p-4 bg-light">
                                <form method="GET">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Nombre</label>
                                            <input type="text" class="form-control" name="busqueda"
                                                   value="<?php echo $busqueda; ?>" placeholder="Nombre de la promoción">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Estado</label>
                                            <select class="form-select" name="estado">
                                                <option value="">Todos</option>
                                                <option value="pendiente" <?php echo $estado == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                                <option value="aprobado" <?php echo $estado == 'aprobado' ? 'selected' : ''; ?>>Aprobada (vigente)</option>
                                                <option value="finalizado" <?php echo $estado == 'finalizado' ? 'selected' : ''; ?>>Finalizada</option>
                                                <option value="rechazado" <?php echo $estado == 'rechazado' ? 'selected' : ''; ?>>Rechazada</option>
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex gap-2 mt-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Aplicar filtros
                                            </button>
                                            <a href="promociones.php" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle"></i> Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($promociones)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-tags fs-1 d-block mb-2"></i>
                                    No hay promociones para mostrar.
                                </div>
                            <?php else: ?>
                                <?php foreach ($promociones as $promocion): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <?php include '../../layouts/promocion.php'; ?>
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