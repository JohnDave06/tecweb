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

    $('#product-form').submit(e => {
        e.preventDefault();

        var finalJSON = {};
        finalJSON['nombre'] = $('#name').val();
        finalJSON['marca'] = $('#marca').val();
        finalJSON['modelo'] = $('#modelo').val();
        finalJSON['precio'] = $('#precio').val();
        finalJSON['detalles'] = $('#detalles').val();
        finalJSON['unidades'] = $('#unidades').val();
        finalJSON['imagen'] = $('#imagen').val();
        $('#container').html('');

         // VALIDACIONES
        if (!validarNombre() || !validarMarca() || !validarModelo() || !validarPrecio() || !validarUnidades() || !validarDetalles()) {
            $('#product-result').show();
            return;
        }

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        let postData = {
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        nombre: $('#name').val(),
        marca: $('#marca').val(),
        modelo: $('#modelo').val(),
        precio: parseFloat($('#precio').val()),
        unidades: parseInt($('#unidades').val()),
        detalles: $('#detalles').val(),
        imagen: $('#imagen').val(),
        id: $('#productId').val()
        };

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
                console.log(response);
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                let respuesta = JSON.parse(response);
                // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
                let template_bar = '';
                template_bar += `
                            <li style="list-style: none;">status: ${respuesta.status}</li>
                            <li style="list-style: none;">message: ${respuesta.message}</li>
                        `;
                // SE REINICIA EL FORMULARIO
                $('#product-form').trigger('reset');
                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').show();
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
                // SE REGRESA LA BANDERA DE EDICIÓN A false
                $('button.btn-primary').text("Agregar Producto");
                edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
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