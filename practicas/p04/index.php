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

        // Ejercicio 1: Validar nombres de variables
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
        echo "<hr>";
    ?>
    </body>
</html>