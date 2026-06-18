<?php
define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'seguridad/seguridadCeo.php';

require_once BASE_PATH . 'controllers/crudPromociones.php';

$idUsuario = $_SESSION['idUsuario'];
$idAerolinea = $_SESSION['idAerolinea'];

$crudPromociones = new crudPromociones();
$err = "";
$exito = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $porcDesc = $_POST['porcDesc'];
    $desc = $_POST['desc'];
    $nombrePromo = $_POST['nombrePromo'];
    $idAerolinea = $_SESSION['idAerolinea'];
    $estadoPromo = 'pendiente';

    if (empty($nombrePromo) || empty($fechaInicio) || empty($fechaFin) || empty($porcDesc) || empty($desc)) {
        $err = "Todos los campos son obligatorios";
    } elseif ($fechaFin < $fechaInicio) {
        $err = "La fecha de fin no puede ser anterior a la de inicio";
    } else {
        if ($crudPromociones->crearPromocion($idAerolinea, $nombrePromo, $desc, $porcDesc, $estadoPromo, $fechaInicio, $fechaFin)) {
            $exito = "Promoción creada exitosamente.";
        } else {
            $err = "Error al crear la promoción. Por favor, inténtalo de nuevo.";
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

                        <a href="dashboard.php" class="btn btn-outline-primary mb-4">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>

                        <div class="text-center mb-5">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-tag-fill text-primary" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <h2 class="fw-bold mb-1">Crear Promoción</h2>
                            <p class="text-muted">Completá los datos para registrar una nueva promoción</p>
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

                        <form action="crearPromocion.php" method="POST">
                            <div class="row g-3">

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nombre de la promoción</label>
                                    <input type="text" class="form-control form-control-lg" name="nombrePromo" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fecha de inicio</label>
                                    <input type="date" class="form-control" name="fechaInicio" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fecha de fin</label>
                                    <input type="date" class="form-control" name="fechaFin" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Porcentaje de descuento</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="porcDesc" step="0.01" min="0" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Descripción</label>
                                    <textarea class="form-control" name="desc" rows="3" placeholder="Breve descripción de la promoción" required></textarea>
                                </div>

                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                        <i class="bi bi-check-circle"></i> Crear Promoción
                                    </button>
                                    <a href="dashboard.php" class="btn btn-secondary w-100 py-3 fw-bold">
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