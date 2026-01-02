<?php
session_start();
if (!isset($_SESSION["email"])) { header("Location: ../login.php"); exit; }
require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = abrirConexion();
$errores = [];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST["id_cliente"];
    $dni = limpiar($_POST["dni"]);
    $nombre = limpiar($_POST["nombre"]);
    $telefono = limpiar($_POST["telefono"]);
    $email = limpiar($_POST["email"]);

    if (empty($dni) || empty($nombre)) $errores[] = "Faltan datos obligatorios.";

    if (empty($errores)) {
        $sql = "UPDATE clientes SET dni=?, nombre=?, telefono=?, email=? WHERE id_cliente=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $dni, $nombre, $telefono, $email, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        }
    }
}

$sql_datos = "SELECT * FROM clientes WHERE id_cliente = $id";
$res = mysqli_query($conexion, $sql_datos);
$cliente = mysqli_fetch_assoc($res);
if (!$cliente) header("Location: listar.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <form method="POST" action="editar.php?id=<?= $id ?>" onsubmit="return validarCliente()">
        <h1>Editar Cliente #<?= $id ?></h1>

        <?php if (!empty($errores)): ?>
            <ul><?php foreach ($errores as $e) echo "<li>$e</li>"; ?></ul>
        <?php endif; ?>

        <input type="hidden" name="id_cliente" value="<?= $id ?>">

        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" value="<?= htmlspecialchars($cliente['dni']) ?>" required class="input-estilo">

        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required class="input-estilo">

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required class="input-estilo">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($cliente['email']) ?>" class="input-estilo">

        <input type="submit" value="Actualizar Cliente">
        <div style="text-align:center; margin-top:20px;"><a href="listar.php">Cancelar</a></div>
    </form>

    <?php cerrarConexion($conexion); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/validaciones.js"></script>
</body>
</html>