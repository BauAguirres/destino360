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
        $query = "SELECT r.*, v.* FROM reserva r JOIN vuelo v ON v.idVuelo = r.idVuelo WHERE idUsuario = '$idUsuario'";
        return mysqli_query($this->db, $query);
        
    }



}