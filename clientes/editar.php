<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = abrirConexion();
$errores = [];
$id_cliente = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_cliente <= 0) {
    header("Location: listar.php");
    exit;
}

// Procesar formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = (int)$_POST["id_cliente"];
    $dni = limpiar($_POST["dni"]);
    $nombre = limpiar($_POST["nombre"]);
    $telefono = limpiar($_POST["telefono"]);
    $email = limpiar($_POST["email"]);

    if (empty($dni)) $errores[] = "El DNI es obligatorio.";
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";

    if (empty($errores)) {
        $sql = "UPDATE clientes SET dni = ?, nombre = ?, telefono = ?, email = ? WHERE id_cliente = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $dni, $nombre, $telefono, $email, $id_cliente);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        } else {
            $errores[] = "Error al actualizar: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }
}

// Obtener datos del cliente actual
$sql_datos = "SELECT * FROM clientes WHERE id_cliente = $id_cliente";
$res_datos = mysqli_query($conexion, $sql_datos);
$cliente = mysqli_fetch_assoc($res_datos);

if (!$cliente) {
    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Cliente - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

    <form method="POST" action="editar.php?id=<?= $id_cliente ?>">
        <h1>Editar Cliente #<?= $id_cliente ?></h1>

        <?php if (!empty($errores)): ?>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">

        <label for="dni">DNI / NIF:</label>
        <input type="text" name="dni" id="dni" value="<?= htmlspecialchars($cliente['dni']) ?>" required style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($cliente['email']) ?>" style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <input type="submit" value="Actualizar Cliente">

        <div style="text-align: center; margin-top: 20px;">
            <a href="listar.php" style="color: #666; text-decoration: none;">Cancelar</a>
        </div>
    </form>

    <?php cerrarConexion($conexion); ?>
</body>
</html>