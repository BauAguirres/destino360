<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudPromociones.php';

$crudPromociones = new CrudPromociones();
$resultadoPromociones = $crudPromociones->listarPromocionesEstado('pendiente');

$promociones = [];
if ($resultadoPromociones) {
    while ($fila = mysqli_fetch_assoc($resultadoPromociones)) {
        $promociones[] = $fila;
    }
}
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <a href="dashboard.php" class="btn btn-outline-primary">&lt; Volver</a>
            <h1 class="text-center my-3">Aprobar Promociones</h1>
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">
                        <form class="d-flex mb-4" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar promoción" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                        <?php if (empty($promociones)): ?>
                            <div class="col-12 text-center text-muted py-5">
                                <i class="bi bi-tags fs-1 d-block mb-2"></i>
                                No hay promociones pendientes por el momento.
                            </div>
                        <?php else: ?>
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
                        <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../../layouts/footer.php'; ?>