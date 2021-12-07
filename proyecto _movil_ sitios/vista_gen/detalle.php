<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include_once "header.php";
    include_once "../sql/conexion.php";
    function tipo_notacomp($nota){
        if($nota > 79){
            return "bien_t";
        }
        if($nota > 59 && $nota <80){
            return "mejorar_t";
        }
        return "fallo_t";
    }
    ?>
    <div class="titulo_info">
        <h1>Revision del componente de <?php echo $_GET["componente"]; ?></h1>
    </div>
    <div class="contenedor_data">
        <div class="info_semaforo2">
            <h2 class="h2semaforo">🔴 Atencion maxima </h2>
            <h2 class="h2semaforo">🟡 Atencion minima </h2>
            <h2 class="h2semaforo">🟢 No requiere atencion</h2>
        </div>
        <a href="/vista_gen/resultados.php?dependencia=<?php echo $_GET["dependencia"]; ?>&correo=<?php echo $_GET["correo"]; ?>&fecha=<?php echo $_GET["fecha"]; ?>"><input class="regresar" type="submit" value="Regresar"  name="btnAdd" style="width: 25%;"></input></a> <br>
        <?php if(isset($_GET['grafico'])){ ?>
            <a href="/vista_gen/detalle.php?correo=<?php echo $_GET['correo']; ?>&fecha=<?php echo $_GET['fecha']; ?>&componente=<?php echo $_GET['componente']; ?>&dependencia=<?php echo $_GET['dependencia']; ?>"><input class="regresar" type="submit" value="Detallar"  name="btnAdd" style="width: 25%;"></input></a>
        <?php }else{ ?>
            <a href="/vista_gen/detalle.php?correo=<?php echo $_GET['correo']; ?>&fecha=<?php echo $_GET['fecha']; ?>&componente=<?php echo $_GET['componente']; ?>&dependencia=<?php echo $_GET['dependencia']; ?>&grafico"><input class="regresar" type="submit" value="Resumir"  name="btnAdd" style="width: 25%;"></input></a>
        <?php } ?>
       
    </div>
    <?php 
        if(isset($_GET['grafico'])){
            echo "<div class='sas'>";
            echo "<div id='top_x_div' class='grafico' style='border: 1px solid black;'></div>";
            echo "</div>";
        }else{ 
    ?>
    <div class="contenedor_data">
        <?php
            $Val = "SELECT * FROM respuesta WHERE Dependencia_responsable= '".$_GET['correo']."' AND Codigo_fecha = '".$_GET['fecha']."' AND Componentes = '".$_GET['componente']."'";
            $conn = conectar();
            $resulval = mysqli_query($conn, $Val);
            while ($fila = mysqli_fetch_array($resulval)){
            ?>
                    <div class="<?php echo tipo_notacomp($fila[4]); ?>">
                        <?php 
                            if($fila[8] !== "" && $fila[9] !== "0000-00-00"){
                        ?>
                            <h3><?php echo $fila[2]; ?></h3>
                            <h4>Nivel:</h4>
                            <h4><?php echo $fila[6]; ?></h3>
                            <h4>Puntaje: <?php echo $fila[4]; ?></h4>
                            <h4>Oportunidades de mejora:</h4>
                            <textarea type="text"  style="text-align:justify;" name="mejora" readonly class="contenedorArea"><?php echo "$fila[8]"; ?></textarea>
                            <h4>Fecha esperada de mejora:</h4>
                            <input type="text" name="nota" class="contenedortext" readonly value="<?php echo $fila[9]; ?>">
                            <h4>Evidencia de mejora agregada:</h4>
                            <input type="text" name="nota" class="contenedortext" readonly value="<?php if(!empty($fila[10])){echo $fila[10]; }else{echo "No se agrego evidencia de mejora";}?>">
                        <?php }else{ ?>
                            <h3 style="margin-top: 130px;"><?php echo $fila[2]; ?></h3>
                            <h4>Nivel:</h4>
                            <h4><?php echo $fila[6]; ?></h3>
                            <h4>Puntaje: <?php echo $fila[4]; ?></h4>
                        <?php }?>
                    </div>
            <?php } ?>

        <?php   
            }
        ?>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
            ['Componentes', 'Nota'],
            <?php
            $Val = "SELECT Subcomponentes, Estado_nivel, Nota, Compromiso_de_mejoras, Fecha_mejora FROM respuesta WHERE Dependencia_responsable= '".$_GET['correo']."' AND Codigo_fecha = '".$_GET['fecha']."' AND Componentes = '".$_GET['componente']."'";
            $conn = conectar();
            $resultado = mysqli_query($conn, $Val);
            while ($fila = $resultado->fetch_array()) 
            {
                echo "['" . $fila["Subcomponentes"] . "'," . $fila["Nota"] . "],";
            }
        ?>
        ]);
        var options = {
            hAxis: {
                textStyle: {
                    fontName: 'Roboto',
                    color: '#ffffff'
                },
            },
            vAxis: {
                textStyle: {
                    fontName: 'Roboto',
                    color: 'black'
                },
            },
            chartArea: {
                backgroundColor: '#ffffff',
            },
            backgroundColor: {
                fill: '#ffffff',
            },
            legend: {
                position: 'none',
                textStyle: {
                    color: "#134E5E"
                }
            },
            bars: 'vertical',
            axes: {
                x: {
                    0: {
                        side: 'bottom',
                        label: 'Componente',

                    }
                },
                y: {
                    0: {
                        side: 'left',
                        label: 'Promedio'
                    }
                }
            },
            colors: '#134E5E'
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    };
    </script>
</body>

</html>