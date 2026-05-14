<?php

$crudUsuarios = new CrudUsuarios();
$idUs = $_GET['idUsuario'];


$resultado = $crudUsuarios->obtenerCEO($idUs);
$usuario = mysqli_fetch_assoc($resultado);

$error='';
$exito='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $contraseñaActual = $_POST['contraseñaActual'];
    $contraseñaNueva = $_POST['contraseñaNueva'];
    $contraseñaConfirm = $_POST['contraseñaConfirm'];
    if (empty($passwordActual) || empty($passwordNueva) || empty($passwordConfirm)) {
            $error = 'Todos los campos son obligatorios';
        } else if (!password_verify($passwordActual, $usuario['claveUsuario'])) {
            $error = 'La contraseña actual es incorrecta';
        } else if (strlen($passwordNueva) >= 8) {
            $error = 'La contraseña debe tener menos de 8 caracteres';
        } else if ($passwordNueva !== $passwordConfirm) {
            $error = 'Las contraseñas no coinciden';
        } else {
            $crud = $crudUsuarios->cambiarContraseña($idUs, $contraseñaNueva);
            $exito = 'Contraseña actualizada correctamente';    
        }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class=" bg-primary-subtle">
        <div class="container shadow-lg p-3 bg-body rounded">
            <h3><i class="bi bi-person-fill"></i>Cambiar Contraseña</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($exito): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ <?= htmlspecialchars($exito) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <div class="row justify-content-start">
                <form action="seguridad.php" method="POST">
                    <div class="col-md-6 m-2">
                        <label class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" name="contraseñaActual" required>
                    </div>
                    <div class="col-md-6 m-2">
                        <label class="form-label">Contraseña Nueva</label>
                        <input type="password" class="form-control" name="contraseñaNueva" required>
                    </div>
                    <div class="col-md-6 m-2">
                        <label class="form-label">Confrimar Contraseña Nueva</label>
                        <input type="password" class="form-control" name="contraseñaConfirm" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


