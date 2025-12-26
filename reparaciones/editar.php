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
$id_reparacion = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_reparacion <= 0) {
    header("Location: listar.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_reparacion = (int)$_POST["id_reparacion"];
    $id_vehiculo = (int)$_POST["id_vehiculo"];
    $descripcion = limpiar($_POST["descripcion"]);
    $fecha = $_POST["fecha"];
    $estado = $_POST["estado"];
    $precio = (float)$_POST["precio"];

    if ($id_vehiculo <= 0) $errores[] = "Debes seleccionar un vehículo.";
    if (empty($descripcion)) $errores[] = "La descripción es obligatoria.";
    if (empty($fecha)) $errores[] = "La fecha es obligatoria.";

    if (empty($errores)) {
        $sql = "UPDATE reparaciones SET descripcion = ?, fecha = ?, estado = ?, precio = ?, id_vehiculo = ? WHERE id_reparacion = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssdis", $descripcion, $fecha, $estado, $precio, $id_vehiculo, $id_reparacion);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: listar.php");
            exit;
        } else {
            $errores[] = "Error al actualizar: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }
}


$sql_datos = "SELECT * FROM reparaciones WHERE id_reparacion = $id_reparacion";
$res_datos = mysqli_query($conexion, $sql_datos);
$reparacion = mysqli_fetch_assoc($res_datos);

if (!$reparacion) {
    header("Location: listar.php");
    exit;
}


$sql_vehiculos = "SELECT id_vehiculo, matricula, marca, modelo FROM vehiculos ORDER BY matricula ASC";
$res_vehiculos = mysqli_query($conexion, $sql_vehiculos);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Reparación - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body>

    <form method="POST" action="editar.php?id=<?= $id_reparacion ?>" onsubmit="return validarReparacion();">
        <h1>Editar Reparación #<?= $id_reparacion ?></h1>

        <?php if (!empty($errores)): ?>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <input type="hidden" name="id_reparacion" value="<?= $id_reparacion ?>">

        <label for="id_vehiculo">Vehículo:</label>
        <select name="id_vehiculo" id="id_vehiculo" required style="width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 2px solid #e1e4e8; background: #f9f9f9;">
            <?php while ($v = mysqli_fetch_assoc($res_vehiculos)): ?>
                <option value="<?= $v['id_vehiculo'] ?>" <?= ($reparacion['id_vehiculo'] == $v['id_vehiculo']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v['matricula'] . " - " . $v['marca'] . " " . $v['modelo']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="descripcion">Descripción del trabajo:</label>
        <textarea name="descripcion" id="descripcion" rows="4" required style="width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 2px solid #e1e4e8; background: #f9f9f9;"><?= htmlspecialchars($reparacion['descripcion']) ?></textarea>

        <label for="fecha">Fecha Entrada:</label>
        <input type="text" name="fecha" id="fecha" value="<?= $reparacion['fecha'] ?>" required autocomplete="off">

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required style="width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 2px solid #e1e4e8; background: #f9f9f9;">
            <option value="pendiente" <?= ($reparacion['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
            <option value="en curso" <?= ($reparacion['estado'] == 'en curso') ? 'selected' : '' ?>>En Curso</option>
            <option value="finalizada" <?= ($reparacion['estado'] == 'finalizada') ? 'selected' : '' ?>>Finalizada</option>
        </select>

        <label for="precio">Precio (€):</label>
        <input type="number" name="precio" id="precio" step="0.01" min="0" value="<?= $reparacion['precio'] ?>" required style="display: block; width: 100%; padding: 12px 16px; margin-bottom: 20px; background-color: #f9f9f9; border: 2px solid #e1e4e8; border-radius: 8px;">

        <input type="submit" value="Actualizar Reparación">

        <div style="text-align: center; margin-top: 20px;">
            <a href="listar.php" style="color: #666; text-decoration: none;">Cancelar</a>
        </div>
    </form>

    <?php cerrarConexion($conexion); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/validaciones.js"></script>

    <script>
        $(document).ready(function() {
            $("#fecha").datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1,
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
            });


            $("#descripcion").contarCaracteres({
                color: "#007bff",
                texto: "Llevas escritos: "
            });
        });
    </script>
</body>

</html>