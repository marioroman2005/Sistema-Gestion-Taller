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

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = limpiar($_POST["dni"]);
    $nombre = limpiar($_POST["nombre"]);
    $telefono = limpiar($_POST["telefono"]);
    $email = limpiar($_POST["email"]);

    // Validaciones básicas
    if (empty($dni)) $errores[] = "El DNI es obligatorio.";
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($telefono)) $errores[] = "El teléfono es obligatorio.";

    if (empty($errores)) {
        $sql = "INSERT INTO clientes (dni, nombre, telefono, email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $dni, $nombre, $telefono, $email);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        } else {
            $errores[] = "Error al guardar (posible DNI duplicado): " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Cliente - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

    <form method="POST" action="crear.php" onsubmit="return validarCliente()">
    <h1>Registrar Cliente</h1>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/plugins.js"></script>z
    <script src="../js/validaciones.js"></script>

        <?php if (!empty($errores)): ?>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <label for="dni">DNI / NIF:</label>
        <input type="text" name="dni" id="dni" value="<?= isset($_POST['dni']) ? $_POST['dni'] : '' ?>" required style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>" required style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= isset($_POST['telefono']) ? $_POST['telefono'] : '' ?>" required style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" style="display: block; width: 100%; padding: 12px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <input type="submit" value="Guardar Cliente">

        <div style="text-align: center; margin-top: 20px;">
            <a href="listar.php" style="color: #666; text-decoration: none;">Cancelar</a>
        </div>
    </form>

    <?php cerrarConexion($conexion); ?>
</body>
</html>