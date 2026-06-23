<?php
define('BASE_PATH', __DIR__ . '/../');

require_once '../controllers/crudUsuarios.php';
require_once BASE_PATH . 'config/mailer.php';

$crud = new CrudUsuarios();
$err = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        $err = 'Ingresá tu email';
    } else {
        $usuario = $crud->buscarPorEmail($email);

        if ($usuario) {
            $token = bin2hex(random_bytes(32));
            $crud->guardarTokenRecupero($email, $token);

            $link = "http://localhost/entorno/public/nuevaPassword.php?token=$token";

            $cuerpo = "
                <h2>Recuperación de contraseña</h2>
                <p>Recibimos una solicitud para restablecer tu contraseña. Hacé clic para crear una nueva:</p>
                <p><a href='$link' style='background:#0d6efd;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;'>Restablecer contraseña</a></p>
                <p>Si no pediste esto, ignorá este mensaje.</p>
            ";

            enviarMail($email, 'Recuperar contraseña - Destino360', $cuerpo);
        }

        // Mensaje genérico (no revelamos si el email existe o no, por seguridad)
        $exito = 'Si el email está registrado, te enviamos un enlace para recuperar tu contraseña.';
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
                        <i class="bi bi-key-fill text-primary" style="font-size: 48px;"></i>
                        <h2 class="fw-bold mt-2">Recuperar contraseña</h2>
                        <p class="text-muted">Ingresá tu email y te enviaremos un enlace para crear una nueva contraseña.</p>
                    </div>

                    <?php if ($err): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $err; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($exito): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $exito; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enviar enlace</button>
                        </div>
                        <a href="index.php" class="d-block text-center mt-3 text-decoration-none">Volver al inicio</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>