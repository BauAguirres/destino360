<?php

require_once __DIR__ . '/../config/db.php';


class CrudReservas {
    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }

    public function crearReserva($idUsuario, $idVuelo, $idPromo, $cantidadMayores, $cantidadMenores, $precioFinal) {
        $idPromo = $idPromo ? "'$idPromo'" : "NULL";

        $query = "INSERT INTO reserva (idUsuario, idVuelo, idPromo, cantidadMayores, cantidadMenores, precioFinal, estadoReserva) VALUES ($idUsuario, $idVuelo, $idPromo, $cantidadMayores, $cantidadMenores, $precioFinal, 'pendiente de pago')";
        return mysqli_query($this->db, $query);
    }


    public function obtenerReservas($idUsuario) {
        $query = "SELECT r.*, v.*, a.nombre AS nombre FROM reserva r JOIN vuelo v ON v.idVuelo = r.idVuelo JOIN aerolinea a ON a.idAerolinea = v.idAerolinea WHERE idUsuario = '$idUsuario'";
        return mysqli_query($this->db, $query);
        
    }

    public function contarReservasPorEstado($idAerolinea) {
    $idAerolinea = (int) $idAerolinea;
    $query = "SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN r.estadoReserva = 'pendiente de pago' THEN 1 ELSE 0 END) AS pendientes,
                SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN 1 ELSE 0 END) AS confirmadas
              FROM reserva r
              JOIN vuelo v ON r.idVuelo = v.idVuelo
              WHERE v.idAerolinea = $idAerolinea";
    $resultado = mysqli_query($this->db, $query);
    return mysqli_fetch_assoc($resultado);
    }

}