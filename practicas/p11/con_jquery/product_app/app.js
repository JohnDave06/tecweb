$(document).ready(function() {
    // Inicializar la aplicación
    init();

    // Evita el envío del formulario de búsqueda
    $('#search-form').submit(function(e) {
        e.preventDefault();
        buscarProducto();
    });

    // Ejecuta la búsqueda al escribir
    $('#search').on('input', buscarProducto);

    // Agregar producto
    $('#product-form').submit(agregarProducto);
});

let edit = false; // Variable para saber si se está editando un producto

// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "imagen/default.png"
};

function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    listarProductos();
}

// FUNCIÓN CALLBACK AL CARGAR LA PÁGINA O AL AGREGAR UN PRODUCTO
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            let productos = JSON.parse(response);
            let template = '';

            productos.forEach(producto => {
                let descripcion = `
                    <li>Precio: ${producto.precio}</li>
                    <li>Unidades: ${producto.unidades}</li>
                    <li>Modelo: ${producto.modelo}</li>
                    <li>Marca: ${producto.marca}</li>
                    <li>Detalles: ${producto.detalles}</li>
                `;

                template += `
                    <tr productId="${producto.id}">
                        <td>${producto.id}</td>
                        <td>
                            <a href="#" class="product-item">${producto.nombre}</a>
                        </td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-delete btn btn-danger" data-id="${producto.id}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#products').html(template);
            $('#product-result').show();
        }
    });
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarProducto() {
    let search = $('#search').val().trim();

    if (search) {
        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search },
            success: function(response) {
                let productos = JSON.parse(response);
                let template = '';
                let template_bar = '';

                if (productos.length > 0) {
                    productos.forEach(producto => {
                        let descripcion = `
                            <li>Precio: ${producto.precio}</li>
                            <li>Unidades: ${producto.unidades}</li>
                            <li>Modelo: ${producto.modelo}</li>
                            <li>Marca: ${producto.marca}</li>
                            <li>Detalles: ${producto.detalles}</li>
                        `;

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>
                                    <a href="#" class="product-item">${producto.nombre}</a>
                                </td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" data-id="${producto.id}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;

                        template_bar += `<li>${producto.nombre}</li>`;
                    });

                    $('#container').html(template_bar);
                    $('#product-result').removeClass('d-none').show();
                } else {
                    echo = "No hay productos que coincidan con la búsqueda.";
                    $('#container').html(echo);
                }

                $('#products').html(template);
            }
        });
    } else {
        $('#product-result').hide();
    }
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto o Actualizar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = $('#description').val();
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = $('#nombre').val();
    let id = $('#productId').val();

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
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    // SE DEFINE LA URL DEPENDIENDO SI SE ESTÁ EDITANDO O AGREGANDO
    let url = edit ? './backend/product-update.php' : './backend/product-add.php';

    // SE ENVÍA EL JSON AL SERVIDOR
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id, ...finalJSON}),
        success: function(response) {
            let respuesta = JSON.parse(response);
            $('#product-result').addClass('d-block');
            $('#container').html(`
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>`);

            listarProductos();
            $('#product-form').trigger('reset');
            $('#description').val(JSON.stringify(baseJSON, null, 2)); // Restaurar el JSON base en el formulario
            $('#change').text("Agregar Producto");
            edit = false;
        }
    });
}

// FUNCIÓN CALLBACK DE BOTÓN "Eliminar Producto"
$(document).on('click', '.product-delete', function () {
    if (confirm("¿Estas seguro de eliminar el Producto?")) {
        let id = $(this).closest('tr').attr('productId');
        $.get(`./backend/product-delete.php?id=${id}`, function (response) {
            let respuesta = JSON.parse(response);
            $('#product-result').addClass('d-block');
            $('#container').html(`
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>`);
            listarProductos();
        });
    }
});

// FUNCIÓN CALLBACK DE BOTÓN "Editar Producto"
$(document).on('click', '.product-item', function () {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr('productId');
    edit = true;

    $.post('./backend/product-single.php', { id }, function (response) {
            const producto = JSON.parse(response);

            // Llenar los campos del formulario con los datos del producto
            $('#nombre').val(producto.nombre);
            $('#productId').val(producto.id);

            // Reemplazar valores de baseJSON con los del producto temporal
            let tempJSON = { ...baseJSON }; // Copia baseJSON sin modificarlo
            tempJSON.precio = producto.precio || tempJSON.precio;
            tempJSON.unidades = producto.unidades || tempJSON.unidades;
            tempJSON.modelo = producto.modelo || tempJSON.modelo;
            tempJSON.marca = producto.marca || tempJSON.marca;
            tempJSON.detalles = producto.detalles || tempJSON.detalles;
            tempJSON.imagen = producto.imagen || tempJSON.imagen;

            // Mostrar el JSON en el textarea
            $('#description').val(JSON.stringify(tempJSON, null, 2));
            $('#change').text("Actualizar Producto");
    });
});