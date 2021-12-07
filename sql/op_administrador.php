<?php 
include_once "../sql/connection/conexion.php";
require_once "opcorreos_adentro.php";
function agregarDependencia($codigo, $nombre, $descripcion){
    $conn = conectar();
    if ($codigo !== "" && $descripcion !== "" && $nombre !== "") {
        $registro = "SELECT * FROM dependencia WHERE Codigo='" . $codigo . "'";
        $resultado = mysqli_query($conn, $registro);
        if (!mysqli_num_rows($resultado)) {
            $query = "INSERT INTO dependencia (Codigo, Nombre, Descripcion) VALUES ('".$codigo."', '".$nombre."', '".$descripcion."')";
            mysqli_query($conn, $query);
            desconectar($conn);
            return "exito";
        } else {
            desconectar($conn);
            return "Esa dependencia ya existe";
        }
    } else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
function registrarfecha( $finicio, $ffinal, $estado)
{
    $conn = conectar();
    if ($finicio !== "" &&  $ffinal !== ""  && $estado !== "") {
        $registro = "SELECT * FROM fecha_evaluacion WHERE F_inicio = '".$finicio."' AND F_final = '".$ffinal."'";
        $resultado = mysqli_query($conn, $registro);
        if (!mysqli_num_rows($resultado)) {
            $registro = "SELECT * FROM fecha_evaluacion WHERE Estado = 1";
            $resultado = mysqli_query($conn, $registro);
            if($estado === "1")
            {
                $es = 1;
                if(!mysqli_num_rows($resultado))
                { 
                    $query = "INSERT INTO fecha_evaluacion (F_inicio,F_final, Estado) 
                    VALUES ('".$finicio."','".$ffinal."',b'".$estado."')";
                    mysqli_query($conn, $query);
                    desconectar($conn);
                    $res = publicar_form();
                    if($res === "exito"){
                        return "exito 1";
                    }else{
                        return $res;
                    }
                }
                else{
                    desconectar($conn);
                    return "Solo puede haber una fecha de evaluacion activa";
                }
            }
            else
            {
                $query = "INSERT INTO fecha_evaluacion ( F_inicio, F_final, Estado) 
                VALUES ('".$finicio."','".$ffinal."',b'".$estado."')";
                mysqli_query($conn, $query);
                desconectar($conn);
                return "exito 2";
            }
        } else {
            desconectar($conn);
            return "La fecha de evaluación ya fue registrada con anterioridad";
        }
    } else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
function modificar($mejora,$estado,$nota,$componente,$subcomponente,$correo,$fecha_mejora)
{
    $conn = conectar();
    if ($componente !== "" && $subcomponente !== "" && $correo !== "") {
        if(($mejora === "" && $fecha_mejora !== "") || ($mejora !== "" && $fecha_mejora === "")){
            return "Te falto la descripcion o la fecha de mejora";
        }else{
            if($estado === "Incipiente" && ($nota < 1 || $nota > 39)){

                return "El nivel de Incipiente tiene que ser una nota de 0 a 39 puntos";

            } else if($estado === "Novato" && ($nota < 40 || $nota > 59)){

                return "El nivel de Novato tiene que ser una nota de 40 a 59 puntos";

            }else if($estado === "Competente" && ($nota < 60 || $nota > 79)){

                return "El nivel de Competente tiene que ser una nota de 60 a 79 puntos";

            }else if($estado === "Diestro" && ($nota < 80 || $nota > 99)){

                return "El nivel de Diestro tiene que ser una nota de 80 a 99 puntos";

            }else if($estado === "Experto" && ($nota < 100)){

                return "El nivel de Experto tiene que ser una nota de 100";

            }else{
                $registro = "SELECT Codigo FROM fecha_evaluacion WHERE Estado = 1";
                $resultado = mysqli_query($conn, $registro);
                $fila = mysqli_fetch_array($resultado);
                $query = "Update respuesta set Compromiso_de_mejoras = '".$mejora."',Estado_nivel = '".$estado."',Nota = '".$nota."', Fecha_mejora = '".$fecha_mejora."', Estado_mejora = 1 
                WHERE Componentes = '".$componente."' AND Subcomponentes = '".$subcomponente."' AND Dependencia_responsable  = '".$correo."' AND Codigo_fecha='".$fila[0]."'";
                mysqli_query($conn, $query);
                desconectar($conn);
                return "exito";
            }
        }
    } else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
function modificarfecha($codigo, $finicio, $ffinal, $estado)
{
    $conn = conectar();
    if ($codigo !== "" && $finicio !== ""&& $ffinal !== "" && $estado !== "") {
        $registro = "SELECT * FROM fecha_evaluacion WHERE Codigo = '".$codigo."'";
        $resultado = mysqli_query($conn, $registro);
        if (mysqli_num_rows($resultado)) {
            $registro = "SELECT * FROM fecha_evaluacion WHERE Estado = 1 and Codigo <> '".$codigo."'";
            $resultado = mysqli_query($conn, $registro);
            if($estado === "1")
            {
                if(!mysqli_num_rows($resultado))
                { 
                    $query = "Update fecha_evaluacion set F_inicio='".$finicio."',F_final='".$ffinal."',Estado=b'".$estado."' where Codigo='".$codigo."'";
                    mysqli_query($conn, $query);
                    desconectar($conn);
                    $res = publicar_form();
                    if($res === "exito"){
                        return "exito";
                    }else{
                        return $res;
                    }
                }
                else{
                    desconectar($conn);
                    return "Solo puede haber una fecha de evaluacion activa";
                }
            }
            else
            {
                $Val_cuest = "SELECT * from respuesta, fecha_evaluacion 
                where fecha_evaluacion.Codigo = respuesta.Codigo_fecha 
                and fecha_evaluacion.F_inicio=".$finicio." and fecha_evaluacion.F_final = ".$ffinal." and respuesta.estado_cuestionario   != '2'";
                $resultadoVal = mysqli_query($conn, $Val_cuest);
                if(!mysqli_num_rows($resultadoVal)){
                    $query = "Update fecha_evaluacion set F_inicio='".$finicio."',F_final='".$ffinal."',Estado=b'".$estado."' where Codigo='".$codigo."'";
                    mysqli_query($conn, $query);
                    desconectar($conn);
                    return "exito";
                }else{
                    return "No puedes desactivar la fecha, ya que faltan cuestionarios por terminar de contestar";
                }
               
            }
        } else {
            desconectar($conn);
            return "La fecha de evaluación no existe";
        }
    } else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}


function modificarDependencia($codigo, $nombre, $descripcion){
    $conn = conectar();
    if($codigo !== "" && $nombre !== "" && $descripcion !== ""){
        $query = "UPDATE dependencia SET Nombre = '".$nombre."', Descripcion = '".$descripcion."'
            WHERE Codigo = '".$codigo."'";
        mysqli_query($conn, $query);
        desconectar($conn);
        return "exito";
    }else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}
function modificarRol($correo, $rol,$nombre, $dependecia){
    $conn = conectar();
    if($rol === "5"){
        $query = "UPDATE Usuarios SET Rol = '".$rol."'
        WHERE Correo = '".$correo."'";
        mysqli_query($conn, $query);
        desconectar($conn);
        Enviarcorreo_asignacionrol($correo,$nombre,$rol);
        return "exito";
    }else{
        $consulta = "SELECT * FROM Usuarios WHERE Rol = '".$rol."' AND Dependencia = '".$dependecia."'";
        $resultado = mysqli_query($conn, $consulta);
        if(!mysqli_num_rows($resultado)){
            $query = "UPDATE Usuarios SET Rol = '".$rol."'
            WHERE Correo = '".$correo."'";
            mysqli_query($conn, $query);
            desconectar($conn);
            Enviarcorreo_asignacionrol($correo,$nombre,$rol);
            return "exito";
        }else{
            desconectar($conn);
            return "Ya existe un empleado con ese rol.";
        }  
    }

    
}

if(isset($_GET['eliminar_dependencia'])){
    $codigo = $_GET['eliminar_dependencia'];
    $conn = conectar();
    $query = "DELETE FROM dependencia WHERE Codigo = '".$_GET['eliminar_dependencia']."'";
    mysqli_query($conn, $query);
    desconectar($conn);
    header("Location:/administrador/index.php");
}

if(isset($_GET['eliminar_fecha'])){
    $codigo = $_GET['eliminar_fecha'];
    $conn = conectar();
    $query = "DELETE FROM fecha_evaluacion WHERE Codigo = '".$_GET['eliminar_fecha']."'";
    mysqli_query($conn, $query);
    desconectar($conn);
    header("Location:/administrador/administrar_fechas.php");
}


if(isset($_GET['eliminar_usuario'])){
    $codigo = $_GET['eliminar_usuario'];
    $conn = conectar();
    $query = "DELETE FROM Usuarios WHERE Correo = '".$_GET['eliminar_usuario']."'";
    mysqli_query($conn, $query);
    desconectar($conn);
    header("Location:/administrador/asignar_roles.php?codigo=".$_GET['codigo']);
}

function falta_componente($reposanble, $componente,$fecha){
    $conn = conectar();
    $registro = "SELECT * FROM respuesta WHERE Dependencia_responsable = '".$reposanble."' AND Componentes = '".$componente."' AND Codigo_fecha='".$fecha."' AND Estado_nivel IS NULL;";
    $resultado = mysqli_query($conn, $registro);
    if (mysqli_num_rows($resultado) === 4) 
    {
        desconectar($conn);
        return "est_incorrecto";
    }
    if (mysqli_num_rows($resultado) < 4 && mysqli_num_rows($resultado) > 0) 
    {
        desconectar($conn);
        return "est_incompleto";
    }
    if (mysqli_num_rows($resultado) === 0) 
    {   
        $registro = "SELECT * FROM respuesta WHERE Dependencia_responsable = '".$reposanble."' AND Componentes = '".$componente."' AND Codigo_fecha='".$fecha."' AND Estado_mejora = 0;";
        $resultado = mysqli_query($conn, $registro);
        if(mysqli_num_rows($resultado)){
            desconectar($conn);
            return "est_incompleto";

        }else{
            desconectar($conn);
            return "correcto";
        }
    }
}
function falta_eje($componente, $eje,$reposanble,$fecha){
    $conn = conectar();
    $registro = "SELECT * FROM respuesta WHERE Componentes = '".$componente."' AND Subcomponentes = '".$eje."' AND Dependencia_responsable= '".$reposanble."' AND Codigo_fecha='".$fecha."' AND Estado_nivel IS NULL";
    $resultado = mysqli_query($conn, $registro);
    if (!mysqli_num_rows($resultado)) 
    {
        $registro = "SELECT * FROM respuesta WHERE Componentes = '".$componente."' AND Subcomponentes = '".$eje."' AND Dependencia_responsable= '".$reposanble."' AND Codigo_fecha='".$fecha."' AND Estado_mejora = 0";
        $resultado = mysqli_query($conn, $registro);
        if (mysqli_num_rows($resultado)) 
        {
            desconectar($conn);
            return "mejora";
        }else{
            desconectar($conn);
            return "correcto";
        }
    }else{
        desconectar($conn);
        return "est_incorrecto";
    }
}
function publicar_form()
{
  $conn = conectar();
  $registro = "SELECT Codigo FROM fecha_evaluacion WHERE Estado = 1";
  $resultado = mysqli_query($conn, $registro);
  if (mysqli_num_rows($resultado)) 
  {
     $fila_activa = mysqli_fetch_array($resultado);
     $registro = "select Count(*) from usuarios where rol = 4";
     $resultado = mysqli_query($conn, $registro);
     if (mysqli_num_rows($resultado)) 
     {
        include_once "../sql/opcorreos_adentro.php";
        $fila_contador = mysqli_fetch_array($resultado);
        $registro = "SELECT * from respuesta where Codigo_fecha = '".$fila_activa[0]."'";
        $resultado = mysqli_query($conn, $registro);
        if (!mysqli_num_rows($resultado)) 
        {
            $registro = "select * from usuarios where rol = 4";
            $resultado = mysqli_query($conn, $registro);
            while ($fila = mysqli_fetch_array($resultado)) 
            {
                $query = "INSERT INTO respuesta (respuesta.Componentes,respuesta.Subcomponentes,respuesta.Dependencia_responsable,respuesta.Codigo_fecha,respuesta.Estado_cuestionario,respuesta.Evidencia) SELECT DISTINCT cuestionario.Componentes,cuestionario.Subcomponentes,'".$fila[0]."','".$fila_activa[0]."','0','' FROM cuestionario";
                $result = mysqli_query($conn, $query);
                Enviarcuestionario_activo($fila[0], $fila[2]);
            }
            desconectar($conn);
            return "exito";
        }           
        else
        {
            desconectar($conn);
            return "Ya existe un cuestionario para ese fecha de evaluacion";
        }
     }
    else
    {
    desconectar($conn);
    return "No hay dependencias agregadas";
    }
  }
  else
  {
    desconectar($conn);
    return "No hay una fecha de evaluacion activa";
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
function existeEvaluacion($correo, $codigo){
  $conn = conectar();
  $registro = "SELECT * FROM respuesta WHERE Codigo_fecha = '".$codigo."' AND Dependencia_responsable = '".$correo."'";
  $resultado = mysqli_query($conn, $registro);
  if (mysqli_num_rows($resultado)) 
  {
    return "exito";
  }else{
    return "No existe una evaluacion aplicada en esas fechas para ese dependencia";
  }

}
function tipo_notacomp($nota){
    if($nota > 79){
        return "bien";
    }
    if($nota > 59 && $nota <80){
        return "mejorar";
    }
    return "fallo";
}
function agregar_credenciak($correo,$contrasena)
{
    $conn = conectar();
    if($correo !== "" && $contrasena !== "")
    {
        $registro = "SELECT * FROM credenciales WHERE Correo_electronico = '".$correo."'";
        $resultado = mysqli_query($conn, $registro);
        if (!mysqli_num_rows($resultado)) {
            $conn = conectar();
            $query = "Insert into credenciales values('".$correo."','".$contrasena."',0)";
            $result = mysqli_query($conn, $query);
            desconectar($conn);
            return 'exito';
        }
        else {
            desconectar($conn);
            return "El credencial ya existe";
        }
    }
    else{
        return "Por favor no deje espacios en blanco";
    }
}
?>
