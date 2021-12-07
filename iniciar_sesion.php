<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/iniciar_sesion.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/alertaregistro.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Iniciar sesion</title>
</head>
<body id = "fondo">
<?php
        require_once "sql/op_sesion.php";
        session_start();
        if(!empty($_SESSION['active'])){
            if((strcasecmp ( $_SESSION['Rol'] , '1'))===0){
                header("location:/administrador/index.php"); //adminitrador
            }
            if((strcasecmp ( $_SESSION['Rol'] , '2'))===0){
                header("location:/director/index.php");              //director
            }
            if((strcasecmp ( $_SESSION['Rol'] , '3'))===0){
                header("location:/fiscalizador/index.php"); //fiscalizador      
            }
            if((strcasecmp ( $_SESSION['Rol'] , '4'))===0){
                header("location:/dependencia/index.php");             //Dependecia
            }
        }else{
            if(!empty($_POST["iniciarSesion"])){
                $respuesta = iniciarSession($_POST['mail'],$_POST['password']);
                if($respuesta === "1"){
                    $_SESSION['active']= true;
                    $_SESSION['Correo']=$_POST['mail'];
                    $_SESSION["tiempo_de_ingreso"]= date("Y-n-j H:i:s");
                    $_SESSION['Rol']='1';
                    header("location:/administrador/index.php");
                }
                else if($respuesta === "2"){
                    $_SESSION['active']= true;
                    $_SESSION['Correo']=$_POST['mail'];
                    $_SESSION["tiempo_de_ingreso"]= date("Y-n-j H:i:s");
                    $_SESSION['Rol']='2';
                    header("location:/director/index.php");
                }
                else if($respuesta === "3"){
                    $_SESSION['active']= true;
                    $_SESSION['Correo']=$_POST['mail'];
                    $_SESSION["tiempo_de_ingreso"]= date("Y-n-j H:i:s");
                    $_SESSION['Rol']='3';
                    header("location:/fiscalizador/index.php");
                }
                else if($respuesta === "4"){
                    $_SESSION['active']= true;
                    $_SESSION['Correo']=$_POST['mail'];
                    $_SESSION["tiempo_de_ingreso"]= date("Y-n-j H:i:s");
                    $_SESSION['Rol']='4';
                    header("location:/Dependencia/index.php");
                }
                else if($respuesta === "5")
                {
                    echo "<script>repuestaError('Aun no tienes un rol asignado, espera a que se te asigne uno para poder ingresar.')</script>";
                }
                else {
                    echo "<script>repuestaError('" . $respuesta . "')</script>";
                }
            }
        }
        if(!empty($_POST["registro"])){
            header("location:/registro.php");
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="sesion">
            <img src="/image/Logo.png" alt="logo">
            <div style="margin-bottom: 25px;">
                <input class="contenedortext" type="text" placeholder="✉️ Correo electronico" name="mail">
                <input class="contenedortext" type="password" placeholder="🔒 Contraseña" name="password">
            </div>
            <input type="submit" class="login-btn" value="Iniciar sesión" name="iniciarSesion"></input>
            <input type="submit" class="login-btn" value="Registrarse" name="registro"></input>
        </div>
    </form>
    
</body>
</html>