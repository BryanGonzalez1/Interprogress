<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_administrador/resultado.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <title>Resultados</title>
</head>
<body>
    <?php
    include "include/header.php";
    include_once "../sql/op_administrador.php";
    $consulta = "SELECT Correo, dependencia.Nombre FROM usuarios, dependencia 
    WHERE Dependencia = (SELECT usuarios.Dependencia FROM usuarios WHERE Correo = '".$_SESSION['Correo']."') AND Rol = '4' AND Dependencia = dependencia.Codigo;";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_fetch_array($resultado);
    if (!empty($_POST["btnAdd"])) {
        $respuesta = existeEvaluacion($fila[0], $_POST['fecha']);
        if ($respuesta === "exito") {
            header("location:/dependencia/resultado_componente.php?correo=".$fila[0]."&fecha=".$_POST['fecha']."");
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    ?>
    <div class="info">
        El grafico de lineas representa los promedios de los componentes de cada una de las dependencias en las evaluaciones realizadas
    </div>
    <div class="contenedor">
            <div class="formulario">
                <form action="" method="post" enctype="multipart/form-data">
                    <h1>Resultados</h1>
                    <h2>Departamento</h2>
                    <?php

                    ?>
                    <input name="correo" class="contenedortext" type="text" value="<?php echo $fila[1]; ?>" readonly></input>

                    <h2>Fecha de evaluacion</h2>
                    <select name="fecha" class="contenedortext" >
                        <?php
                            $consulta = "SELECT DISTINCT fecha_evaluacion.Codigo, fecha_evaluacion.F_inicio, fecha_evaluacion.F_final FROM respuesta, fecha_evaluacion WHERE fecha_evaluacion.Estado = '0' AND fecha_evaluacion.Codigo = Codigo_fecha;";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                            while ($fila = mysqli_fetch_array($resultado)) {
                        ?>
                        <option value="<?php echo $fila[0]; ?>" class="opcion"  ><?php echo $fila[1]." a ".$fila[2]; ?></option>;
                        <?php } ?>  
                    </select>
                    <input class="button" type="submit" value="Buscar" name="btnAdd">
                </form>
            </div>
        

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['line']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Evaluaciones');
                <?php
                $consulta = "SELECT Correo, dependencia.Nombre FROM usuarios, dependencia 
                WHERE Dependencia = (SELECT usuarios.Dependencia FROM usuarios WHERE Correo = '".$_SESSION['Correo']."') AND Rol = '4' AND Dependencia = dependencia.Codigo;";
                $conn = conectar();
                $resultado = mysqli_query($conn, $consulta);
                $fila = mysqli_fetch_array($resultado);
                echo "data.addColumn('number', '" . $fila[1] . "');";
                $correo = $fila[0];
                ?>
                data.addRows([
                    <?php
                    $conn = conectar();
                    //fechas de evaluacion
                    $consulta = "SELECT DISTINCT respuesta.Codigo_fecha,fecha_evaluacion.F_inicio,fecha_evaluacion.F_final FROM respuesta, fecha_evaluacion WHERE fecha_evaluacion.Codigo = respuesta.Codigo_fecha AND respuesta.Dependencia_responsable = '".$correo."' AND fecha_evaluacion.Estado = 0 ORDER BY respuesta.Codigo_fecha";
                    $resultado = mysqli_query($conn, $consulta);
                    $con = 1;
                    while ($fila = mysqli_fetch_array($resultado)) {
                        echo " [" . $con . ",";
                        $consulta2 = "SELECT DISTINCT Dependencia_responsable FROM respuesta, usuarios, dependencia WHERE respuesta.Dependencia_responsable = usuarios.Correo AND usuarios.Dependencia = dependencia.Codigo AND respuesta.Dependencia_responsable = '".$correo."'";
                        $resultado2 = mysqli_query($conn, $consulta2);
                        while ($fila2 = mysqli_fetch_array($resultado2)) {

                            $consulta3 = "SELECT (AVG(Nota))Promedio FROM respuesta, fecha_evaluacion WHERE respuesta.Codigo_fecha = fecha_evaluacion.Codigo AND Dependencia_responsable = '" . $fila2[0] . "' AND respuesta.Codigo_fecha = '" . $fila[0] . "'";
                            $resultado3 = mysqli_query($conn, $consulta3);
                            $fila3 = mysqli_fetch_array($resultado3);
                            echo $fila3[0] . ",";
                        }
                        echo "],";
                        $con++;
                    }
                    ?>
                ]);

                var options = {
                    chart: {
                        title: 'Rendimiento de dependencias por evaluacion',
                        subtitle: 'Datos por componente'
                    },
                    axes: {
                        x: {
                            0: {
                                side: 'top'
                            }
                        }
                    }
                    
                };

                var chart = new google.charts.Line(document.getElementById('line_top_x'));

                chart.draw(data, google.charts.Line.convertOptions(options));
            }
        </script>

        <div id="line_top_x" style="height: 400px; margin-left:100px;" class="grafico"></div>
    </div>
</body>
</html>