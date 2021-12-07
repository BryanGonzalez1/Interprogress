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
    <title>Actualizar fecha</title>
</head>
<style>

</style>

<body>
    <?php
    require_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = modificarfecha($_GET['Codigo'], $_POST['finicio'], $_POST['ffinal'], $_POST['estado']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('Se ha modificado la fecha con exito')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    $consulta2 = "SELECT * FROM fecha_evaluacion WHERE Codigo='" . $_GET['Codigo'] . "'";
    $conn = conectar();
    $resultado2 = mysqli_query($conn, $consulta2);
    $fecha = mysqli_fetch_array($resultado2);
    desconectar($conn);
    ?>
    <div class="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <meta charset="UTF-8">
            <div style="margin-bottom: 25px;">
                <a href="/administrador/administrar_fechas.php"><img src="/image/simbolo/regresar.jpg" alt=""></a>
                <h1 style="margin-top: 100px;">Modificar fecha de evaluación</h2>
                <h2>Fecha de inicio</h2>
                <input type="date" name="finicio" class="contenedortext" value="<?php echo $fecha[1]; ?>">
                <h2>Fecha final</h2>
                <input type="date" name="ffinal" class="contenedortext" value="<?php echo $fecha[2]; ?>">
                <h2>Estado</h2>
                <select name="estado" class="contenedortext" style="height: 39px;">
                    <option value="1" <?php if($fecha[3] === "1"){echo "selected"; }?>>Activo</option>
                    <option value="0" <?php if($fecha[3] === "0"){echo "selected"; }?>>Inactivo</option>
                </select>
            </div>
            <input class="button" type="submit" value="Modificar" name="btnAdd">
        </form>
    </div>
</body>

</html>