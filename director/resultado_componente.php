<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/css_administrador/result_componente.css" type="text/css" />
  
  <title>Administrar dependecias</title>
</head>

<body>
  <?php
  include "include/header.php";
  include_once "../sql/op_administrador.php";
  $consulta = "SELECT Componentes, (ROUND(AVG(Nota),0))Nota FROM respuesta WHERE Dependencia_responsable = '".$_GET['correo']."' AND Codigo_fecha = '".$_GET['fecha']."' GROUP BY Componentes";
  $conn = conectar();
  $resultado = mysqli_query($conn, $consulta);
  ?>
  <div class="titulo">
    <?php
    $titulo = "SELECT DISTINCT dependencia.Nombre, fecha_evaluacion.F_inicio, fecha_evaluacion.F_final FROM respuesta, usuarios, fecha_evaluacion,dependencia
    WHERE usuarios.Correo =  Dependencia_responsable AND Dependencia_responsable = '".$_GET['correo']."' AND usuarios.Dependencia = dependencia.Codigo AND fecha_evaluacion.Codigo = '10'";
    $restitulo = mysqli_query($conn, $titulo);
    $filatil = mysqli_fetch_array($restitulo);
    
    ?>
    <h1>Resultado del departamento de <?php echo $filatil[0]; ?></h1>
    <h1 style="font-size: 30px;"><?php echo $filatil[1]." - ".$filatil[2]; ?></h1>
  </div>
  <div class="contenedor">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php
            while ($fila = $resultado -> fetch_array()) {
            echo "['".$fila["Componentes"]."',".$fila["Nota"]."],";
            }
        ?>
        ]);

        var options = {
            backgroundColor: { fill:'transparent' },
          title: 'Puntos fuertes'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <div id="piechart" style="width: 850px; height: 500px;  float: left;"></div>
    <div class="contenedor_data">
    <table style="margin-top: 25px;">
        <thead>
            <tr>
                <th>Componente</th>
                <th>Promedio</th>
                <th>Detallar</th>
            </tr>
        </thead>
        <?php
        $consulta = "SELECT Componentes, (ROUND(AVG(Nota),0))Nota FROM respuesta WHERE Dependencia_responsable = '".$_GET['correo']."' AND Codigo_fecha = '".$_GET['fecha']."' GROUP BY Componentes";
        $conn = conectar();
        $resultado = mysqli_query($conn, $consulta);

        while ($fila = mysqli_fetch_array($resultado)){
        ?>
            <tr>
                <td><?php echo $fila[0]; ?></td>
                <td class="<?php echo tipo_notacomp($fila[1]); ?>"><?php echo $fila[1]; ?></td>
                <td >
                    <a href="/director/result_eje.php?correo=<?php echo $_GET['correo']; ?>&fecha=<?php echo $_GET['fecha']; ?>&componente=<?php echo $fila[0]; ?>">
                        <img class="simbolo" src="/image/simbolo/documento.png" alt="asignar rol" >
                    </a>
                </td>
            </tr>
        <?php } desconectar($conn); ?>
    </table>
    <div class="info_semaforo" style="width: 800px;">
        <h2 class="h2semaforo">🔴 Atencion maxima | 🟡 Atencion minima | 🟢 No requiere atencion</h2>
    </div>
    </div>
  </div>
</body>

</html>