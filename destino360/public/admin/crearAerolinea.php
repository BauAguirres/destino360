<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'config/app.php';
require_once BASE_PATH . 'controllers/CrudAerolineas.php';

$crud = new CrudAerolineas();
$err = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $codIATA = $_POST['codIATA'];
    $codPais = $_POST['codPais'];
    $descripcion = $_POST['descripcion'];
    $estado = 0;
    $urlLogo = NULL;

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
            $crud->crearAerolinea($nombre, $codIATA, $codPais, $estado, $descripcion, $urlLogo);
            $exito = 'Aerolínea creada correctamente';
        }
    }
}

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

                        <div class="text-center mb-5">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-airplane-fill text-primary" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <h2 class="fw-bold mb-1">Crear Aerolínea</h2>
                            <p class="text-muted">Completá los datos para registrar una nueva aerolínea</p>
                        </div>

                        <?php if ($err): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $err; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($exito): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $exito; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="crearAerolinea.php" method="POST" enctype="multipart/form-data">
                            <div class="row g-3">

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nombre de la aerolínea</label>
                                    <input type="text" class="form-control form-control-lg" name="nombre" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Código IATA</label>
                                    <input type="text" class="form-control" name="codIATA" placeholder="Ej: AA" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Código País</label>
                                    <input type="text" class="form-control" name="codPais" placeholder="Ej: ARG" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Logo de la aerolínea</label>
                                    <input class="form-control" type="file" name="logo" accept=".jpg,.jpeg,.png">
                                    <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Descripción</label>
                                    <textarea class="form-control" name="descripcion" rows="4" placeholder="Breve descripción de la aerolínea"></textarea>
                                </div>

                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                        <i class="bi bi-check-circle"></i> Crear Aerolínea
                                    </button>
                                    <a href="aerolineas.php" class="btn btn-secondary w-100 py-3 fw-bold">
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

<?php include '../../layouts/footer.php'; ?>