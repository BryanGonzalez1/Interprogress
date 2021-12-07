<?php
  include_once "../sql/connection/conexion.php";
  session_start();
  if(!$_SESSION['active']){ 
    header("location:/iniciar_sesion.php");
  }else if((strcasecmp ( $_SESSION['Rol'] , '1')) !== 0)
    {
      header("location:/iniciar_sesion.php");
    }
    else{
      $fechaGuardada = $_SESSION["tiempo_de_ingreso"];
      $ahora = date("Y-n-j H:i:s");
      $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
      if($tiempo_transcurrido >= 6000000) {
        require_once "/salir.php";
      }else {
        $_SESSION["tiempo_de_ingreso"] = $ahora;
      }
    }
  
?>
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/header.css" type="text/css" />
<script src="/js/header.js" defer></script>
<script type="text/javascript" src="/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../../js/alertaregistro.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<header>
    <nav class="navbar">
        <div class="brand-title"><img src="/image/Logo.png" alt=""></div>
        <a href="#" class="toggle-button">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </a>
        <div class="navbar-links">
          <ul>
            <li><a href="/administrador/config_dependencia.php">Configuración de correos</a></li>
            <li><a href="/administrador/index.php">Administrar dependencias</a></li>
            <li><a href="/administrador/administrar_fechas.php">Administrar fechas</a></li>
            <li><a href="/administrador/lista_cuestionario.php">Revisar cuestionario</a></li>
            <li><a href="/administrador/resultados.php">Resultados</a></li>
            <li><a href="/administrador/modificar_cuenta.php"> Cuenta</a></li>
            <li><a href="/salir.php">Salir</a></li>
          </ul>
        </div>
      </nav>
    </header>
</header>