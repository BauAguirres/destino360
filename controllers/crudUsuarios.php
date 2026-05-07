<?php

require_once __DIR__ . '/../config/db.php';


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
        $query = "SELECT * FROM usuario WHERE idUsuario = '$id'";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function obtenerUsuariosPorRol($rol) {
        $query = "SELECT * FROM usuario WHERE rol = '$rol'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function crearUsuario($usuario, $email, $telefono, $password, $token) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuario (nombreUsuario, email, telefono, password, tokenVerif, rol, estadoUsuario) VALUES ('$usuario', '$email', '$telefono', '$passwordHash', '$token', 'usuario', 'verificado')";
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

    //CEO

    public function crearCEO($usuario, $email, $telefono, $password, $token, $aerolinea) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuario (nombreUsuario, email, telefono, password, tokenVerif, rol, estadoUsuario, idAerolinea) VALUES ('$usuario', '$email', '$telefono', '$passwordHash', '$token', 'CEO', 'pendiente', '$aerolinea')";
        return mysqli_query($this->db, $query);
    }
    
    public function obtenerCEOsEstado($estado) {
        $query = "SELECT u.*, a.nombre FROM usuario u JOIN aerolinea a ON u.idAerolinea = a.idAerolinea WHERE u.rol = 'CEO' AND u.estadoUsuario = '$estado'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function obtenerCEO() {
        $query = "SELECT u.*, a.nombre FROM usuario u JOIN aerolinea a ON u.idAerolinea = a.idAerolinea WHERE u.estadoUsuario != 'pendiente' AND u.rol = 'CEO'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function aprobarCEO($id) {
        $query = "UPDATE usuario SET estadoUsuario = 'verificado' WHERE idUsuario = '$id'";
        return mysqli_query($this->db, $query);
    }

    public function rechazarCEO($id) {
        $query = "UPDATE usuario SET estadoUsuario = 'rechazado' WHERE idUsuario = '$id'";
        return mysqli_query($this->db, $query);
    }
}