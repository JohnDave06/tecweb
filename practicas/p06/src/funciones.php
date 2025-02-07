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

// EJERCICIO 
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
                echo '<h3>R= La secuencia es: ' . $matriz[$i][$j-2] . ', ' . $matriz[$i][$j-1] . ', ' . $matriz[$i][$j] . ' en la fila ' . $i+1 . '</h3>';
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
function obtenerMultiploWhile($num) {
    while (true) {
        $aleatorio = rand(1, 1000);
        if ($aleatorio % $num == 0) {
            echo '<h3>Primer múltiplo encontrado con while: ' . $aleatorio . '</h3>';
            break;
        }
    }
}

function obtenerMultiploDoWhile($num) {
    do {
        $aleatorio = rand(1, 1000);
    } while ($aleatorio % $num != 0);

    echo '<h3>Primer múltiplo encontrado con do-while: ' . $aleatorio . '</h3>';
}

// EJERCICIO 4
$arreglo = array();
for ($i = 97; $i <= 122; $i++) {
    $arreglo[$i] = chr($i);
}

function indices($arreglo) {
    echo '<table border="1">';
    echo '<tr><th>Índice</th><th>Valor</th></tr>';
    foreach ($arreglo as $key => $value) {
        echo '<tr>';
        echo '<td>' . $key . '</td>';
        echo '<td>' . $value . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

// EJERCICIO 5
function edad() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['edad']) && isset($_POST['sexo'])) {
            $edad = intval($_POST['edad']);
            $sexo = $_POST['sexo'];
            
            if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
                echo '<h3>Bienvenida, usted está en el rango de edad permitido.</h3>';
            } 
            elseif ($sexo == "masculino" && $edad >= 18 && $edad <= 35) {
                echo '<h3>Bienvenido</h3>';
            } 
            else {
                echo '<h3>Error: No cumple con los requisitos.</h3>';
            }
        } else {
            echo '<h3>Error: Faltan datos en el formulario.</h3>';
        }
    }
}


// EJERCICIO 6
function vehiculos() {
    $parqueVehicular = array(
        "UBN6338" => array(
        "Auto" => array(
            "marca" => "HONDA",
            "modelo" => 2020,
            "tipo" => "camioneta"
        ),
        "Propietario" => array(
            "nombre" => "Alfonzo Esparza",
            "ciudad" => "Puebla, Pue.",
            "direccion" => "C.U., Jardines de San Manuel"
        )
        ),
        "UBN6339" => array(
            "Auto" => array(
                "marca" => "MAZDA",
                "modelo" => 2019,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Ma. del Consuelo Molina",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "97 oriente"
            )
        ),
        "UBN6340" => array(
            "Auto" => array(
                "marca" => "TOYOTA",
                "modelo" => 2018,
                "tipo" => "hatchback"
            ),
            "Propietario" => array(
                "nombre" => "Juan Pérez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Av. Reforma"
            )
        ),
        "UBN6341" => array(
            "Auto" => array(
                "marca" => "FORD",
                "modelo" => 2017,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Ana Gómez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Calle 5 de Mayo"
            )
        ),
        "UBN6342" => array(
            "Auto" => array(
                "marca" => "CHEVROLET",
                "modelo" => 2016,
                "tipo" => "camioneta"
            ),
            "Propietario" => array(
                "nombre" => "Luis Martínez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Blvd. Atlixco"
            )
        ),
        "UBN6343" => array(
            "Auto" => array(
                "marca" => "NISSAN",
                "modelo" => 2015,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Carlos Ramírez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Col. La Paz"
            )
        ),
        "UBN6344" => array(
            "Auto" => array(
                "marca" => "BMW",
                "modelo" => 2014,
                "tipo" => "deportivo"
            ),
            "Propietario" => array(
                "nombre" => "Beatriz López",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Av. Juárez"
            )
        ),
        "UBN6345" => array(
            "Auto" => array(
                "marca" => "MERCEDES",
                "modelo" => 2013,
                "tipo" => "SUV"
            ),
            "Propietario" => array(
                "nombre" => "Fernando Díaz",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Blvd. 5 de Mayo"
            )
        ),
        "UBN6346" => array(
            "Auto" => array(
                "marca" => "KIA",
                "modelo" => 2012,
                "tipo" => "hatchback"
            ),
            "Propietario" => array(
                "nombre" => "María González",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Av. Margaritas"
            )
        ),
        "UBN6347" => array(
            "Auto" => array(
                "marca" => "HYUNDAI",
                "modelo" => 2011,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Pablo Herrera",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Calle 3 Sur"
            )
        ),
        "UBN6348" => array(
            "Auto" => array(
                "marca" => "AUDI",
                "modelo" => 2010,
                "tipo" => "deportivo"
            ),
            "Propietario" => array(
                "nombre" => "Lucía Fernández",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Col. El Mirador"
            )
        ),
        "UBN6349" => array(
            "Auto" => array(
                "marca" => "VOLKSWAGEN",
                "modelo" => 2009,
                "tipo" => "camioneta"
            ),
            "Propietario" => array(
                "nombre" => "Raúl Torres",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "San Manuel"
            )
        ),
        "UBN6350" => array(
            "Auto" => array(
                "marca" => "RENAULT",
                "modelo" => 2008,
                "tipo" => "hatchback"
            ),
            "Propietario" => array(
                "nombre" => "Verónica Méndez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Col. La Noria"
            )
        ),
        "UBN6351" => array(
            "Auto" => array(
                "marca" => "PEUGEOT",
                "modelo" => 2007,
                "tipo" => "sedan"
            ),
            "Propietario" => array(
                "nombre" => "Jorge Estrada",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Col. Humboldt"
            )
        ),
        "UBN6352" => array(
            "Auto" => array(
                "marca" => "FIAT",
                "modelo" => 2006,
                "tipo" => "SUV"
            ),
            "Propietario" => array(
                "nombre" => "Gabriela Navarro",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Av. San Francisco"
            )
        )
    );

    return $parqueVehicular;
}

function consultar_vehiculo($parqueVehicular) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['mostrar_todos'])) {
            echo '<h3>Todos los autos registrados:</h3>';
            echo '<pre>';
            print_r($parqueVehicular);
            echo '</pre>';
        } else {
            $matricula = $_POST['matricula'] ?? '';
            if ($matricula == "") {
                echo '<h3>Por favor, ingrese una matrícula.</h3>';
            } else {
                if (isset($parqueVehicular[$matricula])) {
                    $auto = $parqueVehicular[$matricula];
                    echo '<h3>Información del auto con matrícula ' . $matricula . ':</h3>';
                    echo '<p>Marca: ' . $auto['Auto']['marca'] . '</p>';
                    echo '<p>Modelo: ' . $auto['Auto']['modelo'] . '</p>';
                    echo '<p>Tipo: ' . $auto['Auto']['tipo'] . '</p>';
                    echo '<p>Propietario: ' . $auto['Propietario']['nombre'] . '</p>';
                    echo '<p>Ciudad: ' . $auto['Propietario']['ciudad'] . '</p>';
                    echo '<p>Dirección: ' . $auto['Propietario']['direccion'] . '</p>';
                } else {
                    echo '<h3>No se encontró un auto con la matrícula ' . $matricula . '.</h3>';
                }
            }
        }
    }
}
?>