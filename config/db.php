<?php

function conectarDB() {
    $db = mysqli_connect('localhost', 'root', '', 'destino360');
    return $db;
}