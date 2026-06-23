<?php
$estado = ($aerolinea['estadoAerolinea'] ?? 0) == 1 ? 'activa' : 'inactiva';
$estadoBadge = [
    'activa'   => ['bg-success', 'bi-check-circle', 'Activa'],
    'inactiva' => ['bg-danger', 'bi-x-circle', 'Inactiva'],
];
[$badgeClase, $badgeIcono, $badgeTexto] = $estadoBadge[$estado];
?>

<a href="opcionesAerolinea.php?idAerolinea=<?php echo $aerolinea['idAerolinea'] ?? '' ?>" class="text-decoration-none text-reset">
    <div class="card h-100 shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="../assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>"
                     alt="Logo"
                     style="max-height: 60px; max-width: 100px; object-fit: contain;">
                <div>
                    <h5 class="fw-bold mb-1"><?php echo $aerolinea['nombre'] ?? 'Sin nombre'; ?></h5>
                    <?php if (($aerolinea['estadoAerolinea'] ?? 0) == 1): ?>
                        <span class="badge bg-success">Activa</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inactiva</span>
                    <?php endif; ?>
                </div>
            </div>

            <ul class="list-unstyled small mb-0">
                <li class="mb-1">
                    <i class="bi bi-tag"></i>
                    IATA: <strong><?php echo $aerolinea['codIATA'] ?? '—'; ?></strong>
                </li>
                <li class="mb-1">
                    <i class="bi bi-globe"></i>
                    País: <strong><?php echo $aerolinea['codPais'] ?? '—'; ?></strong>
                </li>
            </ul>
        </div>

        <div class="card-footer bg-transparent text-end">
            <button class="btn btn-sm btn-outline-primary">Ver opciones</button>
        </div>
    </div>
</a>