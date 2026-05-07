<?php

define('BASE_PATH', __DIR__ . '/../../../');

require_once BASE_PATH . 'controllers/crudVuelos.php';

$crud = new crudVuelos();

$id = $_GET['idVuelo'] ?? null;


if (!$id) {
    header('Location: ../vuelos.php?error=ID+invalido');
    exit;
}

$vuelo = $crud->obtenerVuelo($id);
    

if (!$vuelo) {
    header('Location: ../vuelos.php?error=Vuelo_no_encontrado');
    exit;
}

if (empty($vuelo['fechaSalida']) || empty($vuelo['horaSalida']) || empty($vuelo['fechaLlegada']) || empty($vuelo['horaLlegada'])) {
    header('Location: ../vuelos.php?error=No+se+puede+cambiar+estado+de+un+vuelo+sin+horario');
    exit;
}

if ($vuelo['estadoVuelo'] == 0) {


    $crud->activarVuelo($id);
    header('Location: ../vuelos.php?exito=Vuelo_activado');
    exit;
}

elseif ($vuelo['estadoVuelo'] == 1){
    $crud->desactivarVuelo($id);
    header('Location: ../vuelos.php?exito=Vuelo_desactivado');
    exit;
}

header('Location: ../vuelos.php?error=Error+al+cambiar+estado');
exit;
