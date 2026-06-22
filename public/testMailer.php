<?php
define('BASE_PATH', __DIR__ . '/../');
require_once BASE_PATH . 'config/mailer.php';

if (enviarMail('bautyaguirres2@gmail.com', 'Prueba Destino360', '<h1>Funciona!</h1>')) {
    echo 'Mail enviado correctamente';
} else {
    echo 'Error al enviar el mail';
}