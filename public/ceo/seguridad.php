<?php



if($_SERVER['REQUEST_METHOD']==='POST'){
    $contraseñaActual = $_POST['contraseñaActual'];
    $contraseñaNueva = $_POST['contraseñaNueva'];
    $contraseñaConfirm = $_POST['contraseñaConfirm'];
    if (empty($contraseñaActual) || empty($contraseñaNueva) || empty($contraseñaConfirm)) {
            $error = 'Todos los campos son obligatorios';
        } else if (!password_verify($contraseñaActual, $usuario['password']??null)) {
            $error = 'La contraseña actual es incorrecta';
        } else if (strlen($contraseñaNueva) >= 8) {
            $error = 'La contraseña debe tener menos de 8 caracteres';
        } else if ($contraseñaNueva !== $contraseñaConfirm) {
            $error = 'Las contraseñas no coinciden';
        } else {
            $crud = $crudUsuarios->cambiarContraseña($idUs??null, $contraseñaNueva);
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
            <h3><i class="bi bi-shield-lock"></i> Cambiar Contraseña</h3>
            <div class="row justify-content-start">
                <form action="" method="POST">
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


