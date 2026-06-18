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

    public function obtenerReservaById($idReserva) {
        $idReserva = (int)$idReserva;
        $query = "SELECT r.*, v.origen, v.destino, v.fechaSalida, v.horaSalida,
                        v.fechaLlegada, v.horaLlegada, v.precio, v.idVueloRelacionado,
                        a.nombre AS nombreAerolinea, a.urlLogo
                FROM reserva r
                JOIN vuelo v ON r.idVuelo = v.idVuelo
                JOIN aerolinea a ON v.idAerolinea = a.idAerolinea
                WHERE r.idReserva = $idReserva";
        return mysqli_fetch_assoc(mysqli_query($this->db, $query));
    }

    public function obtenerReservaPorVuelo($idUsuario, $idVuelo) {
        $idUsuario = (int)$idUsuario;
        $idVuelo = (int)$idVuelo;
        $query = "SELECT r.*, v.origen, v.destino, v.fechaSalida, v.horaSalida,
                        v.fechaLlegada, v.horaLlegada, v.precio
                FROM reserva r
                JOIN vuelo v ON r.idVuelo = v.idVuelo
                WHERE r.idUsuario = $idUsuario AND r.idVuelo = $idVuelo
                LIMIT 1";
        return mysqli_fetch_assoc(mysqli_query($this->db, $query));
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

    public function contarReservasGlobal() {
        $query = "SELECT 
                    COUNT(*) AS totalReservas,
                    SUM(CASE WHEN estadoReserva = 'confirmada' THEN 1 ELSE 0 END) AS ventas
                FROM reserva";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }
    public function reporteAerolinea($idAerolinea) {
        $idAerolinea = (int)$idAerolinea;
        $query = "SELECT 
                    COUNT(r.idReserva) AS totalReservas,
                    SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN 1 ELSE 0 END) AS ventas,
                    SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN r.precioFinal ELSE 0 END) AS recaudado
                FROM reserva r
                JOIN vuelo v ON r.idVuelo = v.idVuelo
                WHERE v.idAerolinea = $idAerolinea";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function ventasPorVuelo($idAerolinea) {
        $idAerolinea = (int)$idAerolinea;
        $query = "SELECT v.idVuelo, v.origen, v.destino, v.fechaSalida,
                        COUNT(r.idReserva) AS reservas,
                        SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN 1 ELSE 0 END) AS ventas,
                        SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN r.precioFinal ELSE 0 END) AS recaudado
                FROM vuelo v
                LEFT JOIN reserva r ON r.idVuelo = v.idVuelo
                WHERE v.idAerolinea = $idAerolinea
                GROUP BY v.idVuelo
                ORDER BY recaudado DESC";
        return mysqli_query($this->db, $query);
    }

    public function reporteVentas() {
        $query = "SELECT r.idReserva, r.precioFinal, r.fechaReserva,
                        u.nombreUsuario, u.email,
                        v.origen, v.destino, v.fechaSalida,
                        a.nombre AS nombreAerolinea
                FROM reserva r
                JOIN usuario u ON r.idUsuario = u.idUsuario
                JOIN vuelo v ON r.idVuelo = v.idVuelo
                JOIN aerolinea a ON v.idAerolinea = a.idAerolinea
                WHERE r.estadoReserva = 'confirmada'
                ORDER BY r.fechaReserva DESC";
        return mysqli_query($this->db, $query);
    }

    public function ocupacionVuelosAerolinea($idAerolinea) {
        $idAerolinea = (int)$idAerolinea;
        $query = "SELECT v.idVuelo, v.origen, v.destino, v.fechaSalida,
                        v.asientosTotales, v.asientosDisp,
                        (v.asientosTotales - v.asientosDisp) AS ocupados
                FROM vuelo v
                WHERE v.idAerolinea = $idAerolinea
                ORDER BY v.fechaSalida";
    return mysqli_query($this->db, $query);
    }

    public function reporteVuelo($idVuelo) {
        $idVuelo = (int)$idVuelo;
        $query = "SELECT 
                    COUNT(r.idReserva) AS totalReservas,
                    SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN 1 ELSE 0 END) AS ventas,
                    SUM(CASE WHEN r.estadoReserva = 'confirmada' THEN r.precioFinal ELSE 0 END) AS recaudado
                FROM reserva r
                WHERE r.idVuelo = $idVuelo";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function reservasPorVuelo($idVuelo) {
        $idVuelo = (int)$idVuelo;
        $query = "SELECT r.idReserva, r.precioFinal, r.estadoReserva, r.fechaReserva,
                        r.cantidadMayores, r.cantidadMenores,
                        u.nombreUsuario, u.email
                FROM reserva r
                JOIN usuario u ON r.idUsuario = u.idUsuario
                WHERE r.idVuelo = $idVuelo
                ORDER BY r.fechaReserva DESC";
        return mysqli_query($this->db, $query);
    }

    public function reporteVentasAerolinea($idAerolinea) {
        $idAerolinea = (int)$idAerolinea;
        $query = "SELECT r.idReserva, r.precioFinal, r.fechaReserva,
                        r.cantidadMayores, r.cantidadMenores,
                        u.nombreUsuario, u.email,
                        v.origen, v.destino, v.fechaSalida
                FROM reserva r
                JOIN usuario u ON r.idUsuario = u.idUsuario
                JOIN vuelo v ON r.idVuelo = v.idVuelo
                WHERE v.idAerolinea = $idAerolinea
                AND r.estadoReserva = 'confirmada'
                ORDER BY r.fechaReserva DESC";
        return mysqli_query($this->db, $query);
    }
    public function confirmarReserva($idReserva) {
        $idReserva = (int) $idReserva;
        $sql = "UPDATE reservas SET estadoReserva = 'confirmada' WHERE idReserva = $idReserva";
        return mysqli_query($this->db, $sql);
    }
}