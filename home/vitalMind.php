<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 2) { // Suponiendo que el rol de usuario es 2
    header("Location: ../login.php");
    exit();
}

// Conectar a la base de datos
require_once '../config/connection.php';
$connection = new Connection();
$pdo = $connection->connect();

// Obtener la lista de usuarios
$sql = "SELECT id, username FROM usuarios";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener la fecha de la última modificación del archivo actual
$lastModified = date("Y-m-d H:i:s", filemtime(__FILE__));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vital Mind</title>
    <link rel="stylesheet" href="styles.css">
    <!-- FontAwesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script>
        // Pasar la fecha de última modificación de PHP a JavaScript
        const lastModifiedDate = '<?php echo $lastModified; ?>';
    </script>
    <script src="main.js" defer></script>
</head>
<body class="pattern">
    <?php
    session_start();
    ?>
    <!--NAVBAR-->
    <nav class="nav">
        <a href="" class="logo">
            <p>VM</p>
        </a>
        <ul class="nav-main">
            <li><a href="#">Inicio</a></li>
            <li><a href="#articulos">Artículos</a></li>
            <li><a href="#recursos">Recursos</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li><a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    <!--HEADER-->
    <header class="header">
      <div class="date-container">
          <div id="currentDateHeader"></div>
          <div id="lastModifiedHeader"></div>
      </div>
    </header>
    <!--HERO-->
    <div class="hand">
        <div class="container">
            <div class="image-container right">
                <img src="../images/hand.png" alt="Mano">
            </div>
            <div class="text-container">
              <h1 class="text-container-h">Vital Mind</h1>
              <h2 class="text-container-h">Donde la salud mental es la prioridad</h2>
              <p class="text-container-p">Cuidar de tu mente es invertir en ti mismo. Encuentra herramientas prácticas y consejos personalizados para mejorar tu bienestar emocional. ¡Explora nuestros recursos y comienza tu viaje hacia una vida más plena y feliz!</p>
              <div>
                <a href="" class="btn">
                  Libros recomendados
                </a>
                <a href="" class="btn">
                  Entrevistas
                </a>
              </div>
            </div>
        </div>
    </div>
    <!--ARTICULOS-->
    <div class="articulos" id="articulos">
      <h2 class="titulo">
        ARTICULOS DESTACADOS DE LA SEMANA
      </h2>
      <div class="noticias">
        <div class="noticia">
          <h3 class="noticia-titulo">
            El azúcar, un dulce engaño?
          </h3>
          <figure>
            <img src="../images/noticia1.jpeg" alt="noticia1">
            <figcaption>El azúcar, un dulce engaño?</figcaption>
          </figure>
          <p>La comida puede tener muchos efectos sobre tu estado de ánimo y tus emociones. Cuando tienes hambre y quieres comer, puedes estar malhumorado, disgustado o incluso enfadado. Cuando has comido algo delicioso, puedes sentirte eufórico y eufórico. Los alimentos que ingieres también pueden tener consecuencias a largo plazo para tu salud. En concreto, comer demasiado azúcar puede aumentar el riesgo de sufrir trastornos del estado de ánimo, incluida la depresión.</p>
          <button class="btn-noticia">
            <a href="">Continuar leyendo</a>
          </button>
        </div>
        <div class="noticia">
          <h3 class="noticia-titulo">
            Trauma y ansiedad relacionados
          </h3>
          <figure>
            <img src="../images/noticia2.jpeg" alt="noticia2">
            <figcaption>Trauma y ansiedad relacionados</figcaption>
          </figure>
          <p>El trauma se produce cuando uno es parte o testigo de una experiencia negativa que desborda su respuesta al estrés y su capacidad psicológica para hacerle frente. La guerra, las catástrofes naturales, los malos tratos, presenciar la muerte y los accidentes que ponen en peligro la vida son ejemplos de situaciones que pueden causar un trauma. Después de un acontecimiento traumático, es natural pasar por una serie de emociones, como ira, culpa, tristeza y confusión.</p>
          <button class="btn-noticia">
            <a href="https://www.healthline.com/health/anxiety/whats-the-relationship-between-trauma-and-anxiety">Continuar leyendo</a>
          </button>
        </div>
        <div class="noticia">
          <h3 class="noticia-titulo">
            Amnesia disociativa
          </h3>
          <figure>
            <img src="../images/noticia3.jpeg" alt="noticia3">
            <figcaption>Amnesia disociativa</figcaption>
          </figure>
          <p>La amnesia disociativa se produce cuando la mente bloquea información importante sobre uno mismo, provocando «lagunas» en la memoria. Una de las razones más comunes por las que la mente bloquea cosas es para protegerse de experiencias desagradables, angustiosas o traumáticas. No es lo mismo que simplemente olvidar algo. En la mayoría de los casos, conservas los recuerdos pero no puedes acceder a ellos.</p>
          <button class="btn-noticia">
            <a href="https://my.clevelandclinic.org/health/diseases/9789-dissociative-amnesia">Continuar leyendo</a>
          </button>
        </div>
        <div class="noticias-btn-verTodos">
          Ver todos
        </div>
      </div>
    </div>
    <!--RECURSOS-->
    <div class="recursos" id="recursos">
      <h2 class="titulo">RECURSOS</h2>
      <div class="noticias">
        <div class="noticia">
          <h3 class="noticia-titulo">
            Imagenes
          </h3>
          <figure>
            <img src="../images/recurso1.jpeg" alt="recurso1">
            <figcaption>Imagenes</figcaption>
          </figure>
          <p>Explora un universo visual infinito, donde cada imagen es una puerta hacia la serenidad. Nuestra galería te invita a un viaje introspectivo, ofreciéndote una variedad de estilos y temáticas que resonarán con tu alma. Desde paisajes oníricos hasta retratos emotivos, encontrarás la inspiración que necesitas para nutrir tu mente y encontrar tu centro.</p>
          <button class="btn-noticia">
            <a href="/">Ver galería</a>
          </button>
        </div>
        <div class="noticia">
          <h3 class="noticia-titulo">
            Videos
          </h3>
          <figure>
            <iframe width="90%" height="315" src="https://www.youtube.com/embed/DW-Wj62NOjY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <figcaption>Videos</figcaption>
          </figure>
          <p>Amplía tus conocimientos sobre salud mental con nuestros videos informativos y motivadores. Encuentra las claves para superar desafíos y construir una vida más feliz y plena.</p>
          <button class="btn-noticia">
            <a href="">Ver videos</a>
          </button>
        </div>
        <div class="noticia">
          <h3 class="noticia-titulo">
            Libros
          </h3>
          <figure>
            <img src="../images/recurso2.jpg" alt="recurso2">
            <figcaption>Libros</figcaption>
          </figure>
          <p>Descubre un mundo de posibilidades con nuestra selección de libros cuidadosamente curada. Desde clásicos de la psicología hasta las últimas novedades en bienestar, encontrarás la lectura perfecta para alimentar tu mente y espíritu.</p>
          <button class="btn-noticia">
            <a href="">Ver libros</a>
          </button>
        </div>
        <div class="noticias-btn-verTodos">
          Ver todos
        </div>
      </div>
    </div>
    <!--FOOTER-->
    <footer id="contacto">
        <div class="footer-column">
            <h3>About Us</h3>
            <ul>
                <li><a href="#">Our Story</a></li>
                <li><a href="#">Team</a></li>
                <li><a href="#">Careers</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Services</h3>
            <ul>
                <li><a href="#">Consulting</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="#">Training</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Contact Us</h3>
            <ul>
                <li><a href="#">Email</a></li>
                <li><a href="#">Phone</a></li>
                <li><a href="#">Address</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Additional Information</h3>
            <div id="browserInfo"></div>
        </div>
    </footer>
    <script src="main.js"></script>
</body>
</html>