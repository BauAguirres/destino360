<?php 

define('BASE_URL', 'http://localhost/entorno');




function guardarLogo($file) {
    $extencionesPermitidas = ['jpg', 'jpeg', 'png'];
    $tamañoMaximo = 5 * 1024 * 1024; // 5MB

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['error' => 'No se seleccionó ningún archivo'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Error en la subida del archivo'];
    }

    $extencion = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extencion, $extencionesPermitidas)) {
        return ['error' => 'Extensión no permitida. Solo JPG, PNG o GIF'];
    }

    if ($file['size'] > $tamañoMaximo) {
        return ['error' => 'Archivo demasiado grande. Máximo 5MB'];
    }

    $nombreArchivo = hash('sha256', uniqid() . microtime()) . '.' . $extencion;
    
    $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . '/entorno/public/assets/img/logosAerolineas/';
    if (!is_dir($rutaDestino)) {
        mkdir($rutaDestino, 0777, true);
    }

    $archivoCompleto = $rutaDestino . $nombreArchivo;

    // Mover archivo
    if (move_uploaded_file($file['tmp_name'], $archivoCompleto)) {
        return ['exito' => true, 'nombre' => $nombreArchivo];
    } else {
        return ['error' => 'Error al guardar el archivo'];
    }
}

?>
