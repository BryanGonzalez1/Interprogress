<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales</title>
    <link rel="stylesheet" href="/css/css_administrador/admin_roles.css" type="text/css" />
    <link rel="stylesheet" href="/css/css_administrador/config_sistema.css" type="text/css" />
</head>
<body>
    <div class="contenedor">
    <?php
        include_once "../sql/op_administrador.php";
        include_once "../administrador/include/header.php";
        include_once "../administrador/include/headerconfi.php";
        if(!empty($_POST["btnAdd"]))
        {
            $respuesta = agregar_credenciak($_POST['finicio'],$_POST['ffinal']);
            if ($respuesta === "exito") {
                echo "<script>repuestaCorrecta('Se ha agregado el credencial')</script>";
            } else {
                echo "<script>repuestaError('" . $respuesta . "')</script>";
            }            
        }
    ?>
        <div class="contenedor_form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="formulario" style="width: 360px;">
                    <div>
                        <h2 class="titulo">Credenciales del correo</h2>
                        <h2>Correo electronico</h2>
                        <input type="email" name="finicio" class="contenedortext">
                        <h2>Contraseña</h2>
                        <input type="password" name="ffinal" class="contenedortext">
                    </div>
                    <input type="submit" value="Registrar" name="btnAdd" class="button" style="  width: 200px; height: 50px;">
                </div>
            </form>
        </div>
        <div class="contenedor_data">
            <div class="datos">
                <table style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th>Correo electronico</th>
                            <th>Contraseña</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <?php
                    $consulta = "SELECT * FROM credenciales";
                    $conn = conectar();
                    $resultado = mysqli_query($conn, $consulta);
                    while ($fila = mysqli_fetch_array($resultado)) {
                    ?>
                        <tr>
                            <td><?php echo $fila[0]; ?></td>
                            <td><?php echo $fila[1]; ?></td>
                            <td >
                                <a href="/administrador/modificar_estado.php?estado=<?php echo  $fila[2];?>&contrasena=<?php echo  $fila[1];?>&correo=<?php echo  $fila[0];?>">
                                    <input type="submit" value="<?php if($fila[2]=="1"){echo 'Desactivar';}else{echo 'activar';} ?>" name="btnbuscar" class="button" style="font-size: 20px;">
                                </a>
                            </td>
                        </tr>
                    <?php }
                    desconectar($conn); ?>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>
</html>