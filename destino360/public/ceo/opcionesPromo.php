<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

require_once BASE_PATH . 'config/app.php';

if (empty($_SESSION['idUsuario']) || $_SESSION['rol'] !== 'CEO') {
    header("Location: " . BASE_URL . "/public/index.php?login=1");
    exit;
}

require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudVuelos.php';
require_once BASE_PATH . 'controllers/crudPromociones.php';

$crudUsuarios = new CrudUsuarios();
$crudVuelos = new CrudVuelos();
$crudPromociones = new CrudPromociones();

$idUsuario = $_SESSION['idUsuario'];
$usuario = $crudUsuarios->obtenerCEO($idUsuario);
$idAerolinea = $usuario['idAerolinea'];

$error = '';
$exito = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPromo = $_POST['idPromo'] ?? null;
    $vuelosSeleccionados = $_POST['vuelos'] ?? [];

    if (empty($idPromo)) {
        $error = 'Seleccioná una promoción';
    } else {
        // Borrar asignaciones anteriores y volver a guardar las marcadas
        $crudPromociones->limpiarVuelosDePromocion($idPromo);

        foreach ($vuelosSeleccionados as $idVuelo) {
            $crudPromociones->vincularPromocionVuelo ($idPromo, (int)$idVuelo);
        }

        $exito = 'Promoción asignada a ' . count($vuelosSeleccionados) . ' vuelo(s)';
    }
}

$resultPromos = $crudPromociones->listarPromocionesEstado('aprobado');
$promociones = [];
if ($resultPromos) {
    while ($fila = mysqli_fetch_assoc($resultPromos)) {
        if ($fila['idAerolinea'] == $idAerolinea) {
            $promociones[] = $fila;
        }
    }
}

$resultVuelos = $crudVuelos->listarVuelos($idAerolinea);
$vuelos = [];
if ($resultVuelos) {
    while ($fila = mysqli_fetch_assoc($resultVuelos)) {
        $vuelos[] = $fila;
    }
}

$idPromoSeleccionada = $_GET['idPromo'] ?? ($_POST['idPromo'] ?? null);
$vuelosAsignados = [];
if ($idPromoSeleccionada) {
    $vuelosAsignados = $crudPromociones->listarVuelosPorPromocion($idPromoSeleccionada);
}

include '../../layouts/header.php';
?>

<main class="bg-primary-subtle py-5">
    <div class="container">
        <div class="shadow-lg p-5 bg-body rounded">
            <h1 class="mb-4"><i class="bi bi-tags"></i> Asignar Promoción a Vuelos</h1>

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

            <?php if (count($promociones) === 0): ?>
                <div class="alert alert-info">
                    No tenés promociones aprobadas todavía. El administrador debe aprobarlas antes de poder asignarlas.
                </div>
            <?php else: ?>

                <form method="GET" class="mb-4">
                    <label class="form-label fw-bold">Seleccioná una promoción aprobada</label>
                    <select class="form-select form-select-lg" name="idPromo" onchange="this.form.submit()">
                        <option value="">-- Elegí una promoción --</option>
                        <?php foreach ($promociones as $promo): ?>
                            <option value="<?= $promo['idPromo'] ?>" <?= ($idPromoSeleccionada == $promo['idPromo']) ? 'selected' : '' ?>>
                                <?= $promo['nombrePromo'] ?> (<?= $promo['porcDesc'] ?>% OFF)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <?php if ($idPromoSeleccionada): ?>
                    <form method="POST">
                        <input type="hidden" name="idPromo" value="<?= $idPromoSeleccionada ?>">

                        <h4 class="mb-3"><i class="bi bi-airplane"></i> Seleccioná los vuelos</h4>

                        <?php if (count($vuelos) === 0): ?>
                            <div class="alert alert-warning">No tenés vuelos creados.</div>
                        <?php else: ?>
                            <div class="d-flex flex-column gap-2 mb-4">
                                <?php foreach ($vuelos as $vuelo): ?>
                                    <?php $marcado = in_array($vuelo['idVuelo'], $vuelosAsignados); ?>
                                    <input
                                        class="btn-check"
                                        type="checkbox"
                                        name="vuelos[]"
                                        id="vuelo_<?= $vuelo['idVuelo'] ?>"
                                        value="<?= $vuelo['idVuelo'] ?>"
                                        <?= $marcado ? 'checked' : '' ?>>

                                    <label class="btn btn-outline-primary p-3 text-start" for="vuelo_<?= $vuelo['idVuelo'] ?>">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <div>
                                                <strong><?= $vuelo['origen'] ?> → <?= $vuelo['destino'] ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?php 
                                                    if($vuelo['tipoVuelo'] == 'idaSolo'): ?>
                                                        Ida
                                                    <?php elseif($vuelo['tipoVuelo'] == 'idaVuelta'): ?>
                                                        Ida y vuelta
                                                    <?php else: ?>
                                                        Vuelta
                                                    <?php endif; ?> 
                                                    | <?=$vuelo['fechaSalida'] ?> | <?= $vuelo['horaSalida'] ?>
                                                </small>
                                            </div>
                                            <span class="fw-bold">$<?= $vuelo['precio'] ?></span>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                <i class="bi bi-check-circle"></i> Guardar asignación
                            </button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../../layouts/footer.php'; ?>