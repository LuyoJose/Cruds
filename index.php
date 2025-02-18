<?php
error_reporting(E_ALL);
ini_set('display_error', 1);


$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$basedatos = "cruds";

$conexion = new mysqli($servidor, $usuario, $contraseña, $basedatos);

if ($conexion->connect_error){
    die("conexion fallida: " . $conexion->connect_error);
}
if (isset($_GET['controller']) && isset($_GET['action'])){
    $controller = $_GET['controller'];
    $action =$_GET['action'];

    $controllerFile = "controllers/{$controller}controller.php";
    if (file_exists($controllerFile)){
        require_once $controllerFile;
        $controllerClass = $controller . 'controller';
        if(class_exists($controllerClass)){
            $controllerInstance = new $controllerClass($conexion);
            if(method_exists($controllerInstance, $action)){
                $reflectionMethod = new ReflectionMethod($controllerClass, $action);
                $params = $reflectionMethod->getParameters();
                if(count($params) > 0){
                    $param = $_GET['id'] ?? null;
                    if($param !== null){
                        $controllerInstance->$action($param);
                    }else{
                        die ("El parametro requqrido para la accion{$action} no fue proporcionado");
                    }
                }else{
                    $controllerInstance->$action();
                }
            }else{
                die("Leccion {$action} no existe en el controlador {$controller}.");
            }
        }else {
            die("El controador {$controllerClass} no existe. ");
        }
    }else{
        die ("El archivo del controlador {$controllerFile} no existe.");
    }
}else {
    $controller = 'home';
    $action = 'index';
    
    require_once "controller/{$controller}controllers.php";
    $controllerClass = $controller . 'controller';
    $controllerInstance = new $controllerClass($conexion);
    $controllerInstance->$action();
}