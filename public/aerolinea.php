<?php include '../layouts/header.php';

require_once '../controllers/crudAerolineas.php';
require_once '../controllers/crudVuelos.php';

$id = $_GET['id'] ?? null;

// Validación: si no viene un ID numérico, volvemos al listado
if ($id === null || !ctype_digit((string) $id)) {
    header("Location: " . BASE_URL . "public/aerolineas.php");
    exit;
}

$crud = new CrudAerolineas();
$crudVuelos = new CrudVuelos();

// Traer los datos de la aerolínea seleccionada
$aerolinea = $crud->obtenerAerolinea((int) $id);

// Si no existe, volvemos al listado
if (!$aerolinea) {
    header("Location: " . BASE_URL . "public/aerolineas.php");
    exit;
}

// Traer los vuelos de esta aerolínea
$resultadoVuelos = $crudVuelos->listarVuelos((int) $id);

$vuelos = [];
if ($resultadoVuelos) {
    while ($fila = mysqli_fetch_assoc($resultadoVuelos)) {
        $vuelos[] = $fila;
    }
}
?>


<main>
    <div class="bg-primary-subtle py-3">
        <div class="container shadow-lg p-3 mb-5 bg-body rounded">

            <!-- Botón volver -->
            <a href="<?php echo BASE_URL; ?>public/aerolineas.php" class="btn btn-link text-decoration-none mt-2">
                <i class="bi bi-arrow-left"></i> Volver a aerolíneas
            </a>

            <!-- Cabecera de la aerolínea -->
            <div class="text-center mb-5">
                <div class="d-flex justify-content-center">
                    <div class="rounded-circle bg-white shadow-lg d-flex align-items-center justify-content-center overflow-hidden border border-3 border-white"
                        style="width: 120px; height: 120px;">
                        <img src="assets/img/logosAerolineas/<?php echo htmlspecialchars($aerolinea['urlLogo'] ?? 'default-logo.png'); ?>"
                            alt="Logo <?php echo htmlspecialchars($aerolinea['nombre'] ?? ''); ?>"
                            style="max-width: 80%; max-height: 80%; object-fit: contain;">
                    </div>
                </div>

                <h1 class="fw-bold mt-3 mb-1">
                    <?php echo htmlspecialchars($aerolinea['nombre'] ?? 'Aerolínea'); ?>
                </h1>

                <?php if (!empty($aerolinea['codigoIATA'])): ?>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6">
                        <?php echo htmlspecialchars($aerolinea['codigoIATA']); ?>
                    </span>
                <?php endif; ?>

                <p class="text-muted mt-3 mx-auto" style="max-width: 600px;">
                    <?php echo htmlspecialchars($aerolinea['descripcion'] ?? 'Descripción no disponible'); ?>
                </p>
            </div>

            <h3 class="mb-4"><i class="bi bi-airplane-fill"></i> Vuelos disponibles</h3>

            <div class="row g-4">
                <?php if (empty($vuelos)): ?>
                    <div class="col-12 text-center text-muted py-5">
                        <i class="bi bi-airplane fs-1 d-block mb-2"></i>
                        Esta aerolínea no tiene vuelos disponibles por el momento.
                    </div>
                <?php else: ?>
                    <?php foreach ($vuelos as $vuelo): ?>
                        <div class="col-lg-4 col-md-6">
                            <?php include '../layouts/vuelo.php'; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</main>


<?php include '../layouts/footer.php'; ?>