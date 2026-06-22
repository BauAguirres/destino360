<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'controllers/crudCarrusel.php';

$crud = new CrudCarrusel();
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {

        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $permitidas)) {
            $err = 'Formato no permitido. Usá JPG, PNG o WEBP.';
        } else {
            $nombreArchivo = 'carrusel_' . time() . '.' . $ext;
            $destino = BASE_PATH . 'public/assets/img/' . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                $crud->agregarImagen($nombreArchivo);
                header('Location: gestionCarrusel.php?exito=Imagen agregada correctamente');
                exit;
            } else {
                $err = 'No se pudo subir la imagen.';
            }
        }
    } else {
        $err = 'Tenés que seleccionar una imagen.';
    }
}

$resultado = $crud->listarImagenes();
$imagenes = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $imagenes[] = $fila;
    }
}

$exito = $_GET['exito'] ?? '';

include '../../layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <h3 class="mb-4"><i class="bi bi-images"></i> Gestión del Carrusel</h3>

                        <?php if ($err): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $err; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <?php if ($exito): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $exito; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="border rounded-4 p-4 bg-light mb-5">
                            <h5 class="mb-3"><i class="bi bi-upload"></i> Agregar imagen</h5>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="d-flex gap-2 flex-wrap align-items-end">
                                    <div class="flex-grow-1">
                                        <label class="form-label fw-bold">Seleccioná una imagen</label>
                                        <input type="file" class="form-control" name="imagen" accept=".jpg,.jpeg,.png,.webp" required>
                                        <small class="text-muted">Formatos: JPG, PNG, WEBP</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Subir
                                    </button>
                                </div>
                            </form>
                        </div>

                        <h5 class="mb-3"><i class="bi bi-collection"></i> Imágenes actuales</h5>

                        <div class="row g-4">
                            <?php if (empty($imagenes)): ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                                    No hay imágenes en el carrusel. Agregá la primera.
                                </div>
                            <?php else: ?>
                                <?php foreach ($imagenes as $img): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                                            <img src="../assets/img/<?php echo $img['urlImagen']; ?>"
                                                 class="card-img-top" alt="Imagen del carrusel"
                                                 style="height: 180px; object-fit: cover;">
                                            <div class="card-footer bg-transparent text-end">
                                                <a href="actions/eliminarImagenCarrusel.php?idImagen=<?php echo $img['idImagen']; ?>"
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('¿Eliminar esta imagen del carrusel?')">
                                                    <i class="bi bi-trash"></i> Eliminar
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
    </div>
</main>


<?php include '../../layouts/footer.php'; ?>