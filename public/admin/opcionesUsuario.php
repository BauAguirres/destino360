<?php
define('BASE_PATH', __DIR__ . '/../../');
session_start();


require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crudUsuarios = new CrudUsuarios();

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

$idUsuario = $_GET['idUsuario'];
$usuario = $crudUsuarios->obtenerCEO($idUsuario);

$idAerolinea = $usuario['idAerolinea'];





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
                Destino360 - Admin
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
                <a href="dashboard.php" class="btn btn-outline-primary">< Volver</a>
                <h1 class="text-center my-5">Administrar Usuario</h1>
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
                                <h2><?php echo $usuario['idUsuario']?> - <?php echo $usuario['nombreUsuario']; ?></h2>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Email:</strong> <?php echo ($usuario['email']??'Email no disponible'); ?></p>
                                <p><strong>Telefono:</strong> <?php echo ($usuario['telefono']??'Telefono no disponible'); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Aerolinea Asignada:</strong> <?php echo ($usuario['nombre']??'Aerolinea no disponibles'); ?></p>
                                <p><strong>Fecha de Registro</strong> <?php echo date('d/m/Y', strtotime($usuario['creado']));?></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Vuelos Creados:</strong> <?php echo ($usuario['']??'Vuelos Creados no disponibles'); ?></p>
                                <p><strong>Vuelos Habilitados:</strong> <?php echo ($usuario['']??'Sin Vuelos Habilitados'); ?></p>
                            </div>
                            <div class="col-md-12 d-flex justify-content-evenly align-items-center">
                                <p><strong>Estado:</strong> 
                                    <?php if (($usuario['estadoUsuario'] ?? 'rechazado') == 'verificado'): ?>
                                        <span class="badge bg-success">Verificado</span>
                                    <?php elseif ($usuario['estadoUsuario'] == 'pendiente') : ?>
                                        <span class="badge bg-warning">Pendiente</span>
                                    <?php elseif ($usuario['estadoUsuario'] == 'deshabilitado') : ?>
                                        <span class="badge bg-danger">Deshabilitado</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rechazado</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <?php if ($usuario['estadoUsuario'] == 'pendiente') : ?>
                                        <a href="actions/cambiarEstadoCEO.php?idUsuario=<?=$usuario['idUsuario'] ?>&accion=verificar"  class="btn btn-outline-success"  onclick="return confirm('Estás Seguro que desea cambiar el estado del usuario?' )" >
                                            Aprobar
                                        </a>
                                        <a href="actions/cambiarEstadoCEO.php?idUsuario=<?=$usuario['idUsuario'] ?>&accion=rechazar"  class="btn btn-outline-danger"  onclick="return confirm('Estás Seguro que desea cambiar el estado del usuario?' )" >
                                            Rechazar
                                        </a>
                                    <?php elseif ($usuario['estadoUsuario'] != 'verificado') : ?>
                                        <a href="actions/cambiarEstadoCEO.php?idUsuario=<?=$usuario['idUsuario']?>&accion=verificar" class="btn btn-outline-success"  onclick="return confirm('Estás Seguro que desea cambiar el estado del usuario?' )" >
                                            Hablitar
                                        </a>
                                    <?php elseif ($usuario['estadoUsuario'] == 'verificado') : ?>
                                        <a href="actions/cambiarEstadoCEO.php?idUsuario=<?=$usuario['idUsuario']?>&accion=deshabilitar" class="btn btn-outline-warning"  onclick="return confirm('Estás Seguro que desea cambiar el estado del usuario?' )" >
                                            Deshabilitar
                                        </a>
                                    <?php endif; ?>
                                    <a href="eliminarUsuario.php?idUsuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-outline-danger" onclick="return confirm('Estás seguro que deseas eliminar este vuelo?')">Eliminar</a>
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