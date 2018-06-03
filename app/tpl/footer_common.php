</main><!-- /#contenido -->
<footer>
    <div class="container">
        <div id="foot">
            <div class="logo"><a href="<?= BARRA; ?>">the·fancy·cards</a></div>
            <nav class="info-links">
                <h7 id="sn"><a class="amarillo" href="<?= BARRA; ?>sobrenosotros">Sobre Nosotros</a></h7>
                <h7 id="pri"><a class="rojo" href="<?= BARRA; ?>privacidad">Privacidad</a></h7>
                <h7 id="tnc"><a class="azul" href="<?= BARRA; ?>terminosycondiciones">Términos y Condiciones</a></h7>
                <h7 id="al"><a class="verde" href="<?= BARRA; ?>avisolegal">Aviso Legal</a></h7>
            </nav>
            <div id="redes">
                <a href="https://es-es.facebook.com/" target="_blank"><img src="<?= BARRA; ?>pub/img/redesSociales/facebookGris.png"
                        onmouseover="this.src='<?= BARRA; ?>pub/img/redesSociales/facebookColor.png'"
                        onmouseout="this.src='<?= BARRA; ?>pub/img/redesSociales/facebookGris.png'"
                        alt="icono facebook"></a>
                <a href="https://twitter.com" target="_blank"><img src="<?= BARRA; ?>pub/img/redesSociales/twitterGris.png"
                        onmouseover="this.src='<?= BARRA; ?>pub/img/redesSociales/twitterColor.png'"
                        onmouseout="this.src='<?= BARRA; ?>pub/img/redesSociales/twitterGris.png'" alt="icono twitter"></a>
                <a href="https://plus.google.com/" target="_blank"><img src="<?= BARRA; ?>pub/img/redesSociales/googleGris.png"
                        onmouseover="this.src='<?= BARRA; ?>pub/img/redesSociales/google.png'"
                        onmouseout="this.src='<?= BARRA; ?>pub/img/redesSociales/googleGris.png'"
                        alt="icono google"></a>
            </div>
        </div>
        <div id="er">
            <h7>© 2018 Alex Romero, <?= $this->title; ?></h7>
        </div>
    </div>
</footer>
<script src="<?= BARRA; ?>pub/js/modernizr.js"></script>
<script src="<?= BARRA; ?>pub/js/jquery-3.1.1.min.js"></script>
<script src="<?= BARRA; ?>pub/js/jquery.flexslider-min.js"></script>
<script src="<?= BARRA; ?>pub/js/jquery.md5.js"></script>
<script src="<?= BARRA; ?>pub/js/main.js?v=<?php echo VERSION ?>"></script>
<script src="<?= BARRA; ?>pub/js/popup.js?v=<?php echo VERSION ?>"></script>
<script src="<?= BARRA; ?>pub/js/slider.js?v=<?php echo VERSION ?>"></script>
<script src="<?= BARRA; ?>pub/js/desplegables.js?v=<?php echo VERSION ?>"></script>
<script src="<?= BARRA; ?>pub/js/micuenta.js?v=<?php echo VERSION ?>"></script>
<script>
    $(function () {
        $('.flexslider').flexslider({
            animation: "slide",
        });
    });
</script>
</body>
</html>
