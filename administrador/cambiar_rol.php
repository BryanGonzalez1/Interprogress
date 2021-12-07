<?php
  include_once "../sql/connection/conexion.php";
  session_start();
  if(!$_SESSION['active']){ 
    header("location:/iniciar_sesion.php");
  }else if((strcasecmp ( $_SESSION['Rol'] , '1')) !== 0)
    {
      header("location:/iniciar_sesion.php");
    }
    else{
      $fechaGuardada = $_SESSION["tiempo_de_ingreso"];
      $ahora = date("Y-n-j H:i:s");
      $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
      if($tiempo_transcurrido >= 6000000) {
        require_once "/salir.php";
      }else {
        $_SESSION["tiempo_de_ingreso"] = $ahora;
      }
    }
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- librerias y conexiones -->
    <link rel="stylesheet" href="/css/css_administrador/formulario.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/js/alertaregistro.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Asignar roles</title>
</head>
<style>
   
</style>

<body>
    <?php
    require_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = modificarRol($_POST['mail'], $_POST['Estado'], $_POST['name'],$_GET['codigo']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('Se ha modificado el rol con exito')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    $consulta2 = "SELECT * FROM Usuarios WHERE Correo='".$_GET['Correo']."'";
    $conn = conectar();
    $resultado2 = mysqli_query($conn, $consulta2);
    $usuario = mysqli_fetch_array($resultado2)
    ?>
    <div class="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <meta charset="UTF-8">
            <div style="margin-bottom: 25px;">
                <a href="/administrador/asignar_roles.php/?codigo=<?php echo $_GET['codigo'];?>"><img src="/image/simbolo/regresar.jpg" alt=""></a>
                <h1>Asignar rol en <?php echo $_GET['nombre'];?></h2>
                <h2>Correo</h2>
                <input type="email" name="mail" class="contenedortext" readonly value="<?php echo $usuario[0]; ?>">
                <h2>Nombre</h2>
                <input type="text" name="name" class="contenedortext" readonly value="<?php echo $usuario[2]; ?>">
                <h2>Apellido</h2>
                <input type="text" name="lastname" class="contenedortext" readonly value="<?php echo $usuario[3]; ?>">
                <h2>Direccion</h2>
                <input type="text" name="adress" class="contenedortext" readonly value="<?php echo $usuario[4]; ?>">
                <h2>Rol</h2>
                <select name="Estado" class="contenedortext">
                    <?php
                        $consulta = "SELECT * FROM rol WHERE Id_rol != '1'";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                        while ($fila = mysqli_fetch_array($resultado)) {
                    ?>
                     <option value="<?php echo $fila[0]; ?>" class="opcion" <?php if($usuario[6] === $fila[0]){echo "selected";}?> ><?php echo $fila[1]; ?></option>;
                    <?php } ?>  
                </select>
            </div>
            <input class="button" type="submit" value="Guardar" name="btnAdd">
        </form>
    </div>
</body>

</html>