<?php


session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}


$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';



require_once BASE_PATH . 'controllers/crudPromociones.php';


$crudPromociones = new CrudPromociones();


$resultadoPromociones = $crudPromociones->listarPromocionesEstado('pendiente');


$promociones = [];

if ($resultadoPromociones) {
    while ($fila = mysqli_fetch_assoc($resultadoPromociones)) {
        $promociones[] = $fila;
    }
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



    <main>
        <div class=" bg-primary-subtle py-3">
            <div class="container shadow-lg p-3 mb-5 bg-body rounded">
                <a href="dashboard.php" class="btn btn-outline-primary">< Volver</a>
                <h1 class="text-center">Administrar Usuarios</h1>
                <div class="row">
                    <div class="col-md-6">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar usuario" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-12 m-auto my-4">
                        <div class="row m-auto">
                            <?php 
                            /** @var array $promociones*/
                            foreach ($promociones as $promocion): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <a href="opcionesPromo.php?idPromo=<?php echo $promocion['idPromo'] ?>" class="text-decoration-none">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Nombre: <?php echo ($promocion['nombrePromo']??'Nombre no disponible'); ?></h5>
                                                <p class="card-text">porcentaje: <?php echo ($promocion['porcDesc']??'Código no disponible'); ?></p>
                                                <p class="card-text">fecha Inicio: <?php echo ($promocion['fechaInicio']??'Código no disponible'); ?></p>
                                                <p class="card-text">fecha Fin: <?php echo ($promocion['fechaFin']??'Código no disponible'); ?></p>
                                                <p class="card-text">
                                                <p><strong>Estado:</strong> 
                                                    <?php if (($promocion['estadoPromo'] ?? 'rechazado') == 'verificado'): ?>
                                                        <span class="badge bg-success">Verificado</span>
                                                    <?php elseif ($promocion['estadoPromo'] == 'pendiente') : ?>
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    <?php elseif ($promocion['estadoPromo'] == 'deshabilitado') : ?>
                                                        <span class="badge bg-danger">Deshabilitado</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Rechazado</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
                
            </div>





            
        </div>
    </main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>