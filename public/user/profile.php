<?php 

include_once '../../seguridad/seguridadUser.php';
    

$idUsuario = $_SESSION['idUsuario'];
    
    
include '../../layouts/header.php';


require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudReservas.php';

$crudUsuarios = new CrudUsuarios();
$crudReservas = new CrudReservas();

$usuario = $crudUsuarios->obtenerUsuario($idUsuario);
$resultado = $crudReservas->obtenerReservas($idUsuario);

$reservas = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $reservas[] = $fila;
    }
}

ob_start();
include '../seguridad.php';
ob_clean();





?>



    <main>
        <div class=" bg-primary-subtle py-3 my-3">
            <div class="row container m-auto">
                <div class="col-2 shadow-lg p-3 bg-body rounded">
                    <div class="nav nav-pills flex-column gap-3">

                        <strong class="mx-3">Bienvenido, <?php echo $usuario['nombreUsuario']; ?>!</strong>
                        <button href="profileUser.php.php?idUsuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-outline-primary active" data-bs-toggle="pill" data-bs-target="#editarPerfil">Editar Perfil</button>
                        <button href="../seguridad.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#seguridad">Seguridad</button>
                        <button href="reservas.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#reservas">Mis Reservas</button>
                        <a href="../cerrarSesion.php" class="btn btn-outline-primary">Cerrar Sesión</a>


                    </div>
                </div>
                <div class="col-10 tab-content">
                    <div class="tab-pane fade show active " id="editarPerfil">
                        <?php include 'profileUser.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="reservas">
                        <?php include 'reservas.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="seguridad">
                        <?php include '../seguridad.php'; ?>
                    </div>
                    
                </div>
            </div>


            
        </div>
    </main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<?php include '../../layouts/footerAdmin.php'; ?>


