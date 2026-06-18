<?php
require_once '../../controllers/crudPromociones.php';

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

include '../../layouts/header.php';

$crudPromociones = new crudPromociones();
$err = "";
$exito = "";

$idPromo = $_GET['idPromo'];
$promocion = $crudPromociones->obtenerPromocion($idPromo);

$estado = $promocion['estadoPromo'] ?? 'pendiente';
$estadoBadge = [
    'aprobado'  => ['bg-success', 'Aprobada'],
    'pendiente' => ['bg-warning text-dark', 'Pendiente'],
];
[$badgeClase, $badgeTexto] = $estadoBadge[$estado] ?? ['bg-danger', 'Rechazada'];
?>


<main class="bg-primary-subtle py-5">
    <div class="container shadow-lg p-5 bg-body rounded">

        <a href="dashboard.php" class="btn btn-outline-primary mb-4">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <?php if ($err): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $err; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $exito; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="text-center border-bottom pb-4 mb-4">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                        style="width: 90px; height: 90px;">
                    <i class="bi bi-tag-fill text-primary" style="font-size: 44px;"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-1"><?php echo htmlspecialchars($promocion['nombrePromo'] ?? ''); ?></h2>
            <p class="text-muted mb-2"><?php echo htmlspecialchars($promocion['nombre'] ?? ''); ?></p>
            <span class="badge <?php echo $badgeClase; ?> fs-6"><?php echo $badgeTexto; ?></span>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <small class="text-muted d-block">
                    <i class="bi bi-percent"></i> Descuento
                </small>
                <span class="fw-semibold fs-4 text-success"><?php echo $promocion['porcDesc'] ?? '0'; ?>%</span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">
                    <i class="bi bi-calendar-check"></i> Fecha inicio
                </small>
                <span class="fw-semibold"><?php echo $promocion['fechaInicio'] ?? 'No disponible'; ?></span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">
                    <i class="bi bi-calendar-x"></i> Fecha fin
                </small>
                <span class="fw-semibold"><?php echo $promocion['fechaFin'] ?? 'No disponible'; ?></span>
            </div>
            <div class="col-md-12">
                <small class="text-muted d-block">
                    <i class="bi bi-card-text"></i> Descripción
                </small>
                <p class="fw-semibold mb-0"><?php echo htmlspecialchars($promocion['descPromocion'] ?? 'Sin descripción'); ?></p>
            </div>
        </div>

        <?php if ($estado == 'pendiente'): ?>
            <div class="border-top pt-4">
                <h6 class="text-muted mb-3"><i class="bi bi-gear"></i> Acciones</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="actions/estadoPromo.php?idPromo=<?= $promocion['idPromo'] ?>&accion=verificar"
                        class="btn btn-success"
                        onclick="return confirm('¿Estás seguro que deseas aprobar esta promoción?')">
                        <i class="bi bi-check-circle"></i> Aprobar
                    </a>
                    <a href="actions/estadoPromo.php?idPromo=<?= $promocion['idPromo'] ?>&accion=rechazar"
                        class="btn btn-outline-danger"
                        onclick="return confirm('¿Estás seguro que deseas rechazar esta promoción?')">
                        <i class="bi bi-x-circle"></i> Rechazar
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="border-top pt-4 text-center text-muted">
                <i class="bi bi-info-circle"></i> Esta promoción ya fue procesada.
            </div>
        <?php endif; ?>

    </div>
</main>



<?php include '../../layouts/footer.php'; ?>