<?php
define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'controllers/CrudVuelos.php';

$crud = new CrudVuelos();
$resultado = $crud->listarVuelos();

$vuelos = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}

$idVuelo = $_GET['idVuelo'] ?? null;
$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

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
                <h1 class="text-center my-5">Administrar Vuelos</h1>
                <div class="row">
                    <div class="col-md-6">
                        <a href="crearVuelo.php" class="btn btn-primary">Crear Vuelo</a>
                    </div>
                    <div class="col-md-6">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar vuelo" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
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
                    <div class="col-12 m-auto my-4">
                        <div class="row m-auto">
                            <?php foreach ($vuelos as $vuelo): ?>
                                <div class="col-md-3 col-6 d-flex justify-content-center my-5">
                                    <a href="opcionesVuelo.php?idVuelo=<?= $vuelo['idVuelo'] ?>" class="text-decoration-none">
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">Destino: <?php echo ($vuelo['destino']??'Nombre no disponible'); ?></h5>
                                                <p class="card-text">Origen: <?php echo ($vuelo['origen']??'Código no disponible'); ?></p>
                                                <p class="card-text">Aerolinea: <?php echo ($vuelo['nombre']??'Código no disponible'); ?></p>
                                                <p class="card-text">
                                                <strong>Estado:</strong> 
                                                <?php if (($vuelo['estadoVuelo'] ?? 0) == 1): ?>
                                                    <span class="badge bg-success">Activa</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactiva</span>
                                                <?php endif; ?>
                                                </p>
                                                <p class="card-text">Asiento Totales: <?php echo ($vuelo['asientosTotales']??'Asientos no disponibles'); ?></p>
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