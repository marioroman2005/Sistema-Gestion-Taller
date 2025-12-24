<?php

function abrirConexion(){
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $basedatos = "";
    
    $conexion = mysqli_connect($servidor,$usuario,$clave,$basedatos);
    
    if(!$conexion){
        echo "Error en la conexion: ", mysqli_connect_error();
    }
    return $conexion;
}

function cerrarConexion($conexion){
    if(isset($conexion)){
        mysqli_close($conexion);
    }
}


?>