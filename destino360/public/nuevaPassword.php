<?php
define('BASE_PATH', __DIR__ . '/../');

require_once '../controllers/crudUsuarios.php';

$crud = new CrudUsuarios();
$err = '';
$exito = '';

$token = $_GET['token'] ?? $_POST['token'] ?? '';

// Validar que el token exista
$usuario = !empty($token) ? $crud->buscarPorTokenRecupero($token) : null;

if (!$usuario) {
    $err = 'El enlace no es válido o ya fue utilizado.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuario) {
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (empty($password) || empty($password2)) {
        $err = 'Completá los dos campos';
    } else if (strlen($password) < 8) {
        $err = 'La contraseña debe tener al menos 8 caracteres';
    } else if ($password !== $password2) {
        $err = 'Las contraseñas no coinciden';
    } else {
        $crud->actualizarPassword($token, $password);
        $exito = 'Tu contraseña fue actualizada. Ya podés iniciar sesión.';
        $usuario = null; // ocultar el form después de cambiarla
    }
}

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-5">
        <div class="row m-auto p-2">
            <div class="col-lg-5 col-12 m-auto">
                <div class="container shadow-lg p-5 bg-body rounded">

                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock-fill text-primary" style="font-size: 48px;"></i>
                        <h2 class="fw-bold mt-2">Nueva contraseña</h2>
                    </div>

                    <?php if ($err): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $err; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($exito): ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php echo $exito; ?>
                        </div>
                        <div class="d-grid">
                            <a href="index.php?login=1" class="btn btn-primary">Iniciar Sesión</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($usuario && !$exito): ?>
                        <form method="POST">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nueva contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Repetir contraseña</label>
                                <input type="password" class="form-control" name="password2" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                            </div>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>