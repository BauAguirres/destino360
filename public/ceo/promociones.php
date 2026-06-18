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
$resultadoPromociones = $crudPromociones->listarPromociones($idAerolinea);

$promociones = [];
if ($resultadoPromociones) {
    while ($fila = mysqli_fetch_assoc($resultadoPromociones)) {
        $promociones[] = $fila;
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
                        <h3 class="mb-4"><i class="bi bi-percent"></i> Gestionar Promociones</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <a href="crearPromocion.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Crear Promoción
                            </a>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar promoción" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
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
</main>

<?php include '../../layouts/footer.php'; ?>