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

$totalReservas = count($reservas);
$confirmadas = 0;
$pendientes = 0;
foreach ($reservas as $r) {
    if (($r['estadoReserva'] ?? '') == 'confirmada') $confirmadas++;
    if (($r['estadoReserva'] ?? '') == 'pendiente de pago') $pendientes++;
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

                        <div class="d-flex align-items-center gap-3 mb-5">
                            <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 70px; height: 70px;">
                                <i class="bi bi-person-fill fs-2 text-primary"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">¡Hola, <?php echo $usuario['nombreUsuario']; ?>!</h3>
                                <small class="text-muted">
                                    <i class="bi bi-envelope"></i> <?php echo $usuario['email'] ?? ''; ?>
                                </small>
                            </div>
                        </div>

                        <h3 class="mb-4"><i class="bi bi-bookmark-check"></i> Mis Reservas</h3>
                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3">
                                    <i class="bi bi-bookmark-fill fs-2 text-primary"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $totalReservas ?></div>
                                    <small class="text-muted">Reservas totales</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3">
                                    <i class="bi bi-check-circle-fill fs-2 text-success"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $confirmadas ?></div>
                                    <small class="text-muted">Confirmadas</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3">
                                    <i class="bi bi-clock-history fs-2 text-warning"></i>
                                    <div class="fs-2 fw-bold lh-1"><?= $pendientes ?></div>
                                    <small class="text-muted">Pendientes de pago</small>
                                </div>
                            </div>
                        </div>

                        <h3 class="mb-4"><i class="bi bi-lightning-charge"></i> Accesos rápidos</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="<?= BASE_URL ?>/public/vuelos.php" class="btn btn-outline-primary w-100 py-4 rounded-4">
                                    <i class="bi bi-search fs-3 d-block mb-2"></i>
                                    Buscar vuelos
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="reservas.php" class="btn btn-outline-secondary w-100 py-4 rounded-4">
                                    <i class="bi bi-bookmark-check fs-3 d-block mb-2"></i>
                                    Mis reservas
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?= BASE_URL ?>/public/perfil.php" class="btn btn-outline-success w-100 py-4 rounded-4">
                                    <i class="bi bi-person fs-3 d-block mb-2"></i>
                                    Mi perfil
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>



<?php include '../../layouts/footer.php'; ?>