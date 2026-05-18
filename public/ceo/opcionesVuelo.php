<?php
define('BASE_PATH', __DIR__ . '/../../');
session_start();

require_once BASE_PATH . 'controllers/CrudVuelos.php';
require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crudVuelos = new CrudVuelos();
$crudUsuarios = new CrudUsuarios();

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

$idUsuario = $_SESSION['idUsuario'];
$usuario = $crudUsuarios->obtenerCEO($idUsuario);
$idAerolinea = $usuario['idAerolinea'];

$idVuelo = $_GET['idVuelo'] ?? null;
$vuelo = $crudVuelos->obtenerVuelo($idVuelo);

// Verificás que el vuelo pertenezca a SU aerolínea
if (!$vuelo || $vuelo['idAerolinea'] != $idAerolinea) {
    header('Location: dashboard.php?error=No tenés permiso para ver este vuelo');
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerolíneas - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-secondary">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                <img src="../assets/img/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-center">
                Destino360 - CEO
                </a>
                <div>
                    <button class="btn btn-outline-light">Cerrar Sesión</button>
                </div>
            </div>
        </nav>
    </header>



    <main>
        <div class=" bg-primary-subtle py-3">
            <div class="container shadow-lg p-3 mb-5 bg-body rounded">
                <h1 class="text-center my-5">Administrar Vuelo</h1>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
                                    <?php echo $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php endif; ?>
                        <?php if ($exito): ?>
                                <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
                                    <?php echo $exito; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 m-auto">
                        <div class="row m-auto justify-content-center align-items-center text-center">
                            <div class="col-md-12 mb-4">
                                <h2><?php echo $vuelo['origen']; ?> - <?php echo $vuelo['destino']; ?></h2>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Fecha de Salida:</strong> <?php echo ($vuelo['fechaSalida']??'Fecha de salida no disponible'); ?></p>
                                <p><strong>Hora de Salida:</strong> <?php echo ($vuelo['horaSalida']??'Hora de salida no disponible'); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Fecha de Llegada:</strong> <?php echo ($vuelo['fechaLlegada']??'Fecha de llegada no disponible'); ?></p>
                                <p><strong>Hora de Llegada:</strong> <?php echo ($vuelo['horaLlegada']??'Hora de llegada no disponible'); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Asientos Totales:</strong> <?php echo ($vuelo['asientosTotales']??'Asientos totales no disponible'); ?></p>
                                <p><strong>Asientos Disponibles:</strong> <?php echo ($vuelo['asientosDisp']??'Asientos disponibles no disponible'); ?></p>
                            </div>
                            <div class="col-md-12 d-flex justify-content-evenly align-items-center">
                                <p><strong>Precio:</strong> <?php echo ($vuelo['precio']??'Precio no disponible'); ?></p>
                                <p><strong>Estado:</strong> 
                                    <?php if (($vuelo['estadoVuelo'] ?? 0) == 1): ?>
                                        <span class="badge bg-success">Activa</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactiva</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <a href="actions/desActivarVuelo.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>" class="btn btn-outline-primary"  onclick="return confirm('Estás Seguro que desea cambiar el estado del Vuelo?' )" >
                                        <?php if($vuelo['estadoVuelo']==1){
                                            echo 'Desactivar';
                                        } else {
                                            echo 'Activar';
                                        }
                                        ?>
                                    </a>
                                    <a href="asignarHorario.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>" class="btn btn-outline-primary">Asignar fecha</a>
                                    <a href="eliminarVuelo.php?idVuelo=<?php echo $vuelo['idVuelo']; ?>" class="btn btn-outline-danger" onclick="return confirm('Estás seguro que deseas eliminar este vuelo?')">Eliminar</a>
                                </div>
                            </div>
                        </div> 
                    </div>

                </div>
                
            </div>





            
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>