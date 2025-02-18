<?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$basedatos = "cruds";

$conexion = new mysqli($servidor, $usuario, $contraseña, $basedatos);
if ($conexion->connect_error){
    die("conexion fallida: " . $conexion->connect_error);
}

echo "conexion exitosa a la base de datos 'cruds'";
$conexion->close();
?>