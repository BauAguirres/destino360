<?php
$hoy = date('Y-m-d');

if ($hoy < ($novedad['fechaPublicacion']??'')) {
    $estadoClase = 'bg-info text-dark';
    $estadoIcono = 'bi-clock-history';
    $estadoTexto = 'Programada';
} elseif ($hoy > ($novedad['fechaExpiracion']??'')) {
    $estadoClase = 'bg-secondary';
    $estadoIcono = 'bi-x-circle';
    $estadoTexto = 'Vencida';
} else {
    $estadoClase = 'bg-success';
    $estadoIcono = 'bi-check-circle';
    $estadoTexto = 'Vigente';
}
?>

<div class="card h-100 shadow-sm border-0 rounded-4">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width: 60px; height: 60px;">
                <i class="bi bi-megaphone-fill fs-3 text-primary"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Novedad #<?php echo $novedad['idNovedad']??''; ?></h5>
                <span class="badge <?php echo $estadoClase; ?>">
                    <i class="bi <?php echo $estadoIcono; ?>"></i> <?php echo $estadoTexto; ?>
                </span>
            </div>
        </div>

        <h5 class="fw-bold mb-1"><?php echo $novedad['nombreNov']??''; ?></h5>

        <p class="small mb-3"><?php echo $novedad['descNovedad']??''; ?></p>

        <ul class="list-unstyled small mb-0">
            <li class="mb-1">
                <i class="bi bi-calendar-check text-muted"></i>
                Publicación: <strong><?php echo $novedad['fechaPublicacion']??''; ?></strong>
            </li>
            <li>
                <i class="bi bi-calendar-x text-muted"></i>
                Expiración: <strong><?php echo $novedad['fechaExpiracion']??''; ?></strong>
            </li>
        </ul>
    </div>

    <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
        <a href="crearNovedad.php?idNovedad=<?php echo $novedad['idNovedad']??''; ?>"
           class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="actions/eliminarNovedad.php?idNovedad=<?php echo $novedad['idNovedad']??''; ?>"
           class="btn btn-sm btn-outline-danger"
           onclick="return confirm('¿Estás seguro que deseas eliminar esta novedad?')">
            <i class="bi bi-trash"></i> Eliminar
        </a>
    </div>
</div>