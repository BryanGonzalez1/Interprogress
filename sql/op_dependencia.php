<?php
    require_once "connection/conexion.php";
    function Faltan_documentos($componente,$correo,$fecha)
    {
        $conn = conectar();
        $query = "select DISTINCT * from cuestionario, respuesta where respuesta.Codigo_fecha = '".$fecha."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and respuesta.Componentes='".$componente."' and Estado_cuestionario = '2'";
        $resultado= mysqli_query($conn, $query);
        if(mysqli_num_rows($resultado)==20)
        {
            return "correcto";
        }
        else
        {
            $conn = conectar();
            $query = "select DISTINCT * from cuestionario, respuesta where respuesta.Codigo_fecha = '".$fecha."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and respuesta.Componentes='".$componente."' and Estado_cuestionario = '1' ";
            $resultado= mysqli_query($conn, $query);
            if(mysqli_num_rows($resultado))
            {
                return "est_incompleto";
            }
            else
            {
                return "est_incorrecto";
            }
        }
        desconectar($conn);
    }
    function Faltan_documentos_revisar($componente,$correo,$fecha)
    {
        $conn = conectar();
        $query = "SELECT DISTINCT * from cuestionario, respuesta where respuesta.Codigo_fecha = '".$fecha."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and respuesta.Componentes='".$componente."' and (Nota !='')";
        $resultado= mysqli_query($conn, $query);
        if(mysqli_num_rows($resultado)==20)
        {
            $query = "SELECT DISTINCT * FROM cuestionario, respuesta where respuesta.Codigo_fecha = '".$fecha."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and respuesta.Componentes='".$componente."' and (Estado_nivel != '' and Compromiso_de_mejoras !='' and Mejora is NULL)";
            $resultado= mysqli_query($conn, $query);
            if(mysqli_num_rows($resultado)){
                return "est_incompleto";
            }else{
                return "correcto";
            }
        }
        else
        {
            $conn = conectar();
            $query = "select DISTINCT * from cuestionario, respuesta where respuesta.Codigo_fecha = '".$fecha."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and respuesta.Componentes='".$componente."' and (Nota !='' or Estado_nivel != '' or Compromiso_de_mejoras !='')";
            $resultado= mysqli_query($conn, $query);
            if(mysqli_num_rows($resultado))
            {
                return "est_incompleto";
            }
            else
            {
                return "est_incorrecto";
            }
        }
        desconectar($conn);
    }
    function enviar_formulario($fecha,$correo)
    {
        $conn = conectar();
        $query = "select DISTINCT * from cuestionario, respuesta where respuesta.Codigo_fecha = '".$fecha."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and Estado_cuestionario != '2' and Tipo =b'1'";
        $resultado= mysqli_query($conn, $query);
        if(!mysqli_num_rows($resultado))
        {
            $query = "Update respuesta set Estado_cuestionario='3' where Codigo_fecha = '".$fecha."' and Dependencia_responsable ='".$correo."'";
            $resultado= mysqli_query($conn, $query);           
            $query = "Select dependencia.Nombre from usuarios,dependencia where usuarios.Correo = '".$correo."' and dependencia.Codigo = usuarios.Dependencia";
            $resultado= mysqli_query($conn, $query);    
            $dat = mysqli_fetch_array($resultado);       
            require_once "opcorreos_adentro.php";
            desconectar($conn);
            Enviardependencia_termino($correo,$dat[0]);
            return "exitoso";

        }       
        else{
            desconectar($conn);
            return 'Faltan evidencias obligatorias, por favor adjuntarlas antes de enviar el formulario.';
        }
    }
    function modificar($link,$componente,$subcomponente,$correo)
    {
        $conn = conectar();
        if ($link !== "" && $componente !== "" && $subcomponente !== "" && $correo !== "") {
            $registro = "SELECT Codigo FROM `fecha_evaluacion` WHERE Estado = 1";
            $resultado = mysqli_query($conn, $registro);
            $fila = mysqli_fetch_array($resultado);
            $query = "Update respuesta set Evidencia = '".$link."' WHERE Componentes = '".$componente."' AND Subcomponentes = '".$subcomponente."' AND Dependencia_responsable  = '".$correo."' AND Codigo_fecha='".$fila[0]."'";
            mysqli_query($conn, $query);
            $query = "select DISTINCT * from cuestionario, respuesta where respuesta.Codigo_fecha = '".$fila[0]."' and respuesta.Dependencia_responsable ='".$correo."' and respuesta.Componentes = cuestionario.Componentes and respuesta.Subcomponentes = cuestionario.Subcomponentes and respuesta.Componentes='".$componente."'  and respuesta.Evidencia != ''";
            $resultado= mysqli_query($conn, $query);
            if(mysqli_num_rows($resultado)==20)
            {
                $query = "Update respuesta set Estado_cuestionario='2' WHERE Componentes = '".$componente."' AND Dependencia_responsable  = '".$correo."' AND Codigo_fecha='".$fila[0]."'";
                $resultado= mysqli_query($conn, $query); 
                return 'exito';
            }
            else
            {
                $query = "Update respuesta set Estado_cuestionario='1' WHERE Componentes = '".$componente."' AND Dependencia_responsable  = '".$correo."' AND Codigo_fecha='".$fila[0]."'";
                $resultado= mysqli_query($conn, $query); 
                return 'exito';
            }
            desconectar($conn);
        } else {
            desconectar($conn);
            return "Por favor no deje espacios en blanco";
        }
    }
    function modificar_cuenta($correo,$nombre,$apellidos,$contraseña,$direccion)
    {
        $conn = conectar();
        if($correo !== "" && $nombre !== "" && $apellidos !== "" && $contraseña !== ""&& $direccion !== ""){
            $query = "Update usuarios set Nombre ='".$nombre."',Apellidos ='".$apellidos."',Contrasena ='".$contraseña."',Direccion ='".$direccion."'  where Correo='".$correo."'";
            $result = mysqli_query($conn, $query);
            desconectar($conn);
            return 'exito';
        }else {
            desconectar($conn);
            return "Por favor no deje espacios en blanco";
        }
    }
    function agregarMejora($mejora, $fecha, $correo,$eje)
    {
        $conn = conectar();
        if($mejora !== ""){
            $query = "UPDATE respuesta SET Mejora = '".$mejora."', Estado_mejora = 0 WHERE Dependencia_responsable = '".$correo."' AND Codigo_fecha = '".$fecha."' AND Subcomponentes = '".$eje."'";
            $result = mysqli_query($conn, $query);
            desconectar($conn);
            return 'exito';
        }else{
            return "No se puede agregar una mejora en blanco";
        }
    }
?>