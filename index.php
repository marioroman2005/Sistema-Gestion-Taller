<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema Taller - Panel Principal</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>

<body>

    <div class="contenedor-principal">

        <header class="encabezado-panel">
            <h1>SISTEMA DE GESTIÓN</h1>
            <div class="info-usuario">
                <span class="led-status"></span>
                USUARIO ACTIVO: <strong><?= htmlspecialchars($_SESSION["email"]); ?></strong>
            </div>
        </header>

        <nav class="menu-grid">

            <a href="clientes/listar.php" class="tarjeta-modulo">
                <div class="icono">👥</div>
                <h2>CLIENTES</h2>
                <p>Gestión de datos personales</p>
            </a>

            <a href="vehiculos/index.php" class="tarjeta-modulo">
                <div class="icono">🚗</div>
                <h2>VEHÍCULOS</h2>
                <p>Flota y fichas técnicas</p>
            </a>

            <a href="reparaciones/listar.php" class="tarjeta-modulo">
                <div class="icono">🔧</div>
                <h2>REPARACIONES</h2>
                <p>Órdenes de trabajo</p>
            </a>

        </nav>

        <footer class="pie-panel">
            <a href="logout.php" class="btn-salir">CERRAR SESIÓN</a>
        </footer>

    </div>

</body>

</html>