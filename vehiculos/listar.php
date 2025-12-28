<?php
session_start();

// Seguridad: Si no hay usuario logueado, redirigir al login
if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = abrirConexion();

// Consulta para obtener vehículos con datos del cliente
$sql = "SELECT v.id_vehiculo, v.matricula, v.marca, v.modelo, c.nombre as cliente_nombre
        FROM vehiculos v
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente
        ORDER BY v.marca ASC, v.modelo ASC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Vehículos - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>

<body>

    <div class="contenedor-principal" style="max-width: 1000px;">

        <header class="encabezado-listado">
            <h1>GESTIÓN DE VEHÍCULOS</h1>
            <a href="../index.php" class="btn-volver">⬅ Volver al Panel</a>
        </header>

        <a href="crear.php" class="btn-nuevo">+ Nuevo Vehículo</a>

        <table class="tabla-listado">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matrícula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cliente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $fila['id_vehiculo'] ?></td>
                        <td><strong><?= htmlspecialchars($fila['matricula']) ?></strong></td>
                        <td><?= htmlspecialchars($fila['marca']) ?></td>
                        <td><?= htmlspecialchars($fila['modelo']) ?></td>
                        <td><?= htmlspecialchars($fila['cliente_nombre']) ?></td>
                        <td class="acciones">
                            <a href="editar.php?id=<?= $fila['id_vehiculo'] ?>" class="btn-accion btn-editar">Editar</a>
                            <a href="borrar.php?id=<?= $fila['id_vehiculo'] ?>" class="btn-accion btn-borrar" onclick="return confirm('¿Estás seguro? Al borrar el vehículo se borrarán también sus reparaciones.');">Borrar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($resultado) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">No hay vehículos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <?php cerrarConexion($conexion); ?>

</body>

</html>
