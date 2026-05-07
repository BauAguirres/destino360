<?php

define('BASE_PATH', __DIR__ . '/../../../');

require_once BASE_PATH . 'controllers/CrudVuelos.php';

$crud = new CrudVuelos();

$id = $_GET['idVuelo'] ?? null;


if (!$id) {
    header('Location: ../vuelos.php?error=ID invalido');
    exit;
}

$vuelo = $crud->obtenerVuelo($id);
    

if (!$vuelo) {
    header('Location: ../vuelos.php?error=Vuelo no encontrado');
    exit;
}

if (empty($vuelo['fechaSalida']) || empty($vuelo['horaSalida']) || empty($vuelo['fechaLlegada']) || empty($vuelo['horaLlegada'])) {
    header('Location: ../vuelos.php?error=No se puede cambiar el estado de un vuelo sin horario');
    exit;
}

if ($vuelo['asientosDisp'] != $vuelo['asientosTotales'] ) {
    header('Location: ../vuelos.php?error=No se puede desactivar un vuelo con reservas realizadas');
    exit;
}

if ($vuelo['estadoVuelo'] == 0) {


    $crud->activarVuelo($id);
    header('Location: ../vuelos.php?exito=Vuelo activado');
    exit;
}

elseif ($vuelo['estadoVuelo'] == 1){
    $crud->desactivarVuelo($id);
    header('Location: ../vuelos.php?exito=Vuelo desactivado');
    exit;
}

header('Location: ../vuelos.php?error=Error al cambiar estado');
exit;
