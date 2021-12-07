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
    ?>
    <div class="contenedor">
        <div class="contenedor_form">
            <?php
                $que = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
                $conn = conectar();
                $result = mysqli_query($conn, $que);
                $fecha = mysqli_fetch_array($result);
                if (!empty($_POST["agregar"])) {
                    $respuesta = agregarMejora($_POST['mejora'],$fecha[0] ,$_SESSION["Correo"],$_GET['eje']);
                    if ($respuesta === "exito") {
                      echo "<script>repuestaCorrecta('La dependencia fue registrada con exito')</script>";
                    } else {
                      echo "<script>repuestaError('" . $respuesta . "')</script>";
                    }
                } 
            ?>
            <div class="info_semaforo">
                <h2 class="h2semaforo">📅 Fecha de inicio: <?php echo $fecha[1];?></h2>
                <h2 class="h2semaforo">📅 Fecha de final: <?php echo $fecha[2];?></h2>
            </div>
            <br>
            <div class="info_semaforo">
                <h2 class="h2semaforo">🟡 Evidencia opcional</h2>
            </div>
            
                <?php
                    include_once "../sql/op_dependencia.php";
                    if (!empty($_POST["btnAdd"])) {
                        $respuesta = modificar($_POST['evidencia'],$_GET['codigo'],$_GET['eje'],$_SESSION['Correo']);
                        if ($respuesta === "exito") {
                            echo "<script>repuestaCorrecta('Se ha modificado la evidencia.')</script>";
                        } else {
                            echo "<script>repuestaError('" . $respuesta . "')</script>";
                        }
                    }       
                    $que = "SELECT * FROM respuesta WHERE Componentes = '".$_GET['codigo']."' AND Subcomponentes = '".$_GET['eje']."' AND Dependencia_responsable  = '".$_SESSION['Correo']."' AND Codigo_fecha='".$fecha[0]."'";
                    $conn = conectar();
                    $result = mysqli_query($conn, $que);
                    $evi = mysqli_fetch_array($result);  
                if($evi[4]>=80)
                {
                                               
                ?>
                <div class="formulario_true">
                <?php
                }
                else if($evi[4]>=60 && $evi[4]<=79 )
                {
                ?>
                <div class="formulario_yellow">
                <?php
                }
                else if(empty($evi[4])){
                ?>
                <div class="registro">
                <?php
                    }
                else{
                ?>
                    <div class="formulario_red">
                <?php
                }
                ?>
                <div style="margin-bottom: 25px;">
                <form action="" method="post" enctype="multipart/form-data">
                    <a href="/dependencia/eje_mejora.php?codigo=<?php echo $_GET['codigo']; ?>&titulo=<?php echo $_GET['titulo']; ?>">
                        <img class="img_equis" src="/image/simbolo/regresar.jpg" alt="">
                    </a>
                    <h3 class="h1ti" style="margin-bottom: 10px;">Calificación</h3>
                    <h2 style="font-size: 24px;">Nivel alcanzado:</h2>
                    <h2 style="font-size: 24px;"><?php echo $evi[6];?></h2>
                    <h2 style="font-size: 24px;">Nota: <?php echo $evi[4];?></h2>
                    <?php 
                        if(isset($_GET['oportuinidad'])){
                    ?>
                        <h2 style="font-size: 24px;">Fecha esperada de mejora:</h2>
                        <h2 style="font-size: 24px;"><?php echo $evi[9];?></h2>
                        <h2 style="font-size: 24px;">Compromiso de mejora:</h2>
                        <textarea style="text-align:justify;" type="text" name="evidencia" class="contenedorArea" readonly><?php echo $evi[8]; ?></textarea>
                        <h2 style="font-size: 24px;">Agregar mejora</h2>
                        <input type="text" class="contenedortext" style="width: 300px; margin-bottom:10px;" name="mejora" value="<?php echo $evi[10]; ?>" >
                        <br>
                        <input type="submit" name="agregar" class="button" value="Agregar" >
                    <?php } ?>
                </div>
                </form>
            </div>            

        </div>
        <div class="contenedor_data" >
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
                            <th>Descripcion</th>
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
                            <td>
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









