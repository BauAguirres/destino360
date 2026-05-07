<?php

define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'controllers/CrudVuelos.php';

$crud = new CrudVuelos();

$id = $_GET['idVuelo'] ?? null;
$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

$vuelo = $crud->obtenerVuelo($id);


if (empty($vuelo)) {
    header('Location: vuelos.php?error=No se encontro el vuelo');
    exit();
} 
if ($vuelo['estadoVuelo'] == 0) {
    $crud->eliminarVuelo($id);
    header('Location: vuelos.php?exito=Vuelo eliminado correctamente');
    exit();
} else if ($vuelo['estadoVuelo'] == 1) {
    $error = 'No se puede eliminar un vuelo activo. Desactívalo primero.';
    header('Location: vuelos.php?error=' . urlencode($error));
    exit();
}

header('Location: vuelos.php?error=Vuelo no encontrado');
exit();
