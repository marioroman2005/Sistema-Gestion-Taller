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
$id_vehiculo = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_vehiculo <= 0) {
    header("Location: listar.php");
    exit;
}

// Procesar Formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_vehiculo = (int)$_POST["id_vehiculo"];
    $matricula = limpiar($_POST["matricula"]);
    $marca = limpiar($_POST["marca"]);
    $modelo = limpiar($_POST["modelo"]);
    $id_cliente = (int)$_POST["id_cliente"];

    // Validaciones
    if (empty($matricula)) $errores[] = "La matrícula es obligatoria.";
    if (empty($marca)) $errores[] = "La marca es obligatoria.";
    if (empty($modelo)) $errores[] = "El modelo es obligatorio.";
    if ($id_cliente <= 0) $errores[] = "Debes seleccionar un cliente.";

    // Verificar duplicidad de matrícula (excluyendo el actual)
    if (empty($errores)) {
        $sql_check = "SELECT id_vehiculo FROM vehiculos WHERE matricula = ? AND id_vehiculo != ?";
        $stmt_check = mysqli_prepare($conexion, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "si", $matricula, $id_vehiculo);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $errores[] = "Ya existe otro vehículo con esa matrícula.";
        }
        mysqli_stmt_close($stmt_check);
    }

    // Actualizar
    if (empty($errores)) {
        $sql = "UPDATE vehiculos SET matricula = ?, marca = ?, modelo = ?, id_cliente = ? WHERE id_vehiculo = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssii", $matricula, $marca, $modelo, $id_cliente, $id_vehiculo);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        } else {
            $errores[] = "Error al actualizar: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }
}

// Obtener datos del vehículo
$sql_datos = "SELECT * FROM vehiculos WHERE id_vehiculo = $id_vehiculo";
$res_datos = mysqli_query($conexion, $sql_datos);
$vehiculo = mysqli_fetch_assoc($res_datos);

if (!$vehiculo) {
    header("Location: listar.php");
    exit;
}

// Obtener clientes para el select
$sql_clientes = "SELECT id_cliente, nombre FROM clientes ORDER BY nombre ASC";
$res_clientes = mysqli_query($conexion, $sql_clientes);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

    <form method="POST" action="editar.php?id=<?= $id_vehiculo ?>">
        <h1>Editar Vehículo #<?= $id_vehiculo ?></h1>

        <?php if (!empty($errores)): ?>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li style="color: red;"><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <input type="hidden" name="id_vehiculo" value="<?= $id_vehiculo ?>">

        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" id="matricula" value="<?= htmlspecialchars($vehiculo['matricula']) ?>" required>

        <label for="marca">Marca:</label>
        <input type="text" name="marca" id="marca" value="<?= htmlspecialchars($vehiculo['marca']) ?>" required>

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" value="<?= htmlspecialchars($vehiculo['modelo']) ?>" required>

        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" id="id_cliente" required style="width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 2px solid #e1e4e8; background: #f9f9f9;">
            <?php while ($c = mysqli_fetch_assoc($res_clientes)): ?>
                <option value="<?= $c['id_cliente'] ?>" <?= ($vehiculo['id_cliente'] == $c['id_cliente']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Actualizar Vehículo">

        <div style="text-align: center; margin-top: 20px;">
            <a href="listar.php" style="color: #666; text-decoration: none;">Cancelar</a>
        </div>
    </form>

    <?php cerrarConexion($conexion); ?>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/validaciones.js"></script>
    <script src="../js/plugins.js"></script>
    <script>
        $(document).ready(function() {
            $("input[type='text'], select").resaltadoFoco();
            $("#marca, #modelo").contadorSimple();
            $("#marca, #modelo").botonLimpiar();
        });
    </script>
</body>
</html>
