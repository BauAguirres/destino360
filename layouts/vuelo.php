<div class="card h-100 shadow-sm border-0 rounded-4">
    <div class="card-body d-flex flex-column">

        <!-- Ruta origen → destino -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="text-center">
                <div class="fw-bold fs-5"><?php echo htmlspecialchars($vuelo['origen'] ?? ''); ?></div>
                <small class="text-muted">Origen</small>
            </div>
            <i class="bi bi-arrow-right text-primary mx-2"></i>
            <div class="text-center">
                <div class="fw-bold fs-5"><?php echo htmlspecialchars($vuelo['destino'] ?? ''); ?></div>
                <small class="text-muted">Destino</small>
            </div>
        </div>

        <ul class="list-unstyled small mb-3 flex-grow-1">
            <li class="mb-1">
                <i class="bi bi-calendar-event"></i>
                <?php echo htmlspecialchars($vuelo['fecha_salida'] ?? ''); ?>
                a las <?php echo htmlspecialchars($vuelo['hora_salida'] ?? ''); ?> hs
            </li>
            <li class="mb-1">
                <i class="bi bi-people"></i>
                Asientos disponibles: <?php echo htmlspecialchars($vuelo['asientosDisponibles'] ?? '0'); ?>
            </li>
        </ul>

        <div class="d-flex justify-content-between align-items-center mt-auto">
            <span class="fw-bold fs-5 text-success">
                $<?php echo number_format((float) ($vuelo['precio'] ?? 0), 2, ',', '.'); ?>
            </span>
            <a href="<?php echo BASE_URL; ?>public/reservar.php?vuelo=<?php echo $vuelo['codVuelo'] ?? ''; ?>"
                class="btn btn-primary btn-sm">
                <i class="bi bi-bookmark-plus"></i> Reservar
            </a>
        </div>
    </div>
</div>