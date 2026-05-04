<?php
define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'config/app.php';
require_once BASE_PATH . 'controllers/CrudAerolineas.php';

$crud = new CrudAerolineas();
$err = '';
$exito = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $codIATA = $_POST['codIATA'];
    $codPais = $_POST['codPais'];
    $descripcion = $_POST['descripcion'];
    $estado = 0; // Baja por defecto
    $urlLogo = NULL;  
    
    
    if (empty($nombre) || empty($codIATA) || empty($codPais)) {
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
            $crud->crearAerolinea($nombre, $codIATA, $codPais, $estado, $descripcion, $urlLogo);
            $exito = 'Aerolínea creada correctamente';
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
                    <h1>Crear Aerolínea</h1>
                    <p>Completa los datos para crear una nueva aerolínea</p>


                <form action="crearAerolinea.php" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-12 my-2">
                            <label for="nombre">Nombre de Aerolinea</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="codIATA">Codigo IATA</label>
                            <input type="text" class="form-control" name="codIATA" id="codIATA" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="codPais">Codigo País</label>
                            <input type="text" class="form-control" name="codPais" id="codPais" required>
                        </div>
                        <div class="col-md-12 my-2">
                            <label for="formFile" class="form-label">Logo de la Aerolínea</label>
                            <input class="form-control" type="file" id="formFile" name="logo" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-12 my-2">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Aerolinea</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>