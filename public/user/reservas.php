<?php 

include_once '../../seguridad/seguridadUser.php';

$idUsuario = $_SESSION['idUsuario'];

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';
require_once BASE_PATH . 'controllers/crudReservas.php';

$crudUsuarios = new CrudUsuarios();
$crudReservas = new CrudReservas();

$usuario = $crudUsuarios->obtenerUsuario($idUsuario);
$resultado = $crudReservas->obtenerReservas($idUsuario);

$reservas = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $reservas[] = $fila;
    }
}

$error = $_GET['error'] ?? '';
$exito = $_GET['exito'] ?? '';
?>


<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($exito): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $exito ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">

                <?php include '../../layouts/sidebar.php'; ?>

                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-bookmark-check"></i> Mis Reservas</h3>

                        <div class="row g-4">

                            <?php if (empty($reservas)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                    Todavía no tenés reservas. ¡Buscá tu próximo vuelo!
                                </div>
                            <?php else: ?>
                                <?php foreach ($reservas as $reserva): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 shadow-sm border-0 rounded-4">
                                            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                                <span class="fw-semibold">
                                                    <i class="bi bi-airplane-fill text-primary"></i>
                                                    <?php echo $reserva['origen']; ?> → <?php echo $reserva['destino']; ?>
                                                </span>
                                                <?php $estado = $reserva['estadoReserva'] ?? ''; ?>
                                                <?php if ($estado == 'confirmada'): ?>
                                                    <span class="badge bg-success">Confirmada</span>
                                                <?php elseif ($estado == 'cancelada'): ?>
                                                    <span class="badge bg-secondary">Cancelada</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                                <?php endif; ?>
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
                                                        <i class="bi bi-tag"></i>
                                                        Tipo: <?php echo $reserva['tipoVuelo']; ?>
                                                    </li>
                                                </ul>
                                            </div>

                                            <?php if ($estado == 'pendiente de pago'): ?>
                                                <div class="card-footer bg-transparent">
                                                    <a href="<?php echo BASE_URL; ?>/public/user/confirmarReserva.php?id=<?php echo $reserva['idReserva']; ?>"
                                                       class="btn btn-primary btn-sm w-100">
                                                        <i class="bi bi-arrow-right-circle"></i> Continuar reserva
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


<?php include '../../layouts/footer.php'; ?>