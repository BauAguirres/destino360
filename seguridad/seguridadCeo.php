<?php
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../index.php?error=Debes iniciar sesion');
    exit;
}

if ($_SESSION['rol'] !== 'CEO') {
    header('Location: ../index.php?error=No tenes permisos para acceder');
    exit;
}