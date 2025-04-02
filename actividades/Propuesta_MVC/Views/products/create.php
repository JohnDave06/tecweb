<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
            <h1 class="mt-4">Agregar Producto</h1>
            <form id="add-product-form" action="/tecweb/actividades/Propuesta_MVC/products/add" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="unidades">Unidades</label>
                    <input type="number" name="unidades" id="unidades" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="detalles">Detalles</label>
                    <textarea name="detalles" id="detalles" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    <input type="text" name="imagen" id="imagen" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Agregar Producto</button>
            </form>
        </div>
    </div>
    <script>
    document.getElementById('add-product-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío normal del formulario

        const formData = new FormData(this);

        fetch('/tecweb/actividades/Propuesta_MVC/products/add', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                window.location.href = '/tecweb/actividades/Propuesta_MVC/products/list';
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</body>
</html>