<?php
// EJERCICIO 1
function es_multiplo7y5($num)
{
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}

// EJERCICIO 2
function generar_secuencia()
{
    $matriz = array();
    $num_generados = 0;
    $iteraciones = 0;

    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $matriz[$i][$j] = rand(1, 1000);
            $num_generados++;
        }
    }

    echo '<h3>Matriz generada:</h3>';
    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 3; $j++) {
            echo $matriz[$i][$j] . ' ';
        }
        echo '<br>';
    }

    for ($i = 0; $i < 4; $i++) {
        for ($j = 2; $j < 3; $j++) {
            $iteraciones++;
            if ($matriz[$i][$j-2] % 2 != 0 && $matriz[$i][$j-1] % 2 == 0 && $matriz[$i][$j] % 2 != 0) {
                echo '<h3>R= La secuencia es: ' . $matriz[$i][$j-2] . ', ' . $matriz[$i][$j-1] . ', ' . $matriz[$i][$j] . ' en la fila ' . $i . '</h3>';
                echo '<h3>Número de iteraciones: ' . $iteraciones . '</h3>';
                echo '<h3>Cantidad de números generados: ' . $num_generados . '</h3>';
                return;
            }
        }
    }

    echo '<h3>No se encontró la secuencia específica.</h3>';
    echo '<h3>Número de iteraciones: ' . $iteraciones . '</h3>';
    echo '<h3>Cantidad de números generados: ' . $num_generados . '</h3>';
}

// EJERCICIO 3
function obtenerMultiplo($num) {
    do {
        $aleatorio = rand(1, 1000);
    } while ($aleatorio % $num != 0);

    echo '<h3>Primer múltiplo encontrado con do-while: ' .$aleatorio. '</h3>';
}
?>