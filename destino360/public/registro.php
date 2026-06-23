<?php
define('BASE_PATH', __DIR__ . '/../');

require_once '../controllers/crudUsuarios.php';
require_once BASE_PATH . 'config/mailer.php';

$crud = new CrudUsuarios();
$err = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($usuario) || empty($email) || empty($telefono) || empty($password) || empty($password2)) {
        $err = 'Todos los campos son obligatorios';
    } else if (strlen($password) < 8) {
        $err = 'La contraseña debe tener al menos 8 caracteres';
    } else if ($password !== $password2) {
        $err = 'Las contraseñas no coinciden';
    } else {
        $token = bin2hex(random_bytes(32));
        $crud->crearUsuario($usuario, $email, $telefono, $password, $token);

        $link = "http://localhost/entorno/public/verificar.php?token=$token";

        $cuerpo = "
            <h2>¡Bienvenido a Destino360!</h2>
            <p>Gracias por registrarte. Para activar tu cuenta, hacé clic en el siguiente enlace:</p>
            <p><a href='$link' style='background:#0d6efd;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;'>Verificar mi cuenta</a></p>
            <p>O copiá esta dirección en tu navegador:<br>$link</p>
        ";

        if (enviarMail($email, 'Verificación de cuenta - Destino360', $cuerpo)) {
            $exito = 'Te enviamos un mail para verificar tu cuenta. Revisá tu casilla.';
        } else {
            $err = 'No se pudo enviar el mail de verificación. Intentá de nuevo.';
        }
    }
}

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="shadow-lg p-3 mb-5 bg-body rounded container">
            <div class="text-center">
                <h1>Crear Cuenta</h1>
                <p>Completa tus datos para empezar a reservar vuelos</p>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-2 py-3">
                <span class="badge rounded-pill bg-primary text-white">1</span>
                <span class="text-black fw-semibold small">Tus datos</span>

                <hr class="border-primary opacity-75 m-0" style="width: 80px;">

                <span class="badge rounded-pill bg-secondary" id="badge2">2</span>
                <span class="text-black-50 small" id="label2">Verificar email</span>

                <hr class="border-secondary opacity-50 m-0" id="linea2" style="width: 36px;">

                <span class="badge rounded-pill bg-secondary" id="badge3">3</span>
                <span class="text-black-50 small" id="label3">¡Listo!</span>
            </div>

            <div class="progress mb-1 mx-auto" style="height: 5px; width: 60%;">
                <div class="progress-bar bg-primary" role="progressbar"
                    id="barraProgreso"
                    style="width: 33%; transition: width .5s ease;">
                </div>
            </div>

            <form action="registro.php" method="POST">
                <div class="row">
                    <div class="col-md-6 my-2">
                        <label for="usuario">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" required>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" required>
                    </div>
                    <div class="col-md-12 my-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="password2">Repetir Contraseña</label>
                        <input type="password" class="form-control" name="password2" id="password2" required>
                    </div>

                    <?php if ($err): ?>
                        <div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
                            <?php echo $err; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($exito): ?>
                        <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
                            <?php echo $exito; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary">Crear Cuenta</button>
                </div>
            </form>

        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>