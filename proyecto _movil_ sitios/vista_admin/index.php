<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="/sass/index.css" rel="stylesheet" type="text/css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
</head>

<body>
    <?php
    include_once 'header.php';
    include_once '../sql/conexion.php';
    include_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = existeEvaluacion($_POST['correo'], $_POST['fecha']);
        if ($respuesta === "exito") {
            header("location:/vista_admin/resultados.php?correo=" . $_POST['correo'] . "&fecha=" . $_POST['fecha'] . "");
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    ?>
    <script>
    $(window).bind('resize', function(e) {
        if (window.RT) clearTimeout(window.RT);
        window.RT = setTimeout(function() {
            this.location.reload(false);
        }, 100);
    });
    </script>
    <div class="contenedor">
        <div class="filtro">
            <div class="formulario">
                <form action="" method="post" enctype="multipart/form-data">
                    <h1>Resultados</h1>
                    <h2>Departamento</h2>
                    <select name="correo" class="contenedortext">
                        <?php
                        $consulta = "SELECT DISTINCT Dependencia_responsable,dependencia.Nombre FROM respuesta, usuarios, dependencia WHERE respuesta.Dependencia_responsable = usuarios.Correo AND usuarios.Dependencia = dependencia.Codigo;";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                        while ($fila = mysqli_fetch_array($resultado)) {
                        ?>
                            <option value="<?php echo $fila[0]; ?>" class="opcion"><?php echo $fila[1]; ?></option>;
                        <?php } ?>
                    </select>
                    <h2>Fecha de evaluacion</h2>
                    <select name="fecha" class="contenedortext">
                        <?php
                        $consulta = "SELECT DISTINCT fecha_evaluacion.Codigo, fecha_evaluacion.F_inicio, fecha_evaluacion.F_final FROM respuesta, fecha_evaluacion WHERE fecha_evaluacion.Estado = '0' AND fecha_evaluacion.Codigo = Codigo_fecha;";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                        while ($fila = mysqli_fetch_array($resultado)) {
                        ?>
                            <option value="<?php echo $fila[0]; ?>" class="opcion"><?php echo $fila[1] . " - " . $fila[2]; ?></option>;
                        <?php } ?>
                    </select>
                    <input class="button" type="submit" value="Buscar" name="btnAdd">
                </form>
            </div>
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
                $consulta = "SELECT DISTINCT Dependencia_responsable,dependencia.Nombre FROM respuesta, usuarios, dependencia WHERE respuesta.Dependencia_responsable = usuarios.Correo AND usuarios.Dependencia = dependencia.Codigo;";
                $conn = conectar();
                $resultado = mysqli_query($conn, $consulta);
                while ($fila = mysqli_fetch_array($resultado)) {
                    echo "data.addColumn('number', '" . $fila[1] . "');";
                }

                ?>
                data.addRows([
                    <?php
                    $conn = conectar();
                    //fechas de evaluacion
                    $consulta = "SELECT DISTINCT respuesta.Codigo_fecha,fecha_evaluacion.F_inicio,fecha_evaluacion.F_final FROM respuesta, fecha_evaluacion WHERE fecha_evaluacion.Codigo = respuesta.Codigo_fecha ORDER BY respuesta.Codigo_fecha";
                    $resultado = mysqli_query($conn, $consulta);
                    $con = 1;
                    while ($fila = mysqli_fetch_array($resultado)) {
                        echo " [" . $con . ",";
                        $consulta2 = "SELECT DISTINCT Dependencia_responsable FROM respuesta, usuarios, dependencia WHERE respuesta.Dependencia_responsable = usuarios.Correo AND usuarios.Dependencia = dependencia.Codigo";
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
        <div id="line_top_x" style="height: 400px;" class="grafico"></div>
    </div>

</body>

</html>