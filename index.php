<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- librerias y estilos -->
  <link rel="stylesheet" href="css/index.css" type="text/css" />
  <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <title>Document</title>
</head>

<body>
  <div class="button">
    <input onclick="redirigir()" type="submit" name="iniciar_sesion" value="Iniciar sesion">
    <script>
      function redirigir() {
        location.href = "/iniciar_sesion.php"
      }
    </script>
  </div>
  <div class="container">
    <ul class="slider">
      <li id="slide1">
        <h1>¿Que es InterProgress?</h1>
        <h2>Somos un sistema de gestión de progreso interno, teniendo en cuenta estandarizaciones para la optimización </h2>
      </li>
      <li id="slide2">
        <h1>Nuestros valores</h1>
        <h2>
          Solidaridad
        </h2>
        <h2>
          Trabajo en equipo
        </h2>
        <h2>
          Sencillez
        </h2>
      </li>
      <li id="slide3">
      <h1>Aspectos que puedes Evaluar</h1>
        <h3>Seguimientos del Sistema de Control</h3>
        <h3>Ambiente de compromiso</h3>
        <h3>Valoracion de Riesgo</h3>
        <h3>Actividades de Control</h3>
        <h3>Sistema de Información</h3>
      </li>
    </ul>

    <ul class="menu">
      <li>
        <a href="#slide1">1</a>
      </li>
      <li>
        <a href="#slide2">2</a>
      </li>
      <li>
        <a href="#slide3">3</a>
      </li>
    </ul>

  </div>
  <footer class="pie">
    <div class="acerca_de">
      <h1 class="titulo_pie">Acerca de</h1>
    </div>
    <div class="version">
      <h1 class="version_h1">© 2021 hecho por Syswork</h1>
    </div>
    <div class="contacto">
      <h1 class="titulo_pie">Contacto</h1>
      <h3 class="contacto_h1">
        Phone: 800-2345-6789
        Email: interprogresCI@gmail.com
      </h3>
    </div>
  </footer>
</body>

</html>