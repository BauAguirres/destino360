
<?php 

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CEO</title>
</head>
<body>
    <div class="bg-primary-subtle">
        <div class="container shadow-lg p-3 bg-body rounded">
            <h3><i class="bi bi-airplane"></i> Mi Aerolinea</h3>
            <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php endif; ?>
            <?php if ($exito): ?>
                    <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
                        <?php echo $exito; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php endif; ?>
            <div class="row justify-content-center m-4">
                <div class="col-md-8">
                    <div class="card fondoBlur text-light">
                        <div class="cardLogo">
                            <img class="logo" src="../assets/img/logosAerolineas/<?php echo $usuario['urlLogo']??null  ?>" alt="">
                        </div>
                        <div class="infoAerolinea">
                            <h5><?php echo $usuario['nombre']??null ?></h5>
                            <div class="d-flex justify-content-evenly">
                                <div class="">
                                    <small>Codigo IATA</small>
                                    <p class="fw-bold"><?php echo $usuario['codIATA']??null ?></p>
                                </div>
                                <div class="">
                                    <small>Codigo Pais</small>
                                    <p class="fw-bold"><?php echo $usuario['codPais']??null ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (($usuario['estadoUsuario']??null) == 'verificado') : ?>
            <div class="my-5">
                <h3 class="mb-4">
                    <i class="bi bi-graph-up"></i> Estadísticas
                </h3>
                <div class="d-flex justify-content-evenly fs-5">
                    <div class="d-flex flex-column p-4 bg-body card">
                        <span><i class="bi bi-airplane-fill"></i> Vuelos Activos</span>
                        <?= $vuelosActivos ?? 0 ?>
                    </div>
                    <div class="d-flex flex-column p-4 bg-body card">
                        <span><i class="bi bi-percent"></i> Promociones Activas</span>
                        <?= $vuelosActivos ?? 0 ?>
                    </div>
                    <div class="d-flex flex-column p-4 bg-body card">
                        <span><i class="bi bi-check-circle"></i> Reservas Activas</span>
                        <?= $vuelosActivos ?? 0 ?>
                    </div>
                </div>
            </div>
            <?php endif ?>
            <div class="my-5">
                <h3><i class="bi bi-info-circle"></i> Estado de Solicitud</h3>
                <?php if (($usuario['estadoUsuario']??null)=='pendiente') : ?>
                    <span class="statusBadge bg-warning text-light">
                        <i class="bi bi-clock-history"></i> Pendiente
                    </span>
                    <div class="statusMessage">
                        ⏳ Tu solicitud está en proceso de revisión. Esto toma 24-48 horas.
                    </div>
                <?php elseif (($usuario['estadoUsuario']??null)=='verificado') : ?>
                    <span class="statusBadge bg-success text-light">
                        <i class="bi bi-check-circle"></i> Verificado
                    </span>
                    <div class="statusMessage">
                        ✅ ¡Tu solicitud fue aprobada! Puedes gestionar vuelos y promociones.
                    </div>
                <?php else: ?>
                    <span class="statusBadge bg-danger text-light">
                        <i class="bi bi-clock-history"></i> Rechazado
                    </span>
                    <div class="statusMessage">
                        ❌ Tu solicitud fue rechazada.<br>
                        <strong>Razón:</strong> <?php echo $usuario['razonRechazo']??null ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>


