<?php
session_start();

require_once 'includes/conexion.php';
require_once 'includes/funciones.php';

$errores = [];
$valor_email = "";

if (isset($_POST["Acceder"])) {

    if (!isset($_POST["email"]) || $_POST["email"] == "") {
        $errores["email"] = "Introduce un email";
    } else {
        $valor_email = trim($_POST["email"]);

        if (!filter_var($valor_email, FILTER_VALIDATE_EMAIL)) {
            $errores["email"] = "El formato del email no es válido";
        } else {
            $valor_email = limpiar($valor_email);
        }
    }

    if (!isset($_POST["password"]) || $_POST["password"] == "") {
        $errores["password"] = "Introduce la contraseña";
    }

    if (!isset($errores["email"]) && !isset($errores["password"])) {

        $con = abrirConexion();
        $sql = "SELECT email, password_hash
                FROM usuarios
                WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "s", $valor_email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 0) {
                $errores["email"] = "No existe ningún usuario con ese email";
            } else {

                mysqli_stmt_bind_result($stmt, $email_bd, $hash_bd);
                mysqli_stmt_fetch($stmt);

                if (!is_string($hash_bd) || !password_verify($_POST["password"], $hash_bd)) {
                    $errores["password"] = "La contraseña es incorrecta";
                } else {
                    $_SESSION["email"] = $email_bd;
                    header("Location: index.php");
                    exit;
                }
            }

            mysqli_stmt_close($stmt);
            cerrarConexion($con);
        } else {
            $errores["general"] = "Error al acceder";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <h1>Login</h1>

    <form method="POST">
        <label>Email:
            <input type="email" name="email" value="<?= $valor_email ?>">
        </label><br>

        <label>Password:
            <input type="password" name="password">
        </label><br>

        <input type="submit" name="Acceder" value="Login">
    </form>

    <?php
    if (isset($errores) && count($errores) > 0) {
        echo "<ul>";
        foreach ($errores as $e) {
            echo "<li style='color: red;'>" . limpiar($e) . "</li>";
        }
        echo "</ul>";
    }
    ?>

</body>

</html>