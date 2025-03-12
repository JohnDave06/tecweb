<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>

    <!-- Ejercicio 1: Determinar variables válidas en PHP -->
    <p>Ejercicio 1: Determinar variables válidas en PHP</p>
    
    <?php
    error_reporting(0);
    $variables = array('_myvar', '_7var', 'myvar', 'var7', '_element1', 'house*5');
    foreach ($variables as $var) {
        echo '<p>La variable $' . htmlspecialchars($var, ENT_QUOTES, 'UTF-8') . ' es: ' . 
        (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $var) ? 'válida' : 'inválida') . '</p>';
    }

    echo '<hr />';
    ?>

    <!-- Ejercicio 2: Asignaciones y referencias -->
    <p>Ejercicio 2: Asignaciones y referencias</p>
    
    <?php
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a;
    echo '<p>Valores iniciales:</p>';
    echo '<p>a: ' . htmlspecialchars($a, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>b: ' . htmlspecialchars($b, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>c: ' . htmlspecialchars($c, ENT_QUOTES, 'UTF-8') . '</p>';

    // Segunda asignación
    $a = "PHP server";
    $b = &$a;
    $c = &$a;

    echo '<p>Valores después de la segunda asignación:</p>';
    echo '<p>a: ' . htmlspecialchars($a, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>b: ' . htmlspecialchars($b, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>c: ' . htmlspecialchars($c, ENT_QUOTES, 'UTF-8') . '</p>';

    // Explicación de lo ocurrido
    echo '<p>Explicación:</p>';
    echo '<p>En la segunda asignación, dado que \'c\' es una referencia a \'a\', cuando \'a\' cambia, \'c\' también refleja el nuevo valor. Además, al hacer que \'b\' apunte a \'a\', cualquier cambio en \'a\' se reflejará también en \'b\'. </p>';

    echo '<hr />';
    ?>

    <!-- Ejercicio 3: Evolución de variables -->
    <p>Ejercicio 3: Evolución de variables</p>
    
    <?php
    $a = "PHP5";
    echo '<p>Después de asignar $a = \'PHP5\': </p>';
    echo '<p>Resultado: ' . htmlspecialchars($a, ENT_QUOTES, 'UTF-8') . '</p>';

    $z[] = &$a;
    echo '<p>Después de asignar $z[] = &amp;$a: </p>';
    echo '<p>Resultado: ' . htmlspecialchars($z[0], ENT_QUOTES, 'UTF-8') . '</p>';
    
    $b = "5a version de PHP";
    echo '<p>Después de asignar $b = \'5a version de PHP\': </p>';
    echo '<p>Resultado: ' . htmlspecialchars($b, ENT_QUOTES, 'UTF-8') . '</p>';

    $c = intval($b) * 10;
    echo '<p>Después de asignar $c = $b * 10: </p>';
    echo '<p>Resultado: ' . htmlspecialchars($c, ENT_QUOTES, 'UTF-8') . '</p>';

    $a .= $b;
    echo '<p>Después de asignar $a .= $b:  </p>';
    echo '<p>Resultado: ' . htmlspecialchars($a, ENT_QUOTES, 'UTF-8') . '</p>';

    $b *= $c;
    echo '<p>Después de asignar $b *= $c: </p>';
    echo '<p>Resultado: ' . htmlspecialchars($b, ENT_QUOTES, 'UTF-8') . '</p>';

    $z[0] = "MySQL";
    echo '<p>Después de asignar $z[0] = \'MySQL\': </p>';
    echo '<p>Resultado: ' . htmlspecialchars($z[0], ENT_QUOTES, 'UTF-8') . '</p>'; 

    echo '<hr />';
    ?>

    <!-- Ejercicio 4: Uso de $GLOBALS -->
    <p>Ejercicio 4: Uso de $GLOBALS</p>
    <?php
    $GLOBALS['a'] = "PHP5";
    $GLOBALS['b'] = "5a version de PHP";
    $GLOBALS['c'] = intval($GLOBALS['b']) * 10;
    
    echo '<p>Después de asignar $a = \'PHP5\': ' . htmlspecialchars($GLOBALS['a'], ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>Después de asignar $b = \'5a version de PHP\': ' . htmlspecialchars($GLOBALS['b'], ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>Después de asignar $c = $b * 10: ' . htmlspecialchars($GLOBALS['c'], ENT_QUOTES, 'UTF-8') . '</p>';
    
    echo '<hr />';
    ?>

    <!-- Ejercicio 5: Conversiones de tipos -->
    <p>Ejercicio 5: Conversiones de tipos</p>
    <?php
    $a = "7 personas";
    $b = (int) $a;
    $a = "9E3";
    $c = (float) $a;
    
    echo '<p>a: ' . htmlspecialchars($a, ENT_QUOTES, 'UTF-8') . ' (tipo: ' . gettype($a) . ')</p>';
    echo '<p>b: ' . htmlspecialchars($b, ENT_QUOTES, 'UTF-8') . ' (tipo: ' . gettype($b) . ')</p>';
    echo '<p>c: ' . htmlspecialchars($c, ENT_QUOTES, 'UTF-8') . ' (tipo: ' . gettype($c) . ')</p>';

    echo '<hr />';        
    ?>

    <!-- Ejercicio 6: Valores Booleanos -->
    <p>Ejercicio 6: Valores Booleanos</p>

    <?php
    $a = "0";
    $b = true;
    $c = false;
    $d = ($a || $b);
    $e = ($a && $c);
    $f = ($a ^ $b);

    echo '<p>' . htmlspecialchars(var_export($a, true), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>' . htmlspecialchars(var_export($b, true), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>' . htmlspecialchars(var_export($c, true), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>' . htmlspecialchars(var_export($d, true), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>' . htmlspecialchars(var_export($e, true), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>' . htmlspecialchars(var_export($f, true), ENT_QUOTES, 'UTF-8') . '</p>';

    // Mostrar valores booleanos con echo
    echo '<p>Valor de $c con echo: false</p>';
    echo '<p>Valor de $e con echo: false</p>';
    
    echo '<hr />';    
    ?>

    <!-- Ejercicio 7: Información del Servidor -->
    <p>Ejercicio 7: Información del Servidor</p>

    <?php
    echo '<p>Versión de Apache y PHP: ' . htmlspecialchars($_SERVER['SERVER_SOFTWARE'], ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>Sistema operativo del servidor: ' . htmlspecialchars(PHP_OS, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>Idioma del navegador del cliente: ' . htmlspecialchars($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'No disponible', ENT_QUOTES, 'UTF-8') . '</p>';
    
    echo '<hr />';
    ?>

    <p>
        <a href="https://validator.w3.org/markup/check?uri=referer"><img
        src="https://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
    </p>
</body>
</html>