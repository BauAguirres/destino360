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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAerolinea = $usuario['idAerolinea'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $asientosTotales = $_POST['asientosTotales'];
    $asientosDisponibles = $asientosTotales;
    $precio = $_POST['precio'];
    $estado = 0; // Baja por defecto

    
    
    if (empty($idAerolinea) || empty($origen) || empty($destino) || empty($asientosTotales) || empty($asientosDisponibles) || empty($precio)) {
        $err = 'Todos los campos son obligatorios';
    } else {

        if (empty($err)) {
            $crud->crearVuelo($idAerolinea, $origen, $destino, $asientosTotales, $asientosDisponibles, $precio, $estado);
            header('Location: dashboard.php?exito=Vuelo creado correctamente');
            exit();
        }
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
                        <button type="submit" class="my-4 btn btn-primary">Crear Vuelo</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>