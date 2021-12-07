<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_fiscalizador/fechas.css" type="text/css" />
    <title>Revision de cuestionario</title>
</head>

<body>
    <?php
      include "include/header.php";
    include_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = registrarfecha( $_POST['finicio'], $_POST['ffinal'],$_POST['estado']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('El fiscalizador de ha sigo Modificado')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    ?>
    <div class="contenedor">
        <?php 
        $Val3 = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
        $conn = conectar();
        $resulval3 = mysqli_query($conn, $Val3);
        if(mysqli_num_rows($resulval3)){
        ?>
        <div class="titulo">
            <h1>Revisar evidencias de dependencias</h1>
        </div>
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
                            <input type="text" name="ffinal" class="contenedortext" style="margin-bottom: 20px;" value="<?php echo rtrim($fechas[2]); ?>">
                        <?php }else{ ?>
                            <h2 class="titulo">No hay fechas activas</h2>
                        <?php } desconectar($conn);?>
                    </div>
                </div>
                <?php
                $consultaDep = "SELECT Dependencia FROM usuarios WHERE Correo = '".$_SESSION['Correo']."'";
                $conn = conectar();
                $resultado4 = mysqli_query($conn, $consultaDep);
                $dep = mysqli_fetch_array($resultado4);
                $consultaCant = "SELECT DISTINCT Dependencia_responsable FROM respuesta,usuarios WHERE Estado_cuestionario = 3 AND Codigo_fecha = '".$fechas[0]."' 
                AND usuarios.Correo = Dependencia_responsable AND usuarios.Dependencia='".$dep[0]."';";
                $resultado3 = mysqli_query($conn , $consultaCant);
                ?>
                <div class="info_semaforo" style="width: 360px; margin-bottom:15px;">
                    <h2 class="h2semaforo" style="font-size: 18px;">🧑 Numero de dependencias: <?php echo mysqli_num_rows($resultado3);  desconectar($conn); ?></h2>
                </div>
                <div class="info_semaforo"  style="width: 360px;">
                    <h2 class="h2semaforo" style="color: red; font-size: 15px;">🔴 Dependencia sin revisar</h2>
                    <h2 class="h2semaforo" style="color: gold; font-size: 15px;">🟡 En proceso de revision</h2>
                    <h2 class="h2semaforo" style="color: green; font-size: 15px;">🟢 Revision teminada</h2>
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
                            <th>Correo</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Dependencia</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <?php
                    $consultaDep = "SELECT Dependencia FROM usuarios WHERE Correo = '".$_SESSION['Correo']."'";
                    $conn = conectar();
                    $resultado4 = mysqli_query($conn, $consultaDep);
                    $dep = mysqli_fetch_array($resultado4);
                    if (!empty($_POST["btnbuscar"]) && !empty($_POST["caja_de_busqueda"])) {
                        if($_POST["caja_de_busqueda"] !== ""){
                            $consulta = "SELECT usuarios.Correo,usuarios.Nombre,usuarios.Apellidos,Dependencia.Nombre FROM usuarios,dependencia WHERE usuarios.Dependencia = '".$dep[0]."' AND Rol = '4' AND Dependencia.Codigo = usuarios.Dependencia;";
                            $resultado = mysqli_query($conn, $consulta);
                        }else{
                            $consulta = "SELECT usuarios.Correo,usuarios.Nombre,usuarios.Apellidos,Dependencia.Nombre FROM usuarios,dependencia WHERE usuarios.Dependencia = '".$dep[0]."' AND Rol = '4' AND Dependencia.Codigo = usuarios.Dependencia;";
                            $resultado = mysqli_query($conn, $consulta);
                        }
                       
                    } else {
                        $consulta = "SELECT usuarios.Correo,usuarios.Nombre,usuarios.Apellidos,Dependencia.Nombre FROM usuarios,dependencia WHERE usuarios.Dependencia = '".$dep[0]."' AND Rol = '4' AND Dependencia.Codigo = usuarios.Dependencia;";
                        $resultado = mysqli_query($conn, $consulta);
                    }
                    while ($fila = mysqli_fetch_array($resultado)) {
                        $val = "SELECT * FROM respuesta WHERE Dependencia_responsable = '".$fila[0]."' AND Estado_cuestionario != 3 AND Codigo_fecha = '".$fechas[0]."';";
                        $resulval = mysqli_query($conn, $val);
                        if (!mysqli_num_rows($resulval)) {
                            $colsulta2 = "SELECT * FROM respuesta WHERE Dependencia_responsable = '".$fila[0]."' AND Estado_nivel IS NULL";
                            $resultado2 = mysqli_query($conn, $colsulta2);
                            if(mysqli_num_rows($resultado2) === 20){
                                $est = "sin_revisar";
                            }
                            if(mysqli_num_rows($resultado2) === 0){
                                $colsulta2 = "SELECT * FROM respuesta WHERE Dependencia_responsable = '".$fila[0]."' AND  Estado_mejora = 0";
                                $resultado2 = mysqli_query($conn, $colsulta2);
                                if(mysqli_num_rows($resultado2)){
                                    $est = "enproceso";
                                }else{
                                    $est = "revisado";
                                }
                            }
                            if(mysqli_num_rows($resultado2) > 0 && mysqli_num_rows($resultado2) < 20){
                                $est = "enproceso";
                            }
                    ?>   
                        <tr class="<?php echo $est; ?>">
                            <td><?php echo$fila[0]; ?></td>
                            <td><?php echo $fila[1]; ?></td>
                            <td><?php echo $fila[2]; ?></td>
                            <td><?php echo $fila[3]; ?></td>
                            <td>
                                <a href="/fiscalizador/menu_revcuestionario.php?dependencia=<?php echo $fila[3]; ?>&responsable=<?php echo$fila[0]; ?>&fecha=<?php echo $fechas[0]; ?>">
                                    <img src="/image/simbolo/documento.png" alt="revisar" class="simbolo">
                                </a>
                            </td>
                        </tr>
                    <?php }
                    } desconectar($conn); ?>
                </table>
            </div>
        </div>
        <?php }else {?>
        <div class="Sin_menu">
            <h1 class="titulo_error">No hay cuestionarios por revisar.</h1>
            <img src="/image/simbolo/advertencia.png" alt="advertencia" class="adv"> 
        </div>
        <?php } ?>
    </div>
</body>

</html>