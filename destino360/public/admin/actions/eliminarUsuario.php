<?php
define('BASE_PATH', __DIR__ . '/../../');
session_start();

require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$idUsuario = $_GET['idUsuario'] ?? null;

if (empty($idUsuario) || !ctype_digit((string)$idUsuario)) {
    header('Location: usuarios.php?error=Usuario inválido');
    exit;
}

$crud = new CrudUsuarios();
$crud->eliminarUsuario($idUsuario);

header('Location: usuarios.php?exito=Usuario eliminado correctamente');
exit;