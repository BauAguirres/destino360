<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<body>
    
    <header>
        <nav class="navbar navbar-dark navbar-expand-lg bg-secondary">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img src="../../public/assets/img/logo.png" alt="Logo">
                    Destino360 - Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../public/vuelos.php">Vuelos</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="aerolineas.php">Aerolineas</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn nav-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Iniciar Sesión</button>
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content text-center">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Iniciar sesión</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" placeholder="Ingrese su correo electrónico">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Contraseña</label>
                                                <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña">
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                ¿Olvidaste tu contraseña?
                                            </a>
                                            <button type="submit" class="mx-5 btn btn-primary">Iniciar Sesión</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <span>¿No tenés cuenta?</span>
                                        <a href="registro.php" class="ms-1">Registrate</a>
                                        <span class="mx-2">|</span>
                                        <a href="registro-ceo.php">¿Sos CEO?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>


