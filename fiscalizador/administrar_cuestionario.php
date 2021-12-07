<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_fiscalizador/menu.css" type="text/css" />
    <title>Administrar cuestionario</title>
</head>

<body>
    <?php 
        include "include/header.php";
        include_once "../sql/connection/conexion.php";
        if (!empty($_POST["publicar"])) {
            include_once "../sql/opcorreos_adentro.php";
            Enviarcuestionario_terminado();
            echo "<script>repuestaCorrecta('Se ha enviado un correo al administrador')</script>";
        }
        $Val = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
        $conn = conectar();
        $resulval = mysqli_query($conn, $Val);
        if(!mysqli_num_rows($resulval)){
    ?>
        <div class="titulo">
            <h1>Administrar cuestionario</h1>
        </div>
        <div id=btn>
            <form action="" method="post" enctype="multipart/form-data">
                <input name="publicar" type="submit" value="Avisar al gestor de formulario realizado" class="button" />
            </form>
        </div>
        <div id="contenedor" style="margin-top: 10px;">
            <a href="/fiscalizador/mostrar_encuesta.php?codigo=Ambiente&titulo=Ambiente de Control&eje=Compromiso">
                <div class="tarjetas">
                    <div id="ambienteControl">
                        <div id="tipo">Ambiente de Control</div>
                        <div id="info">
                            <div id="tipo">Ambiente de Control</div>
                            <p id="info2">El ambiente de control es el conjunto de factores del ambiente organizacional que deben establecer y mantener el jerarca, los titulares subordinados y demás funcionarios, para permitir el desarrollo de una actitud positiva y de apoyo para el control interno.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/fiscalizador/mostrar_encuesta.php?codigo=Riesgo&titulo=Valoracion del Riesgo&eje=Documentacion y comunicacion">
                <div class="tarjetas">
                    <div id="valoracionRiesgo">
                        <div id="tipo">Valoracion del Riesgo</div>
                        <div id="info">
                            <div id="tipo">Valoracion del Riesgo</div>
                            <p id="info2">La valoración del riesgo conlleva la identificación y el análisis de los riesgos que enfrenta la institución, tanto de fuentes internas como externas relevantes para la consecución de los objetivos; deben ser realizados por el jerarca y los titulares subordinados, con el fin de determinar cómo se deben administrar dichos riesgos.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/fiscalizador/mostrar_encuesta.php?codigo=Actividad&titulo=Actividades de Control&eje=Alcance de las actividades de control">
                <div class="tarjetas">
                    <div id="actividadesControl">
                        <div id="tipo">Actividades de Control</div>
                        <div id="info">
                            <div id="tipo">Actividades de Control</div>
                            <p id="info2">La Ley General de Control Interno define las actividades de control como políticas y procedimientos que permiten obtener la seguridad de que se llevan a cabo las disposiciones emitidas por la Contraloría General de la República, por los jerarcas y titulares subordinados para la consecución de los objetivos del sistema de control interno.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/fiscalizador/mostrar_encuesta.php?codigo=Sistema&titulo=Sistema de Informacion&eje=Alcance de los sistemas de informacion">
                <div class="tarjetas">
                    <div id="sitemaInformacion">
                        <div id="tipo">Sistema de Información</div>
                        <div id="info">
                            <div id="tipo">Sistema de Información</div>
                            <p id="info2">Los sistemas de información son los elementos y condiciones necesarias para que de manera organizada, uniforme, consistente y oportuna se ejecuten las actividades de obtener, procesar, generar y comunicar la información de la gestión institucional y otra de interés para la consecución de los objetivos institucionales. </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/fiscalizador/mostrar_encuesta.php?codigo=Seguimiento&titulo=Seguimiento de Control Interno&eje=Alcance del seguimiento del sistema de control interno">
                <div class="tarjetas">
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
            <h1 class="titulo_error">No puedes alterar el cuestionario en tiempos de evaluación.</h1>
            <img src="/image/simbolo/advertencia.png" alt="advertencia" class="adv"> 
        </div>
    <?php } ?>
</body>

</html>