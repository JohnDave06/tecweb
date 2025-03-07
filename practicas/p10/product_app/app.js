// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "marca": "NA",
    "modelo": "XX-000",
    "precio": 0.0,
    "detalles": "NA",
    "unidades": 1,
    "imagen": "imagen/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar por ID"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('searchID').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos[0].precio+'</li>';
                    descripcion += '<li>unidades: '+productos[0].unidades+'</li>';
                    descripcion += '<li>modelo: '+productos[0].modelo+'</li>';
                    descripcion += '<li>marca: '+productos[0].marca+'</li>';
                    descripcion += '<li>detalles: '+productos[0].detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos[0].id}</td>
                            <td>${productos[0].nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("searchID="+id);
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar por nombre, marca o detalles"
function buscarProducto(event) {
    event.preventDefault(); // Evita el envío automático del formulario

    const search = document.getElementById('searchTerm').value;

    fetch('backend/read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `search=${encodeURIComponent(search)}`,
    })
    .then(response => response.json())
    .then(data => {
        const resultados = document.getElementById('productos');
        resultados.innerHTML = '';

        if (data.length > 0) {
            data.forEach(producto => {
                let descripcion = '';
                descripcion += '<li>precio: '+producto.precio+'</li>';
                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                descripcion += '<li>marca: '+producto.marca+'</li>';
                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                
                let template = '';
                template += `
                    <tr>
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                    </tr>
                `;
                resultados.innerHTML += template;
            });
        } else {
            resultados.innerHTML = '<tr><td colspan="3">No se encontraron productos.</td></tr>';
        }
    })
    .catch(error => console.error('Error:', error));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;

    // VALIDACIONES
    if (finalJSON['nombre'].trim() === "" || finalJSON['nombre'].length > 100) {
        alert("El nombre es requerido y debe tener máximo 100 caracteres.");
        return;
    }
    if (finalJSON['marca'].trim() === "") {
        alert("La marca es requerida.");
        return;
    }
    if (finalJSON['modelo'].trim() === "" || finalJSON['modelo'].length > 25 || !/^[a-zA-Z0-9]+$/.test(finalJSON['modelo'])) {
        alert("El modelo es requerido, alfanumérico y debe tener máximo 25 caracteres.");
        return;
    }
    if (isNaN(finalJSON['precio']) || finalJSON['precio'] <= 99.99) {
        alert("El precio es requerido y debe ser mayor a 99.99.");
        return;
    }
    if (finalJSON['detalles'].length > 250) {
        alert("Los detalles no deben superar los 250 caracteres.");
        return;
    }
    if (isNaN(finalJSON['unidades']) || finalJSON['unidades'] < 0) {
        alert("Las unidades deben ser un número mayor o igual a 0.");
        return;
    }
    if (finalJSON['imagen'].trim() === "") {
        finalJSON['imagen'] = "imagen/default.png";
    }

    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            alert(client.responseText);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}