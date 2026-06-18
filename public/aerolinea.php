<?php include '../layouts/header.php';


$id = $_GET['id'] ?? null;

require_once '../controllers/crudAerolineas.php';
require_once '../controllers/crudVuelos.php';
require_once '../controllers/crudPromociones.php';

$crud = new CrudAerolineas();
$crudVuelos = new CrudVuelos();
$crudPromociones = new CrudPromociones();

$aerolinea = $crud->obtenerAerolinea((int) $id);


if (empty($aerolinea)) {
    header("Location: " . BASE_URL . "public/aerolineas.php");
    exit;
}


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

        
            <a href="<?php echo BASE_URL; ?>/public/aerolineas.php" class="btn btn-outline-primary mt-2">
                <i class="bi bi-arrow-left"></i> Volver a aerolíneas
            </a>

            <div class="text-center mb-5">
                <div class="d-flex justify-content-center">
                    <div class="rounded-circle bg-white shadow-lg d-flex align-items-center justify-content-center overflow-hidden border border-3 border-white"
                        style="width: 120px; height: 120px;">
                        <img src="assets/img/logosAerolineas/<?php echo $aerolinea['urlLogo'] ?? 'default-logo.png'; ?>"
                            alt="Logo <?php echo $aerolinea['nombre'] ?? ''; ?>"
                            style="max-width: 80%; max-height: 80%; object-fit: contain;">
                    </div>
                </div>

                <h1 class="fw-bold mt-3 mb-1">
                    <?php echo $aerolinea['nombre'] ?? 'Aerolínea'; ?>
                </h1>

                <?php if (!empty($aerolinea['codIATA'])): ?>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6">
                        <?php echo $aerolinea['codIATA']; ?>
                    </span>
                <?php endif; ?>

                <p class="text-muted mt-3 mx-auto" style="max-width: 600px;">
                    <?php echo $aerolinea['descripcion'] ?? 'Descripción no disponible'; ?>
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
                        <?php
                            $promocion = $crudPromociones->obtenerPromocionVuelos($vuelo['idVuelo']);
                            $precioOriginal = $vuelo['precio'] ?? 0;
                            $precioFinal = $precioOriginal;

                            if (!empty($promocion)) {
                                $precioFinal = $precioOriginal - ($precioOriginal * ($promocion['porcDesc'] / 100));
                            }
                        ?>
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