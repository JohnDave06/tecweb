<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<?php
    $data = array();

    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', 'contraseña_6', 'marketzone');
    /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

    /** comprobar la conexión */
    if ($link->connect_errno) 
    {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
    }

    /** Consulta para obtener los productos vigentes */
    if ($result = $link->query("SELECT * FROM productos WHERE eliminado = 0")) 
    {
        /** Se extraen las tuplas obtenidas de la consulta */
        $row = $result->fetch_all(MYSQLI_ASSOC);

        /** Se crea un arreglo con la estructura deseada */
        foreach($row as $num => $registro) {
            foreach($registro as $key => $value) {
                $data[$num][$key] = ($value);
            }
        }

        /** útil para liberar memoria asociada a un resultado con demasiada información */
        $result->free();
    }

    $link->close();
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos Vigentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h3 class="mt-4">PRODUCTOS VIGENTES</h3>
        <br/>
        <?php if (!empty($data)) : ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $producto) : ?>
                        <tr>
                            <th scope="row"><?= $producto['id'] ?></th>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= $producto['marca'] ?></td>
                            <td><?= $producto['modelo'] ?></td>
                            <td><?= $producto['precio'] ?></td>
                            <td><?= $producto['unidades'] ?></td>
                            <td><?= $producto['detalles'] ?></td>
                            <td><img src="<?= $producto['imagen'] ?>" width="100" height="100" alt="Imagen del producto" /></td>
                            <td>
                                <a href="formulario_productos_v2.html?id=<?= $producto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No se encontraron productos vigentes.</p>
        <?php endif; ?>
    </div>
</body>
</html>