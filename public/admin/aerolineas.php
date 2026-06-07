<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

$idUsuario = $_SESSION['idUsuario'] ?? null;

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudAerolineas.php';

$crudUsuarios = new CrudUsuarios();
$crudAerolinea = new CrudAerolineas();

$usuario = $crudUsuarios->obtenerUsuario($idUsuario);
$resultado = $crudAerolinea->listarAerolineas();

$aerolineas = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $aerolineas[] = $fila;
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

                        <h3 class="mb-4"><i class="bi bi-airplane"></i> Administrar Aerolíneas</h3>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <a href="crearAerolinea.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Crear Aerolínea
                            </a>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar aerolínea" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($aerolineas)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                    No hay aerolíneas cargadas.
                                </div>
                            <?php else: ?>
                                <?php foreach ($aerolineas as $aerolinea): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <a href="opcionesAerolinea.php?idAerolinea=<?php echo $aerolinea['idAerolinea'] ?>"
                                           class="text-decoration-none text-reset">
                                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <img src="../assets/img/logosAerolineas/<?php echo ($aerolinea['urlLogo'] ?? 'default-logo.png'); ?>"
                                                             alt="Logo"
                                                             style="max-height: 60px; max-width: 100px; object-fit: contain;">
                                                        <div>
                                                            <h5 class="fw-bold mb-1">
                                                                <?php echo ($aerolinea['nombre'] ?? 'Sin nombre'); ?>
                                                            </h5>
                                                            <?php if (($aerolinea['estadoAerolinea'] ?? 0) == 1): ?>
                                                                <span class="badge bg-success">Activa</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">Inactiva</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <ul class="list-unstyled small mb-0">
                                                        <li class="mb-1">
                                                            <i class="bi bi-tag"></i>
                                                            IATA: <strong><?php echo ($aerolinea['codIATA'] ?? '—'); ?></strong>
                                                        </li>
                                                        <li class="mb-1">
                                                            <i class="bi bi-globe"></i>
                                                            País: <strong><?php echo ($aerolinea['codPais'] ?? '—'); ?></strong>
                                                        </li>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../../layouts/footer.php'; ?>