<?php


require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crud = new CrudUsuarios();

$resultado = $crud->listarCeo();

$usuarios = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $fila;
    }
}

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

?>

    <main>
        <div class=" bg-primary-subtle">
            <div class="container shadow-lg p-3 bg-body rounded">
                <h1 class="text-center">Administrar Usuarios</h1>
                <div class="row">
                    <div class="col-md-6">
                        <a href="solicitudes.php" class="btn btn-primary">Solicitudes de Acceso</a>
                    </div>
                    <div class="col-md-6">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar usuario" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
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
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
                
            </div>





            
        </div>
    </main>
