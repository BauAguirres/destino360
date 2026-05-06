<?php

define('BASE_PATH', __DIR__ . '/../../../');

require_once BASE_PATH . 'controllers/crudAerolineas.php';

$crud = new CrudAerolineas();

$id = $_GET['idAerolinea'] ?? null;


if (!$id) {
    header('Location: ../aerolineas.php?error=ID+invalido');
    exit;
}

$aerolinea = $crud->obtenerAerolinea($id);
    

if (!$aerolinea) {
    header('Location: ../aerolineas.php?error=Aerolinea_no_encontrada');
    exit;
}

if ($aerolinea['estado'] == 0) {


    $crud->activarAerolinea($id);
    header('Location: ../aerolineas.php?$exito=Aerolinea_activada');
    exit;
}

elseif ($aerolinea['estado'] == 1){
    $crud->desactivarAerolinea($id);
    header('Location: ../aerolineas.php?$exito=Aerolinea_desactivada');
    exit;
}

header('Location: ../aerolineas.php?error=Error+al+cambiar+estado');
exit;
