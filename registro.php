<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- librerias y conexiones -->
    <link rel="stylesheet" href="css/registro.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/alertaregistro.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registrarse</title>
</head>
<style>
   
</style>

<body>
    <?php
    require_once "sql/op_sesion.php";
    if (!empty($_POST["btnAdd"])) {
        $respuesta = registrarAdmin($_POST['mail'], $_POST['name'], $_POST['lastname'], $_POST['adress'],$_POST['dependecia']);
        if ($respuesta === "exito") {
            header("location:/administrador/index.php"); 
        } else {
            echo "<script>repuestaError('" . $respuesta . "')</script>";
        }
    }
    ?>
    <div class="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <meta charset="UTF-8">
            <div style="margin-bottom: 25px;">
                <a href="/iniciar_sesion.php"><img src="/image/simbolo/regresar.jpg" alt=""></a>
                <h1>Registrarse</h2>
                <h2>Correo</h2>
                <input type="email" name="mail" class="contenedortext">
                <h2>Nombre</h2>
                <input type="text" name="name" class="contenedortext">
                <h2>Apellidos</h2>
                <input type="text" name="lastname" class="contenedortext">
                <h2>Dirección</h2>
                <input type="text" name="adress" class="contenedortext">
                <h2>Departamento</h2>
                <select name="dependecia" class="contenedortext">
                    <?php
                        $consulta = "SELECT * FROM dependencia";
                        $conn = conectar();
                        $resultado = mysqli_query($conn, $consulta);
                        while ($fila = mysqli_fetch_array($resultado)) {
                    ?>
                     <option value="<?php echo $fila[0]; ?>" class="opcion"  ><?php echo $fila[1]; ?></option>;
                    <?php } ?>  
                </select>
            </div>
            <input class="button" type="submit" value="Registrarse" name="btnAdd">
        </form>
    </div>
</body>

</html>