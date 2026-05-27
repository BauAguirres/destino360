<?php
    require_once '../../controllers/crudPromociones.php';

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: ../index.php?error=Debes iniciar sesion');
        exit;
    }


    
    $crudPromociones = new crudPromociones();
    $err = "";
    $exito = "";
    

    
    $idPromo = $_GET['idPromo'];
    $promocion = $crudPromociones->obtenerPromocion($idPromo);
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
                    <h1>Verificar Promoción</h1>
                    <p>Verifica los datos para habilitar una nueva promoción</p>


                
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
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $promocion['estadoPromo']??null ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $promocion['nombrePromo']??null ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Aerolinea</label>
                            <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $promocion['nombre']??null ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Porcentaje de Descuento</label>
                            <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $promocion['porcDesc']??null ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $promocion['fechaInicio']??null ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha Fin</label>
                            <input type="text" class="form-control bg-dark text-light fw-bold" value="<?= $promocion['fechaFin']??null ?>" disabled>
                        </div><div class="col-md-12">
                            <label class="form-label">Descripcion</label>
                            <textarea class="form-control bg-dark text-light fw-bold" disabled rows="4"><?= htmlspecialchars($promocion['descPromocion'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <?php if ($promocion['estadoPromo'] == 'pendiente') : ?>
                                        <a href="actions/estadoPromo.php?idPromo=<?=$promocion['idPromo'] ?>&accion=verificar"  class="btn btn-outline-success"  onclick="return confirm('Estás Seguro que desea cambiar el estado de la promocion?' )" >
                                            Aprobar
                                        </a>
                                        <a href="actions/estadoPromo.php?idPromo=<?=$promocion['idPromo'] ?>&accion=rechazar"  class="btn btn-outline-danger"  onclick="return confirm('Estás Seguro que desea cambiar el estado de la promocion?' )" >
                                            Rechazar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>