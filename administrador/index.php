<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/css_administrador/index.css" type="text/css" />
  <title>Administrar dependecias</title>
</head>

<body>
  <?php
  include_once "../administrador/include/header.php";
  include_once "../sql/op_administrador.php";
  if (!empty($_POST["btnAdd"])) {
    $respuesta = agregarDependencia($_POST['codigo'], $_POST['nombre'], $_POST['descripcion']);
    if ($respuesta === "exito") {
      echo "<script>repuestaCorrecta('La dependencia fue registrada con exito')</script>";
    } else {
      echo "<script>repuestaError('" . $respuesta . "')</script>";
    }
  }
  ?>
  <div class="titulo">
    <h1>Administrar dependencias</h1>
  </div>
  <div class="contenedor">
    <div class="contenedor_form">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="formulario">
          <div>
            <h2 class="titulo">Registrar dependencia</h2>
            <h2>Codigo</h2>
            <input type="text" name="codigo" class="contenedortext">
            <h2>Nombre</h2>
            <input type="text" name="nombre" class="contenedortext">
            <h2>Descripcion</h2>
            <textarea  type="text" name="descripcion" class="contenedorArea"></textarea>
          </div>
          <input class="button" type="submit" value="Registrar" name="btnAdd" class="button">
        </div>
        <div class="info_semaforo">
          <h2 class="h2semaforo" style="color: red;">🔴 Dependencia sin configurar</h2>
          <h2 class="h2semaforo" style="color: gold;">🟡 Falta configurar</h2>
          <h2 class="h2semaforo" style="color: green;">🟢 Configuracion teminada</h2>
        </div>
      </form>
    </div>
    <div class="contenedor_data">
      <?php
      $consulta = "SELECT * FROM dependencia";
      $conn = conectar();
      $resultado = mysqli_query($conn, $consulta);
      while ($fila = mysqli_fetch_array($resultado)) {
        $colsulta2 = "SELECT * FROM usuarios WHERE dependencia = '".$fila[0]."' AND rol != 5";
        $resultado2 = mysqli_query($conn, $colsulta2);
        
        if(mysqli_num_rows($resultado2) === 0){
          $estado = "est_incorrecto";
        }if(mysqli_num_rows($resultado2) === 2 ||mysqli_num_rows($resultado2) === 1){
          $estado = "est_incompleto";
        }if(mysqli_num_rows($resultado2) === 3){
          $estado = "correcto";
        }
      ?>
        <a href="/administrador/asignar_roles.php?codigo=<?php echo $fila[0];?>">
          <div class="tarjetas <?php echo $estado; ?>">
            <div id="contenido">
              <h1 class="titulo_tarjeta"><?php echo  $fila[1];?></h1>
              <h2 class="codigo_tarjeta"><?php echo $fila[0]; ?></h2>
              <h2 class="informacion"><?php echo $fila[2]; ?></h3>
            </div>
          </div>
        </a>
      <?php } desconectar($conn); ?>
    </div>
  </div>
</body>

</html>