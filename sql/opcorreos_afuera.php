<?php
require_once "connection/conexion.php";
require_once "PHPMailer/Exception.php";
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function Enviarcorreo_contrasena($contra,$correo,$nombre)
{
    $mail = new PHPMailer(true);
    $consulta = "SELECT * FROM `correos` WHERE correo ='registro'";
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
        $mail->Subject = 'Inicio de sesion-Interprogress';
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
        <b style="font-size: xx-large;color:'.$dat[6].'">'.$contra.'</b>
        </div>
        ';
        $mail->send();
        return 'exito';
    } catch (Exception $e) {
        return "No se ha encontrado el gmail digitado.";
    }
}
