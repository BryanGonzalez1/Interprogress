<?php 
require_once "connection/conexion.php";
require_once "opcorreos_afuera.php";
function registrarAdmin($correo,$nombre,$apellido,$direccion,$dependencia){
    $conn = conectar();
    if($correo !== "" && $nombre !== "" && $apellido !== "" && $direccion !== ""){
        $registro = "SELECT * FROM usuarios WHERE Correo='".$correo."'";
        $resultado=mysqli_query($conn,$registro);
        if(!mysqli_num_rows($resultado)){
            $contrasena = contraseñaaleatoria();
            $res= Enviarcorreo_contrasena($contrasena,$correo,$nombre);
            if($res==='exito')
            {
                $query = "INSERT INTO usuarios (Correo, Contrasena, Nombre, Apellidos, Direccion, Dependencia , Rol) 
                VALUES ('".$correo."','".$contrasena."','".$nombre."','".$apellido."','".$direccion."','".$dependencia."','5')";
                mysqli_query($conn, $query);
                desconectar($conn);
                return "exito";
            }
            else
            {
                return $res;
            }
        }else{
            desconectar($conn);
            return "EL usuario ya fue registrado con anterioridad";
        }
    }
    else{
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
function contraseñaaleatoria()
{
   $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
   $password = "";
   for($i=0;$i<20;$i++) {
      $password .= substr($str,rand(0,62),1);
   }
   return $password;
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
