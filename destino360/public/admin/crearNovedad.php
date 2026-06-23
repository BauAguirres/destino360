<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'controllers/crudNovedades.php';

$crud = new CrudNovedades();
$err = '';

$idNovedad = $_GET['idNovedad'] ?? null;
$novedad = null;

if ($idNovedad && ctype_digit((string)$idNovedad)) {
    $novedad = $crud->obtenerNovedad($idNovedad);
}

$esEdicion = $novedad !== null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombreNov'] ?? '');
    $texto = trim($_POST['textoNovedad'] ?? '');
    $fechaPublicacion = $_POST['fechaPublicacion'] ?? '';
    $fechaExpiracion = $_POST['fechaExpiracion'] ?? '';

    if (empty($nombre) || empty($texto) || empty($fechaPublicacion) || empty($fechaExpiracion)) {
        $err = 'Todos los campos son obligatorios';
    } elseif ($fechaExpiracion < $fechaPublicacion) {
        $err = 'La fecha de expiración no puede ser anterior a la de publicación';
    } else {
        if ($esEdicion) {
            $crud->editarNovedad($idNovedad, $nombre, $texto, $fechaPublicacion, $fechaExpiracion);
            header('Location: Novedades.php?exito=Novedad actualizada correctamente');
        } else {
            $crud->crearNovedad($nombre, $texto, $fechaPublicacion, $fechaExpiracion);
            header('Location: Novedades.php?exito=Novedad creada correctamente');
        }
        exit;
    }
}

include '../../layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="gestionNovedades.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>

                        <h3 class="mb-4">
                            <i class="bi bi-megaphone"></i>
                            <?php echo $esEdicion ? 'Editar Novedad' : 'Nueva Novedad'; ?>
                        </h3>

                        <?php if ($err): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $err; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nombre de la novedad</label>
                                <input type="text" class="form-control" name="nombreNov" maxlength="100"
                                    value="<?php echo $novedad['nombreNov'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Texto de la novedad</label>
                                <textarea class="form-control" name="textoNovedad" rows="4" maxlength="200" required><?php echo $novedad['textoNovedad'] ?? ''; ?></textarea>
                                <small class="text-muted">Máximo 200 caracteres</small>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fecha de publicación</label>
                                    <input type="date" class="form-control" name="fechaPublicacion"
                                           value="<?php echo $novedad['fechaPublicacion'] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fecha de expiración</label>
                                    <input type="date" class="form-control" name="fechaExpiracion"
                                           value="<?php echo $novedad['fechaExpiracion'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i>
                                    <?php echo $esEdicion ? 'Guardar cambios' : 'Crear novedad'; ?>
                                </button>
                                <a href="Novedades.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../../layouts/footer.php'; ?>