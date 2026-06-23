<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudNovedades.php';

$crud = new CrudNovedades();
$resultado = $crud->listarNovedades();

$novedades = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $novedades[] = $fila;
    }
}

$error = $_GET['error'] ?? '';
$exito = $_GET['exito'] ?? '';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <?php if ($exito): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $exito ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <h3 class="mb-4"><i class="bi bi-megaphone"></i> Gestión de Novedades</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <a href="crearNovedad.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Nueva novedad
                            </a>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar novedad" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($novedades)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-megaphone fs-1 d-block mb-2"></i>
                                    No hay novedades cargadas.
                                </div>
                            <?php else: ?>
                                <?php foreach ($novedades as $novedad): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <?php include '../../layouts/novedad.php'; ?>
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