<?php include '../layouts/header.php'; 

require_once '../controllers/crudAerolineas.php';

$crud = new CrudAerolineas();

$busqueda = $_GET['busqueda'] ?? '';

if (!empty($busqueda)) {
    $resultado = $crud->buscarAerolineas($busqueda);
} else {
    $resultado = $crud->listarAerolineasActivas();
}

$aerolineas = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $aerolineas[] = $fila;
    }
}
?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="container shadow-lg p-3 mb-5 bg-body rounded">
            <h1 class="text-center my-5">Aerolíneas</h1>
            <div class="row">
                <div class="col-md-8 col-lg-6 m-auto">
                    <form class="d-flex" method="GET" role="search">
                        <input class="form-control me-2" type="search" name="busqueda"
                               placeholder="Buscar aerolínea por nombre, IATA o país"
                               value="<?php echo $busqueda; ?>" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>

                <div class="col-12 my-4">
                    <?php if (!empty($busqueda)): ?>
                        <p class="text-muted">
                            Resultados para "<?php echo $busqueda; ?>"
                            <a href="aerolineas.php" class="ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
                        </p>
                    <?php endif; ?>

                    <div class="row g-4">
                        <?php if (empty($aerolineas)): ?>
                            <div class="col-12 text-center text-muted py-5">
                                <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                                No hay aerolíneas para mostrar.
                            </div>
                        <?php else: ?>
                            <?php foreach ($aerolineas as $aerolinea): ?>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card h-100 shadow-sm border-0 rounded-4 text-center overflow-hidden">
                                        <div class="d-flex justify-content-center pt-4">
                                            <div class="rounded-circle bg-white shadow d-flex align-items-center justify-content-center overflow-hidden" style="width: 100px; height: 100px;">
                                                <img src="assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>" alt="Logo <?php echo $aerolinea['nombre'] ?? ''; ?>" style="max-width: 80%; max-height: 80%;">
                                            </div>
                                        </div>

                                        <div class="card-body d-flex flex-column pt-3">
                                            <h5 class="card-title fw-bold mb-1">
                                                <?php echo $aerolinea['nombre'] ?? 'Nombre no disponible'; ?>
                                            </h5>

                                            <p class="card-text text-muted small flex-grow-1">
                                                <?php echo $aerolinea['descripcion'] ?? 'Descripción no disponible'; ?>
                                            </p>

                                            <a href="<?php echo BASE_URL; ?>/public/aerolinea.php?id=<?php echo $aerolinea['idAerolinea'] ?? ''; ?>" class="btn btn-outline-primary btn-sm mt-2 w-100">
                                                <i class="bi bi-airplane-fill"></i> Ver vuelos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>