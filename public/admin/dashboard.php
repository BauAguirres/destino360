<?php 

include '../../layouts/headeradmin.php';

define('BASE_PATH', __DIR__ . '/../../');


require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudAerolineas.php';

$crudAerolinea = new crudAerolineas();
$crudUsuarios = new CrudUsuarios();

$idUs = $_GET['idUsuario'] ?? null;
$usuario = $crudUsuarios->obtenerUsuario($idUs);









?>



    <main>
        <div class=" bg-primary-subtle py-3 my-3">
            <div class="row container m-auto">
                <div class="col-2 shadow-lg p-3 bg-body rounded">
                    <div class="nav nav-pills flex-column gap-3">

                        <strong class="mx-3">Bienvenido, <?php echo $usuario['nombreUsuario']; ?>!</strong>
                        <button href="opcionesUsuario.php?idUsuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-outline-primary " data-bs-toggle="pill" data-bs-target="#editarPerfil">Editar Perfil</button>
                        <button href="aerolineas.php" class="btn btn-outline-primary active" data-bs-toggle="pill" data-bs-target="#gestionAerolineas">Gestionar Aerolineas</button>
                        <button href="vuelos.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#cerrarSesion">Cerrar Sesión</button>


                    </div>
                </div>
                <div class="col-10 tab-content">
                        <div class="tab-pane fade fade show active" id="gestionAerolineas">
                            <?php include 'aerolineas.php'; ?>
                        </div>
                        <div class="tab-pane fade fade " id="editarPerfil">
                            <?php include '../profile.php'; ?>
                        </div>
                </div>
            </div>


            
        </div>
    </main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<?php include '../../layouts/footerAdmin.php'; ?>


