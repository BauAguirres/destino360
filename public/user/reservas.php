
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
            <h3><i class="bi bi-person-fill"></i> Mis Reservas</h3>
            <div class="row justify-content-start">
                <?php 
                /** @var array $reservas*/
                foreach ($reservas as $reserva): ?>
                <div class="col-md-6 m-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $reserva['origen']; ?></h3>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>


