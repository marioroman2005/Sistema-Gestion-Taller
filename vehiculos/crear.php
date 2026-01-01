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

// Procesar Formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = limpiar($_POST["matricula"]);
    $marca = limpiar($_POST["marca"]);
    $modelo = limpiar($_POST["modelo"]);
    $id_cliente = (int)$_POST["id_cliente"];

    // Validaciones
    if (empty($matricula)) $errores[] = "La matrícula es obligatoria.";
    if (empty($marca)) $errores[] = "La marca es obligatoria.";
    if (empty($modelo)) $errores[] = "El modelo es obligatorio.";
    if ($id_cliente <= 0) $errores[] = "Debes seleccionar un cliente.";

    // Verificar duplicidad de matrícula
    if (empty($errores)) {
        $sql_check = "SELECT id_vehiculo FROM vehiculos WHERE matricula = ?";
        $stmt_check = mysqli_prepare($conexion, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $matricula);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $errores[] = "Ya existe un vehículo con esa matrícula.";
        }
        mysqli_stmt_close($stmt_check);
    }

    // Insertar
    if (empty($errores)) {
        $sql = "INSERT INTO vehiculos (matricula, marca, modelo, id_cliente) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $matricula, $marca, $modelo, $id_cliente);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        } else {
            $errores[] = "Error al guardar: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }
}

// Obtener clientes para el select
$sql_clientes = "SELECT id_cliente, nombre FROM clientes ORDER BY nombre ASC";
$res_clientes = mysqli_query($conexion, $sql_clientes);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Vehículo - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

    <form method="POST" action="crear.php">
        <h1>Registrar Vehículo</h1>

        <?php if (!empty($errores)): ?>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li style="color: red;"><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" id="matricula" value="<?= isset($_POST['matricula']) ? htmlspecialchars($_POST['matricula']) : '' ?>" required>

        <label for="marca">Marca:</label>
        <input type="text" name="marca" id="marca" value="<?= isset($_POST['marca']) ? htmlspecialchars($_POST['marca']) : '' ?>" required>

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" value="<?= isset($_POST['modelo']) ? htmlspecialchars($_POST['modelo']) : '' ?>" required>

        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" id="id_cliente" required style="width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 2px solid #e1e4e8; background: #f9f9f9;">
            <option value="">-- Seleccionar Cliente --</option>
            <?php while ($c = mysqli_fetch_assoc($res_clientes)): ?>
                <option value="<?= $c['id_cliente'] ?>" <?= (isset($_POST['id_cliente']) && $_POST['id_cliente'] == $c['id_cliente']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Guardar Vehículo">

        <div style="text-align: center; margin-top: 20px;">
            <a href="listar.php" style="color: #666; text-decoration: none;">Cancelar</a>
        </div>
    </form>

    <?php cerrarConexion($conexion); ?>

    <script src="../js/validaciones.js"></script>
</body>

</html>
