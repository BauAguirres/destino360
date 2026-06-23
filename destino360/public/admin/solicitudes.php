<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

$idUsuario = $_SESSION['idUsuario'] ?? null;

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crud = new CrudUsuarios();
$resultado = $crud->obtenerCEOsEstado('pendiente');

$usuarios = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $fila;
    }
}
?>
<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="usuarios.php" class="btn btn-outline-primary">&lt; Volver</a>
                        <h3 class="my-4"><i class="bi bi-person-check"></i> Solicitudes de Acceso</h3>

                        <form class="d-flex mb-4" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar usuario" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>

                        <div class="row g-4">
                            <?php if (empty($usuarios)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                                    No hay usuarios pendientes por el momento.
                                </div>
                            <?php else: ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <?php include '../../layouts/usuario.php'; ?>
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