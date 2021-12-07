<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/css_administrador/admin_roles.css" type="text/css" />
    <title>Administrar roles</title>
</head>

<body>
    <?php
    include_once "../administrador/include/header.php";
    include_once "../sql/op_administrador.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = modificarDependencia($_POST['codigo'], $_POST['nombre'], $_POST['descripcion']);
        if ($respuesta === "exito") {
            echo "<script>repuestaCorrecta('Se ha modificado la dependencia')</script>";
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    $consulta = "SELECT * FROM dependencia WHERE Codigo='" . $_GET['codigo'] . "'";
    $conn = conectar();
    $resultado = mysqli_query($conn, $consulta);
    $departamento = mysqli_fetch_array($resultado);
    ?>
    <div class="titulo">
        <h1>Administrar roles del departamento de <?php echo $departamento[1]; ?></h1>
    </div>
    <div class="contenedor">
        <div class="contenedor_form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="formulario">
                    <div style="text-align:end;"><a href="/sql/op_administrador.php?eliminar_dependencia=<?php echo $departamento[0]; ?>" class="del-btn"><img src="/image/simbolo/eliminar.png" alt="eliminar" class="simbolo"></a></div>
                    <div>
                        <h2 class="titulo">Modificar dependencia</h2>
                        <h2>Codigo</h2>
                        <input type="text" name="codigo" class="contenedortext" value="<?php echo $departamento[0]; ?>" readonly>
                        <h2>Nombre</h2>
                        <input type="text" name="nombre" class="contenedortext" value="<?php echo $departamento[1]; ?>">
                        <h2>Descripción</h2>
                        <textarea type="text" name="descripcion" class="contenedorArea"><?php echo $departamento[2]; ?></textarea>
                    </div>
                    <input type="submit" value="Modificar" name="btnAdd" class="button" style="  width: 200px; height: 50px;">
                </div>
            </form>
        </div>
        <div class="contenedor_data">
            <div>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="caja_de_buscqueda">Buscar:</label>
                    <input type="text" name="caja_de_busqueda" class="caja_de_busqueda" id="caja_de_busqueda">
                    <input type="submit" value="Buscar" name="btnbuscar" class="button" style="font-size: 20px;">
                </form>
            </div>
            <div class="datos">
                <table style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo electronico</th>
                            <th>Dirección</th>
                            <th>Rol</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($_POST["btnbuscar"]) && !empty($_POST["caja_de_busqueda"])) {
                        if($_POST["caja_de_busqueda"] !== ""){
                            $consulta = "SELECT Correo,us.Nombre,us.Apellidos,us.Direccion,r.Nombre 
                            FROM usuarios AS us  
                            INNER JOIN rol AS r 
                            ON us.Rol = r.Id_rol
                            WHERE us.Nombre LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR us.Apellidos LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR us.Direccion LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR r.Nombre LIKE '%" . $_POST["caja_de_busqueda"] . "%' OR Correo LIKE '%" . $_POST["caja_de_busqueda"] . "%'";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                        }else{
                            $consulta = "SELECT Correo,usuarios.Nombre,usuarios.Apellidos,usuarios.Direccion,Rol.Nombre 
                            FROM usuarios,Dependencia,Rol WHERE Dependencia = '" . $departamento[0] . "' AND Dependencia = Dependencia.Codigo AND Rol.Id_rol = usuarios.Rol";
                            $conn = conectar();
                            $resultado = mysqli_query($conn, $consulta);
                        }
                       
                    } else {
                        $consulta = "SELECT Correo,usuarios.Nombre,usuarios.Apellidos,usuarios.Direccion,Rol.Nombre 
                            FROM usuarios,Dependencia,Rol WHERE Dependencia = '" . $departamento[0] . "' AND Dependencia = Dependencia.Codigo AND Rol.Id_rol = usuarios.Rol";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                    }
                    while ($fila = mysqli_fetch_array($resultado)) {
                        $val = "SELECT * FROM usuarios WHERE Dependencia = '".$_GET['codigo']."' AND Correo = '".$fila[0]."'";
                        $resulval = mysqli_query($conn, $val);
                        if (mysqli_num_rows($resulval)) {
                    ?>
                        <tr>
                            <td><?php echo $fila[1]; ?></td>
                            <td><?php echo $fila[2]; ?></td>
                            <td><?php echo $fila[0]; ?></td>
                            <td><?php echo $fila[3]; ?></td>
                            <td><?php echo $fila[4]; ?></td>
                            <td>
                                <a href="/administrador/cambiar_rol.php?codigo=<?php echo $_GET['codigo']?>&nombre=<?php echo $departamento[1];?>&Correo=<?php echo  $fila[0];?>">
                                    <img class="simbolo" src="/image/simbolo/asignar_rol.png" alt="asignar rol" style="margin-right: 20px;">
                                </a>
                                <a href="/sql/op_administrador.php?codigo=<?php echo $_GET['codigo']?>&eliminar_usuario=<?php echo  $fila[0]; ?>"  class="del-us">
                                    <img class="simbolo" src="/image/simbolo/basurero.png" alt="eliminar cuenta">
                                </a>
                            </td>
                        </tr>
                    <?php }
                    }
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
                title: '¿Seguro quieres eliminar la dependencia?',
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
        $('.del-us').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                title: '¿Seguro quieres eliminar el usuario?',
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