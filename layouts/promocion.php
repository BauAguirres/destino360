<?php
/** @var array $promocion */
$hoy = date('Y-m-d');
$estado = $promocion['estadoPromo'] ?? 'pendiente';

if ($estado == 'aprobado' && $hoy > $promocion['fechaFin']) {
    $estado = 'finalizada';
}

$estadoBadge = [
    'aprobado'   => ['bg-success', 'bi-check-circle', 'Aprobada'],
    'pendiente'  => ['bg-warning text-dark', 'bi-clock-history', 'Pendiente'],
    'rechazado'  => ['bg-danger', 'bi-x-circle', 'Rechazada'],
    'finalizada' => ['bg-secondary', 'bi-calendar-x', 'Finalizada'],
];
[$badgeClase, $badgeIcono, $badgeTexto] = $estadoBadge[$estado] ?? ['bg-secondary', 'bi-question-circle', 'Sin estado'];
?>

<a href="opcionesPromo.php?idPromocion=<?php echo $promocion['idPromo'] ?? ''?>" class="text-decoration-none text-reset">
    <div class="card h-100 shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-tag-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1"><?php echo $promocion['nombrePromo'] ?? 'Sin nombre'; ?></h5>
                    <span class="badge <?php echo $badgeClase; ?>">
                        <i class="bi <?php echo $badgeIcono; ?>"></i> <?php echo $badgeTexto; ?>
                    </span>
                </div>
            </div>

            <ul class="list-unstyled small mb-0">
                <li class="mb-1">
                    <i class="bi bi-percent"></i>
                    Descuento: <strong><?php echo $promocion['porcDesc'] ?? '0'; ?>%</strong>
                </li>
                <li class="mb-1">
                    <i class="bi bi-calendar-check"></i>
                    Desde: <strong><?php echo $promocion['fechaInicio'] ?? '—'; ?></strong>
                </li>
                <li class="mb-1">
                    <i class="bi bi-calendar-x"></i>
                    Hasta: <strong><?php echo $promocion['fechaFin'] ?? '—'; ?></strong>
                </li>
            </ul>
        </div>

        <div class="card-footer bg-transparent text-end">
            <button class="btn btn-sm btn-outline-primary">Ver opciones</button>
        </div>
    </div>
</a>