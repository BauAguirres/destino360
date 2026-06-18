<?php
define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'seguridad/seguridadCeo.php';

$idUsuario = $_SESSION['idUsuario'];

require_once BASE_PATH . 'config/app.php';
require_once BASE_PATH . 'controllers/crudVuelos.php';
require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crud = new crudVuelos();
$err = '';
$exito = '';

$crudUsuarios = new CrudUsuarios();
$usuario = $crudUsuarios->obtenerCEO($idUsuario);

$vuelos = $crud->listarVuelosActivos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoVuelo = $_POST['tipoVuelo'];
    $idAerolinea = $usuario['idAerolinea'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $asientosTotales = $_POST['asientosTotales'];
    $asientosDisponibles = $asientosTotales;
    $precio = $_POST['precio'];
    $estado = 0;

    if (empty($tipoVuelo) || empty($idAerolinea) || empty($origen) || empty($destino) || empty($asientosTotales) || empty($asientosDisponibles) || empty($precio)) {
        $err = 'Todos los campos son obligatorios';
    } else {
        $idVueloIda = $crud->crearVuelo($tipoVuelo, $idAerolinea, $origen, $destino, $asientosTotales, $asientosTotales, $precio, $estado);

        if ($tipoVuelo === 'idaVuelta') {
            $opcionVuelta = $_POST['opcionVuelta'] ?? 'seleccionar';

            if ($opcionVuelta === 'seleccionar') {
                $idVueloVuelta = $_POST['idVueloVuelta'] ?? null;

                if (!empty($idVueloVuelta)) {
                    $crud->vincularVuelos($idVueloIda, $idVueloVuelta);
                }
            } else {
                $origenVuelta = $_POST['origenVuelta'] ?? '';
                $destinoVuelta = $_POST['destinoVuelta'] ?? '';
                $asientosVuelta = $_POST['asientosTotalesVuelta'] ?? '';
                $precioVuelta = $_POST['precioVuelta'] ?? '';

                if (!empty($origenVuelta) && !empty($destinoVuelta) && !empty($asientosVuelta) && !empty($precioVuelta)) {
                    $idVueloVuelta = $crud->crearVuelo('vuelta', $idAerolinea, $origenVuelta, $destinoVuelta, $asientosVuelta, $asientosVuelta, $precioVuelta, $estado);
                    $crud->vincularVuelos($idVueloIda, $idVueloVuelta);
                }
            }
        }

        header('Location: vuelos.php?exito=Vuelo creado correctamente');
        exit();
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

                        <a href="vuelos.php" class="btn btn-outline-primary mb-4">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>

                        <div class="text-center mb-5">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-airplane-fill text-primary" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <h2 class="fw-bold mb-1">Crear Vuelo</h2>
                            <p class="text-muted">Completá los datos para registrar un nuevo vuelo</p>
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

                        <form action="crearVuelo.php" method="POST" enctype="multipart/form-data">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tipo de viaje</label>
                                    <select class="form-select form-select-lg" id="tipoVuelo" name="tipoVuelo" required onchange="cambiarTipoViaje()">
                                        <option value="">-- Selecciona --</option>
                                        <option value="idaSolo">Vuelo de IDA solamente</option>
                                        <option value="idaVuelta">Vuelo de IDA + VUELTA</option>
                                        <option value="vuelta">Vuelo de VUELTA solamente</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Precio</label>
                                    <input type="number" class="form-control form-control-lg" name="precio" step="0.01" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Origen</label>
                                    <input type="text" class="form-control" name="origen" placeholder="Buenos Aires" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Destino</label>
                                    <input type="text" class="form-control" name="destino" placeholder="Córdoba" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Asientos totales</label>
                                    <input type="number" class="form-control" name="asientosTotales" min="1" required>
                                </div>

                                <!-- SECCIÓN VUELTA -->
                                <div id="seccionVuelta" class="col-12" style="display: none;">
                                    <hr class="my-4">
                                    <h4 class="mb-3"><i class="bi bi-arrow-down-left"></i> Vuelo de VUELTA</h4>

                                    <div class="btn-group w-100 mb-4" role="group">
                                        <input type="radio" class="btn-check" name="opcionVuelta" id="seleccionarVuelta" value="seleccionar" checked onchange="cambiarOpcionVuelta()">
                                        <label class="btn btn-outline-primary w-50" for="seleccionarVuelta">
                                            <i class="bi bi-list-check"></i> Seleccionar existente
                                        </label>

                                        <input type="radio" class="btn-check" name="opcionVuelta" id="crearVuelta" value="crear" onchange="cambiarOpcionVuelta()">
                                        <label class="btn btn-outline-primary w-50" for="crearVuelta">
                                            <i class="bi bi-plus-circle"></i> Crear nuevo
                                        </label>
                                    </div>

                                    <div id="seleccionarVueltaDiv" class="mb-4">
                                        <label class="form-label fw-bold">Seleccioná un vuelo de vuelta</label>
                                        <select class="form-select form-select-lg" name="idVueloVuelta" id="idVueloVuelta">
                                            <option value="">-- Selecciona una vuelta --</option>
                                            <?php foreach ($vuelos as $vuelo): ?>
                                                <option value="<?= $vuelo['idVuelo'] ?>">
                                                    <?= htmlspecialchars($vuelo['origen'] . ' → ' . $vuelo['destino']) ?> - 
                                                    <?= $vuelo['fechaSalida'] ?> <?= $vuelo['horaSalida'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div id="formVuelta" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Origen</label>
                                                <input type="text" class="form-control" name="origenVuelta" placeholder="Córdoba">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Destino</label>
                                                <input type="text" class="form-control" name="destinoVuelta" placeholder="Buenos Aires">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Asientos totales</label>
                                                <input type="number" class="form-control" name="asientosTotalesVuelta" min="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Precio</label>
                                                <input type="number" class="form-control" name="precioVuelta" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                        <i class="bi bi-check-circle"></i> Crear Vuelo
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