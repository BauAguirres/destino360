<?php
$estado = $usuario['estadoUsuario'] ?? 'pendiente';
$estadoBadge = [
    'verificado'    => ['bg-success', 'bi-check-circle', 'Verificado'],
    'pendiente'     => ['bg-warning text-dark', 'bi-clock-history', 'Pendiente'],
    'deshabilitado' => ['bg-danger', 'bi-x-circle', 'Deshabilitado'],
    'rechazado'     => ['bg-danger', 'bi-x-circle', 'Rechazado'],
];
[$badgeClase, $badgeIcono, $badgeTexto] = $estadoBadge[$estado] ?? ['bg-secondary', 'bi-question-circle', 'Sin estado'];
?>

<a href="opcionesUsuario.php?idUsuario=<?php echo $usuario['idUsuario'] ?? ''; ?>" class="text-decoration-none text-reset">
    <div class="card h-100 shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-person-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1"><?php echo $usuario['nombreUsuario'] ?? 'Sin nombre'; ?></h5>
                    <?php $estado = $usuario['estadoUsuario'] ?? 'pendiente'; ?>
                    <?php if ($estado == 'verificado'): ?>
                        <span class="badge bg-success">Verificado</span>
                    <?php elseif ($estado == 'pendiente'): ?>
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    <?php elseif ($estado == 'deshabilitado'): ?>
                        <span class="badge bg-danger">Deshabilitado</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Rechazado</span>
                    <?php endif; ?>
                </div>
            </div>

            <ul class="list-unstyled small mb-0">
                <li class="mb-1">
                    <i class="bi bi-envelope"></i>
                    <?php echo $usuario['email'] ?? '—'; ?>
                </li>
                <li class="mb-1">
                    <i class="bi bi-airplane"></i>
                    Aerolínea: <strong><?php echo $usuario['nombre'] ?? 'Sin asignar'; ?></strong>
                </li>
            </ul>
        </div>

        <div class="card-footer bg-transparent text-end">
            <button class="btn btn-sm btn-outline-primary">Ver opciones</button>
        </div>
    </div>
</a>