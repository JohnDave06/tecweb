<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Gracias por participar!</title>
    <style>
        body {
            background-color: #d4edda;
            color: #155724;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            color: #0c3;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <h1>¡MUCHAS GRACIAS!</h1>
    <p>Estos son los datos que has enviado:</p>
    <ul>
        <li><strong>Nombre:</strong> <?= htmlspecialchars($_POST['name']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($_POST['email']) ?></li>
        <li><strong>Teléfono:</strong> <?= htmlspecialchars($_POST['phone']) ?></li>
        <li><strong>Razón:</strong> <?= nl2br(htmlspecialchars($_POST['reason'])) ?></li>
        <li><strong>Color elegido:</strong> <?= htmlspecialchars($_POST['color']) ?></li>
        <li><strong>Características seleccionadas:</strong>
            <ul>
                <?php
                if (isset($_POST['features'])) {
                    foreach ($_POST['features'] as $feature) {
                        echo "<li>" . htmlspecialchars($feature) . "</li>";
                    }
                } else {
                    echo "<li>Ninguna</li>";
                }
                ?>
            </ul>
        </li>
        <li><strong>Talla:</strong> <?= htmlspecialchars($_POST['size']) ?></li>
    </ul>
</body>
</html>
