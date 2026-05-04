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

    public function crearAerolinea($nombre, $codIATA, $codPais, $estado, $descipcion, $logo) {
        $query = "INSERT INTO aerolinea (nombre, codIATA, codPais, estado, descripcion, urlLogo) VALUES ('$nombre', '$codIATA', '$codPais', '$estado', '$descipcion', '$logo')";
        return mysqli_query($this->db, $query);
    }

    
}