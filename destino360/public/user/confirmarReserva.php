<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once BASE_PATH . 'seguridad/seguridadUser.php';

$idUsuario = $_SESSION['idUsuario'];

require_once BASE_PATH . 'controllers/crudReservas.php';

$idReserva = $_GET['id'] ?? null;
$error = $_GET['error'] ?? '';

if (empty($idReserva) || !ctype_digit((string)$idReserva)) {
    header('Location: reservas.php');
    exit;
}

$crudReservas = new CrudReservas();
$reservaIda = $crudReservas->obtenerReservaById($idReserva);

if (!$reservaIda || $reservaIda['idUsuario'] != $idUsuario) {
    header('Location: reservas.php?error=Reserva no encontrada');
    exit;
}

$reservaVuelta = null;
if (!empty($reservaIda['idVueloRelacionado'])) {
    $reservaVuelta = $crudReservas->obtenerReservaPorVuelo($idUsuario, $reservaIda['idVueloRelacionado']);
}

$paymentId = $_GET['payment_id'] ?? $_GET['collection_id'] ?? null;

if ($paymentId && $reservaIda['estadoReserva'] === 'pendiente de pago') {
    require_once BASE_PATH . 'vendor/autoload.php';
    require_once BASE_PATH . 'config/mp.php';

    \MercadoPago\MercadoPagoConfig::setAccessToken(MP_ACCESS_TOKEN);
    $clientPago = new \MercadoPago\Client\Payment\PaymentClient();

    try {
        $payment = $clientPago->get($paymentId);

        if ($payment->status === 'approved') {
            
            $crudReservas->confirmarReserva($reservaIda['idReserva']);

            if ($reservaVuelta) {
                $crudReservas->confirmarReserva($reservaVuelta['idReserva']);
            }

            $reservaIda = $crudReservas->obtenerReservaById($idReserva);
        }
    } catch (\Exception $e) {
        error_log("Error al verificar pago de Mercado Pago: " . $e->getMessage());
    }
}
$esIdaYVuelta = $reservaVuelta !== null;

$total = $reservaIda['precioFinal'];
if ($esIdaYVuelta) {
    $total += $reservaVuelta['precioFinal'];
}

$cantidadPasajeros = (int) $reservaIda['cantidadMayores'] + (int) $reservaIda['cantidadMenores'];
$total = $total*$cantidadPasajeros;

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-5">
        <div class="row m-auto p-2">
            <div class="col-lg-8 col-12 m-auto">
                <div class="container shadow-lg p-5 bg-body rounded">

                    <a href="reservas.php" class="btn btn-outline-primary mb-4">
                        <i class="bi bi-arrow-left"></i> Volver a mis reservas
                    </a>
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0"><i class="bi bi-ticket-detailed"></i> Detalle de Reserva</h1>
                        <?php
                            $estado = $reservaIda['estadoReserva'];
                            if ($estado == 'confirmada') {
                                $estadoClase = 'bg-success';
                                $estadoTexto = 'Confirmada';
                            } elseif ($estado == 'cancelada') {
                                $estadoClase = 'bg-danger';
                                $estadoTexto = 'Cancelada';
                            } else {
                                $estadoClase = 'bg-warning text-dark';
                                $estadoTexto = 'Pendiente de pago';
                            }
                        ?>
                        <span class="badge <?php echo $estadoClase; ?> fs-6"><?php echo $estadoTexto; ?></span>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <img src="<?php echo BASE_URL; ?>/public/assets/img/logosAerolineas/<?php echo $reservaIda['urlLogo'] ?? 'default-logo.png'; ?>"
                             alt="Logo" style="max-height: 50px; max-width: 90px; object-fit: contain;">
                        <span class="fw-semibold fs-5"><?php echo $reservaIda['nombreAerolinea']; ?></span>
                    </div>

                    <div class="bg-primary-subtle rounded p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de IDA</h5>
                        <div class="row text-center mb-3">
                            <div class="col-md-5">
                                <small class="text-muted">ORIGEN</small>
                                <p class="fw-bold fs-4 text-dark mb-0"><?php echo $reservaIda['origen']; ?></p>
                            </div>
                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-right text-primary fs-3"></i>
                            </div>
                            <div class="col-md-5">
                                <small class="text-muted">DESTINO</small>
                                <p class="fw-bold fs-4 text-dark mb-0"><?php echo $reservaIda['destino']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <small class="text-muted">SALIDA</small>
                                <p class="fw-bold text-dark mb-0"><?php echo $reservaIda['fechaSalida']; ?></p>
                                <p class="text-primary fw-bold"><?php echo $reservaIda['horaSalida']; ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">LLEGADA</small>
                                <p class="fw-bold text-dark mb-0"><?php echo $reservaIda['fechaLlegada'] ?? '—'; ?></p>
                                <p class="text-primary fw-bold"><?php echo $reservaIda['horaLlegada'] ?? '—'; ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">SUBTOTAL</small>
                                <p class="fw-bold fs-5 text-success">$<?php echo number_format($reservaIda['precioFinal'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if ($esIdaYVuelta): ?>
                    <div class="bg-primary-subtle rounded p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de VUELTA</h5>
                        <div class="row text-center mb-3">
                            <div class="col-md-5">
                                <small class="text-muted">ORIGEN</small>
                                <p class="fw-bold fs-4 text-dark mb-0"><?php echo $reservaVuelta['origen']; ?></p>
                            </div>
                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-right text-primary fs-3"></i>
                            </div>
                            <div class="col-md-5">
                                <small class="text-muted">DESTINO</small>
                                <p class="fw-bold fs-4 text-dark mb-0"><?php echo $reservaVuelta['destino']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <small class="text-muted">SALIDA</small>
                                <p class="fw-bold text-dark mb-0"><?php echo $reservaVuelta['fechaSalida']; ?></p>
                                <p class="text-primary fw-bold"><?php echo $reservaVuelta['horaSalida']; ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">LLEGADA</small>
                                <p class="fw-bold text-dark mb-0"><?php echo $reservaVuelta['fechaLlegada'] ?? '—'; ?></p>
                                <p class="text-primary fw-bold"><?php echo $reservaVuelta['horaLlegada'] ?? '—'; ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">SUBTOTAL</small>
                                <p class="fw-bold fs-5 text-success">$<?php echo number_format($reservaVuelta['precioFinal'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-4">
                        <span><i class="bi bi-people"></i> Pasajeros</span>
                        <span class="fw-bold">
                            <?php echo $reservaIda['cantidadMayores']; ?> mayor(es),
                            <?php echo $reservaIda['cantidadMenores']; ?> menor(es)
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light rounded p-4 mb-4">
                        <h4 class="mb-0">TOTAL A PAGAR</h4>
                        <h3 class="fw-bold text-success mb-0">$<?php echo number_format($total, 2, ',', '.'); ?></h3>
                    </div>

                    <?php if ($estado == 'pendiente de pago'): ?>
                        <a href="procesarPago.php?id=<?php echo $reservaIda['idReserva']; ?>"
                           class="btn btn-primary w-100 py-3 fw-bold fs-5">
                            <i class="bi bi-credit-card"></i> Continuar con el pago
                        </a>
                        <a href="actions/cancelarReserva.php?idReserva=<?php echo $reservaIda['idReserva']; ?>"
                           class="btn btn-outline-danger w-100 py-3 fw-bold mt-2"
                           onclick="return confirm('¿Estás seguro que deseas cancelar esta reserva?')">
                            <i class="bi bi-x-circle"></i> Cancelar reserva
                        </a>
                    <?php elseif ($estado == 'confirmada'): ?>
                        <div class="alert alert-success text-center mb-0">
                            <i class="bi bi-check-circle"></i> Esta reserva ya está pagada y confirmada.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger text-center mb-0">
                            <i class="bi bi-x-circle"></i> Esta reserva fue cancelada.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>