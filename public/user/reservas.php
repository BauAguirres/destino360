<?php

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <!-- Si tu layout ya incluye Bootstrap + Icons, podés borrar estas dos líneas -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="bg-primary-subtle py-4">
        <div class="container shadow-lg p-4 bg-body rounded">
            <h3 class="mb-4"><i class="bi bi-person-fill"></i> Mis Reservas</h3>

            <div class="row justify-content-start">
                <?php /** @var array $reservas */ ?>
                <?php foreach ($reservas as $reserva): ?>
                    <?php if($reserva['tipoVuelo'] !== 'vuelta') :?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-airplane-fill"></i>
                                    <?php echo $reserva['origen']; ?>
                                    →
                                    <?php echo $reserva['destino']; ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1">
                                        <i class="bi bi-buildings"></i>
                                        Aerolínea: <?php echo $reserva['nombre']; ?>
                                    </li>
                                    <li class="mb-1">
                                        <i class="bi bi-calendar-event"></i>
                                        Salida: <?php echo $reserva['fechaSalida']; ?>
                                        a las <?php echo $reserva['horaSalida']; ?> hs
                                    </li>
                                    <li class="mb-1">
                                        <i class="bi bi-cash-coin"></i>
                                        Precio: $<?php echo number_format((float) $reserva['precioFinal'], 2, ',', '.'); ?>
                                    </li>
                                    <li>
                                        <i class="bi bi-info-circle"></i>
                                        Estado: <?php echo $reserva['estadoReserva']; ?>
                                    </li>
                                    <li>
                                        <i class="bi bi-info-circle"></i>
                                        Tipo de vuelo: <?php echo $reserva['tipoVuelo']; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?php echo BASE_URL; ?>public/reservas.php?accion=confirmar&id=<?php echo $reserva['idReserva']; ?>"
                                   class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-arrow-right-circle"></i> Continuar reserva
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>