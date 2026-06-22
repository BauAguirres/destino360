<?php include '../layouts/header.php';

require_once '../controllers/crudNovedades.php';

$crud = new CrudNovedades();
$resultado = $crud->listarNovedadesVigentes();

$novedades = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $novedades[] = $fila;
    }
}
?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="container shadow-lg p-4 mb-5 bg-body rounded">

            <div class="text-center mb-5">
                <i class="bi bi-megaphone-fill fs-1 text-primary"></i>
                <h1 class="fw-bold mt-2">Novedades</h1>
                <p class="text-muted">Enterate de las últimas noticias y anuncios</p>
            </div>

            <?php if (empty($novedades)): ?>
                <div class="text-center text-muted py-5">
                    <i class="bi bi-megaphone fs-1 d-block mb-2"></i>
                    No hay novedades por el momento.
                </div>
            <?php else: ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($novedades as $novedad): ?>
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                             style="width: 55px; height: 55px;">
                                            <i class="bi bi-megaphone-fill fs-4 text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0"><?php echo $novedad['nombreNov']; ?></h5>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar-event"></i>
                                                <?php echo $novedad['fechaPublicacion']; ?>
                                            </small>
                                        </div>
                                    </div>
                                    <p class="mb-0"><?php echo $novedad['descNovedad']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>