<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_fiscalizador/menu_eje.css" type="text/css" />
    <title>Revisar cuestionario</title>
</head>

<body>
    <?php
    include "include/header.php";
    include_once "../sql/connection/conexion.php";
    $Val = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
    $conn = conectar();
    $resulval = mysqli_query($conn, $Val);
    if (mysqli_num_rows($resulval)) {
        include_once "../sql/op_administrador.php";
    ?>
        <div style="width: 100%;">
            <div class="info_semaforo" style="width: 360px; float: left;">
                <h2 class="h2semaforo" style="font-size: 15px;">🔴 Sin revision</h2>
                <h2 class="h2semaforo" style="font-size: 15px;">🟢 Con revision</h2>
                <h2 class="h2semaforo" style="font-size: 15px;">🔵 Mejora agregada</h2>
            </div>
            <div class="" style="float: left; margin-left:70%;">
                <a href="/administrador/menu_revcuestionario.php?dependencia=<?php echo $_GET["dependencia"]; ?>&responsable=<?php echo $_GET["reponsable"]; ?>&fecha=<?php echo $_GET["fecha"]; ?>"><input type="submit" class="button" value="salir"></a>
            </div>
        </div>
        <div class="titulo" style="margin-top: 185px;">
            <h1>Revision del componente de <?php echo $_GET["titulo"]; ?></h1>
        </div>
        <div class="contenedor_data">
            <?php
            $consulta = "SELECT DISTINCT Subcomponentes FROM respuesta WHERE Componentes = '" . $_GET["codigo"] . "'";
            $conn = conectar();
            $resultado = mysqli_query($conn, $consulta);
            while ($fila = mysqli_fetch_array($resultado)) {
            ?>
                <a href="/administrador/rev_evidecia.php?codigo=<?php echo $_GET["codigo"]; ?>&dependencia=<?php echo $_GET["dependencia"];?>&eje=<?php echo $fila[0];?>&fecha=<?php echo $_GET["fecha"]; ?>&reponsable=<?php echo $_GET["reponsable"]; ?>&titulo=<?php echo $_GET["titulo"]; ?>">
                    <div class="tarjetas <?php echo falta_eje($_GET["codigo"], $fila[0], $_GET["reponsable"],$_GET["fecha"]); ?>">
                        <div id="contenido">
                            <h1 class="titulo_tarjeta"><?php echo  $fila[0]; ?></h1>
                        </div>
                    </div>
                </a>
            <?php }
            desconectar($conn); ?>
        </div>
    <?php } else { ?>
        <div class="Sin_menu">
            <h1 class="titulo_error">No hay cuestionarios por revisar.</h1>
            <img src="/image/simbolo/advertencia.png" alt="advertencia" class="adv">
        </div>
    <?php } ?>
</body>

</html>