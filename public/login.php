<?php

session_start();

require_once '../controllers/crudUsuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $crud = new CrudUsuarios;
    $usuario = $crud->obtenerEmail($email);

    if(empty($usuario)) {
        header('Location: index.php?error=Usuario no Encontrado');
        exit;
    }

    if(!password_verify($pass, $usuario['password'])){
        header('Location: index.php?error=Contraseña Incorrecta');
        exit;
    }

    $_SESSION['idUsuario'] = $usuario['idUsuario'];
    $_SESSION['rol'] = $usuario['rol'];

    if($usuario['rol'] === 'CEO') {
        $_SESSION['idAerolinea'] = $usuario['idAerolinea'];
        header('Location: ceo/dashboard.php');
        exit;
    }
    
    if($usuario['rol'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit;
    }
}