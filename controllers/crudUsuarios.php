<?php

require_once '../config/db.php';


class CrudUsuarios {
    private $db;

    public function __construct() {
        $this->db = conectarDB();
    }


    public function listarUsuarios() {
        $query = "SELECT * FROM usuario";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function obtenerUsuario($id) {
        $query = "SELECT * FROM usuario WHERE id = '$id'";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function crearUsuario($usuario, $email, $telefono, $password, $token, $rol, $aerolinea = null) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuario (nombreUsuario, email, telefono, password, tokenVerif, rol, id_aerolinea) VALUES ('$usuario', '$email', '$telefono', '$passwordHash', '$token', $rol, '$aerolinea')";
        return mysqli_query($this->db, $query);
    }

    public function verificarToken($token) {
        $query = "SELECT * FROM usuario WHERE tokenVerif = '$token'";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function activarCuenta($token){
        $query = "UPDATE usuario SET emailVerif = 1, tokenVerif = NULL WHERE tokenVerif = '$token'";
        return mysqli_query($this->db, $query);
    }

    public function eliminarUsuario($id) {
        $query = "DELETE FROM usuario WHERE id = '$id'";
        return mysqli_query($this->db, $query);
    }

    public function aprobarCEO($id) {
        $query = "UPDATE usuario SET rol = 2 WHERE id = '$id'";
        return mysqli_query($this->db, $query);
    }

    public function rechazarCEO($id) {
        $query = "UPDATE usuario SET rol = 3 WHERE id = '$id'";
        return mysqli_query($this->db, $query);
    }

    

}