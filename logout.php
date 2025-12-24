<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$_SESSION = [];

if(ini_get("session.use_cookies")){
    setcookie(session_name(),'',time()-42000,'/');
}

session_destroy();
header("Location: login.php");
exit;

?>

<!doctype html>
<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
       <p>La sesión se ha cerrado correctamente.</p>
        <p><a href="login.php">Volver al login</a></p>
    </body>
</html>


