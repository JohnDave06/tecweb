<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'contraseña_6',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexión contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conectada!');
    }
?>