
<?php 

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="bg-primary-subtle">
        <div class="container shadow-lg p-3 bg-body rounded">
            <h3><i class="bi bi-person-fill"></i> Informacion Personal</h3>
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
</body>
</html>


