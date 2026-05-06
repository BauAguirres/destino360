<?php

define('BASE_PATH', __DIR__ . '/../../../');

require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crud = new CrudUsuarios();

$id = $_GET['idUsuario'] ?? null;

$usuario = $crud->obtenerUsuario($id);




    if ($id) {
        if (!$usuario) {
            header('Location: ../usuarios.php?error=Usuario_no_encontrado');
            exit;
        }

        if ($usuario['estado'] !== 'pendiente') {
            header('Location: ../usuarios.php?error=Usuario_no_pendiente');
            exit;
        }

        if ($usuario['rol'] !== 'CEO') {
            header('Location: ../usuarios.php?error=Usuario_no_CEO');
            exit;
        }


        $crud->aprobarCEO($id);
        header('Location: ../usuarios.php?$exito=CEO_aprobado');
        exit;
    } else {
        header('Location: ../usuarios.php?error=ID_invalido');
        exit;
    }
