$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `<li>${producto.nombre}</il>`;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(function (e) {
        e.preventDefault();
    
        // Crear el objeto con los datos del formulario
        let postData = {
            nombre: $('#name').val(),
            marca: $('#marca').val(),
            modelo: $('#modelo').val(),
            precio: parseFloat($('#precio').val()),
            unidades: parseInt($('#unidades').val()),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val(),
            id: $('#productId').val() // Este campo será vacío si es un producto nuevo
        };
    
        // Verificar los datos antes de enviarlos
        console.log(postData); // Depuración: Verificar los datos enviados
    
        // Determinar la URL según si es agregar o modificar
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
    
        // Enviar los datos al backend
        $.ajax({
            url: url,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData), // Convertir el objeto a JSON
            success: function (response) {
                console.log(response); // Depuración: Verificar la respuesta del servidor
                let respuesta = JSON.parse(response);
    
                if (respuesta.status === 'success') {
                    let template_bar = '';
                    template_bar += `
                            <li style="list-style: none;">status: ${respuesta.status}</li>
                            <li style="list-style: none;">message: ${respuesta.message}</li>
                        `;
                    alert(respuesta.message);
                    listarProductos(); // Actualizar la lista de productos
                    $('#product-form').trigger('reset'); // Reiniciar el formulario
                    $('button.btn-primary').text("Agregar Producto");
                    $('#container').html(template_bar);
                    edit = false; // Restablecer la bandera de edición
                } else {
                    alert(respuesta.message || 'Error al procesar la solicitud');
                }
            },
            error: function (error) {
                console.error('Error en la solicitud:', error);
            }
        });
    });

    $(document).on('click', '.product-delete', function () {
        let id = $(this).closest('tr').attr('productId'); // Asegúrate de que el atributo productId esté configurado en la fila
    
        if (confirm("¿Estás seguro de eliminar este producto?")) {
            $.ajax({
                url: './backend/product-delete.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: id }),
                success: function (response) {
                    let result = JSON.parse(response);
                    if (result.success) {
                        alert(result.message);
                        listarProductos(); // Actualizar la lista de productos
                    } else {
                        alert(result.error || 'Error al eliminar el producto');
                    }
                },
                error: function (error) {
                    console.error('Error al eliminar el producto:', error);
                }
            });
        }
    });

    $(document).on('click', '.product-item', function(e) {
        const element = $(this)[0].closest('tr');
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#modelo').val(product.modelo);
            $('#marca').val(product.marca);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id);
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
            $('button.btn-primary').text("Modificar Producto");
        });
        e.preventDefault();
    });   

    $('#name').on('blur', validarNombre);
    $('#precio').on('blur', validarPrecio);
    $('#unidades').on('blur', validarUnidades);
    $('#modelo').on('blur', validarModelo);
    $('#marca').on('blur', validarMarca);
    $('#detalles').on('blur', validarDetalles);
    $('#imagen').on('blur', validarImagen);

    // Validar nombre de producto en la base de datos mientras se escribe
    $('#name').on('keyup', function () {
        let nombre = $(this).val().trim();
    
        if (nombre.length < 3) {
            $('#mensaje').html("");
            $('#suggestions').hide();
            $('#container').html("");
            return;
        }
    
        $.ajax({
            url: "./backend/product-name.php",
            type: "GET",
            data: { search: nombre },
            dataType: "json",
            success: function (productos) {
                let template = '';
                let mensaje = '';
    
                if (productos.length === 0) {
                    template = "<li class='list-group-item'>No encontrado</li>";
                    $('#container').html("");
                    $('#product-result').hide();
                } else {
                    productos.forEach(producto => {
                        template += `<li class='list-group-item suggestion-item'>${producto.nombre}</li>`;
                    });
    
                    $('#product-result').show();
                    mensaje = `El producto <strong>${nombre}</strong> ya existe en la base de datos.`;
                }
                $('#suggestions').html(template).show();
                $('#container').html(mensaje);
            },
            error: function (error) {
                console.error("Error en la validación:", error);
            }
        });
    });

    // Autocompletar input cuando se seleccione un producto
    $(document).on("click", ".suggestion-item", function () {
        $("#name").val($(this).text());
        $("#suggestions").hide();
    });

    // Ocultar sugerencias si el usuario hace clic fuera
    $(document).click(function (e) {
        if (!$(e.target).closest("#name, #suggestions").length) {
            $("#suggestions").hide();
        }
    });
});

function validarNombre() {
    let nombre = $('#name').val().trim();
    $('#container').html('');
    if (nombre === "" || nombre.length > 100) {
        $('#product-result').show();
        $('#container').append("<li>El nombre es requerido y debe tener máximo 100 caracteres.</li>");
        return false;
    } else {
        $('#product-result').show();
        $('#container').append("<li>Nombre introducido con éxito.</li>");
        return true;
    }
}

function validarPrecio() {
    let precio = parseFloat($('#precio').val());
    $('#container').html('');
    if (isNaN(precio) || precio <= 99.99) {
        $('#product-result').show();
        $('#container').append("<li>El precio es requerido y debe ser mayor a 99.99.</li>");
        return false;
    } else {
        $('#product-result').show();
        $('#container').append("<li>Precio introducido con éxito.</li>");
        return true;
    }
}

function validarUnidades() {
    let unidades = parseInt($('#unidades').val());
    $('#container').html('');
    if (isNaN(unidades) || unidades < 0) {
        $('#product-result').show();
        $('#container').append("<li>Las unidades deben ser un número mayor o igual a 0.</li>");
        return false;
    } else {
        $('#product-result').show();
        $('#container').append("<li>Unidades introducidas con éxito.</li>");
        return true;
    }
}

function validarModelo() {
    let modelo = $('#modelo').val().trim();
    $('#container').html('');
    if (modelo === "" || modelo.length > 25 || !/^[a-zA-Z0-9]+$/.test(modelo)) {
        $('#product-result').show();
        $('#container').append("<li>El modelo es requerido, alfanumérico y debe tener máximo 25 caracteres.</li>");
        return false;
    } else {
        $('#product-result').show();
        $('#container').append("<li>Modelo introducido con éxito.</li>");
        return true;
    }
}

function validarMarca() {
    let marca = $('#marca').val().trim();
    $('#container').html('');
    if (marca === "") {
        $('#product-result').show();
        $('#container').append("<li>La marca es requerida.</li>");
        return false;
    } else {
        $('#product-result').show();
        $('#container').append("<li>Marca introducida con éxito.</li>");
        return true;
    }
}

function validarDetalles() {
    let detalles = $('#detalles').val().trim();
    if (detalles.length > 250) {
        $('#product-result').show();
        $('#container').append("<li>Los detalles no deben superar los 250 caracteres.</li>");
        return false;
    } else {
        return true;
    }
}

function validarImagen() {
    let imagen = $('#imagen').val().trim();
    if (imagen === "") {
        let finalJSON = {};
        finalJSON['imagen'] = 'imagen/default.png';
        return false;
    } else {
        return true;
    }
}