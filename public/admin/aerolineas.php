<?php
define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'controllers/CrudAerolineas.php';

$crud = new CrudAerolineas();
$resultado = $crud->listarAerolineas();

$aerolineas = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $aerolineas[] = $fila;
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
                <h1 class="text-center">Administrar Aerolíneas</h1>
                <div class="row">
                    <div class="col-md-6">
                        <a href="crearAerolinea.php" class="btn btn-primary">Crear Aerolínea</a>
                    </div>
                    <div class="col-md-6">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar aerolínea" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                    <div class="col-12 m-auto my-4">
                        <div class="row">
                            <?php foreach ($aerolineas as $aerolinea): ?>
                                <div class="col-md-3 my-2">
                                    <?php include '../../layouts/aerolinea.php'; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
                
            </div>





            
        </div>
    </main>




</body>
</html>