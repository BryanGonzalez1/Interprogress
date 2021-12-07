<?php
    
    //realizamos coneccion
    function conectar(){
        $usuario = "bryan";
        $contrasena= "123";
        $server = "localhost";
        $db="control_interno";
        $con=mysqli_connect($server, $usuario, $contrasena, $db);
        if (mysqli_connect_errno()) {
            printf("Conexion fallida: %s\n", mysqli_connect_error());
            exit();
        }else{
            return $con;
        }
    }
    //cierra conexion pero hay que meter el parametro
    function desconectar($conection){
        mysqli_close($conection);
    } 
    
?>