<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.1//EN”
“http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd”>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang=“es” lang=“es”>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Práctica 4</title>
    </head>
    <body>
    <?php
        // Ejericio 1: Determinar variables válidas en PHP
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
    ?>
    </body>
</html>