<?php

function conectarDB() {
    $db = mysqli_connect(
        'sql208.infinityfree.com',
        'if0_42247371',
        'Destino360',
        'if0_42247371_destino360'
    );

    if (!$db) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    return $db;
}