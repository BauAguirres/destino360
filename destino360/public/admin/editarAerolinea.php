<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'config/app.php';
require_once BASE_PATH . 'controllers/CrudAerolineas.php';

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

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $codIATA = $_POST['codIATA'];
    $codPais = $_POST['codPais'];
    $descripcion = $_POST['descripcion'];
    $urlLogo = null;

    if (empty($nombre) || empty($codIATA) || empty($codPais)) {
        $err = 'Todos los campos son obligatorios';
    } else {
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $resultado = guardarLogo($_FILES['logo']);
            if (isset($resultado['error'])) {
                $err = $resultado['error'];
            } else {
                $urlLogo = $resultado['nombre'];
            }
        }

        if (empty($err)) {
            $crud->editarAerolinea($idAerolinea, $nombre, $codIATA, $codPais, $descripcion, $urlLogo);
            header('Location: opcionesAerolinea.php?idAerolinea=' . $idAerolinea . '&exito=Aerolínea actualizada correctamente');
            exit;
        }
    }
}

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include BASE_PATH . 'layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="opcionesAerolinea.php?idAerolinea=<?= $idAerolinea ?>" class="btn btn-outline-primary mb-4">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>

                        <div class="text-center mb-5">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rounded-circle bg-white shadow d-flex align-items-center justify-content-center overflow-hidden border"
                                     style="width: 90px; height: 90px;">
                                    <img src="../assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>"
                                         alt="Logo" style="max-width: 80%; max-height: 80%; object-fit: contain;">
                                </div>
                            </div>
                            <h2 class="fw-bold mb-1">Editar Aerolínea</h2>
                            <p class="text-muted">Modificá los datos de la aerolínea</p>
                        </div>

                        <?php if ($err): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $err; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="row g-3">

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nombre de la aerolínea</label>
                                    <input type="text" class="form-control form-control-lg" name="nombre"
                                           value="<?php echo $aerolinea['nombre']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Código IATA</label>
                                    <input type="text" class="form-control" name="codIATA"
                                           value="<?php echo $aerolinea['codIATA']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Código País</label>
                                    <input type="text" class="form-control" name="codPais"
                                           value="<?php echo $aerolinea['codPais']; ?>" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Logo de la aerolínea</label>
                                    <input class="form-control" type="file" name="logo" accept=".jpg,.jpeg,.png">
                                    <small class="text-muted">Dejá vacío para mantener el logo actual</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Descripción</label>
                                    <textarea class="form-control" name="descripcion" rows="4"><?php echo $aerolinea['descripcion']; ?></textarea>
                                </div>

                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                        <i class="bi bi-check-circle"></i> Guardar cambios
                                    </button>
                                    <a href="opcionesAerolinea.php?idAerolinea=<?= $idAerolinea ?>" class="btn btn-secondary w-100 py-3 fw-bold">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>