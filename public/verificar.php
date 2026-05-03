<?php

require_once '../controllers/crudUsuarios.php';


$crud = new crudUsuarios();
$err = '';

$token = $_GET['token'] ?? '';
if(empty($token)) {
    $err = 'Token no proporcionado';
} else {
    $usuario = $crud -> verificarToken($token);
    if($usuario) {
        $crud -> activarCuenta($token);
        header('Location: confirmacion.php');
        exit;
    } else {
        $err = 'Token inválido o ya utilizado';
    }
}


$email = $_GET['email'] ?? '';





?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Mail - Destino360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-secondary">
            <div class="container">
                <a class="navbar-brand" href="#">
                <img src="assets/img/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-center">
                Destino360
                </a>
                <div>
                    <button class="btn btn-outline-light">Iniciar Sesión</button>
                </div>
            </div>
        </nav>
    </header>
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

                    <hr class="border-primary opacity-100 m-0" style="width: 36px;">

                    <span class="badge rounded-pill bg-primary text-white" id="badge2">2</span>
                    <span class="text-black fw-semibold small" id="label2">Verificar email</span>

                    <hr class="border-secondary opacity-75 m-0" id="linea2" style="width: 80px;">

                    <span class="badge rounded-pill bg-secondary" id="badge3">3</span>
                    <span class="text-black-50 small" id="label3">¡Listo!</span>

                </div>
                <div class="progress mb-1 mx-auto" style="height: 5px; width: 60%;">
                    <div class="progress-bar bg-primary" role="progressbar"
                        id="barraProgreso" 
                        style="width: 66%; transition: width .5s ease;">
                    </div>
                </div>

                <div class="row justify-content-center my-5">
                    <div class="col-md-6">
                        <div class="card p-4 text-center">
                            <p class="text-center">¡Te enviamos un email para verificar tu cuenta!</p>
                            <strong> <?= htmlspecialchars($email) ?> </strong>
                            <p class="text-muted small">No olvides revisar tu bandeja de entrada (o spam) para encontrar el mensaje de verificación.</p>
                            <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>
    
</body>
</html>