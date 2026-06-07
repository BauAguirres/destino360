<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crud = new CrudUsuarios();
$resultado = $crud->listarCeo();

$usuarios = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $fila;
    }
}

$error = $_GET['error'] ?? '';
$exito = $_GET['exito'] ?? '';
?>


<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">

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

            <div class="row">

                <?php include '../../layouts/sidebar.php'; ?>

                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-people"></i> Administrar Usuarios</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <a href="solicitudes.php" class="btn btn-warning">
                                <i class="bi bi-person-check"></i> Solicitudes de Acceso
                            </a>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar usuario" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($usuarios)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                                    No hay usuarios para mostrar.
                                </div>
                            <?php else: ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <a href="opcionesUsuario.php?idUsuario=<?php echo $usuario['idUsuario'] ?>"
                                           class="text-decoration-none text-reset">
                                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                                <div class="card-body text-center d-flex flex-column">

                                                    <!-- Avatar -->
                                                    <div class="mx-auto mb-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width: 70px; height: 70px;">
                                                        <i class="bi bi-person-fill fs-2 text-primary"></i>
                                                    </div>

                                                    <h5 class="fw-bold mb-1">
                                                        <?php echo $usuario['nombreUsuario'] ?? 'Sin nombre'; ?>
                                                    </h5>

                                                    <p class="text-muted small mb-2">
                                                        <i class="bi bi-envelope"></i>
                                                        <?php echo $usuario['email'] ?? '—'; ?>
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="bi bi-airplane"></i>
                                                        <?php echo $usuario['nombre'] ?? 'Sin aerolínea'; ?>
                                                    </p>

                                                    <!-- Estado -->
                                                    <div class="mt-auto">
                                                        <?php $estado = $usuario['estadoUsuario'] ?? null; ?>
                                                        <?php if ($estado == 'verificado'): ?>
                                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Verificado</span>
                                                        <?php elseif ($estado == 'pendiente'): ?>
                                                            <span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Pendiente</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rechazado</span>
                                                        <?php endif; ?>
                                                    </div>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../../layouts/footerAdmin.php'; ?>