<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_dependencia/cuestionario.css" type="text/css" />
    <title>Ejes de componente</title>
</head>

<body>
    <?php 
        include "include/header.php";
        require_once "../sql/op_dependencia.php";
        $Val = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
        $conn = conectar();
        $resulval = mysqli_query($conn, $Val);
        $fecha_0 = mysqli_fetch_array($resulval);
        $Val = "select * from respuesta where Codigo_fecha='".$fecha_0[0]."' and Dependencia_responsable='".$_SESSION['Correo']."'  and Componentes='".$_GET['codigo']."'";
        $resulval = mysqli_query($conn, $Val);
        $i = 0;
        while ($fila = mysqli_fetch_array($resulval)) 
        {
            $datos[$i]["Subcomponentes"] = $fila[2];
            if (!empty($fila[4]))
            {
                if($fila[8] !== "" && !empty($fila[4]) && !empty($fila[9])){
                    $datos[$i]["estado"] = 'oportuinidad';
                }else{
                    $datos[$i]["estado"] = 'correcto';
                }
            }
            else{
                $datos[$i]["estado"] = 'est_incorrecto';
            }
            $i++;
        }
    ?>
    <div class="contenedor_form">
        <div class="info_semaforo" style="margin-bottom: 15px;">
            <h2 class="h2semaforo">🔴 Sin revisar</h2>
            <h2 class="h2semaforo">🟢 Eje revisado</h2>
            <h2 class="h2semaforo">🔵 oportuinidad de mejora</h2>
        </div>
    </div>
    <div class="titulo" style="margin-top:200px;">
        <h1><?php echo $_GET['titulo'];?></h1>
    </div>
    <div id="contenedor" style="margin-top: 10px;">
            <?php
                if($datos[0]["estado"]==="correcto" || $datos[0]["estado"]==="oportuinidad")
                {
            ?>
            <a href="/dependencia/ver_resultado.php?codigo=<?php echo $_GET['codigo']; ?>&titulo=<?php echo $_GET['titulo']; ?>&eje=<?php echo $datos[0]["Subcomponentes"]; ?>&<?php echo $datos[0]["estado"]; ?>">
                <div class="tarjetas <?php echo $datos[0]["estado"]; ?>">
                    <div id="eje1">
                        <div id="tipo_nombre"><?php echo $datos[0]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            </a>
            <?php
                }
                else
                {
            ?>
                <div class="tarjetas <?php echo $datos[0]["estado"]; ?>">
                    <div id="eje1">
                        <div id="tipo_nombre"><?php echo $datos[0]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            <?php
                }
            ?>
            <?php
                if($datos[1]["estado"]==="correcto")
                {
            ?>
            <a href="/dependencia/ver_resultado.php?codigo=<?php echo $_GET['codigo']; ?>&titulo=<?php echo $_GET['titulo']; ?>&eje=<?php echo $datos[1]["Subcomponentes"]; ?>">
                <div class="tarjetas <?php echo $datos[1]["estado"]; ?>">
                    <div id="eje2">
                        <div id="tipo_nombre"><?php echo $datos[1]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            </a>
            <?php
                }
                else
                {
            ?>
                <div class="tarjetas <?php echo $datos[1]["estado"]; ?>">
                    <div id="eje2">
                        <div id="tipo_nombre"><?php echo $datos[1]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            <?php
                }
            ?>
            <?php
                if($datos[2]["estado"]==="correcto")
                {
            ?>
            <a href="/dependencia/ver_resultado.php?codigo=<?php echo $_GET['codigo']; ?>&titulo=<?php echo $_GET['titulo']; ?>&eje=<?php echo $datos[2]["Subcomponentes"]; ?>">
                <div class="tarjetas <?php echo $datos[2]["estado"]; ?>">
                    <div id="eje3">
                        <div id="tipo_nombre"><?php echo $datos[2]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            </a>
            <?php
                }
                else
                {
            ?>
                <div class="tarjetas <?php echo $datos[2]["estado"]; ?>">
                    <div id="eje3">
                        <div id="tipo_nombre"><?php echo $datos[2]["Subcomponentes"]; ?></div>
                    </div>
                </div>            
            <?php
                }
            ?>
            <?php
                if($datos[3]["estado"]==="correcto")
                {
            ?>
            <a href="/dependencia/ver_resultado.php?codigo=<?php echo $_GET['codigo']; ?>&titulo=<?php echo $_GET['titulo']; ?>&eje=<?php echo $datos[3]["Subcomponentes"]; ?>">
                <div class="tarjetas <?php echo $datos[3]["estado"]; ?>">
                    <div id="eje4">
                        <div id="tipo_nombre"><?php echo $datos[3]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            </a>
            <?php
                }
                else
                {
            ?>
                <div class="tarjetas <?php echo $datos[3]["estado"]; ?>">
                    <div id="eje4">
                        <div id="tipo_nombre"><?php echo $datos[3]["Subcomponentes"]; ?></div>
                    </div>
                </div>
            <?php
                }
            ?>
    </div>
</body>

</html>









