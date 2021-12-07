<?php
include_once "../sql/connection/conexion.php";
function modificar_cuestionario($estado,$descripcion,$componentes,$subcomponentes,$nivel)
{
    if($estado !== "" && $componentes !== "" && $subcomponentes !== "" && $nivel !== "" && $descripcion !== "")
    {
        $conn = conectar();
        $query = "Update cuestionario set Fecha_act = CURRENT_DATE(), Tipo =b'".$estado."', Descripcion ='".$descripcion."' WHERE Componentes='".$componentes."' AND Subcomponentes='".$subcomponentes."' AND  Nivel='".$nivel."'";
        mysqli_query($conn, $query);
        desconectar($conn);
        return "exito";
    }
    else {
        return "Por favor no deje espacios en blanco";
    }
}
function modificar_cuenta($correo,$nombre,$apellidos,$contraseña,$direccion)
{
    if($correo !== "" && $nombre !== "" && $apellidos !== "" && $contraseña !== ""&& $direccion !== ""){
        $conn = conectar();
        $query = "Update usuarios set Nombre ='".$nombre."',Apellidos ='".$apellidos."',Contrasena ='".$contraseña."',Direccion ='".$direccion."'  where Correo='".$correo."'";
        $result = mysqli_query($conn, $query);
        desconectar($conn);
        return 'exito';
    }else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
?>