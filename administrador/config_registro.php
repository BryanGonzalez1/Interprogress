<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_administrador/admin_roles.css" type="text/css" />
    <link rel="stylesheet" href="/css/css_administrador/config_sistema.css" type="text/css" />
    <title>Configuración de registro</title>
</head>
<body>
    <?php
        include_once "../administrador/include/header.php";
        include_once "../administrador/include/headerconfi.php";
    ?>
    <div class="titulo_confi">
        <h1>Configuración del correo de registro</h1>
    </div>
    <div class="contenedor">
        <div class="contenedor_form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="formulario cambio_color">                
                    <div>
                        Este correo se utilizara cuando se
                        registra un nuevo usuario, donde a 
                        este le llegara una contraseña para 
                        poder ingresar al sistema.
                    </div>
                </div>
            </form>
        </div>
        <?php
            
            if (!empty($_POST["btnmodificar"])) {
                $respuesta = modificarcorreo('registro', $_POST['header'], $_POST['subheader'],$_POST['backcolor'],$_POST['bordercolor'],$_POST['cabeceracolor'],$_POST['passcolor']);
                if ($respuesta === "exito") {
                    echo "<script>repuestaCorrecta('Se ha modificado el formato del correo')</script>";
                } else {
                    echo "<script>repuestaError('" . $respuesta . "')</script>";
                }
            }
        ?>
        <?php
            include_once "../sql/opconfi.php";
            $consulta = "SELECT * FROM `correos` WHERE correo ='registro'";
            $conn = conectar();
            $resultado = mysqli_query($conn, $consulta);
            $dat = mysqli_fetch_array($resultado)
        ?>
        <div class="contenedor_data">
            <div class="contenedor_form">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="formulario form_gmail">                
                            <div>
                                <h2 class="titulo">Configuración del correo</h2>
                                <div>
                                    <div style="border: <?php echo $dat[4]?> 10px double; background-color:<?php echo $dat[3]; ?>;text-align: center;justify-content: center;">
                                        <img src="/image/Logo.png" alt="">
                                        <br>
                                        <textarea style="font-size:xx-large;color: <?php echo $dat[5] ?>;" rows="3" maxlength="117" type="text" name="header" class="contenedorheader"><?php echo $dat[1] ?></textarea>
                                        <br>
                                        <br>
                                        <textarea rows="3" style="font-size: 20px;color: <?php echo $dat[5] ?>;" maxlength="156" type="text" name="subheader" class="contenedorheader"><?php echo $dat[2] ?></textarea>
                                        <br>
                                        <b style="font-size: xx-large;color: <?php echo $dat[6] ?>;">password</b>
                                        <br>
                                        <br>
                                    </div>                                   
                                </div>
                            </div>
                            <h2>Color de fondo</h2>
                            <input type="color" style="height:50px;" value="<?php echo $dat[3]; ?>" name="backcolor" class="contenedortext">
                            <br>
                            <h2>Color de bordes</h2>
                            <input type="color" style="height:50px;" value="<?php echo $dat[4]; ?>" name="bordercolor" class="contenedortext">
                            <br>
                            <h2>Color de la letra cabecera</h2>
                            <input type="color" style="height:50px;" value="<?php echo $dat[5]; ?>" name="cabeceracolor" class="contenedortext">
                            <br>
                            <h2>Color de "password"</h2>
                            <input type="color" style="height:50px;" value="<?php echo $dat[6]; ?>" name="passcolor" class="contenedortext">
                            <br>
                            <input type="submit" value="Guardar" name="btnmodificar" class="button" style="  width: 200px; height: 50px;">
                    </div>
                </form>
            </div>     
        </div>
    </div>
</body>

</html>
