<?php
require_once '../controllers/crudUsuarios.php';

$crud = new CrudUsuarios();

$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: confirmacion.php?error=1');
    exit;
}

$usuario = $crud->verificarToken($token);

if ($usuario) {
    $crud->activarCuenta($token);
    header('Location: confirmacion.php?exito=1');
    exit;
} else {
    header('Location: confirmacion.php?error=1');
    exit;
}