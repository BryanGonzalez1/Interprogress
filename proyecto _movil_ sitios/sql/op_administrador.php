<?php
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

?>
