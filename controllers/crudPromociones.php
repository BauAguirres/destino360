<?php

require_once __DIR__ . '/../config/db.php';

class CrudPromociones {

    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }

    public function crearPromocion($idAerolinea,$nombrePromo, $descPromocion, $porcDesc, $estadoPromo, $fechaInicio, $fechaFin){
        $query = "INSERT INTO promocion (idAerolinea, nombrePromo, descPromocion, porcDesc, estadoPromo, fechaInicio, fechaFin) VALUES ('$idAerolinea', '$nombrePromo', '$descPromocion', '$porcDesc', '$estadoPromo', '$fechaInicio', '$fechaFin')";
        return mysqli_query($this->db, $query);
    }

    public function listarPromociones($idAerolinea) {
        $query = "SELECT * FROM promocion WHERE idAerolinea = '$idAerolinea'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function listarPromocionesEstado($estado) {
        $query = "SELECT * FROM promocion WHERE estadoPromo = '$estado'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function listarPromocionesEstadoDist($estado) {
        $query = "SELECT * FROM promocion WHERE estadoPromo != '$estado'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function obtenerPromocion($id) {
        $query = "SELECT p.*, a.nombre FROM promocion p JOIN aerolinea a ON p.idAerolinea = a.idAerolinea WHERE idPromo = '$id'";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function cambiarEstadoPromo($id, $estado) {
        $query = "UPDATE promocion SET estadoPromo = '$estado' WHERE idPromo = '$id'";
        return mysqli_query($this->db, $query);
    }
}