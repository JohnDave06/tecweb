<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        require_once __DIR__ .'/src/funciones.php';

        if(isset($_GET['numero']))
        {
            es_multiplo7y5($_GET['numero']);
        }
    ?>
    <hr>

    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>
    <hr>

    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta por: impar, par, impar</p>
    <?php
        generar_secuencia();
    ?>
    <hr>

    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.</p>
    <?php
        require_once __DIR__ .'/src/funciones.php';

        if (isset($_GET['numero'])) {
            $numero = intval($_GET['numero']);
            obtenerMultiploWhile($numero);
            obtenerMultiploDoWhile($numero);
        }
    ?>
    <hr>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
    a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
    el valor en cada índice.</p>
    <?php
        indices($arreglo);
    ?>
    <hr>

    <h2>Ejercicio 5</h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de
    sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de
    bienvenida apropiado.</p>
    <form method="post" action="">
    <label for="edad">Edad:</label>
    <input type="number" id="edad" name="edad" required>
    <br>
    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo" required>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
    </select>
    <br>
    <input type="submit" value="Enviar">
    </form>

    <?php
        edad();
    ?>
    <hr>

    <?php
        require_once __DIR__ .'/src/funciones.php';
        $parqueVehicular = vehiculos();
    ?>
    <h2>Ejercicio 6</h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de
    una ciudad.</p>
    <h3>Consultar Vehículos almacenados</h3>
    <form method="post" action="">
        <input type="hidden" name="mostrar_todos" value="1">
        <input type="submit" value="Consultar">
    </form>

    <h3>Consultar Información del Parque Vehicular</h3>
    <form method="post" action="">
        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula">
        <br>
        <input type="submit" value="Verificar">
    </form>

    <?php
    consultar_vehiculo($parqueVehicular);
    ?>
    <hr>
</body>
</html>