<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_dependencia/evidencia.css" type="text/css" />
    <title>Adjuntar evidencia</title>
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
            if (!empty($fila[5]))
            {
                $datos[$i]["estado"] = 'correcto';
            }
            else{
                $datos[$i]["estado"] = 'est_incorrecto';
            }
            $i++;
        }
    ?>
    <div class="contenedor">
        <div class="contenedor_form">
            <?php
                $que = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
                $conn = conectar();
                $result = mysqli_query($conn, $que);
                $fecha = mysqli_fetch_array($result);  
            ?>
            <div class="info_semaforo">
                <h2 class="h2semaforo">📅 Fecha de inicio: <?php echo $fecha[1];?></h2>
                <h2 class="h2semaforo">📅 Fecha de final: <?php echo $fecha[2];?></h2>
            </div>
            <br>
            <div class="info_semaforo">
                <h2 class="h2semaforo">🟡 Evidencia opcional</h2>
            </div>
            <div class="registro">
                <?php
                    include_once "../sql/op_dependencia.php";
                    if (!empty($_POST["btnAdd"])) {
                        $respuesta = modificar($_POST['evidencia'],$_GET['codigo'],$_GET['eje'],$_SESSION['Correo']);
                        if ($respuesta === "exito") {
                            echo "<script>repuestaCorrecta('Se ha adjuntado la evidencia.')</script>";
                        } else {
                            echo "<script>repuestaError('" . $respuesta . "')</script>";
                        }
                    }       
                    $que = "SELECT Evidencia FROM respuesta WHERE Componentes = '".$_GET['codigo']."' AND Subcomponentes = '".$_GET['eje']."' AND Dependencia_responsable  = '".$_SESSION['Correo']."' AND Codigo_fecha='".$fecha[0]."'";
                    $conn = conectar();
                    $result = mysqli_query($conn, $que);
                    $evi = mysqli_fetch_array($result);                                
                ?>
                <div style="margin-bottom: 25px;">
                <form action="" method="post" enctype="multipart/form-data">
                    <a href="/dependencia/eje_componente.php?codigo=<?php echo $_GET['codigo']; ?>&titulo=<?php echo $_GET['titulo']; ?>">
                        <img class="img_equis" src="/image/simbolo/regresar.jpg" alt="">
                    </a>
                    <h1 class="h1ti">Agregar evidencia</h1>
                    <textarea type="text" name="evidencia" class="contenedorArea"><?php echo $evi[0]; ?></textarea>
                </div>
                    <input class="button" type="submit" value="Guardar" name="btnAdd">
                </form>
            </div>            

        </div>
        <div class="contenedor_data">
            <div class="titulo" style="margin-top:100px;">
                <h1>Componente: <?php echo $_GET['titulo']; ?></h1>
                <h1>Eje: <?php echo $_GET['eje']; ?></h1>
            </div>
            <?php
            $consulta = "SELECT * FROM cuestionario WHERE cuestionario.Componentes = '".$_GET['codigo']."' and cuestionario.Subcomponentes = '".$_GET['eje']."' ORDER BY FIELD(Nivel,'Incipiente','Novato','Competente','Diestro','Experto')";
            $conn = conectar();
            $resultado = mysqli_query($conn, $consulta);
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nivel</th>
                            <th>Descripción</th>
                            <th>Puntaje</th>
                        </tr>
                    </thead>
                    <?php
                    while ($fila = mysqli_fetch_array($resultado)) {
                        if($fila[5] === '1')
                        {
                    ?>
                        <tr>
                            <td><?php echo $fila[2]; ?></td>
                            <td style="text-align:justify;">
                                <?php
                                    if($fila[3] !== ""){
                                        echo $fila[3];
                                    }else{
                                        echo "Sin evidencias descritas";
                                    }
                                ?>
                            </td>
                            <td><?php echo $fila[6]; ?></td>
                        </tr>
                    <?php
                        }
                        else
                        {
                    ?>
                        <tr style="background-color: rgb(245, 189, 7);">
                            <td><?php echo $fila[2]; ?></td>
                            <td style="text-align:justify;">
                                <?php
                                    if($fila[3] !== ""){
                                        echo $fila[3];
                                    }else{
                                        echo "Sin evidencias descritas";
                                    }
                                ?>
                            </td>
                            <td><?php echo $fila[6]; ?></td>
                        </tr>
                    <?php
                        }       
                    }
                    ?>
                </table>
            <?php
            desconectar($conn);
            ?>
        </div>
    </div>
</body>

</html>









