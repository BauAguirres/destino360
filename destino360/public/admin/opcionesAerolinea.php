<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'controllers/crudAerolineas.php';

$idAerolinea = $_GET['idAerolinea'] ?? null;

if (empty($idAerolinea) || !ctype_digit((string)$idAerolinea)) {
    header('Location: aerolineas.php');
    exit;
}

$crud = new CrudAerolineas();
$aerolinea = $crud->obtenerAerolinea((int)$idAerolinea);

if (!$aerolinea) {
    header('Location: aerolineas.php?error=Aerolínea no encontrada');
    exit;
}

$activa = ($aerolinea['estadoAerolinea'] ?? 0) == 1;

$error = $_GET['error'] ?? '';
$exito = $_GET['exito'] ?? '';

include '../../layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="aerolineas.php" class="btn btn-outline-primary mb-4">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>

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

                        <div class="text-center border-bottom pb-4 mb-4">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rounded-circle bg-white shadow d-flex align-items-center justify-content-center overflow-hidden border"
                                     style="width: 110px; height: 110px;">
                                    <img src="../assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>"
                                         alt="Logo" style="max-width: 80%; max-height: 80%; object-fit: contain;">
                                </div>
                            </div>
                            <h2 class="fw-bold mb-1"><?php echo $aerolinea['nombre']; ?></h2>
                            <?php if ($activa): ?>
                                <span class="badge bg-success fs-6"><i class="bi bi-check-circle"></i> Activa</span>
                            <?php else: ?>
                                <span class="badge bg-danger fs-6"><i class="bi bi-x-circle"></i> Inactiva</span>
                            <?php endif; ?>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    <i class="bi bi-tag"></i> Código IATA
                                </small>
                                <span class="fw-semibold"><?php echo $aerolinea['codIATA'] ?? 'No disponible'; ?></span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    <i class="bi bi-globe"></i> Código País
                                </small>
                                <span class="fw-semibold"><?php echo $aerolinea['codPais'] ?? 'No disponible'; ?></span>
                            </div>
                            <div class="col-md-12">
                                <small class="text-muted d-block">
                                    <i class="bi bi-card-text"></i> Descripción
                                </small>
                                <p class="fw-semibold mb-0"><?php echo $aerolinea['descripcion'] ?? 'Sin descripción'; ?></p>
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <h6 class="text-muted mb-3"><i class="bi bi-gear"></i> Acciones</h6>
                            <div class="d-flex flex-wrap gap-2">

                                <?php if ($activa): ?>
                                    <a href="actions/desActivarAerolinea.php?idAerolinea=<?= $aerolinea['idAerolinea'] ?>&accion=desactivar"
                                       class="btn btn-warning"
                                       onclick="return confirm('¿Estás seguro que deseas desactivar esta aerolínea?')">
                                        <i class="bi bi-pause-circle"></i> Desactivar
                                    </a>
                                <?php else: ?>
                                    <a href="actions/desActivarAerolinea.php?idAerolinea=<?= $aerolinea['idAerolinea'] ?>&accion=activar"
                                       class="btn btn-success"
                                       onclick="return confirm('¿Estás seguro que deseas activar esta aerolínea?')">
                                        <i class="bi bi-play-circle"></i> Activar
                                    </a>
                                <?php endif; ?>

                                <a href="editarAerolinea.php?idAerolinea=<?= $aerolinea['idAerolinea'] ?>"
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>

                                <a href="actions/eliminarAerolinea.php?idAerolinea=<?= $aerolinea['idAerolinea'] ?>"
                                   class="btn btn-outline-danger ms-auto"
                                   onclick="return confirm('¿Estás seguro que deseas eliminar esta aerolínea?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../../layouts/footer.php'; ?>