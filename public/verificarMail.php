<?php
$email = $_GET['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificá tu email — Destino360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once '../layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card p-4 shadow-sm">
                <h2>📧 Revisá tu correo</h2>
                <p class="text-muted mt-3">
                    Te mandamos un link de verificación a
                    <strong><?= htmlspecialchars($email) ?></strong>
                </p>
                <a href='$link' class="btn btn-primary">Verificar cuenta</a>
                <p class="text-muted small">
                    Si no lo encontrás, revisá la carpeta de spam.
                </p>
                <a href="index.php" class="btn btn-outline-primary mt-3">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layouts/footer.php'; ?>

</body>
</html>