<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../../');
}

include_once BASE_PATH . 'seguridad/seguridadAdmin.php';

require_once BASE_PATH . 'controllers/crudAerolineas.php';

$idAerolinea = $_GET['idAerolinea'] ?? null;

if (empty($idAerolinea) || !ctype_digit((string)$idAerolinea)) {
    header('Location: ../aerolineas.php?error=Aerolínea inválida');
    exit;
}

$crud = new CrudAerolineas();
$crud->eliminarAerolinea($idAerolinea);

header('Location: ../aerolineas.php?exito=Aerolínea eliminada correctamente');
exit;