$(document).ready(function() {
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/Read/Read.php?action=list',
            type: 'GET',
            dataTypr: 'json',
            success: function(response) {
                const productos = JSON.parse(response);
                if(Object.keys(productos).length > 0) {
                    let template = '';
                    productos.forEach(producto => {
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
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/Read/Read.php',
                type: 'GET',
                data: {
                    action: 'search',
                    search: search
                },
                success: function (response) {
                    if(!response.error) {
                        const productos = JSON.parse(response);
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';
                            productos.forEach(producto => {
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

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            $('#product-result').show();
                            $('#container').html(template_bar);
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

    $('#form-nombre').on('keyup', function() {
        const nombre = $(this).val();
        if (nombre) {
            const cn = edit ? './backend/Update/Update.php?action=checkName' : './backend/Create/Create.php?action=checkName';
            $.ajax({
                url: cn,
                type: 'POST',
                data: { nombre },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.exists) {
                        let template_bar = `
                            <li style="list-style: none;">status: error</li>
                            <ul><li>El nombre del producto ya existe.</li></ul>
                        `;
                        $('#product-result').show();
                        $('#container').html(template_bar);
                    } else {
                        $('#product-result').hide();
                    }
                }
            });
        }
    })

    function validarCampo(campo, valor) {
        let mensaje = '';
        switch (campo) {
            case 'nombre':
                if (!valor || valor.length > 100) {
                    mensaje = 'El nombre es requerido y debe tener una longitud máxima de 100 caracteres.';
                }
                break;
            case 'marca':
                if (!valor || valor.trim() === '') {
                    mensaje = 'La marca es requerida.';
                }
                break;
            case 'modelo':
                if (!valor || valor.length > 25 || !/^[a-zA-Z0-9]+$/.test(valor)) {
                    mensaje = 'El modelo es requerido, debe tener una longitud máxima de 25 caracteres y debe ser alfanumérico.';
                }
                break;
            case 'precio':
                if (!valor || isNaN(valor) || valor < 99.99) {
                    mensaje = 'El precio es requerido y debe ser mayor a 99.99.';
                }
                break;
            case 'detalles':
                if (valor && valor.length > 250) {
                    mensaje = 'Los detalles no deben exceder los 250 caracteres.';
                }
                break;
            case 'unidades':
                if (! valor || isNaN(valor) || valor < 0) {
                    mensaje = 'El número de unidades es requerido y debe ser mayor o igual a 0.';
                }
                break;
            case 'imagen':
                if (!valor || valor.trim() === '') {
                    valor = 'imagen/default.png';
                }
                break;
        }
        return mensaje;
    }

    function mostrarErrores() {
        let postData = {
            nombre: $('#form-nombre').val(),
            marca: $('#form-marca').val(),
            modelo: $('#form-modelo').val(),
            precio: $('#form-precio').val(),
            detalles: $('#form-detalles').val(),
            unidades: $('#form-unidades').val(),
            imagen: $('#form-imagen').val()
        };

        let data = {
            status: 'error',
            message: ''
        };

        let cont = 0;

        for (let campo in postData) {
            let mensaje = validarCampo(campo, postData[campo]);
            if (mensaje) {
                data.message += `<li>${mensaje}</li>`;
                cont++;
            }
        }

        if (cont > 0) {
            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${data.status}</li>
                <ul>${data.message}</ul>
            `;
            $('#product-result').show();
            $('#container').html(template_bar);
        } else {
            $('#product-result').hide();
        }
    }

    $('#product-form input, #product-form textarea').on('blur', function() {
        mostrarErrores();
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        let postData = {
            id: $('#form-id').val(),
            nombre: $('#form-nombre').val(),
            marca: $('#form-marca').val(),
            modelo: $('#form-modelo').val(),
            precio: parseFloat($('#form-precio').val()),
            detalles: $('#form-detalles').val(),
            unidades: parseInt($('#form-unidades').val()),
            imagen: $('#form-imagen').val()
        };
        console.log(postData);
        if (!validarFormulario(postData)) {
            return;
        }
        const url = edit ? './backend/Update/Update.php?action=edit' : './backend/Create/Create.php?action=add';

        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);

            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;

            $('#product-form')[0].reset();
            $('#product-result').show();
            $('#container').html(template_bar);
            listarProductos();
            $('button.btn-primary').text("Agregar Producto");
            edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(e.target).closest('tr');
            const id = $(element).attr('productId');
            $.post('./backend/Delete/Delete.php', { id }, (response) => {
                let respuesta = JSON.parse(response);
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
    
                $('#product-result').show();
                $('#container').html(template_bar);
    
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(e.target).closest('tr');
        const id = $(element).attr('productId');
        $.post('./backend/Read/Read.php?action=single', {id}, (response) => {
            let product = JSON.parse(response);
            $('#form-nombre').val(product.nombre);
            $('#form-marca').val(product.marca);
            $('#form-modelo').val(product.modelo);
            $('#form-precio').val(product.precio);
            $('#form-detalles').val(product.detalles);
            $('#form-unidades').val(product.unidades);
            $('#form-imagen').val(product.imagen);
            $('#form-id').val(product.id);
            edit = true;
            $('button.btn-primary').text("Modificar Producto");
        });
        e.preventDefault();
    });

    function validarFormulario(postData) {
        let cont = 0;
        let data = {
            status: 'error',
            message: ''
        };
    
        if (!postData.nombre || postData.nombre.length > 100) {
            data.message += '<li>El nombre es requerido y debe tener una longitud máxima de 100 caracteres.</li>';
            cont++;
        }
    
        if (!postData.marca || postData.marca.trim() === '') {
            data.message += '<li>La marca es requerida.</li>';
            cont++;
        }
    
        if (!postData.modelo || postData.modelo.length > 25 || !/^[a-zA-Z0-9]+$/.test(postData.modelo)) {
            data.message += '<li>El modelo es requerido, debe tener una longitud máxima de 25 caracteres y debe ser alfanumérico.</li>';
            cont++;
        }
    
        if (!postData.precio || isNaN(postData.precio) || postData.precio < 99.99) {
            data.message += '<li>El precio es requerido y debe ser mayor a 99.99.</li>';
            cont++;
        }
    
        if (postData.detalles && postData.detalles.length > 250) {
            data.message += '<li>Los detalles no deben exceder los 250 caracteres.</li>';
            cont++;
        }
    
        if (!postData.unidades || isNaN(postData.unidades) || postData.unidades < 0) {
            data.message += '<li>El número de unidades es requerido y debe ser mayor o igual a 0.</li>';
            cont++;
        }
    
        if (!postData.imagen || postData.imagen.trim() === '') {
            postData.imagen = 'img/default.png';
        }
    
        if (cont > 0) {
            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${data.status}</li>
                <ul>${data.message}</ul>
            `;
            $('#product-result').show();
            $('#container').html(template_bar);
            return false;
        }
    
        return true;
    }
});