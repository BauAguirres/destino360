<?php
define('BASE_PATH', __DIR__ . '/../../');
session_start();

require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crud = new CrudUsuarios();
$err = '';

$idUsuario = $_GET['idUsuario'] ?? null;

if (empty($idUsuario) || !ctype_digit((string)$idUsuario)) {
    header('Location: usuarios.php');
    exit;
}

$usuario = $crud->obtenerCEO($idUsuario);

if (!$usuario) {
    header('Location: usuarios.php?error=Usuario no encontrado');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    if (empty($nombre) || empty($email) || empty($telefono)) {
        $err = 'Todos los campos son obligatorios';
    } else {
        $crud->editarUsuario($idUsuario, $nombre, $email, $telefono);
        header('Location: opcionesUsuario.php?idUsuario=' . $idUsuario . '&exito=Usuario actualizado correctamente');
        exit;
    }
}

include BASE_PATH . 'layouts/header.php';
?>

<main class="bg-primary-subtle py-5">
    <div class="container shadow-lg p-5 bg-body rounded">

        <a href="usuarios.php" class="btn btn-outline-primary mb-4">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <div class="text-center mb-5">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-person-fill text-primary" style="font-size: 40px;"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-1">Editar Usuario</h2>
            <p class="text-muted">Modificá los datos del usuario</p>
        </div>

        <?php if ($err): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $err; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Nombre de usuario</label>
                    <input type="text" class="form-control form-control-lg" name="nombre"
                           value="<?php echo $usuario['nombreUsuario']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" name="email"
                           value="<?php echo $usuario['email']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Teléfono</label>
                    <input type="text" class="form-control" name="telefono"
                           value="<?php echo $usuario['telefono']; ?>" required>
                </div>
                <div class="col-12 d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                        <i class="bi bi-check-circle"></i> Guardar cambios
                    </button>
                    <a href="opcionesUsuario.php?idUsuario=<?= $idUsuario ?>" class="btn btn-secondary w-100 py-3 fw-bold">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>

    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>