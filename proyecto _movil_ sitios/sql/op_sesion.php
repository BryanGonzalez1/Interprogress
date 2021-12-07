<?php 
require_once "conexion.php";
function registrarAdmin($correo,$nombre,$apellido,$direccion,$dependencia){
    $conn = conectar();
    if($correo !== "" && $nombre !== "" && $apellido !== "" && $direccion !== ""){
        $registro = "SELECT * FROM usuarios WHERE Correo='".$correo."'";
        $resultado=mysqli_query($conn,$registro);
        if(!mysqli_num_rows($resultado)){
            $query = "INSERT INTO usuarios (Correo, Contrasena, Nombre, Apellidos, Direccion, Dependencia , Rol) 
            VALUES ('".$correo."','2846','".$nombre."','".$apellido."','".$direccion."','".$dependencia."','5')";
            mysqli_query($conn, $query);
            desconectar($conn);
            return "exito";
        }else{
            desconectar($conn);
            return "El usuario ya fue registrado con anterioridad";
        }
    }
    else{
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
function iniciarSession($correo,$contrasena){
    $conn = conectar();
    if($correo !== "" && $contrasena !== ""){
        $registro = "SELECT * FROM usuarios WHERE Correo='".$correo."' and Contrasena = '".$contrasena."'";
        $resultado=mysqli_query($conn,$registro);
        if(mysqli_num_rows($resultado)){
            while($fila = mysqli_fetch_array($resultado)){
                $datos = $fila['Rol'];
            }
            desconectar($conn);
            return $datos;
        }else{
            desconectar($conn);
            return "La contraseña y/o el usuario son incorrectos";
        }
    }
    else{
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}



?>
