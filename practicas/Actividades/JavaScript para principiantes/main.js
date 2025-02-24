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