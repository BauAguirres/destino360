<?php
require_once __DIR__ . '/../config/db.php';

class CrudNovedades {
    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }

    public function crearNovedad($nombre, $texto, $fechaPublicacion, $fechaExpiracion) {
    $nombre = mysqli_real_escape_string($this->db, $nombre);
    $texto = mysqli_real_escape_string($this->db, $texto);
    $query = "INSERT INTO novedad (nombreNov, descNovedad, fechaPublicacion, fechaExpiracion) 
              VALUES ('$nombre', '$texto', '$fechaPublicacion', '$fechaExpiracion')";
    return mysqli_query($this->db, $query);
    }

    public function editarNovedad($id, $nombre, $texto, $fechaPublicacion, $fechaExpiracion) {
        $id = (int)$id;
        $nombre = mysqli_real_escape_string($this->db, $nombre);
        $texto = mysqli_real_escape_string($this->db, $texto);
        $query = "UPDATE novedad SET 
                    nombreNov = '$nombre',
                    desNovedad = '$texto',
                    fechaPublicacion = '$fechaPublicacion',
                    fechaExpiracion = '$fechaExpiracion'
                WHERE idNovedad = $id";
        return mysqli_query($this->db, $query);
    }

    public function listarNovedades() {
        $query = "SELECT * FROM novedad ORDER BY fechaPublicacion DESC";
        return mysqli_query($this->db, $query);
    }

    public function listarNovedadesVigentes() {
        $query = "SELECT * FROM novedad 
                  WHERE CURDATE() BETWEEN fechaPublicacion AND fechaExpiracion
                  ORDER BY fechaPublicacion DESC";
        return mysqli_query($this->db, $query);
    }

    public function obtenerNovedad($id) {
        $id = (int)$id;
        $query = "SELECT * FROM novedad WHERE idNovedad = $id";
        return mysqli_fetch_assoc(mysqli_query($this->db, $query));
    }

    public function eliminarNovedad($id) {
        $id = (int)$id;
        $query = "DELETE FROM novedad WHERE idNovedad = $id";
        return mysqli_query($this->db, $query);
    }
}