<?php
define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}


require_once BASE_PATH . 'config/app.php';
require_once BASE_PATH . 'controllers/CrudVuelos.php';

$crud = new crudVuelos();
$err = '';
$exito = '';

$idVuelo = $_GET['idVuelo'] ?? null;
$vuelo = $crud->obtenerVuelo($idVuelo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fechaSalida = $_POST['fechaSalida'];
    $horaSalida = $_POST['horaSalida'];
    $fechaLlegada = $_POST['fechaLlegada'];
    $horaLlegada = $_POST['horaLlegada'];
    
    
    if (empty($fechaSalida) || empty($horaSalida) || empty($fechaLlegada) || empty($horaLlegada)) {
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
            $crud->asignarHorario($idVuelo, $fechaSalida, $horaSalida, $fechaLlegada, $horaLlegada);
            $exito = 'Horario asignado correctamente';
            header('Location: dashboard.php?exito=' . urlencode($exito));
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
                <a href="opcionesVuelo.php?idVuelo=<?php echo $idVuelo ?>" class="btn btn-outline-primary">< Volver</a>
                <div class="text-center">
                    <h1>Asignar Horario</h1>
                    <p>Completa los datos para asignar un horario al vuelo</p>


                <form action="asignarHorario.php?idVuelo=<?php echo $idVuelo ?>" method="POST" enctype="multipart/form-data">
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
                            <label for="fechaSalida">Fecha de Salida</label>
                            <input type="date" class="form-control" name="fechaSalida" id="fechaSalida" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="horaSalida">Hora de Salida</label>
                            <input type="time" class="form-control" name="horaSalida" id="horaSalida" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="fechaLlegada">Fecha de Llegada</label>
                            <input type="date" class="form-control" name="fechaLlegada" id="fechaLlegada" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="horaLlegada">Hora de Llegada</label>
                            <input type="time" class="form-control" name="horaLlegada" id="horaLlegada" required>
                        </div>
                            
                        <button type="submit" class="btn btn-primary">Asignar Horario</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>