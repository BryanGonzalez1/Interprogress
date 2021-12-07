<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_fiscalizador/act_cuestionario.css" type="text/css" />
    <title>Administrar cuestionario</title>
</head>

<body>
    <?php
    include "include/header.php";
    require_once "../sql/op_administrador.php";
    ?>
    <div id="contenedor">
        <?php
        $ejesConsulta = "SELECT DISTINCT Subcomponentes FROM cuestionario WHERE Componentes = '" . $_GET['codigo'] . "'";
        $conn = conectar();
        $resultEjes = mysqli_query($conn, $ejesConsulta);
        while ($eje = mysqli_fetch_array($resultEjes)) {
        ?>
            <a href="/fiscalizador/mostrar_encuesta.php?codigo=<?php echo $_GET['codigo']; ?>&eje=<?php echo $eje[0]; ?>&titulo=<?php echo $_GET['titulo']; ?>">
                <div id="opcion"><?php echo $eje[0]; ?></div>
            </a>
        <?php }
        desconectar($conn); ?>
        <div class="contenedor_form">
            <div class="info_semaforo">
                <h2 class="h2semaforo">🟡 Evidencia opcional</h2>
            </div>
        </div>
    </div>

    <div class="titulo">
        <h1>Componente: <?php echo $_GET['titulo']; ?></h1>
        <h1>Eje: <?php echo $_GET['eje']; ?></h1>
    </div>
    <div id="main-container">
        <?php
        $consulta = "SELECT * FROM cuestionario WHERE cuestionario.Componentes = '" . $_GET['codigo'] . "' and cuestionario.Subcomponentes = '" . $_GET['eje'] . "' ORDER BY FIELD(Nivel,'Incipiente','Novato','Competente','Diestro','Experto')";
        $conn = conectar();
        $resultado = mysqli_query($conn, $consulta);
        ?>
        <table>
            <thead>
                <tr>
                    <th>Nivel</th>
                    <th>Descripción</th>
                    <th>Puntaje</th>
                    <th> Ultima fecha de actualizacion</th>
                    <th>Actualizar</th>
                </tr>
            </thead>
            <?php
            while ($fila = mysqli_fetch_array($resultado)) {
            ?>
                <tr class="<?php if ($fila[5] === "0") {
                                echo "opcional";
                            } ?>">
                    <td><?php echo $fila[2]; ?></td>
                    <td style="text-align:justify;">
                        <?php
                        if ($fila[3] !== "") {
                            echo $fila[3];
                        } else {
                            echo "Sin evidencias descritas";
                        }
                        ?>
                    </td>
                    <td><?php echo $fila[6]; ?></td>
                    <td><?php echo $fila[4]; ?></td>
                    <td>
                        <a href="/fiscalizador/actualizar_cuestionario.php?Componentes=<?php echo $_GET['codigo']; ?>&Subcomponentes=<?php echo $_GET['eje']; ?>&Nivel=<?php echo $fila[2]; ?>&titulo=<?php echo $_GET['titulo']; ?>">
                            <img src="/image/simbolo/actualizar.png" alt="actualizar" class="simbolos">
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <?php
        desconectar($conn);
        ?>
    </div>
</body>

</html>