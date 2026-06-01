<?php

require_once __DIR__ . '/../config/db.php';

class CrudVuelos {

    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }

    public function listarVuelos($idAerolinea) {
        $query = "SELECT v.*, a.* FROM vuelo v JOIN aerolinea a ON v.idAerolinea = a.idAerolinea WHERE a.idAerolinea = '$idAerolinea'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function crearVuelo($tipoVuelo, $idAerolinea, $origen, $destino, $asientosTotales, $asientosDisp, $precio, $estado, $idVueloRelacionado = null) {
        $relacionadoSQL = $idVueloRelacionado ? $idVueloRelacionado : "NULL";
        $query = "INSERT INTO vuelo (tipoVuelo, idAerolinea, origen, destino, asientosTotales, asientosDisp, precio, estadoVuelo, idVueloRelacionado) VALUES ('$tipoVuelo',$idAerolinea, '$origen', '$destino', $asientosTotales, $asientosDisp, $precio, '$estado', $relacionadoSQL)";
        mysqli_query($this->db, $query);
        return mysqli_insert_id($this->db);
    }

    public function vincularVuelos($idIda, $idVuelta) {
    $idIda = (int)$idIda;
    $idVuelta = (int)$idVuelta;
    
    // Vincular ida → vuelta
    $query1 = "UPDATE vuelo SET idVueloRelacionado = $idVuelta WHERE idVuelo = $idIda";
    mysqli_query($this->db, $query1);
    
    // Vincular vuelta → ida
    $query2 = "UPDATE vuelo SET idVueloRelacionado = $idIda WHERE idVuelo = $idVuelta";
    mysqli_query($this->db, $query2);
}

    public function eliminarVuelo($id) {
        $query = "DELETE FROM vuelo WHERE idVuelo = $id";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function actualizarVuelo($id, $idAerolinea, $origen, $destino, $asientosTotales, $asientosDisp, $precio) {
        $query = "UPDATE vuelo SET idAerolinea = '$idAerolinea', origen = '$origen', destino = '$destino', asientosTotales = '$asientosTotales', asientosDisp = '$asientosDisp', precio = '$precio' WHERE idVuelo = '$id'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function asignarHorario($idVuelo, $fechaSalida, $horaSalida, $fechaLlegada, $horaLlegada) {
        $query = "UPDATE vuelo SET fechaSalida = '$fechaSalida', horaSalida = '$horaSalida', fechaLlegada = '$fechaLlegada', horaLlegada = '$horaLlegada' WHERE idVuelo = '$idVuelo'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function obtenerVuelo($id) {
        $query = "SELECT * FROM vuelo WHERE idVuelo = $id";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function activarVuelo($id) {
        $query = "UPDATE vuelo SET estadoVuelo = 1 WHERE idVuelo = $id";
        return mysqli_query($this->db, $query);
    }

    public function desactivarVuelo($id) {
        $query = "UPDATE vuelo SET estadoVuelo = 0 WHERE idVuelo = $id";
        return mysqli_query($this->db, $query);
    }

    public function listarVuelosActivos() {
        $query = "SELECT v.*, a.* FROM vuelo v JOIN aerolinea a ON v.idAerolinea = a.idAerolinea WHERE v.estadoVuelo = 1 and a.estadoAerolinea = 1";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }


}