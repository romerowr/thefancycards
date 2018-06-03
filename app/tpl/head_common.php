<?php
use X\Sys\Session;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>thefancycards -> <?= $this->page; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/css.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/desplegables.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/home.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/flexslider.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/animate.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/hover.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/popup.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/fonts/iconos/flaticon.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/alex.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/productos.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/gestiones.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/perfil.css?v=<?php echo VERSION ?>">
    <link rel="stylesheet" type="text/css" href="<?= BARRA; ?>pub/css/error.css?v=<?php echo VERSION ?>">
    <script type="text/javascript">
        RUTA = '<?= BARRA ?>';
    </script>
</head>
<body>
<header id="cabecera-principal">
    <?php
    /* hacemos un control de sesiones para cargar el menu de administrador o no y con
    los enlaces que cada admin puede tener*/
    if (!empty(Session::get('rol'))) {

        if (Session::get('rol') == 1 || Session::get('rol') == 2) { ?>
            <div id="panelAdministrador"> <!-- Panel que se tiene que ocultar depende que usuario-->
                <div id="panel"><h5>Panel Administrador</h5></div>
                <div id="gestiones">
                    <?php if (Session::get('rol') == 1) { ?>
                        <div id="gusers"><a href="<?= BARRA; ?>gestionusuarios">Gestión Usuarios</a></div>
                    <?php } ?>
                    <div id="gproducts"><a href="<?= BARRA; ?>gestionproductos">Gestión Productos</a></div>
                    <div id="desconectar"><a class="logout"><span class="flaticon-exit"></span></a></div>
                </div>
            </div>

        <?php }
    } ?>
    <div class="container">
        <div id="logo" class="logo hvr-push"><a href="<?= BARRA; ?>">the·fancy·cards</a></div>

        <nav id="navegacion-principal">

            <div id="adorno" class="hvr-underline-from-center">
                <a href="#" class="icono-responsive productos toggle" data-class="visible"
                   data-target="#todosLosAdornos"></a>
                <div class="contenido-menu">Productos</div>
            </div>

            <div class="buscar">
                <a href="#" class="icono-responsive buscar toggle" data-class="visible"
                   data-target="#navegacion-principal .buscar"></a>
                <div class="contenido-menu">
                    <div class="cuadro-busqueda">
                        <input type="search" placeholder="...">
                        <!--<span class="flaticon-magnifier-tool"></span>-->
                        <span class="hvr-bounce-in">Buscar</span>
                    </div>
                </div>
            </div>

            <!-- if user is logged: quitar inciar sesion y que aparezca Perfil-->
            <!-- dentro de ese logged ver que tipo de usuario estamos usando-->
            <div class="main-nav">
                <a href="#" class="icono-responsive usuario toggle" data-class="visible"
                   data-target="#navegacion-principal .main-nav"></a>
                <div class="contenido-menu">
                    <!-- en caso de que estes logueado lo que se veria seria:-->
                    <?php
                    /* Dependiendo si el usuario esta logeado o no, mostramos su perfil o las opciones de logeo/registro*/
                    if (!empty(Session::get('nombreUsuario'))) {
                        ?>
                        <div id="perfil"><a
                                    href="<?= BARRA; ?>micuenta">Perfil, <?= Session::get('nombreUsuario'); ?></a></div>
                        <div><a class="cd-signin logout" href="#0">Cerrar Sesión</a></div>
                    <?php } else { ?>
                        <div><a class="cd-signin" href="#0">Iniciar Sesión</a></div>
                        <div><a class="cd-signup" href="#0">Registrarse</a></div>
                    <?php } ?>
                </div>
            </div>
            <div>
                <img id="carrito" src="<?= BARRA; ?>pub/img/iconosCategoria/carrito.png" alt="icono carrito">
            </div>

        </nav>
        <div id="todosLosAdornos">
            <div>
                <div><img src="<?= BARRA; ?>pub/img/iconosCategoria/regalo.png" alt="icono regalo">
                    <h3>Celebración</h3></div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/aniversario"
                            class="amarillo">Aniversario</a></h5></div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/nacimiento"
                            class="rojo">Nacimiento</a>
                    </h5></div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/boda" class="azul">Boda</a></h5></div>
            </div>
            <div>
                <div><img src="<?= BARRA; ?>pub/img/iconosCategoria/corazon.png" alt="icono corazon">
                    <h3>Sentimientos</h3></div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/amor" class="verde">Amor</a></h5>
                </div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/amistad" class="amarillo">Amistad</a>
                    </h5>
                </div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/familia" class="rojo">Familia</a></h5>
                </div>
            </div>
            <div>
                <div><img src="<?= BARRA; ?>pub/img/iconosCategoria/fiesta.png" alt="icono fiesta">
                    <h3>Festejos</h3></div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/navidad" class="azul">Navidad</a></h5>
                </div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/carnaval" class="verde">Carnaval</a>
                    </h5>
                </div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/halloween"
                            class="amarillo">Halloween</a>
                    </h5></div>
            </div>
            <div>
                <div><img src="<?= BARRA; ?>pub/img/iconosCategoria/otros.png" alt="icono otros">
                    <h3>Otros</h3></div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/gracias" class="rojo">Gracias</a></h5>
                </div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/mostrar/categoria/perdon" class="azul">Perdon</a></h5>
                </div>
                <div><h5><a href="<?= BARRA; ?>mostrarproductos/" class="verde">Todos los productos</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
    <div class="cd-user-modal-container"> <!-- this is the container wrapper -->
        <ul class="cd-switcher">
            <li><a href="#0">Iniciar Sesión</a></li>
            <li><a href="#0">Registrarse</a></li>
        </ul>

        <!-- Inicio login form -->
        <div id="cd-login">
            <form class="cd-form" id="cd-signin-ajax" method="POST">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="username">Usuario</label>
                    <input class="full-width has-padding has-border" id="signin-username" name="username" type="text"
                           placeholder="Usuario" required>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="password">Contraseña</label>
                    <input class="full-width has-padding has-border" id="signin-password" name="password"
                           type="password"
                           placeholder="Contraseña" required>
                    <a href="#0" class="hide-password">Mostrar</a>
                </p>

                <p class="fieldset">
                    <input class="full-width" type="submit" value="Iniciar Sesión">
                    <span id="signin-error-message"></span>
                </p>
            </form>

        </div>
        <!-- Fin login form -->

        <!-- Inicio signup form -->
        <div id="cd-signup">
            <form class="cd-form" id="cd-signup-ajax" method="POST">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="username">Username</label>
                    <input class="full-width has-padding has-border" id="signup-username" name="username" type="text"
                           placeholder="Username" required>
                    <span id="signup-username-message"></span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-email" for="semail">E-mail</label>
                    <input class="full-width has-padding has-border" id="signup-email" name="email" type="email"
                           placeholder="E-mail" required>
                    <span id="signup-email-message"></span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="password">Contraseña</label>
                    <input class="full-width has-padding has-border" id="signup-password" name="password"
                           type="password"
                           placeholder="Contraseña" required>
                    <a href="#0" class="hide-password">Mostrar</a>
                    <span id="signup-password-message"></span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="accept-terms" required>
                    <label for="accept-terms">Acepto los <a href="<?= BARRA; ?>terminosycondiciones" class="rojo" target="_blank">Términos
                            y Condiciones</a></label> <!--rederigir con php a la vista de terminos y condiciones -->
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Registrarse">
                    <span id="signup-registro-message"></span>
                </p>
            </form>

        </div>
        <!-- Fin signup form -->
    </div>
</div>

<div id="sombra"></div>

<div id="carritoDespegable">
</div>
<main id="principal"><!-- se cierra en el footer -->
