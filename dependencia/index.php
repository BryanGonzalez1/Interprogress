<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_dependencia/cuestionario.css" type="text/css" />
    <title>Cuestionario</title>
</head>

<body>
    <?php 
    include_once "../sql/connection/conexion.php";
    include_once "../sql/op_dependencia.php";
    include "include/header.php";
    if (!empty($_POST["publicar"]))
    {
        $Val = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
        $conn = conectar();
        $resulval = mysqli_query($conn, $Val);
        $fecha_0 = mysqli_fetch_array($resulval);
        $res = enviar_formulario($fecha_0[0],$_SESSION['Correo']);
        if($res === "exitoso")
        {
            header("../dependencia/index.php");
        }
        else
        {
            echo "<script>repuestaError('" . $res . "')</script>";
        }
    }
        $Val = "SELECT fecha_evaluacion.Codigo from fecha_evaluacion,respuesta where fecha_evaluacion.Estado = '1' and fecha_evaluacion.Codigo = respuesta.Codigo_fecha and Dependencia_responsable ='".$_SESSION['Correo']."' and respuesta.Estado_cuestionario !='3'";
        $conn = conectar();
        $resulval = mysqli_query($conn, $Val);
        if(mysqli_num_rows($resulval)){
        $fecha_0 = mysqli_fetch_array($resulval);
        $estado= Faltan_documentos("Ambiente",$_SESSION['Correo'],$fecha_0[0]);
    ?>
        <div class="contenedor_form">
            <div class="info_semaforo">
                <h2 class="h2semaforo">🔴 Ninguna evidencia adjuntada</h2>
                <h2 class="h2semaforo">🟡 Faltan evidencias obligatorias</h2>
                <h2 class="h2semaforo">🟢 Cuestionario teminado</h2>
            </div>
        </div>
        <div class="contenedor_form" style="position:absolute;top:280px;">
            <?php
                $que = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
                $conn = conectar();
                $result = mysqli_query($conn, $que);
                $fecha = mysqli_fetch_array($result);  
            ?>
            <div class="info_semaforo">
                <h2 class="h2semaforo">📅 Fecha de inicio: <?php echo $fecha[1];?></h2>
                <h2 class="h2semaforo">📅 Fecha de final: <?php echo $fecha[2];?></h2>
            </div>
        </div>
        <div id=btn>
            <div class="titulo">
                <h1>Cuestionario</h1>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <input name="publicar" type="submit" value="Enviar formulario" class="button" />
            </form>
        </div>
        <div id="contenedor" style="margin-top: 10px;">
            <a href="/dependencia/eje_componente.php?codigo=Ambiente&titulo=Ambiente de Control">
                <div class="tarjetas <?php echo $estado; ?>">
                    <div id="ambienteControl">
                    <div id="tipo">Ambiente de Control</div>
                        <div id="info">
                            <div id="tipo">Ambiente de Control</div>
                            <p id="info2">El ambiente de control es el conjunto de factores del ambiente organizacional que deben establecer y mantener el jerarca, los titulares subordinados y demás funcionarios, para permitir el desarrollo de una actitud positiva y de apoyo para el control interno.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/dependencia/eje_componente.php?codigo=Riesgo&titulo=Valoracion del Riesgo">
                <?php $estado= Faltan_documentos("Riesgo",$_SESSION['Correo'],$fecha_0[0]); ?>
                <div class="tarjetas <?php echo $estado; ?>">
                    <div id="valoracionRiesgo">
                    <div id="tipo">Valoracion del Riesgo</div>
                        <div id="info">
                            <div id="tipo">Valoracion del Riesgo</div>
                            <p id="info2">La valoración del riesgo conlleva la identificación y el análisis de los riesgos que enfrenta la institución, tanto de fuentes internas como externas relevantes para la consecución de los objetivos; deben ser realizados por el jerarca y los titulares subordinados, con el fin de determinar cómo se deben administrar dichos riesgos.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/dependencia/eje_componente.php?codigo=Actividad&titulo=Actividades de Control">
                <?php $estado= Faltan_documentos("Actividad",$_SESSION['Correo'],$fecha_0[0]); ?>
                <div class="tarjetas <?php echo $estado; ?>">
                    <div id="actividadesControl">
                    <div id="tipo">Actividades de Control</div>
                        <div id="info">
                            <div id="tipo">Actividades de Control</div>
                            <p id="info2">La Ley General de Control Interno define las actividades de control como políticas y procedimientos que permiten obtener la seguridad de que se llevan a cabo las disposiciones emitidas por la Contraloría General de la República, por los jerarcas y titulares subordinados para la consecución de los objetivos del sistema de control interno.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/dependencia/eje_componente.php?codigo=Sistema&titulo=Sistema de Informacion">
                <?php $estado= Faltan_documentos("Sistema",$_SESSION['Correo'],$fecha_0[0]); ?>
                <div class="tarjetas <?php echo $estado; ?>">
                    <div id="sitemaInformacion">
                    <div id="tipo">Sistema de Informacion</div>
                        <div id="info">
                            <div id="tipo">Sistema de Informacion</div>
                            <p id="info2">Los sistemas de información son los elementos y condiciones necesarias para que de manera organizada, uniforme, consistente y oportuna se ejecuten las actividades de obtener, procesar, generar y comunicar la información de la gestión institucional y otra de interés para la consecución de los objetivos institucionales. </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/dependencia/eje_componente.php?codigo=Seguimiento&titulo=Seguimiento de Control Interno">
                <?php $estado= Faltan_documentos("Seguimiento",$_SESSION['Correo'],$fecha_0[0]); ?>
                <div class="tarjetas <?php echo $estado; ?>">
                    <div id="sistemaControlInterno">
                    <div id="tipo">Seguimiento de Control Interno</div>
                        <div id="info">
                            <div id="tipo">Seguimiento de Control Interno</div>
                            <p id="info2">El seguimiento comprende las actividades que se realizan para valorar la calidad del funcionamiento del sistema de control interno, a lo largo del tiempo; asimismo, para asegurar que los hallazgos de la auditoría y los resultados de otras revisiones se atiendan con prontitud.</p>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    <?php }else{ ?>
        <div class="Sin_menu">
            <h1 class="titulo_error">El tiempo de completar el formulario termino o ya enviaste el formulario.</h1>
            <img src="/image/simbolo/advertencia.png" alt="advertencia" class="adv"> 
        </div>
    <?php } ?>
</body>

</html>