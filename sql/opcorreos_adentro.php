<?php
require_once "connection/conexion.php";
require_once "../PHPMailer/Exception.php";
require_once '../PHPMailer/PHPMailer.php';
require_once '../PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function Enviarcorreo_asignacionrol($correo,$nombre,$id_rol)
{
    $mail = new PHPMailer(true);
    $conn = conectar();
    $registro = "SELECT * FROM rol WHERE Id_rol=".$id_rol;
    $resultado = mysqli_query($conn, $registro);  
    $rol = mysqli_fetch_array($resultado); 
    $consulta = "SELECT * FROM `correos` WHERE correo ='asignacion'";
    $resultado = mysqli_query($conn, $consulta);
    $dat = mysqli_fetch_array($resultado);
    desconectar($conn);
    $consulta = "SELECT * FROM `credenciales` WHERE credenciales.Estado ='1'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $credenciales = mysqli_fetch_array($resultado);
    desconectar($conn);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                    
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $credenciales[0];               
        $mail->Password   = $credenciales[1];                      
        $mail->SMTPSecure = 'ssl';         
        $mail->Port       = 465;   

        //Recipients
        $mail->setFrom($credenciales[0], 'Interprogress');
        $mail->addAddress($correo, $nombre);     //Add a recipient            //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Asignacion de rol-Interprogress';
        $mail->Body    = '
        <div style="border:'.$dat[4].' 10px double; background-color:'.$dat[3].';text-align: center;justify-content: center;">
        <img src="http://apsw.42web.io/Correos/Logo.png" />
        <br>
        <label style="color: '.$dat[5].';font-size:xx-large;">
            '.$dat[1].'
        </label>
        <br>
        <br>
        <label style="font-size: larger;color:'.$dat[5].'">
            '.$dat[2].'
        </label>
        <br>
        <b style="font-size: xx-large;color:'.$dat[6].'">'.$rol[1].'</b>
        </div>
        ';
        $mail->send();
        return 'exito';
    } catch (Exception $e) {
        return "Se han tenido problemas al enviar el correo, intentelo de nuevo.";
    }
}

function Enviarcuestionario_terminado()
{
    $mail = new PHPMailer(true);
    $consulta = "SELECT * FROM `correos` WHERE correo ='cuestionario'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $dat = mysqli_fetch_array($resultado);
    $consulta = "SELECT * FROM `usuarios` WHERE Rol = 1";
    $resultado = mysqli_query($conn, $consulta);
    $usuario = mysqli_fetch_array($resultado); 
    desconectar($conn);
    $consulta = "SELECT * FROM `credenciales` WHERE credenciales.Estado ='1'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $credenciales = mysqli_fetch_array($resultado);
    desconectar($conn);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                    
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $credenciales[0];               
        $mail->Password   = $credenciales[1];                      
        $mail->SMTPSecure = 'ssl';         
        $mail->Port       = 465;   

        //Recipients
        $mail->setFrom($credenciales[0], 'Interprogress');
        $mail->addAddress($usuario[0], $usuario[2]);     //Add a recipient            //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'El fiscalizador ha terminado el cuestionario-Interprogress';
        $mail->Body    = '
        <div style="border:'.$dat[4].' 10px double; background-color:'.$dat[3].';text-align: center;justify-content: center;">
        <img src="http://apsw.42web.io/Correos/Logo.png" />
        <br>
        <label style="color: '.$dat[5].';font-size:xx-large;">
            '.$dat[1].'
        </label>
        <br>
        <br>
        <label style="font-size: larger;color:'.$dat[5].'">
            '.$dat[2].'
        </label>
        <br>
        ';
        $mail->send();
        return 'exito';
    } catch (Exception $e) {
        return "Se han tenido problemas al enviar el correo, intentelo de nuevo.";
    }
}

function Enviarcuestionario_activo($correo, $nombre)
{
    $mail = new PHPMailer(true);
    $consulta = "SELECT * FROM `correos` WHERE correo ='cuestionario activo'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $dat = mysqli_fetch_array($resultado);
    desconectar($conn);
    $consulta = "SELECT * FROM `credenciales` WHERE credenciales.Estado ='1'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $credenciales = mysqli_fetch_array($resultado);
    desconectar($conn);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                    
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $credenciales[0];               
        $mail->Password   = $credenciales[1];                         
        $mail->SMTPSecure = 'ssl';         
        $mail->Port       = 465;   

        //Recipients
        $mail->setFrom($credenciales[0], 'Interprogress');
        $mail->addAddress($correo, $nombre);     //Add a recipient            //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Cuestionario activo-Interprogress';
        $mail->Body    = '
        <div style="border:'.$dat[4].' 10px double; background-color:'.$dat[3].';text-align: center;justify-content: center;">
        <img src="http://apsw.42web.io/Correos/Logo.png" />
        <br>
        <label style="color: '.$dat[5].';font-size:xx-large;">
            '.$dat[1].'
        </label>
        <br>
        <br>
        <label style="font-size: larger;color:'.$dat[5].'">
            '.$dat[2].'
        </label>
        <br>
        ';
        $mail->send();
        return 'exito';
    } catch (Exception $e) {
        return "Se han tenido problemas al enviar el correo, intentelo de nuevo.";
    }
}

function Enviardependencia_termino($correo,$nombre_dependencia)
{
    $mail = new PHPMailer(true);
    $consulta = "SELECT * FROM `correos` WHERE correo ='dependencia'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $dat = mysqli_fetch_array($resultado);
    desconectar($conn);
    $consulta = "SELECT * FROM `credenciales` WHERE credenciales.Estado ='1'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $credenciales = mysqli_fetch_array($resultado);
    desconectar($conn);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                    
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $credenciales[0];               
        $mail->Password   = $credenciales[1];                       
        $mail->SMTPSecure = 'ssl';         
        $mail->Port       = 465;   

        //Recipients
        $mail->setFrom($credenciales[0], 'Interprogress');
        $mail->addAddress($correo);     //Add a recipient            //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Una dependencia termino el cuestionario-Interprogress';
        $mail->Body    = '
        <div style="border:'.$dat[4].' 10px double; background-color:'.$dat[3].';text-align: center;justify-content: center;">
        <img src="http://apsw.42web.io/Correos/Logo.png" />
        <br>
        <label style="color: '.$dat[5].';font-size:xx-large;">
            '.$dat[1].'
        </label>
        <br>
        <br>
        <label style="font-size: larger;color:'.$dat[5].'">
            '.$dat[2].'
        </label>
        <br>
        <b style="font-size: xx-large;color:'.$dat[6].'">'.$nombre_dependencia.'</b>
        </div>
        ';
        $mail->send();
        return 'exito';
    } catch (Exception $e) {
        return "Se han tenido problemas al enviar el correo, intentelo de nuevo.";
    }
}