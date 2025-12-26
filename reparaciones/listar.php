<?php
session_start();


if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = abrirConexion();


$sql = "SELECT r.id_reparacion, r.fecha, r.descripcion, r.estado, r.precio, 
               v.matricula, v.marca, v.modelo, c.nombre as cliente_nombre
        FROM reparaciones r
        INNER JOIN vehiculos v ON r.id_vehiculo = v.id_vehiculo
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente
        ORDER BY r.fecha DESC, r.id_reparacion DESC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Reparaciones - Taller</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>

<body>

    <div class="contenedor-principal" style="max-width: 1200px;">

        <header class="encabezado-listado">
            <h1>GESTIÓN DE REPARACIONES</h1>
            <a href="../index.php" class="btn-volver">⬅ Volver al Panel</a>
        </header>

        <a href="crear.php" class="btn-nuevo">+ Nueva Reparación</a>

        <table class="tabla-listado">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Vehículo</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $fila['id_reparacion'] ?></td>
                        <td><?= date("d/m/Y", strtotime($fila['fecha'])) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($fila['matricula']) ?></strong><br>
                            <small><?= htmlspecialchars($fila['marca'] . " " . $fila['modelo']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($fila['cliente_nombre']) ?></td>
                        <td><?= htmlspecialchars(substr($fila['descripcion'], 0, 50)) . (strlen($fila['descripcion']) > 50 ? '...' : '') ?></td>
                        <td>
                            <?php
                            $clase_estado = "";
                            switch ($fila['estado']) {
                                case 'pendiente':
                                    $clase_estado = 'color: #dc3545; font-weight: bold;';
                                    break;
                                case 'en curso':
                                    $clase_estado = 'color: #ffc107; font-weight: bold;';
                                    break;
                                case 'finalizada':
                                    $clase_estado = 'color: #28a745; font-weight: bold;';
                                    break;
                            }
                            ?>
                            <span style="<?= $clase_estado ?>"><?= ucfirst($fila['estado']) ?></span>
                        </td>
                        <td><?= number_format($fila['precio'], 2) ?> €</td>
                        <td class="acciones">
                            <a href="editar.php?id=<?= $fila['id_reparacion'] ?>" class="btn-accion btn-editar">Editar</a>
                            <a href="borrar.php?id=<?= $fila['id_reparacion'] ?>" class="btn-accion btn-borrar" onclick="return confirmarBorrado();">Borrar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($resultado) == 0): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">No hay reparaciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <?php cerrarConexion($conexion); ?>
    <script src="../js/validaciones.js"></script>

</body>

</html>