<?php 

include_once '../../seguridad/seguridadCeo.php';

$idUsuario = $_SESSION['idUsuario'];
$idAerolinea = $_SESSION['idAerolinea'];

include '../../layouts/header.php';


require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudVuelos.php';
require_once BASE_PATH . 'controllers/crudPromociones.php';

$crudVuelos = new CrudVuelos();
$crudUsuarios = new CrudUsuarios();
$crudPromociones = new CrudPromociones();

$usuario = $crudUsuarios->obtenerCEO($idUsuario);
$resultado = $crudVuelos->listarVuelos($idAerolinea);
$resultadoPromociones = $crudPromociones->listarPromociones($idAerolinea);

$vuelos = [];

$promociones = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}

if ($resultadoPromociones) {
    while ($fila = mysqli_fetch_assoc($resultadoPromociones)) {
        $promociones[] = $fila;
    }
}

$error = '';
$exito = '';

ob_start();
include 'seguridad.php';
include 'vuelo.php';
include 'promociones.php';
ob_clean()



?>



    <main>
        <div class=" bg-primary-subtle py-3 my-3">
                    <?php if ($error): ?>
            <div class="container mb-3">
                <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($exito): ?>
            <div class="container mb-3">
                <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($exito) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>
            <div class="row container m-auto">
                <div class="col-2 shadow-lg p-3 bg-body rounded">
                    <div class="nav nav-pills flex-column gap-3">

                        <strong class="mx-3">Bienvenido, <?php echo $usuario['nombreUsuario']; ?>!</strong>
                        <button href="profileCeo.php" class="btn btn-outline-primary active" data-bs-toggle="pill" data-bs-target="#perfil">Informacion Personal</button>
                        <button href="aerolinea.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#aerolinea">Mi Aerolinea</button>
                        <?php if (($usuario['estadoUsuario']??null) == 'verificado') : ?>
                            <button href="vuelos.php?" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#gestionVuelos">Gestionar Vuelos</button>
                        <?php endif ?>
                        <button href="promociones.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#promciones">Gestionar Promociones</button>
                        <button href="../seguridad.php" class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#seguridad">Seguridad</button>
                        <a href="../cerrarSesion.php" class="btn btn-outline-primary">Cerrar Sesión</a>


                    </div>
                </div>
                <div class="col-10 tab-content">
                    <div class="tab-pane fade show active" id="perfil">
                        <?php include 'profileCeo.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="aerolinea">
                        <?php include 'aerolinea.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="gestionVuelos">
                        <?php include 'vuelos.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="promciones">
                        <?php include 'promociones.php'; ?>
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


