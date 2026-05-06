<?php

require_once __DIR__ . '/../config/db.php';


class crudAerolineas {
    
    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }


    public function listarAerolineas() {
        $query = "SELECT * FROM aerolinea";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function listarAerolineasActivas() {
        $query = "SELECT * FROM aerolinea WHERE estado = 1";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function crearAerolinea($nombre, $codIATA, $codPais, $estado, $descipcion, $logo) {
        $query = "INSERT INTO aerolinea (nombre, codIATA, codPais, estado, descripcion, urlLogo) VALUES ('$nombre', '$codIATA', '$codPais', '$estado', '$descipcion', '$logo')";
        return mysqli_query($this->db, $query);
    }

    public function obtenerAerolinea($id) {
        $query = "SELECT * FROM aerolinea WHERE idAerolinea = $id";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }
    
    public function activarAerolinea($id) {
        $query = "UPDATE aerolinea SET estado = 1 WHERE idAerolinea = $id";
        return mysqli_query($this->db, $query);
    }

    public function desactivarAerolinea($id) {
        $query = "UPDATE aerolinea SET estado = 0 WHERE idAerolinea = $id";
        return mysqli_query($this->db, $query);
    }

    
}