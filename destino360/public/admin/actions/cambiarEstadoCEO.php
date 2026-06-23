<?php
define('BASE_PATH', __DIR__ . '/../../../');
require_once BASE_PATH . 'controllers/CrudUsuarios.php';

$crud = new CrudUsuarios();
$idUsuario = $_GET['idUsuario'] ?? null;
$accion = $_GET['accion'] ?? null; // 'aprobar', 'rechazar', 'deshabilitar'

if (empty($idUsuario) || empty($accion)) {
    header('Location: ../../admin/dashboard.php?error=Parametros invalidos');
    exit;
}

$usuario = $crud->obtenerCEO($idUsuario);

if (empty($usuario)) {
    header('Location: ../../admin/dashboard.php?error=Usuario no encontrado');
    exit;
}

switch ($accion) {
    case 'verificar':
        $crud->cambiarEstadoCEO($idUsuario, 'verificado');
        $msg = 'Usuario Verificado';
        break;
    case 'rechazar':
        $crud->cambiarEstadoCEO($idUsuario, 'rechazado');
        $msg = 'Usuario Rechazado';
        break;
    case 'deshabilitar':
        $crud->cambiarEstadoCEO($idUsuario, 'deshabilitado');
        $msg = 'Usuario Deshabilitado';
        break;
    default:
        header("Location: ../opcionesUsuario.php?idUsuario=$idUsuario&error=Accion invalida");
        exit;
}



header("Location: ../opcionesUsuario.php?idUsuario=$idUsuario&exito=$msg");
exit;

