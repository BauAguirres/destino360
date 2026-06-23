<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once BASE_PATH . 'seguridad/seguridadUser.php';
require_once BASE_PATH . 'vendor/autoload.php';
require_once BASE_PATH . 'config/mp.php';
require_once BASE_PATH . 'config/app.php';
require_once BASE_PATH . 'controllers/crudReservas.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

$idUsuario = $_SESSION['idUsuario'];

$idReserva = $_GET['id'] ?? null;
if (empty($idReserva) || !ctype_digit((string)$idReserva)) {
    header('Location: reservas.php?error=Reserva inválida');
    exit;
}

$crudReservas = new CrudReservas();

$reservaIda = $crudReservas->obtenerReservaById($idReserva);
if (!$reservaIda || $reservaIda['idUsuario'] != $idUsuario) {
    header('Location: reservas.php?error=Reserva no encontrada');
    exit;
}

if ($reservaIda['estadoReserva'] !== 'pendiente de pago') {
    header('Location: reservas.php?error=Esta reserva no está pendiente de pago');
    exit;
}

$reservaVuelta = null;
if (!empty($reservaIda['idVueloRelacionado'])) {
    $reservaVuelta = $crudReservas->obtenerReservaPorVuelo($idUsuario, $reservaIda['idVueloRelacionado']);
}

$cantidadPasajeros = (int) $reservaIda['cantidadMayores'] + (int) $reservaIda['cantidadMenores'];

$items = [];
$items[] = [
    "title"       => "Ida: " . $reservaIda['origen'] . " → " . $reservaIda['destino'],
    "quantity"    => $cantidadPasajeros,
    "unit_price"  => (float) $reservaIda['precioFinal'],
    "currency_id" => "ARS"
];

if ($reservaVuelta !== null) {
    $items[] = [
        "title"       => "Vuelta: " . $reservaVuelta['origen'] . " → " . $reservaVuelta['destino'],
        "quantity"    => $cantidadPasajeros,
        "unit_price"  => (float) $reservaVuelta['precioFinal'],
        "currency_id" => "ARS"
    ];
}

MercadoPagoConfig::setAccessToken(MP_ACCESS_TOKEN);
$client = new PreferenceClient();

try {
    $preference = $client->create([
        "items" => $items,
        "back_urls" => [
            "success" => BASE_URL . "/public/user/confirmarReserva.php?id=" . $reservaIda['idReserva'],
            "failure" => BASE_URL . "/public/user/confirmarReserva.php?id=" . $reservaIda['idReserva'],
            "pending" => BASE_URL . "/public/user/confirmarReserva.php?id=" . $reservaIda['idReserva']
        ],
        "external_reference" => (string) $reservaIda['idReserva']
    ]);

    header("Location: " . $preference->init_point);
    $reservaIda = $crudReservas->confirmarReserva($idReserva);
    exit;

} catch (MPApiException $e) {
    header('Location: reservas.php?error=' . urlencode('No se pudo generar el pago, intentá de nuevo'));
    exit;
}