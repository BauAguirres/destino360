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
        $query = "INSERT INTO usuario (nombreUsuario, email, telefono, password, tokenVerif, rol, estadoUsuario) VALUES ('$usuario', '$email', '$telefono', '$passwordHash', '$token', 'user', 'verificado')";
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
        $query = "DELETE FROM usuario WHERE idUsuario = '$id'";
        return mysqli_query($this->db, $query);
    }

    public function cambiarContraseña($id, $pass) {
        $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
        $query = "UPDATE usuario SET password = '$passwordHash' WHERE idUsuario = '$id'";
        return mysqli_query($this->db, $query);
    }

    public function obtenerEmail($email) {
        $query = "SELECT * FROM usuario WHERE email = '$email'";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    //CEO

    public function crearCEO($usuario, $email, $telefono, $password, $token, $aerolinea) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuario (nombreUsuario, email, telefono, password, tokenVerif, rol, estadoUsuario, idAerolinea) VALUES ('$usuario', '$email', '$telefono', '$passwordHash', '$token', 'CEO', 'pendiente', '$aerolinea')";
        return mysqli_query($this->db, $query);
    }
    
    public function obtenerCEOsEstado($estado) {
        $query = "SELECT u.*, a.nombre FROM usuario u JOIN aerolinea a ON u.idAerolinea = a.idAerolinea WHERE u.estadoUsuario = '$estado'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function listarCeo() {
        $query = "SELECT u.*, a.nombre FROM usuario u JOIN aerolinea a ON u.idAerolinea = a.idAerolinea WHERE u.estadoUsuario != 'pendiente' AND u.rol = 'CEO'";
        $resultado = mysqli_query($this->db, $query);
        return $resultado;
    }

    public function obtenerCEO($id) {
        $query = "SELECT u.*, a.* FROM usuario u JOIN aerolinea a ON u.idAerolinea = a.idAerolinea WHERE u.idUsuario = '$id'";
        $resultado = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($resultado);
    }

    public function cambiarEstadoCEO($id, $estado) {
        $query = "UPDATE usuario SET estadoUsuario = '$estado' WHERE idUsuario = '$id'";
        return mysqli_query($this->db, $query);
    }


    public function contarUsuarios() {
    $query = "SELECT COUNT(*) AS total FROM usuario";
    $fila = mysqli_fetch_assoc(mysqli_query($this->db, $query));
    return $fila['total'] ?? 0;
    }

    public function contarCeosPendientes() {
        $query = "SELECT COUNT(*) AS total FROM usuario WHERE rol = 'CEO' AND estadoUsuario = 'pendiente'";
        $fila = mysqli_fetch_assoc(mysqli_query($this->db, $query));
        return $fila['total'] ?? 0;
    }

    public function reporteUsuarios() {
    $query = "SELECT u.*, a.nombre AS nombreAerolinea
              FROM usuario u
              LEFT JOIN aerolinea a ON u.idAerolinea = a.idAerolinea
              ORDER BY u.rol, u.nombreUsuario";
    return mysqli_query($this->db, $query);
    }
}