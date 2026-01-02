<?php
session_start();
if (!isset($_SESSION["email"])) { header("Location: ../login.php"); exit; }
require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = abrirConexion();
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = limpiar($_POST["dni"]);
    $nombre = limpiar($_POST["nombre"]);
    $telefono = limpiar($_POST["telefono"]);
    $email = limpiar($_POST["email"]);

    if (empty($dni)) $errores[] = "El DNI es obligatorio.";
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";

    if (empty($errores)) {
        $sql = "INSERT INTO clientes (dni, nombre, telefono, email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $dni, $nombre, $telefono, $email);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        } else {
            $errores[] = "Error SQL: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <form method="POST" action="crear.php" onsubmit="return validarCliente()">
        <h1>Registrar Cliente</h1>

        <?php if (!empty($errores)): ?>
            <ul><?php foreach ($errores as $e) echo "<li>$e</li>"; ?></ul>
        <?php endif; ?>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required class="input-estilo">

        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" required class="input-estilo">

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required class="input-estilo">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="input-estilo">

        <input type="submit" value="Guardar Cliente">
        <div style="text-align:center; margin-top:20px;"><a href="listar.php">Cancelar</a></div>
    </form>

    <?php cerrarConexion($conexion); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/validaciones.js"></script>
</body>
</html>