<?php
$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;
?>
<main>
    <div class="bg-primary-subtle py-3 my-3">
        <h3 class="mb-4"><i class="bi bi-airplane"></i> Mi Aerolínea</h3>

        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-4 bg-primary d-flex align-items-center justify-content-center p-3">
                            <div class="bg-white rounded-3 d-flex align-items-center justify-content-center p-2"
                                style="width: 150px; height: 150px;">
                                <img src="<?= BASE_URL ?>/public/assets/img/logosAerolineas/<?php echo $usuario['urlLogo'] ?? 'default-logo.png'; ?>" alt="Logo" style="max-width: 95%; max-height: 95%; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Aerolínea</small>
                                        <h4 class="fw-bold mb-0"><?php echo $usuario['nombre'] ?? '—'; ?></h4>
                                    </div>
                                    <?php $estado = $usuario['estadoUsuario'] ?? null; ?>
                                    <?php if ($estado == 'verificado'): ?>
                                        <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verificado</span>
                                    <?php elseif ($estado == 'pendiente'): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Pendiente</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rechazado</span>
                                    <?php endif; ?>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Código IATA</small>
                                        <p class="fw-bold fs-5 mb-0"><?php echo $usuario['codIATA'] ?? '—'; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Código País</small>
                                        <p class="fw-bold fs-5 mb-0"><?php echo $usuario['codPais'] ?? '—'; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

<?php if (($usuario['estadoUsuario'] ?? null) == 'verificado'): ?>
        <!-- ACCESOS RÁPIDOS -->
    <h3 class="mb-4"><i class="bi bi-lightning-charge"></i> Accesos rápidos</h3>
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <a href="crearVuelo.php" class="btn btn-outline-primary w-100 py-4 rounded-4">
                <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                Crear vuelo
            </a>
        </div>
        <div class="col-md-4">
            <a href="crearPromocion.php" class="btn btn-outline-success w-100 py-4 rounded-4">
                <i class="bi bi-percent fs-3 d-block mb-2"></i>
                Crear promoción
            </a>
        </div>
        <div class="col-md-4">
            <a href="vuelos.php" class="btn btn-outline-secondary w-100 py-4 rounded-4">
                <i class="bi bi-list-ul fs-3 d-block mb-2"></i>
                Ver mis vuelos
            </a>
        </div>
    </div>
    
    <h3 class="mb-4"><i class="bi bi-speedometer2"></i> Resumen de Vuelos</h3>
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-airplane-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold"><?= $conteoVuelos['total'] ?? 0 ?></div>
                        <small class="text-muted">Total de vuelos</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold"><?= $conteoVuelos['activos'] ?? 0 ?></div>
                        <small class="text-muted">Vuelos activos</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-clock-history fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold"><?= $conteoVuelos['inactivos'] ?? 0 ?></div>
                        <small class="text-muted">Vuelos inactivos</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <h3 class="mb-4"><i class="bi bi-bookmark-check"></i> Resumen de Reservas</h3>
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-bookmark-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold lh-1"><?= $conteoReservas['total'] ?? 0 ?></div>
                        <small class="text-muted">Total de reservas</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold lh-1"><?= $conteoReservas['confirmadas'] ?? 0 ?></div>
                        <small class="text-muted">Confirmadas (con pago)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-clock-history fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold lh-1"><?= $conteoReservas['pendientes'] ?? 0 ?></div>
                        <small class="text-muted">Pendientes de pago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php endif; ?>


</main>