<?php
define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crud = new CrudUsuarios();
$resultado = $crud->obtenerCEOsEstado('pendiente');

$usuarios = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $fila;
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
                            <?php foreach ($usuarios as $usuario): ?>
                                <div class="col-md-3 col-6 d-flex justify-content-center my-5">
                                    <div class="card" style="width: 18rem;">
                                        <?php include '../../layouts/usuario.php'; ?>
                                        <div class="card-footer">
                                            <a href="opcionesUsuario.php?idUsuario=<?php echo $usuario['idUsuario'] ?>" class="btn btn-primary d-block w-100">Detalles</a>
                                    </div>
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