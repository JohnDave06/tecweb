<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
</head>
<body>
    <!-- BARRA DE NAVEGACIÓN  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">ProductApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto"></ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" name="search" id="search" type="search" placeholder="ID, marca o descripción" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
    </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Lista de Productos</h1>
        <a href="/tecweb/actividades/Propuesta_MVC/products/create" class="btn btn-primary mb-3">Agregar Producto</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Detalles</th>
                    <th>Unidades</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['id']) ?></td>
                            <td><?= htmlspecialchars($product['nombre']) ?></td>
                            <td><?= htmlspecialchars($product['marca']) ?></td>
                            <td><?= htmlspecialchars($product['modelo']) ?></td>
                            <td><?= htmlspecialchars($product['precio']) ?></td>
                            <td><?= htmlspecialchars($product['detalles']) ?></td>
                            <td><?= htmlspecialchars($product['unidades']) ?></td>
                            <td>
                            <a href="/tecweb/actividades/Propuesta_MVC/products/edit?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <form action="/tecweb/actividades/Propuesta_MVC/products/delete" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay productos disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script>
    document.getElementById('search').addEventListener('input', function() {
        const query = this.value;
        fetch(`/tecweb/actividades/Propuesta_MVC/products/search?search=${query}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(product => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${product.id}</td>
                                <td>${product.nombre}</td>
                                <td>${product.marca}</td>
                                <td>${product.modelo}</td>
                                <td>${product.precio}</td>
                                <td>${product.detalles}</td>
                                <td>${product.unidades}</td>
                                <td>
                                    <a href="/tecweb/actividades/Propuesta_MVC/products/edit?id=${product.id}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="/tecweb/actividades/Propuesta_MVC/products/delete" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="${product.id}">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center">No hay productos disponibles</td></tr>';
                }
            });
    });
</script>
</body>
</html>