<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_administrador/rev_evidencias.css" type="text/css" />
    <title>Revisar evidencias</title>
</head>

<body>
    <?php
    include_once "../administrador/include/header.php";
    include_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = modificar($_POST['mejora'], $_POST["estado"], $_POST["nota"], $_GET['codigo'], $_GET['eje'], $_GET['reponsable'],$_POST["fecha_mejora"]);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('Se ha guardado la revision de la evidencia')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    $consulta = "SELECT respuesta.Evidencia,respuesta.Nota,respuesta.Compromiso_de_mejoras,respuesta.Estado_nivel,respuesta.Fecha_mejora,Mejora FROM respuesta
    WHERE Componentes = '" . $_GET['codigo'] . "' AND Subcomponentes= '" . $_GET['eje'] . "' AND Dependencia_responsable = '" . $_GET['reponsable'] . "' AND Codigo_fecha = '" . $_GET['fecha'] . "'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $departamento = mysqli_fetch_array($resultado);
    ?>
    <div class="titulo" style="margin-bottom: 15px;">
        <h1>Revisar eje de <?php echo $_GET["eje"]; ?></h1>
    </div>
    <div class="contenedor">
        <div class="contenedor_form">
            <form action="" method="post" enctype="multipart/form-data">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="formulario">
                        <div style="text-align:end;"><a href="/administrador/rev_eje.php?codigo=<?php echo $_GET["codigo"]; ?>&dependencia=<?php echo $_GET["dependencia"]; ?>&fecha=<?php echo $_GET["fecha"]; ?>&reponsable=<?php echo $_GET["reponsable"]; ?>&titulo=<?php echo $_GET["titulo"]; ?>" class="del-btn"><img src="/image/simbolo/eliminar.png" alt="eliminar" class="simbolo"></a></div>
                        <div>
                            <h2>Dependencia</h2>
                            <input type="text" name="codigo" class="contenedortext" value="<?php echo $_GET["dependencia"]; ?>" readonly>
                            <h2>Evidencia</h2>
                            <a href="<?php echo $departamento[0]; ?>">
                                <input type="text" name="evidencia" class="contenedortext" value="<?php echo $departamento[0]; ?>" readonly>
                            </a>
                            <h2>Puntaje</h2>
                            <input type="Number" name="nota" class="contenedortext" value="<?php echo $departamento[1]; ?>">
                            <h2>Compromiso de mejoras</h2>
                            <textarea type="text"  style="text-align:justify;" name="mejora" class="contenedorArea"><?php echo $departamento[2]; ?></textarea>
                            <h2>Fecha esperada de mejora</h2>
                            <input type="Date" name="fecha_mejora" class="contenedortext" value="<?php echo $departamento[4]; ?>">
                            <h2>Nivel alcanzado</h2>
                            <select name="estado" class="contenedortext">
                                <option <?php if ($departamento[3] === "Incipiente") {
                                            echo "selected";
                                        } ?> class="opcion">Incipiente</option>;
                                <option <?php if ($departamento[3] === "Novato") {
                                            echo "selected";
                                        } ?> class="opcion">Novato</option>;
                                <option <?php if ($departamento[3] === "Competente") {
                                            echo "selected";
                                        } ?> class="opcion">Competente</option>;
                                <option <?php if ($departamento[3] === "Diestro") {
                                            echo "selected";
                                        } ?> class="opcion">Diestro</option>;
                                <option <?php if ($departamento[3] === "Experto") {
                                            echo "selected";
                                        } ?> class="opcion">Experto</option>;
                            </select>
                            <?php 
                             $consulta = "SELECT respuesta.Evidencia,respuesta.Nota,respuesta.Compromiso_de_mejoras,respuesta.Estado_nivel,respuesta.Fecha_mejora,Mejora FROM respuesta
                             WHERE Componentes = '" . $_GET['codigo'] . "' AND Subcomponentes= '" . $_GET['eje'] . "' AND Dependencia_responsable = '" . $_GET['reponsable'] . "' AND Codigo_fecha = '" . $_GET['fecha'] . "' AND Estado_mejora = 0";
                             $conn = conectar();
                             $resultado = mysqli_query($conn, $consulta);
                             if(mysqli_num_rows($resultado)){
                            ?>
                            <h2>Mejora realizada</h2>
                            <input type="text" class="contenedortext" value="<?php echo $departamento[5]; ?>">
                            <?php } ?>
                        </div>
                        <input type="submit" value="Modificar" name="btnAdd" class="button" style="  width: 200px; height: 50px;">
                    </div>
                    <div class="contenedor_form">
                        <div class="info_semaforo">
                            🟡 Evidencia opcional
                        </div>
                    </div>
                </form>
            </form>
        </div>
        <div class="contenedor_data">
            <div class="datos">
                <table style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th>Nivel</th>
                            <th>Descripción</th>
                            <th>Puntaje</th>
                        </tr>
                    </thead>
                    <?php
                    $consulta = "SELECT * FROM cuestionario WHERE cuestionario.Componentes = '" . $_GET['codigo'] . "' and cuestionario.Subcomponentes = '" . $_GET['eje'] . "' ORDER BY FIELD(Nivel,'Incipiente','Novato','Competente','Diestro','Experto')";
                    $conn = conectar();
                    $resultado = mysqli_query($conn, $consulta);
                    while ($fila = mysqli_fetch_array($resultado)) {
                    ?>
                        <tr class="<?php if ($fila[5] === "0") {
                                        echo "opcional";
                                    } ?>">
                            <td><?php echo $fila[2]; ?></td>
                            <td style="text-align:justify;">
                                <?php if ($fila[3] !== "") {
                                    echo $fila[3];
                                } else {
                                    echo "Sin evidencias descritas";
                                }
                                ?>
                            </td>
                            <td><?php echo $fila[6]; ?></td>
                        </tr>
                    <?php }
                    desconectar($conn); ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>