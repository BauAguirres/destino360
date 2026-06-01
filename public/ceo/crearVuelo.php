<?php
define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

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
    $estado = 0; // Baja por defecto

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

        header('Location: dashboard.php?exito=Vuelo creado correctamente');
        exit();
    }
}









?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Aerolínea - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <div class="bg-primary-subtle py-3">
            <div class="shadow-lg p-3 mb-5 bg-body rounded container">
                <div class="text-center">
                    <h1>Crear Vuelo</h1>
                    <p>Completa los datos para crear un nuevo vuelo</p>


                <form action="crearVuelo.php" method="POST" enctype="multipart/form-data">
                    <div class="row fs-4">
                        <?php if ($err): ?>
                                <div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
                                    <?php echo $err; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php endif; ?>

                        <?php if ($exito): ?>
                                <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
                                    <?php echo $exito; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php endif; ?>
                        <div class="col-md-6 my-2">
                            <label class="form-label fw-bold">Tipo de Viaje</label>
                            <select class="form-select form-select-lg" id="tipoVuelo" name="tipoVuelo" required onchange="cambiarTipoViaje()">
                                    <option value="">-- Selecciona --</option>
                                    <option value="idaSolo">Vuelo de IDA solamente</option>
                                    <option value="idaVuelta">Vuelo de IDA + VUELTA</option>
                                </select>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="origen">Origen</label>
                            <input type="text" class="form-control" name="origen" id="origen" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="destino">Destino</label>
                            <input type="text" class="form-control" name="destino" id="destino" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="asientosTotales">Asientos Totales</label>
                            <input type="number" class="form-control" name="asientosTotales" id="asientosTotales" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control" name="precio" id="precio" step="0.01" required>
                        </div>

                        <div id="seccionVuelta" class=" col-12" style="display: none;">
                                <h4 class="mb-3"><i class="bi bi-arrow-down-left"></i> Vuelo de VUELTA</h4>

                                <div class="btn-group w-75 mb-4" role="group">
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
                                    <select class="form-select form-select-lg" name="idVueloVuelta" id="idVueloVuelta" >
                                        <option value="">-- Selecciona una vuelta --</option>
                                        <?php foreach ($vuelos as $vuelo): ?>
                                            <option value="<?= $vuelo['idVuelo'] ?>">
                                                <?= htmlspecialchars($vuelo['origen'] . ' → ' . $vuelo['destino']) ?> - 
                                                <?= $vuelo['fechaSalida'] ?> 
                                                <?= $vuelo['horaSalida'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="formVuelta" class="" style="display: none;">
        
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Origen</label>
                                        <input type="text" class="form-control" name="origenVuelta" placeholder="Córdoba">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Destino</label>
                                        <input type="text" class="form-control" name="destinoVuelta" placeholder="Buenos Aires">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Asientos Totales</label>
                                        <input type="number" class="form-control" name="asientosTotalesVuelta" min="1">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Precio</label>
                                        <input type="number" class="form-control" name="precioVuelta" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p>Precio Total: <?php  ?></p>
                        <button type="submit" class="my-4 btn btn-primary">Crear Vuelo</button>
                    
                </form>

            </div>
        </div>
    </main>

<script src="../assets/js/main.js"></script>
<?php include '../../layouts/footer.php'; ?>