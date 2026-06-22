<?php
require_once __DIR__ . '/../config/db.php';

class CrudCarrusel {
    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }

    public function listarImagenes() {
        $query = "SELECT * FROM carrusel ORDER BY orden ASC, idImagen ASC";
        return mysqli_query($this->db, $query);
    }

    public function agregarImagen($urlImagen) {
        $urlImagen = mysqli_real_escape_string($this->db, $urlImagen);
        $query = "INSERT INTO carrusel (urlImagen) VALUES ('$urlImagen')";
        return mysqli_query($this->db, $query);
    }

    public function obtenerImagen($id) {
        $id = (int)$id;
        $query = "SELECT * FROM carrusel WHERE idImagen = $id";
        return mysqli_fetch_assoc(mysqli_query($this->db, $query));
    }

    public function eliminarImagen($id) {
        $id = (int)$id;
        $query = "DELETE FROM carrusel WHERE idImagen = $id";
        return mysqli_query($this->db, $query);
    }
}