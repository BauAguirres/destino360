<?php

define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

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
    header('Location: opcionesVuelo.php?exito=Vuelo eliminado correctamente');
    exit();
} else if ($vuelo['estadoVuelo'] == 1) {
    $error = 'No se puede eliminar un vuelo activo. Desactívalo primero.';
    header('Location: opcionesVuelo.php?error=' . urlencode($error));
    exit();
}

header('Location: opcionesVuelo.php?error=Vuelo no encontrado');
exit();
