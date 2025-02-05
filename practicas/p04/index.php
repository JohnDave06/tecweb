<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.1//EN”
“http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd”>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang=“es” lang=“es”>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Práctica 4</title>
    </head>
    <body>
    <?php
        error_reporting(0);
        // Ejericio 1: Determinar variables válidas en PHP
        echo "\n<br>Ejercicio 1: Determinar variables válidas en PHP<br>\n";
        $variables = ['$_myvar', '$_7var', 'myvar', '$myvar', '$var7', '$_element1', '$house*5'];
        foreach ($variables as $var) {
            echo "La variable $var es: " . (preg_match('/^\$[a-zA-Z_][a-zA-Z0-9_]*$/', $var) ? "válida" : "inválida") . "\n";
        }
        //`$_myvar` Válida: Las variables pueden iniciar con `_` seguido de letras o números.
        //`$_7var` Válida: Se permite iniciar con `_` y contener números y letras.
        //`myvar` Inválida: No tiene el prefijo `$`, todas las variables en PHP deben iniciar con `$`.
        //`$myvar` Válida: Sigue las reglas de nomenclatura de PHP.
        //`$var7` Válida: Puede contener números siempre y cuando no inicie con ellos.
        //`$_element1` Válida: Puede iniciar con `_` y contener números y letras.
        //`$house*5` Inválida: No se pueden usar operadores en los nombres de variables.

        unset($_myvar);
        unset($_7var);
        unset($myvar);
        unset($var7);
        unset($_element1);

        echo "<hr>";

        // Ejercicio 2: Asignaciones y referencias
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;

        echo "\n<br>Ejercicio 2: Asignaciones y referencias<br>\n";
        echo "\n\nValores iniciales:\n";
        echo "a: $a\n";
        echo "b: $b\n";
        echo "c: $c\n";

        // Segunda asignación
        $a = "PHP server";
        $b = &$a;

        echo "\nValores después de la segunda asignación:\n";
        echo "a: $a\n";
        echo "b: $b\n";
        echo "c: $c\n";

        // Explicación de lo ocurrido
        echo "\nExplicación:\n";
        echo "En la segunda asignación, dado que 'c' es una referencia a 'a', cuando 'a' cambia, 'c' también refleja el nuevo valor. ";
        echo "Además, al hacer que 'b' apunte a 'a', cualquier cambio en 'a' se reflejará también en 'b'.";

        unset($a);
        unset($b);
        unset($c);
        echo "<hr>\n\n";

        
        // Ejercicio 3: Evolución de variables
        echo "\n<br>Ejercicio 3: Evolución de variables<br>\n";
        $a = "PHP5";
        echo "Después de asignar \$a = 'PHP5': ";
        echo "Resultado: " . $a;
        echo "<br><br>\n";

        $z[] = &$a;
        echo "Después de asignar \$z[] = &\$a: ";
        echo "Resultado: " . $z[0];
        echo "<br><br>\n";
        
        $b = "5a version de PHP";
        echo "Después de asignar \$b = '5a version de PHP': ";
        echo "Resultado: " . $b;
        echo "<br><br>\n";

        $c = $b * 10;
        echo "Después de asignar \$c = \$b * 10: ";
        echo "Resultado: " . $c;
        echo "<br><br>\n";

        $a .= $b;
        echo "Después de asignar \$a .= \$b: ";
        echo "Resultado: " . $a;
        echo "<br><br>\n";

        $b *= $c;
        echo "Después de asignar \$b *= \$c: ";
        echo "Resultado: " . $b;
        echo "<br><br>\n";

        $z[0] = "MySQL";
        echo "Después de asignar \$z[0] = 'MySQL': ";
        echo "Resultado: " . $z[0];
        echo "<br><br>\n"; 
        
        unset($a);
        unset($b);
        unset($c);
        unset($z);

        echo "<hr>";

        // Ejercicio 4: Uso de $GLOBALS
        global $a, $z, $b, $c; 
        echo "\n<br>Ejercicio 4: Uso de $GLOBALS<br>\n";

        $a = "PHP5";
        echo "Después de asignar \$a = 'PHP5': ";
        echo "Resultado: " . $a;
        echo "<br><br>";

        $z[] = &$a;
        echo "Después de asignar \$z[] = &\$a: ";
        echo "Resultado: " . $z[0];
        echo "<br><br>";

        $b = "5a version de PHP";
        echo "Después de asignar \$b = '5a version de PHP': ";
        echo "Resultado: " . $b;
        echo "<br><br>";

        $c = $b * 10;
        echo "Después de asignar \$c = \$b * 10: ";
        echo "Resultado: " . $c;
        echo "<br><br>";

        $a .= $b;
        echo "Después de asignar \$a .= \$b: ";
        echo "Resultado: " . $a;
        echo "<br><br>";

        $b *= $c;
        echo "Después de asignar \$b *= \$c: ";
        echo "Resultado: " . $b;
        echo "<br><br>";

        $z[0] = "MySQL";
        echo "Después de asignar \$z[0] = 'MySQL': ";
        echo "Resultado: " . $z[0];
        echo "<br><br>";

        unset($a);
        unset($b);
        unset($c);
        unset($z);

        // Ejercicio 5: Conversión de tipos de datos
        echo "<hr>";
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo "\n<br>Ejercicio 5: Conversiones de tipos<br>\n";
        echo "a: $a (tipo: ". gettype($a) .")<br>\n";
        echo "b: $b (tipo: ". gettype($b) .")<br>\n";
        echo "c: $c (tipo: ". gettype($c) .")<br>\n";

        // Ejercicio 6: Valores booleanos
        echo "<hr>";
        echo "<br>Ejercicio 6: Valores Booleanos<br>";
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);

        var_dump($a); echo "<br>";
        var_dump($b); echo "<br>";
        var_dump($c); echo "<br>";
        var_dump($d); echo "<br>";
        var_dump($e); echo "<br>";
        var_dump($f); echo "<br>";

        // Mostrar valores booleanos con echo
        echo "<br>Valor de \$c con echo: " . var_export($c, true);
        echo "<br>Valor de \$e con echo: " . var_export($e, true);

        unset($a);
        unset($b);
        unset($c);
        unset($d);
        unset($e);
        unset($f);

        echo "<hr>";

        // Ejercicio 7: Uso de $_SERVER
        echo "<br>Ejercicio 7: Información del Servidor<br>";
        echo "Versión de Apache y PHP: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
        echo "Sistema operativo del servidor: " . PHP_OS . "<br>";
        echo "Idioma del navegador del cliente: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br>";
    ?>
    </body>
</html>