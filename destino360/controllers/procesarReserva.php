<?php

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../public/index.php?error=Debes iniciar sesión');
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/crudReservas.php';
require_once __DIR__ . '/crudVuelos.php';
require_once __DIR__ . '/crudPromociones.php';

$crudReservas = new CrudReservas();
$crudVuelos = new CrudVuelos();
$crudPromociones = new CrudPromociones();

$idUsuario = $_SESSION['idUsuario'];

$idVueloIda = $_POST['idVueloIda'] ?? null;
$idVueloVuelta = !empty($_POST['idVueloVuelta']) ? $_POST['idVueloVuelta'] : null;
$idPromoIda = !empty($_POST['idPromoIda']) ? $_POST['idPromoIda'] : null;
$idPromoVuelta = !empty($_POST['idPromoVuelta']) ? $_POST['idPromoVuelta'] : null;

$cantidadMayores = (int)($_POST['cantidadMayores'] ?? 0);
$cantidadMenores = (int)($_POST['cantidadMenores'] ?? 0);
$cantidadTotal = $cantidadMayores + $cantidadMenores;

if (!$idVueloIda || $cantidadTotal === 0) {
    header('Location: ../public/vuelos.php?error=Datos inválidos');
    exit;
}

$vueloIda = $crudVuelos->obtenerVuelo($idVueloIda);
$precioUnitarioIda = $vueloIda['precio'];

if ($idPromoIda) {
    $promo = $crudPromociones->obtenerPromocion($idPromoIda);
    if ($promo) {
        $precioUnitarioIda -= ($precioUnitarioIda * $promo['porcDesc'] / 100);
    }
}

$precioFinalIda = $precioUnitarioIda * $cantidadTotal;

$crudReservas->crearReserva($idUsuario, $idVueloIda, $idPromoIda, $cantidadMayores, $cantidadMenores, $precioFinalIda);
$crudVuelos->decrementarAsientos($idVueloIda, $cantidadTotal);


if ($idVueloVuelta) {
    $vueloVuelta = $crudVuelos->obtenerVuelo($idVueloVuelta);
    $precioUnitarioVuelta = $vueloVuelta['precio'];

    if ($idPromoVuelta) {
        $promoV = $crudPromociones->obtenerPromocion($idPromoVuelta);
        if ($promoV) {
            $precioUnitarioVuelta -= ($precioUnitarioVuelta * $promoV['porcDesc'] / 100);
        }
    }

    $precioFinalVuelta = $precioUnitarioVuelta * $cantidadTotal;

    $crudReservas->crearReserva($idUsuario, $idVueloVuelta, $idPromoVuelta, $cantidadMayores, $cantidadMenores, $precioFinalVuelta);
    $crudVuelos->decrementarAsientos($idVueloVuelta, $cantidadTotal);
    $idReservaIda = $crudReservas->obtenerReservaPorVuelo($idUsuario, $idVueloIda);
    $idReservaVuelta = $crudReservas->obtenerReservaPorVuelo($idUsuario, $idVueloVuelta);
    $crudReservas->vincularReservas($idReservaIda['idReserva'], $idReservaVuelta['idReserva']);
}

header('Location: ../public/vuelos.php?exito=Reserva creada correctamente');
exit;