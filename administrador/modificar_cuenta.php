<?php
  include_once "../sql/connection/conexion.php";
  include "../administrador/include/header.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- librerias y conexiones -->
    <link rel="stylesheet" href="/css/css_administrador/modi_cuenta.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/js/alertaregistro.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Modificar cuenta</title>
</head>
<style>

</style>

<body>
    <?php
    require_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = modificar_cuenta($_SESSION['Correo'],$_POST['nombre'],$_POST['apellidos'],$_POST['contrasena'],$_POST['direccion']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('Se ha modificado la información del usuario')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    $consulta2 = "SELECT Nombre,Apellidos,Direccion,Contrasena FROM Usuarios WHERE Correo='" .$_SESSION['Correo']. "'";
    $conn = conectar();
    $resultado2 = mysqli_query($conn, $consulta2);
    $fecha = mysqli_fetch_array($resultado2);
    desconectar($conn);
    ?>
    <div class="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <meta charset="UTF-8">
            <div style="margin-bottom: 25px;">
                <h1 >Modificar cuenta</h2>
                <h2>Nombre</h2>
                <input type="text" name="nombre" class="contenedortext" value="<?php echo $fecha[0]; ?>">
                <h2>Apellidos</h2>
                <input type="text" name="apellidos" class="contenedortext" value="<?php echo $fecha[1]; ?>">
                <h2>Dirección</h2>
                <input type="text" name="direccion" class="contenedortext" value="<?php echo $fecha[2]; ?>">
                <h2>Contraseña</h2>
                <input type="password" name="contrasena" class="contenedortext" value="<?php echo $fecha[3]; ?>">
            </div>
            <input class="button" type="submit" value="Guardar" name="btnAdd">
        </form>
    </div>
</body>

</html>