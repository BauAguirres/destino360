<?php 

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';



require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudAerolineas.php';
require_once BASE_PATH . 'controllers/crudPromociones.php';

$crudAerolinea = new crudAerolineas();
$crudUsuarios = new CrudUsuarios();
$crudPromociones = new CrudPromociones();

$usuario = $crudUsuarios->obtenerUsuario($idUsuario);
$resultadoPromociones = $crudPromociones->listarPromocionesEstadoDist('pendiente');


if ($resultadoPromociones) {
    while ($fila = mysqli_fetch_assoc($resultadoPromociones)) {
        $promociones[] = $fila;
    }
}







?>



    <main>
        <div class=" bg-primary-subtle py-3 my-3">
            <div class="row container m-auto">
                <div class="col-2 shadow-lg p-3 bg-body rounded">
                    <div class="nav nav-pills flex-column gap-3">

                        <strong class="mx-3">Bienvenido, <?php echo $usuario['nombreUsuario']; ?>!</strong>
                        <button href="profileAdmin.php.php?idUsuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-outline-primary active" data-bs-toggle="pill" data-bs-target="#editarPerfil">Editar Perfil</button>
                        <button href="aerolineas.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#gestionAerolineas">Gestionar Aerolineas</button>
                        <button href="promociones.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#promociones">Gestionar Promociones</button>
                        <button href="usuarios.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#usuarios">Gestionar CEOs</button>
                        <a href="../cerrarSesion.php" class="btn btn-outline-primary">Cerrar Sesión</a>


                    </div>
                </div>
                <div class="col-10 tab-content">
                    <div class="tab-pane fade show active " id="editarPerfil">
                        <?php include 'profileAdmin.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="gestionAerolineas">
                        <?php include 'aerolineas.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="promociones">
                        <?php include 'promociones.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="usuarios">
                        <?php include 'usuarios.php'; ?>
                    </div>
                    
                </div>
            </div>


            
        </div>
    </main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<?php include '../../layouts/footerAdmin.php'; ?>


