<?php 

define('BASE_PATH', __DIR__ . '/../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

$idUsuario = $_SESSION['idUsuario'] ?? null;
$idAerolinea = $_SESSION['idAerolinea'] ?? null;

include '../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';


$crudUsuarios = new CrudUsuarios();


$usuario = $crudUsuarios->obtenerCEO($idUsuario);



$error = '';
$exito = '';

?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="container">
            <div class="row">

                <?php include '../layouts/sidebar.php'; ?>

                    <div class="col-md-9 col-lg-10">
                        <div class="shadow-lg p-4 bg-body rounded">
                        <h3><i class="bi bi-person-fill"></i> Informacion Personal</h3>
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
                <div class="row justify-content-start">
                    <div class="col-md-6 m-2">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $usuario['nombreUsuario']??null ?>" disabled>
                    </div>
                    <div class="col-md-6 m-2">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control bg-dark text-light fw-bold" value="<?= $usuario['email'] ??null?>" disabled>
                    </div>
                    <div class="col-md-6 m-2">
                        <label class="form-label">Telefono</label>
                        <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $usuario['telefono'] ??null?>" disabled>
                    </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>