<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css_fiscalizador/menu.css" type="text/css" />
    <title>Revision cuestionario</title>
</head>
<body>
    <?php 
        include "include/header.php";
        include_once "../sql/connection/conexion.php";
        $Val = "SELECT * FROM fecha_evaluacion WHERE Estado = '1'";
        $conn = conectar();
        $resulval = mysqli_query($conn, $Val);
        if(mysqli_num_rows($resulval)){
            include_once "../sql/op_administrador.php";
    ?>
        <div class="info_semaforo"  style="width: 360px;">
                    <h2 class="h2semaforo" style="color: red; font-size: 15px;">🔴 Dependencia sin revisar</h2>
                    <h2 class="h2semaforo" style="color: gold; font-size: 15px;">🟡 En proceso de revision</h2>
                    <h2 class="h2semaforo" style="color: green; font-size: 15px;">🟢 Revision teminada</h2>
        </div>
        <div class="titulo" style="margin-top: 5px;">
            <h1>Revision de la dependencia de <?php echo $_GET["dependencia"]; ?></h1>
        </div>
        <div id="contenedor" style="margin-top: 50px;">
            <a href="/administrador/rev_eje.php?codigo=Ambiente&titulo=Ambiente de Control&reponsable=<?php echo $_GET["responsable"];?>&dependencia=<?php echo $_GET["dependencia"];?>&fecha=<?php echo $_GET["fecha"];?>">
                <div class="tarjetas">
                    <div id="ambienteControl" class="<?php echo falta_componente($_GET["responsable"], "Ambiente",$_GET["fecha"]); ?>">
                        <div id="tipo">Ambiente de Control</div>
                        <div id="info">
                            <div id="tipo">Ambiente de Control</div>
                            <p id="info2">El ambiente de control es el conjunto de factores del ambiente organizacional que deben establecer y mantener el jerarca, los titulares subordinados y demás funcionarios, para permitir el desarrollo de una actitud positiva y de apoyo para el control interno.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/administrador/rev_eje.php?codigo=Riesgo&titulo=Valoracion del Riesgo&reponsable=<?php echo $_GET["responsable"];?>&dependencia=<?php echo $_GET["dependencia"];?>&fecha=<?php echo $_GET["fecha"];?>">
                <div class="tarjetas">
                    <div id="valoracionRiesgo" class="<?php echo falta_componente($_GET["responsable"], "Riesgo",$_GET["fecha"]); ?>" >
                        <div id="tipo">Valoracion del Riesgo</div>
                        <div id="info">
                            <div id="tipo">Valoracion del Riesgo</div>
                            <p id="info2">La valoración del riesgo conlleva la identificación y el análisis de los riesgos que enfrenta la institución, tanto de fuentes internas como externas relevantes para la consecución de los objetivos; deben ser realizados por el jerarca y los titulares subordinados, con el fin de determinar cómo se deben administrar dichos riesgos.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/administrador/rev_eje.php?codigo=Actividad&titulo=Actividades de Control&reponsable=<?php echo $_GET["responsable"];?>&dependencia=<?php echo $_GET["dependencia"];?>&fecha=<?php echo $_GET["fecha"];?>">
                <div class="tarjetas">
                    <div id="actividadesControl"  class="<?php echo falta_componente($_GET["responsable"], "Actividad",$_GET["fecha"]); ?>">
                        <div id="tipo">Actividades de Control</div>
                        <div id="info">
                            <div id="tipo">Actividades de Control</div>
                            <p id="info2">La Ley General de Control Interno define las actividades de control como políticas y procedimientos que permiten obtener la seguridad de que se llevan a cabo las disposiciones emitidas por la Contraloría General de la República, por los jerarcas y titulares subordinados para la consecución de los objetivos del sistema de control interno.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/administrador/rev_eje.php?codigo=Sistema&titulo=Sistema de Informacion&reponsable=<?php echo $_GET["responsable"];?>&dependencia=<?php echo $_GET["dependencia"];?>&fecha=<?php echo $_GET["fecha"];?>">
                <div class="tarjetas">
                    <div id="sitemaInformacion"  class="<?php echo falta_componente($_GET["responsable"], "Sistema",$_GET["fecha"]); ?>">
                        <div id="tipo">Sistema de Informacion</div>
                        <div id="info">
                            <div id="tipo">Sistema de Informacion</div>
                            <p id="info2">Los sistemas de información son los elementos y condiciones necesarias para que de manera organizada, uniforme, consistente y oportuna se ejecuten las actividades de obtener, procesar, generar y comunicar la información de la gestión institucional y otra de interés para la consecución de los objetivos institucionales. </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/administrador/rev_eje.php?codigo=Seguimiento&titulo=Seguimiento de Control Interno&reponsable=<?php echo $_GET["responsable"];?>&dependencia=<?php echo $_GET["dependencia"];?>&fecha=<?php echo $_GET["fecha"];?>">
                <div class="tarjetas">
                    <div id="sistemaControlInterno"  class="<?php echo falta_componente($_GET["responsable"], "Seguimiento",$_GET["fecha"]); ?>">
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
            <h1 class="titulo_error">No hay cuestionarios por revisar.</h1>
            <img src="/image/simbolo/advertencia.png" alt="advertencia" class="adv"> 
        </div>
    <?php } ?>
</body>

</html>