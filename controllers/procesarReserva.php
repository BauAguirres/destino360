<?php

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../public/index.php?error=Debes iniciar sesión');
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/CrudReservas.php';
require_once __DIR__ . '/CrudVuelos.php';

$crudReservas = new CrudReservas();
$crudVuelos = new CrudVuelos();

$idUsuario = $_SESSION['idUsuario'];
$idVueloIda = $_POST['idVueloIda'] ?? null;
$idVueloVuelta = $_POST['idVueloVuelta'] ?? null;
$cantidadMayores = $_POST['cantidadMayores'] ?? 1;
$cantidadMenores = $_POST['cantidadMenores'] ?? 0;

$totalPasajeros = (int)($cantidadMayores + $cantidadMenores);
$vueloIda = $crudVuelos->obtenerVuelo($idVueloIda);

$precio = $vueloIda['precio']*$totalPasajeros;

if (!$idVueloIda || $totalPasajeros == 0) {
    header('Location: ../public/vuelos.php?error=Datos inválidos');
    exit;
}
$precioTotal = $precio;


if(!empty($idVueloVuelta)){
    $vueloVuelta = $crudVuelos->obtenerVuelo($idVueloVuelta);
    $precio2 = $vueloVuelta['precio']*$totalPasajeros;
    $precioTotal = $precio + $precio2;

    $crudReservas->crearReserva($idUsuario, $idVueloVuelta, null, $cantidadMayores, $cantidadMenores, $precioTotal);
}

$crudReservas->crearReserva($idUsuario, $idVueloIda, null, $cantidadMayores, $cantidadMenores, $precioTotal);

header('Location: ../public/user/profile.php?exito=Reserva creada');
exit;

?>

