<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_fiscalizador/fechas.css" type="text/css" />
    <title>Informacion fechas</title>
</head>

<body>
    <?php
    include_once "../fiscalizador/include/header.php";
    include_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = registrarfecha( $_POST['finicio'], $_POST['ffinal'],$_POST['estado']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    ?>
    <div class="titulo">
        <h1>Información de fechas de evaluación</h1>
    </div>
    <div class="contenedor">
        <div class="contenedor_form">
                <?php 
                $Val = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
                $conn = conectar();
                $resulval = mysqli_query($conn, $Val);
                ?>
                <div class="<?php if(mysqli_num_rows($resulval)){ echo "formulario_true"; }else{ echo "formulario_false"; } ?>" style="width: 360px;">
                    <div>
                        <?php
                        if(mysqli_num_rows($resulval)){ 
                            $fechas = mysqli_fetch_array($resulval);
                        ?>
                            <h2 class="titulo">Fecha activa actual</h2>
                            <h2>Fecha de inicio</h2>
                            <input type="text" name="finicio" class="contenedortext" style="text-align: center;" value="<?php echo rtrim($fechas[1]); ?>">
                            <h2>Fecha final</h2>
                            <input type="text" name="ffinal" class="contenedortext" value="<?php echo rtrim($fechas[2]); ?>">
                            <img src="/image/simbolo/reloj.gif" alt="tiempo" class="reloj">
                        <?php }else{ ?>
                            <h2 class="titulo">No hay fechas activas</h2>
                        <?php } desconectar($conn);?>
                    </div>
                </div>
                <?php
                $consultaCant = "SELECT * FROM fecha_evaluacion";
                $conn2 = conectar();
                $resultado3 = mysqli_query($conn2, $consultaCant);
                ?>
                <div class="info_semaforo" style="width: 360px;">
                    <h2 class="h2semaforo" style="font-size: 18px;">📅 Numero de fechas de evaluacion: <?php echo mysqli_num_rows($resultado3);  desconectar($conn2); ?></h2>
                </div>
        </div>
        <div class="contenedor_data">
            <div>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="caja_de_busqueda" class="caja_de_busqueda" id="caja_de_busqueda">
                    <input type="submit" value="Buscar" name="btnbuscar" class="button" style="font-size: 20px;">
                </form>
            </div>
            <div class="datos">
                <table style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th>Fecha de inicio</th>
                            <th>Fecha final</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($_POST["btnbuscar"]) && !empty($_POST["caja_de_busqueda"])) {
                        if($_POST["caja_de_busqueda"] !== ""){
                            $consulta = "SELECT * FROM fecha_evaluacion WHERE Estado = '0' AND
                            (Codigo LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR F_inicio LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR F_final LIKE '%" . $_POST["caja_de_busqueda"] . "%')";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                        }else{
                            $consulta = "SELECT * FROM fecha_evaluacion WHERE Estado = '0'";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                        }
                       
                    } else {
                        $consulta = "SELECT * FROM fecha_evaluacion WHERE Estado = '0'";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                    }
                    while ($fila = mysqli_fetch_array($resultado)) {
                    ?>
                        <tr>
                            <td><?php echo $fila[1]; ?></td>
                            <td><?php echo $fila[2]; ?></td>
                            <td class="<?php if($fila[3] === "1"){ echo "Activado";}else{echo "Desactivado";} ?>"><?php if($fila[3] === "1"){ echo "Activado";}else{echo "Desactivado";} ?></td>
                        </tr>
                    <?php }
                    desconectar($conn); ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>