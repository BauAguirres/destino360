<?php

define('BASE_PATH', __DIR__ . '/../../../');

require_once BASE_PATH . 'controllers/CrudVuelos.php';

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}



$crud = new CrudVuelos();

$id = $_GET['idVuelo'] ?? null;


if (!$id) {
    header('Location: ../dashboard.php?error=ID invalido');
    exit;
}

$vuelo = $crud->obtenerVuelo($id);
    

if (!$vuelo) {
    header("Location: ../opcionesVuelo.php?idVuelo=$id&error=Vuelo no encontrado");
    exit;
}

if (empty($vuelo['fechaSalida']) || empty($vuelo['horaSalida']) || empty($vuelo['fechaLlegada']) || empty($vuelo['horaLlegada'])) {
    header("Location: ../asignarHorario.php?idVuelo=$id&error=No se puede cambiar el estado de un vuelo sin horario");
    exit;
}

if ($vuelo['asientosDisp'] != $vuelo['asientosTotales'] ) {
    header("Location: ../opcionesVuelo.php?idVuelo=$id&error=No se puede desactivar un vuelo con reservas realizadas");
    exit;
}

if ($vuelo['estadoVuelo'] == 0) {


    $crud->activarVuelo($id);
    header("Location: ../opcionesVuelo.php?idVuelo=$id&exito=Vuelo activado");
    exit;
}

elseif ($vuelo['estadoVuelo'] == 1){
    $crud->desactivarVuelo($id);
    header("Location: ../opcionesVuelo.php?idVuelo=$id&exito=Vuelo desactivado");
    exit;
}

header("Location: ../opcionesVuelo.php?idVuelo=$id&error=Error al cambiar estado");
exit;
