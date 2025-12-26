<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/conexion.php";

if (isset($_GET['id'])) {
    $conexion = abrirConexion();
    $id = (int)$_GET['id'];


    if ($id > 0) {
        $sql = "DELETE FROM reparaciones WHERE id_reparacion = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    cerrarConexion($conexion);
}

header("Location: listar.php");
exit;
