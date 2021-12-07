<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Relampago</title>
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(window).bind('resize', function(e) {
            if (window.RT) clearTimeout(window.RT);
            window.RT = setTimeout(function() {
                this.location.reload(false); /* false to get page from cache */
            }, 100);
        });
    </script>
    <?php
    include_once "header.php";
    include_once "../sql/conexion.php";
    function tipo_notacomp($nota){
        if($nota > 79){
            return "bien";
        }
        if($nota > 59 && $nota <80){
            return "mejorar";
        }
        return "fallo";
    }
    $consulta = "SELECT Componentes, (ROUND(AVG(Nota),0))Nota FROM respuesta WHERE Dependencia_responsable = '".$_GET['correo']."' AND Codigo_fecha = '".$_GET['fecha']."' GROUP BY Componentes";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $titulo = "SELECT DISTINCT dependencia.Nombre, fecha_evaluacion.F_inicio, fecha_evaluacion.F_final FROM respuesta, usuarios, fecha_evaluacion,dependencia
    WHERE usuarios.Correo =  Dependencia_responsable AND Dependencia_responsable = '".$_GET['correo']."' AND usuarios.Dependencia = dependencia.Codigo AND fecha_evaluacion.Codigo = '".$_GET['fecha']."'";
    $restitulo = mysqli_query($conn, $titulo);
    $filatil = mysqli_fetch_array($restitulo);
    ?>
    <div class="titulo_info">
        <h1>Estadisticas del departamento de <?php echo $filatil[0]; ?></h1>
        <h2><?php echo $filatil[1]." _ ".$filatil[2]; ?></h2>
    </div>
    <div class="data_form">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    <?php
                    while ($fila = $resultado->fetch_array()) {
                        echo "['" . $fila["Componentes"] . "'," . $fila["Nota"] . "],";
                    } desconectar($conn);
                    ?>
                ]);

                var options = {
                    backgroundColor: {
                        fill: 'transparent'
                    },
                    title: 'Puntos fuertes'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>

        <div id="piechart" class="grafico"></div>
        <div class="tabla">
            <div class="info_semaforo">
                <h2 class="h2semaforo">🔴 Atencion maxima </h2>
                <h2 class="h2semaforo">🟡 Atencion minima </h2>
                <h2 class="h2semaforo">🟢 No requiere atencion</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Componente</th>
                        <th>Promedio</th>
                        <th>Detallar</th>
                    </tr>
                <thead>
                <tbody>
                    <?php
                     $consulta = "SELECT Componentes, (ROUND(AVG(Nota),0))Nota FROM respuesta WHERE Dependencia_responsable = '".$_GET['correo']."' AND Codigo_fecha = '".$_GET['fecha']."' GROUP BY Componentes";
                     $conn = conectar();
                     $resultado = mysqli_query($conn, $consulta);
                     while ($fila = $resultado->fetch_array()) {
                    ?>
                    <tr>
                        <td><?php echo $fila["Componentes"]; ?></td>
                        <td class="<?php echo tipo_notacomp($fila["Nota"]); ?>"><?php echo $fila["Nota"];?></td>
                        <td>
                            <a href="/vista_gen/detalle.php?correo=<?php echo $_GET['correo']; ?>&fecha=<?php echo $_GET['fecha']; ?>&componente=<?php echo $fila["Componentes"]; ?>&dependencia=<?php echo $filatil[0]; ?>">
                                <img src="/image/documento.png" alt="detallar" class="simbolo">
                            </a>
                        </td>
                    </tr>
                    <?php } desconectar($conn); ?>
                </tbody>
            </table>
        </div>
    </div>
   
</body>

</html>