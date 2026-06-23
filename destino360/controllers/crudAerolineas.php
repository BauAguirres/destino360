<?php

require_once __DIR__ . '/../config/db.php';


class CrudAerolineas { 
    
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
        $query = "SELECT * FROM aerolinea WHERE estadoAerolinea = 1";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function crearAerolinea($nombre, $codIATA, $codPais, $estado, $descipcion, $logo) {
        $query = "INSERT INTO aerolinea (nombre, codIATA, codPais, estadoAerolinea, descripcion, urlLogo) VALUES ('$nombre', '$codIATA', '$codPais', '$estado', '$descipcion', '$logo')";
        return mysqli_query($this->db, $query);
    }

    public function editarAerolinea($id, $nombre, $codIATA, $codPais, $descripcion, $logo = null) {
        $id = (int)$id;
        $nombre = mysqli_real_escape_string($this->db, $nombre);
        $codIATA = mysqli_real_escape_string($this->db, $codIATA);
        $codPais = mysqli_real_escape_string($this->db, $codPais);
        $descripcion = mysqli_real_escape_string($this->db, $descripcion);

        if ($logo !== null) {
            $logo = mysqli_real_escape_string($this->db, $logo);
            $query = "UPDATE aerolinea SET 
                        nombre = '$nombre', codIATA = '$codIATA', codPais = '$codPais',
                        descripcion = '$descripcion', urlLogo = '$logo'
                    WHERE idAerolinea = $id";
        } else {
            $query = "UPDATE aerolinea SET 
                        nombre = '$nombre', codIATA = '$codIATA', codPais = '$codPais',
                        descripcion = '$descripcion'
                    WHERE idAerolinea = $id";
        }
        return mysqli_query($this->db, $query);
    }

    public function eliminarAerolinea($id) {
        $id = (int)$id;
        $query = "DELETE FROM aerolinea WHERE idAerolinea = $id";
        return mysqli_query($this->db, $query);
    }

    public function obtenerAerolinea($id) {
        $query = "SELECT * FROM aerolinea WHERE idAerolinea = $id";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }
    
    public function activarAerolinea($id) {
        $query = "UPDATE aerolinea SET estadoAerolinea = 1 WHERE idAerolinea = $id";
        return mysqli_query($this->db, $query);
    }

    public function desactivarAerolinea($id) {
        $query = "UPDATE aerolinea SET estadoAerolinea = 0 WHERE idAerolinea = $id";
        return mysqli_query($this->db, $query);
    }

    public function contarAerolineas() {
    $query = "SELECT COUNT(*) AS total FROM aerolinea";
    $fila = mysqli_fetch_assoc(mysqli_query($this->db, $query));
    return $fila['total'] ?? 0;
    }

    public function buscarAerolineas($texto = '', $estado = '') {
        $where = "WHERE 1=1";

        if (!empty($texto)) {
            $texto = mysqli_real_escape_string($this->db, $texto);
            $where .= " AND (nombre LIKE '%$texto%' OR codIATA LIKE '%$texto%' OR codPais LIKE '%$texto%')";
        }
        if ($estado !== '') {
            $estado = (int)$estado;
            $where .= " AND estadoAerolinea = $estado";
        }

        $query = "SELECT * FROM aerolinea $where ORDER BY nombre";
        return mysqli_query($this->db, $query);
    }

    public function buscarAerolineasAdmin($texto = '', $estado = '') {
        $where = "WHERE 1=1";

        if (!empty($texto)) {
            $texto = mysqli_real_escape_string($this->db, $texto);
            $where .= " AND (nombre LIKE '%$texto%' OR codIATA LIKE '%$texto%' OR codPais LIKE '%$texto%')";
        }
        if ($estado !== '') {
            $estado = (int)$estado;
            $where .= " AND estadoAerolinea = $estado";
        }

        $query = "SELECT * FROM aerolinea $where ORDER BY nombre";
        return mysqli_query($this->db, $query);
    }
}