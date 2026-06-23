<?php

define('BASE_PATH', __DIR__ . '/../../');

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crud = new CrudUsuarios();

$id = $_GET['idUsuario'] ?? null;
$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

$usuario = $crud->obtenerCEO($id);


if (empty($usuario)) {
    header('Location: dashboard.php?error=No se encontro el vuelo');
    exit();
} 
if ($usuario['estadoUsuario'] != 'verificado') {
    $crud->eliminarUsuario($id);
    header('Location: dashboard.php?exito=Usuario eliminado correctamente');
    exit();
} else if ($usuario['estadoUsuario'] == 'verificado') {
    $error = 'No se puede eliminar un usuario activo. Desactívalo primero.';
    header('Location: dashboard.php?error=' . urlencode($error));
    exit();
}

header('Location: dashboard.php?error=Vuelo no encontrado');
exit();
