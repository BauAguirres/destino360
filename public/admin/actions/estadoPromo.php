<?php

define('BASE_PATH', __DIR__ . '/../../../');

require_once BASE_PATH . 'controllers/crudPromociones.php';

$crud = new CrudPromociones();

$idPromo = $_GET['idPromo'] ?? null;
$accion = $_GET['accion'] ?? null; // 'aprobar', 'rechazar', 'deshabilitar'

if (empty($idPromo) || empty($accion)) {
    header('Location: ../../admin/dashboard.php?error=Parametros invalidos');
    exit;
}

$usuario = $crud->obtenerPromocion($idPromo);

if (empty($usuario)) {
    header('Location: ../../admin/dashboard.php?error=Promocion no encontrado');
    exit;
}

switch ($accion) {
    case 'verificar':
        $crud->cambiarEstadoPromo($idPromo, 'aprobado');
        $msg = 'Promocion Aprobada';
        break;
    case 'rechazar':
        $crud->cambiarEstadoPromo($idPromo, 'denegada');
        $msg = 'Promocion Denegada';
        break;
    default:
        header("Location: ../opcionesPromo.php?idPromo=$idPromo&error=Accion invalida");
        exit;
}



header("Location: ../opcionesPromo.php?idPromo=$idPromo&exito=$msg");
exit;

