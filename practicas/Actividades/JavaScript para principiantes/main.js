// Ejercicio de muestra
function getDatos()
{
    var nombre = prompt("Nombre: ", "");

    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

// JS01 Introducción a JavaScript
function holamundo()
{
    alert("Hola Mundo");
}

// JS02 Variables, Entradas, Operadores
function variable()
{
    var nombre = "Juan";
    var edad = 20;
    var altura = 1.70;
    var casado = false;
    alert("Nombre: "+nombre+" Edad: " +edad  +" Altura: "+altura+" Casado: "+casado);
}

function variable2()
{
    var nombre = prompt("ingresa tu nombre: ", "");
    var edad = prompt("ingresa tu edad: ", "");
    alert("Hola: "+nombre+" , asi que tienes: " +edad+" años.");
}

// JS03 Estructuras de Condición
function estructurada()
{
    var numero = prompt("ingresa primer numero: ", '');
    var num = prompt("ingresa segundo numero: ", '');
    var suma = parseInt(numero) + parseInt(num);
    var multi = parseInt(numero) * parseInt(num);

    alert("La suma de los numeros es: "+suma);
    alert("La multiplicacion de los numeros es: "+multi);
}

function sentenciaif()
{
    var nombre = prompt("ingresa tu nombre: ", "");
    var nota = prompt("ingresa tu nota: ", '');

    if(nota >= 4)
    {
        alert("Felicidades "+nombre+", has aprobado con: "+nota);
    }
}

function sentenciaifelse()
{
    var numero1 = prompt("ingresa el primer numero: ", '');
    var numero2 = prompt("ingresa el segundo numero: ", '');

    numero1 = parseInt(numero1);
    numero2 = parseInt(numero2);

    if(numero1 > numero2)
    {
        alert("El numero mayor es: "+numero1);
    }
    else
    {
        alert("El numero mayor es: "+numero2);
    }
}

function sentenciaifelseif()
{
    var nota1 = prompt("ingresa 1ra. nota : ", '');
    var nota2 = prompt("ingresa 2da. nota : ", '');
    var nota3 = prompt("ingresa 3ra. nota : ", '');

    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    prome = (nota1 + nota2 + nota3) / 3;

    if (prome >= 7)
    {
        alert("Aprobado con: "+prome);
    }
    else 
    {
        if (prome >= 4)
        {
            alert("Regular con: "+prome);
        }
        else
        {
            alert("repobado con: "+prome);
        }
    }
}

function sentenciaswitch()
{
    var valor = prompt("ingresa un valor comprendido entre 1 y 5: ", '');
    //convertir a entero
    valor = parseInt(valor);

    switch(valor)
    {
        case 1:
            alert("uno");
            break;
        case 2:
            alert("dos");
            break;
        case 3:
            alert("tres");
            break;
        case 4:
            alert("cuatro");
            break;
        case 5:
            alert("cinco");
            break;
        default:
            alert("valor fuera de rango");
    }
}

function sentenciaswitch2()
{
    var col = prompt("ingresa el color con que quieras pintar el fondo de la ventana (rojo,verde,azul) ", '');

    switch(col)
    {
        case 'rojo':
            document.bgColor = 'red';
            break;
        case 'verde':
            document.bgColor = 'green';
            break;
        case 'azul':
            document.bgColor = 'blue';
            break;
        default:
            alert("color no valido");
    }
}

// JS04 Estructuras de Repetición
function sentenciawhile()
{
    var x = 1;
    while(x <= 10)
    {
        alert(x);
        x++;
    }
}

function sentenciawhile2()
{
    var x = 1;
    var suma = 0;
    var valor;

    while(x <= 5)
    {
        var valor = prompt("ingresa el valor : ", '');
        valor = parseInt(valor);
        suma += valor;
        x++;
    }

    alert("La suma de los valoes es: "+suma);
}

function sentenciadowhile()
{
    var valor ;
    do
    {
        valor = prompt("ingresa un valor entre 0 y 999: ", '');
        valor = parseInt(valor);
        alert (" valor ingresado: "+valor);
        if (valor < 10)
        {
            alert("tiene 1 digito");
        }else   
        {
            if (valor < 100)
            {
                alert("tiene 2 digitos");
            }else
            {
                alert("tiene 3 digitos");
            }
        }
    }while(valor != 0);
}

function sentenciafor()
{
    var i;
    for(i = 1; i <= 10; i++)
    {
        alert(i);
    }
}

// JS05 Funciones
function implementacion()
{
    alert("cuiado "+" ingresa tu documento correctamente");
    alert("cuiado "+" ingresa tu documento correctamente");
    alert("cuiado "+" ingresa tu documento correctamente");
}

function implementacion2()
{
    function mensaje()
    {
        alert("cuiado "+" ingresa tu documento correctamente");
    }
    mensaje();
    mensaje();
    mensaje();   
}

function implementacion3()
{
    var valor1 = prompt("ingresa el valor inferior : ", '');
    var valor2 = prompt("ingresa el valor superior : ", '');
    valor1 = parseInt(valor1);
    valor2 = parseInt(valor2);
    function mostrarrango(valor1, valor2)
    {
        var i;
        for(i = valor1; i <= valor2; i++)
        {
            alert(i);
        }
    }
    mostrarrango(valor1, valor2);

}

function retorno()
{
    function convertirCastellano(x)
    {
        if (x == 1)
        {
            return "uno";
        }else
        {
            if (x == 2)
            {
                return "dos";
            }else
            {
                if (x == 3)
                {
                    return "tres";
                }else
                {
                    if (x == 4)
                    {
                        return "cuatro";
                    }
                    else
                    {
                        if (x == 5)
                        {
                            return "cinco";
                        }
                        else
                        {
                            return "numero no valido";
                        }
                    }
                }
            }
        }
    }
    var valor = prompt("ingresa un valor entre 1 y 5: ", '');
    valor = parseInt(valor);
    alert(convertirCastellano(valor));
}

function retorno2()
{
    function convertirCastellano(x)
    {
        switch(x)
        {
            case 1:
                return "uno";
            case 2:
                return "dos";
            case 3:
                return "tres";
            case 4:
                return "cuatro";
            case 5:
                return "cinco";
            default:
                return "numero no valido";
        }
    }
    var valor = prompt("ingresa un valor entre 1 y 5: ", '');
    valor = parseInt(valor);
    alert(convertirCastellano(valor));
}