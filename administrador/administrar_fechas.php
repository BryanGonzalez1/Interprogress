<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_administrador/admin_roles.css" type="text/css" />
    <title>Administrar fechas</title>
</head>

<body>
    <?php
    include_once "../administrador/include/header.php";
    include_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = registrarfecha( $_POST['finicio'], $_POST['ffinal'],$_POST['estado']);
        if ($respuesta === "exito 1" || $respuesta === "exito 2") {
            if($respuesta === "exito 1"){
                echo "<script>repuestaCorrecta('Se ha registrado la fecha con exito y se han enviado los cuestionarios')</script>";
            }else{
                echo "<script>repuestaCorrecta('Se ha registrado la fecha con exito')</script>";
            }
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    ?>
    <div class="titulo">
        <h1>Administrar fechas de evaluaciónes</h1>
    </div>
    <div class="contenedor">
        <div class="contenedor_form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="formulario" style="width: 360px;">
                    <div>
                        <h2 class="titulo">Agregar fecha de evaluación</h2>
                        <h2>Fecha de inicio</h2>
                        <input type="date" name="finicio" class="contenedortext">
                        <h2>Fecha final</h2>
                        <input type="date" name="ffinal" class="contenedortext">
                        <h2>Estado</h2>
                        <select name="estado" class="contenedortext" style="height: 39px;">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <input type="submit" value="Registrar" name="btnAdd" class="button" style="  width: 200px; height: 50px;">
                </div>
                <?php
                $consultaCant = "SELECT * FROM fecha_evaluacion";
                $conn2 = conectar();
                $resultado3 = mysqli_query($conn2, $consultaCant);
                ?>
                <div class="info_semaforo" style="width: 360px;">
                    <h2 class="h2semaforo" style="font-size: 18px;">📅 Numero de fechas de evaluación: <?php echo mysqli_num_rows($resultado3);  desconectar($conn2); ?></h2>
                </div>
            </form>
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
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($_POST["btnbuscar"]) && !empty($_POST["caja_de_busqueda"])) {
                        if($_POST["caja_de_busqueda"] !== ""){
                            $consulta = "SELECT * FROM fecha_evaluacion WHERE
                            Codigo LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR F_inicio LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR F_final LIKE '%" . $_POST["caja_de_busqueda"] . "%'";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                        }else{
                            $consulta = "SELECT * FROM fecha_evaluacion";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                        }
                       
                    } else {
                        $consulta = "SELECT * FROM fecha_evaluacion";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                    }
                    while ($fila = mysqli_fetch_array($resultado)) {
                    ?>
                        <tr>
                            <td><?php echo $fila[1]; ?></td>
                            <td><?php echo $fila[2]; ?></td>
                            <td class="<?php if($fila[3] === "1"){ echo "activado";}else{echo "desactivado";} ?>"><?php if($fila[3] === "1"){ echo "activado";}else{echo "Inactivo";} ?></td>
                            <td>
                                <a href="/administrador/modificar_fecha.php?Codigo=<?php echo  $fila[0];?>">
                                    <img class="simbolo" src="/image/simbolo/modificar.png" alt="asignar rol" style="margin-right: 20px;">
                                </a>
                                <a href="/sql/op_administrador.php?codigo=&eliminar_fecha=<?php echo  $fila[0]; ?>"  class="del-btn">
                                    <img class="simbolo" src="/image/simbolo/basurero.png" alt="eliminar cuenta">
                                </a>
                            </td>
                        </tr>
                    <?php }
                    desconectar($conn); ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('.del-btn').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: '¿Seguro que quieres eliminar la fecha de evaluacion?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: '¡Sí, bórralo!'
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;

                }
            })
        })
    </script>
    <script src="/js/datos_roles.js"></script>
</body>

</html>