<?php
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

<link href="/sass/estilo.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/header.js" defer></script>
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="plugins/jnoty.min.js"></script>
<link rel="stylesheet" type="text/css" href="plugins/jnoty.min.css">
<script type="text/javascript" src="js/alertaregistro.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="stick">
    <nav class="navbar">
        <div class="brand-title"><img src="/image/Logo.png" alt=""></div>
        <a href="#" class="toggle-button">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
        </a>
        <div class="navbar-links">
        <ul>
            <li><a href="/vista_admin/index.php">Resultados</a></li>
            <li><a href="/salir.php">Salir</a></li>
        </ul>
        </div>
    </nav>
</div>