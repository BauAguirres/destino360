<?php
    require_once '../../controllers/crudPromociones.php';

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: ../index.php?error=Debes iniciar sesion');
        exit;
    }

    $idUsuario = $_SESSION['idUsuario'];
    $idAerolinea = $_SESSION['idAerolinea'];



    $crudPromociones = new crudPromociones();
    $err = "";
    $exito = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $porcDesc = $_POST['porcDesc'];
        $desc = $_POST['desc'];
        $nombrePromo = $_POST['nombrePromo'];
        $idAerolinea = $_SESSION['idAerolinea'];
        $estadoPromo = 'pendiente';

        if ($crudPromociones->crearPromocion($idAerolinea, $nombrePromo, $desc, $porcDesc, $estadoPromo, $fechaInicio, $fechaFin)) {
            $exito = "Promoción creada exitosamente.";
        } else {
            $err = "Error al crear la promoción. Por favor, inténtalo de nuevo.";
        }
    }
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Promoción - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <div class="bg-primary-subtle py-3">
            <div class="shadow-lg p-3 mb-5 bg-body rounded container">
                <div class="text-center">
                    <h1>Crear Promoción</h1>
                    <p>Completa los datos para crear una nueva promoción</p>


                <form action="crearPromocion.php" method="POST" enctype="multipart/form-data">
                    <div class="row fs-4">
                        <?php if ($err): ?>
                                <div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
                                    <?php echo $err; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php endif; ?>

                        <?php if ($exito): ?>
                                <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
                                    <?php echo $exito; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php endif; ?>
                        <div class="col-md-6 my-2">
                            <label for="nombrePromo">nombre Promo</label>
                            <input type="text" class="form-control" name="nombrePromo" id="nombrePromo" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="fechaInicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="fechaFin">Fecha de Fin</label>
                            <input type="date" class="form-control" name="fechaFin" id="fechaFin" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="porcDesc">Porcentaje de Descuento</label>
                            <input type="number" class="form-control" name="porcDesc" id="porcDesc" step="0.01" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="desc">Descripción</label>
                            <input type="text" class="form-control" name="desc" id="desc" required>
                        </div>
                        <button type="submit" class="my-4 btn btn-primary">Crear Promoción</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>