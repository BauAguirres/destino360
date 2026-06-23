<?php
define('BASE_PATH', __DIR__ . '/../../../');
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../../index.php?error=Debes iniciar sesion');
    exit;
}

require_once BASE_PATH . 'controllers/crudReservas.php';
require_once BASE_PATH . 'controllers/crudVuelos.php';

$idUsuario = $_SESSION['idUsuario'];
$idReserva = $_GET['idReserva'] ?? null;

if (empty($idReserva) || !ctype_digit((string)$idReserva)) {
    header('Location: ../reservas.php?error=Reserva inválida');
    exit;
}

$crud = new CrudReservas();
$crudVuelos = new CrudVuelos();

$reserva = $crud->obtenerReservaById($idReserva);

if (!$reserva || $reserva['idUsuario'] != $idUsuario) {
    header('Location: ../reservas.php?error=Reserva no encontrada');
    exit;
}

$fechaSalida = strtotime($reserva['fechaSalida'] . ' ' . ($reserva['horaSalida'] ?? '00:00'));
$horasRestantes = ($fechaSalida - time()) / 3600;

if ($horasRestantes < 72) {
    header('Location: ../confirmarReserva.php?id=' . $idReserva . '&error=Solo se puede cancelar hasta 72 horas antes de la salida');
    exit;
}

$pasajerosIda = (int)$reserva['cantidadMayores'] + (int)$reserva['cantidadMenores'];

$crud->cancelarReserva($idReserva);
$crudVuelos->incrementarAsientos($reserva['idVuelo'], $pasajerosIda);

if (!empty($reserva['idReservaRelacionada'])) {
    $reservaVuelta = $crud->obtenerReservaById($reserva['idReservaRelacionada']);
    if ($reservaVuelta) {
        $pasajerosVuelta = (int)$reservaVuelta['cantidadMayores'] + (int)$reservaVuelta['cantidadMenores'];
        $crud->cancelarReserva($reservaVuelta['idReserva']);
        $crudVuelos->incrementarAsientos($reservaVuelta['idVuelo'], $pasajerosVuelta);
    }
}

header('Location: ../reservas.php?exito=Reserva cancelada correctamente');
exit;