<?php
session_start();

// Seguridad
if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = abrirConexion();

// Consulta para obtener todos los clientes
$sql = "SELECT * FROM clientes ORDER BY nombre ASC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>

<body>

    <div class="contenedor-principal" style="max-width: 1200px;">

        <header class="encabezado-listado">
            <h1>GESTIÓN DE CLIENTES</h1>
            <a href="../index.php" class="btn-volver">⬅ Volver al Panel</a>
        </header>

        <a href="crear.php" class="btn-nuevo">+ Nuevo Cliente</a>

        <table class="tabla-listado">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI / NIF</th>
                    <th>Nombre Completo</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $fila['id_cliente'] ?></td>
                        <td><strong><?= htmlspecialchars($fila['dni']) ?></strong></td>
                        <td><?= htmlspecialchars($fila['nombre']) ?></td>
                        <td><?= htmlspecialchars($fila['telefono']) ?></td>
                        <td><?= htmlspecialchars($fila['email']) ?></td>
                        <td class="acciones">
                            <a href="editar.php?id=<?= $fila['id_cliente'] ?>" class="btn-accion btn-editar">Editar</a>
                            <a href="borrar.php?id=<?= $fila['id_cliente'] ?>" class="btn-accion btn-borrar" onclick="return confirmarBorrado();">Borrar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($resultado) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">No hay clientes registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <?php cerrarConexion($conexion); ?>
    <script>
        function confirmarBorrado() {
            return confirm("¿Estás seguro? Si borras el cliente, podrías perder sus vehículos asociados.");
        }
    </script>

</body>
</html>