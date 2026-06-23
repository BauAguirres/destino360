<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../../');
}

include_once BASE_PATH . 'seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'controllers/crudCarrusel.php';

$idImagen = $_GET['idImagen'] ?? null;

if (empty($idImagen) || !ctype_digit((string)$idImagen)) {
    header('Location: ../gestionCarrusel.php?error=Imagen inválida');
    exit;
}

$crud = new CrudCarrusel();
$imagen = $crud->obtenerImagen($idImagen);

if ($imagen) {
    $ruta = BASE_PATH . 'public/assets/img/' . $imagen['urlImagen'];
    if (file_exists($ruta)) {
        unlink($ruta);
    }
    $crud->eliminarImagen($idImagen);
}

header('Location: ../gestionCarrusel.php?exito=Imagen eliminada correctamente');
exit;