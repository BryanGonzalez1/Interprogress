<?php
include_once "../sql/connection/conexion.php";
if(isset($_GET['correo']) && isset($_GET['contrasena']) && isset($_GET['estado']))
{
    $conn = conectar();
    $correo = $_GET['correo'];
    $contrasena = $_GET['contrasena'];
    $estado = $_GET['estado'];
    if ($correo !== "" && $contrasena !== ""&& $estado !== "") {
            if($estado === "1")
            {
                $registro = "Update credenciales set Estado = 0 WHERE Correo_electronico = '".$correo."'";
                $resultado = mysqli_query($conn, $registro);   
                header("Location:/administrador/config_credencial.php");  
            }
            else
            {   
                $registro = "Update credenciales set Estado = 0 WHERE Estado = 1";
                $resultado = mysqli_query($conn, $registro);
                $registro = "Update credenciales set Estado = 1 WHERE Correo_electronico = '".$correo."'";
                $resultado = mysqli_query($conn, $registro);
                header("Location:/administrador/config_credencial.php");         
            }
    } else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}