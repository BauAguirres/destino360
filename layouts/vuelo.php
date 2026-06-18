<?php
    $precioOriginal = $vuelo['precio'] ?? 0;
    $precioFinal = $precioOriginal;

    if (!empty($promocion)) {
        $precioFinal = $precioOriginal - ($precioOriginal * ($promocion['porcDesc'] / 100));
    }
?>

<div class="card h-100 shadow-sm border-0 rounded-4">
    <div class="card-body d-flex flex-column">

        <!-- Ruta origen → destino -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="text-center">
                <div class="fw-bold fs-5"><?php echo $vuelo['origen'] ?? ''; ?></div>
                <small class="text-muted">Origen</small>
            </div>
            <i class="bi bi-arrow-right text-primary mx-2"></i>
            <div class="text-center">
                <div class="fw-bold fs-5"><?php echo $vuelo['destino'] ?? ''; ?></div>
                <small class="text-muted">Destino</small>
            </div>
        </div>

        <ul class="list-unstyled small mb-3 flex-grow-1">
            <li class="mb-1">
                <i class="bi bi-calendar-event"></i>
                <?php echo $vuelo['fechaSalida'] ?? ''; ?>
                a las <?php echo $vuelo['horaSalida'] ?? ''; ?> hs
            </li>
            <li class="mb-1">
                <i class="bi bi-people"></i>
                Asientos disponibles: <?php echo $vuelo['asientosDisp'] ?? '0'; ?>
            </li>
            <?php if (!empty($promocion)): ?>
                <li class="mb-1">
                    <span class="badge bg-success">
                        <i class="bi bi-tag-fill"></i> <?php echo $promocion['porcDesc']; ?>% OFF - <?php echo htmlspecialchars($promocion['nombrePromo']); ?>
                    </span>
                </li>
            <?php endif; ?>
        </ul>

        <div class="d-flex justify-content-between align-items-center mt-auto">
            <span class="fw-bold fs-5 text-success">
                <?php if (!empty($promocion)): ?>
                    $<?php echo number_format((float) $precioFinal, 2, ',', '.'); ?>
                    <small class="text-muted text-decoration-line-through ms-1">
                        $<?php echo number_format((float) $precioOriginal, 2, ',', '.'); ?>
                    </small>
                <?php else: ?>
                    $<?php echo number_format((float) $precioOriginal, 2, ',', '.'); ?>
                <?php endif; ?>
            </span>
            <a href="<?php echo BASE_URL; ?>/public/reserva.php?idVuelo=<?php echo $vuelo['idVuelo'] ?? ''; ?>"
                class="btn btn-primary btn-sm">
                <i class="bi bi-bookmark-plus"></i> Reservar
            </a>
        </div>
    </div>
</div>