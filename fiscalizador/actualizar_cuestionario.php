<?php
  session_start();
  if(!$_SESSION['active']){ 
    header("location:/iniciar_sesion.php");
  }else if((strcasecmp ( $_SESSION['Rol'] , '3')) !== 0)
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
    <link rel="stylesheet" href="/css/css_fiscalizador/act_evidencias.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/js/alertaregistro.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Actualizar cuestionario</title>
</head>
<style>
   
</style>

<body>
    <?php
    require_once "../sql/op_fiscalizador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = modificar_cuestionario($_POST['Estado'], $_POST['descripcion'], $_GET['Componentes'],$_POST['tipo'],$_POST['Nivel']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('Se ha modificado el cuestionario con exito')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    $consulta2 = "SELECT cuestionario.Descripcion,cuestionario.Fecha_act,cuestionario.Tipo,cuestionario.Puntaje FROM cuestionario
    WHERE Componentes = '".$_GET['Componentes']."' AND Subcomponentes = '".$_GET['Subcomponentes']."' AND Nivel='".$_GET['Nivel']."'";
    $conn = conectar();
    $resultado2 = mysqli_query($conn, $consulta2);
    $cuestionario = mysqli_fetch_array($resultado2)
    ?>
    <div class="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <meta charset="UTF-8">
            <div style="margin-bottom: 25px;">
                <a href="/fiscalizador/mostrar_encuesta.php?codigo=<?php echo $_GET['Componentes']; ?>&titulo=<?php echo $_GET['titulo']; ?>&eje=<?php echo $_GET['Subcomponentes']; ?>">
                    <img src="/image/simbolo/regresar.jpg" alt="">
                </a>
                <h1>Actualizar eje</h2>
                <h2>Eje</h2>
                <input type="text" name="tipo" class="contenedortext" readonly value="<?php echo $_GET['Subcomponentes']; ?>">
                <h2>Nivel</h2>
                <input type="text" name="Nivel" class="contenedortext" readonly value="<?php echo $_GET['Nivel']; ?>">
                <h2>Puntaje</h2>
                <input type="text" name="Puntaje" class="contenedortext" readonly value="<?php echo $cuestionario[3]; ?>">
                <h2>Fecha de actualización</h2>
                <input type="text" name="Fechas" class="contenedortext" readonly value="<?php echo $cuestionario[1]; ?>">
                <h2>Descripción</h2>
                <textarea type="text" style="text-align:justify;" name="descripcion" class="contenedorArea"><?php echo $cuestionario[0]; ?></textarea>
                <h2>Tipo de evidencia</h2>
                <select name="Estado" class="contenedortext">
                     <option value="0" class="opcion" <?php if($cuestionario[2] === "0"){echo "selected";}?>>Opcional</option>;
                     <option value="1" class="opcion" <?php if($cuestionario[2] === "1"){echo "selected";}?>>Requerida</option>;
                </select>
            </div>
            <input class="button" type="submit" value="Modificar" name="btnAdd">
        </form>
    </div>
</body>

</html>