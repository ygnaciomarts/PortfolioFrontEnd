<?php


    require 'includes/functions.php';
    includeTemplate('header');
    include 'config.php';

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $str_bienvenida = "Iniciar sesión";
        $str_link = "login";
    } else {
        $str_bienvenida = $_SESSION["nombre"];
        $str_link = "my-account";
    }

    $query = $link->query("SELECT * FROM productos");
    $row = $query->fetch_assoc();

    $id = array();
    $nombre = array();
    $artista = array();
    $cover = array();
    $tipo = array();
    $precio = array();
    $precioV = array();
    $precioD = array();
    $cont = 0;
    $descuento = "0.00";

    while ($row = mysqli_fetch_array($query)) {
        $id[$cont] = $row['id'];
        $nombre[$cont] = $row['nombre'];
        $artista[$cont] = $row['artista'];
        $cover[$cont] = base64_encode($row['img']);
        $tipo[$cont] = $row['tipo'];
        $precioV[$cont] = $row['precioV'];
        $precioD[$cont] = $row['precioD'];
        $cont++;

        if($precioD[$cont] === $descuento) {
            $precio[$cont] = $precioV[$cont];
            $descStyle = "rebaja";
        } else {
            $precio[$cont] = $precioD[$cont];
            $descStyleD = "precioD";
        }
    }
?>

<section>
    <div class="flexslider">
        <ul class="slides">
            <li>
                <a href="/bandupshop/product.php?action=ver&id=10000">
                    <img src="img/slider/Slider-PP_HolyFvck.png" />
                </a>
            </li>
            <li>
                <a href="/bandupshop/product.php?action=ver&id=10001">
                    <img src="img/slider/Slider-PP_BetterMistakes.png" />
                </a>
            </li>
            <li>
                <a href="/bandupshop/product.php?action=ver&id=10097">
                    <img src="img/slider/Slider-PP_Positions.png" />
                </a>
            </li>
            <li>
                <a href="/bandupshop/product.php?action=ver&id=10065">
                    <img src="img/slider/Slider-PP_Reinaissance.png" />
                </a>
            </li>
            <li>
                <a href="/bandupshop/product.php?action=ver&id=10071">
                    <img src="img/slider/Slider-PP_Special.png" />
                </a>
            </li>
        </ul>
    </div>
</section>


<!-- FlexSlider -->
<script defer src="js/jquery.flexslider-min.js"></script>

<script>
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
        });
    });
</script>

<main id="main1" class="contenedor sombra">
    <a name="top-sellers" class="titulos-body">TOP SELLERS</a>
    <div class="slider-ts">
        <div class="slider-ts-inner">
            <input class="slider-ts-open" type="radio" id="slider-ts-1" name="slider-ts" aria-hidden="true" hidden=""
                checked="checked">
            <div class="slider-ts-item">
                <div class="servicios">
                    <a href="/bandupshop/product.php?action=ver&id=10000">
                        <section id="serv1" class="servicio">
                            <div class="iconos">
                                <span class="span-lp">LP</span>
                                <img
                                    src="https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/c3/f7/6a/c3f76a82-5bc5-e291-e88e-56672a2b23f6/22UMGIM60461.rgb.jpg/500x500.png" />
                            </div>
                            <h3>HOLY FVCK</h3>
                            <h4><span>por</span>Demi Lovato</h4>
                            <h5>MX$1099</h5>
                        </section>
                    </a>
                    <a href="/bandupshop/product.php?action=ver&id=10067">
                        <section id="serv2" class="servicio">
                            <div class="iconos">
                                <span class="span-lp">LP</span>
                                <img src="https://is1-ssl.mzstatic.com/image/thumb/Music123/v4/8a/49/83/8a498383-03bb-27bd-000c-572d5e362f01/07UMGIM08937.rgb.jpg/500x500.png"
                                    width="100%" height="100%" />
                            </div>
                            <h3>Underclass Hero</h3>
                            <h4><span>por</span>Sum 41</h4>
                            <h5><span class="strikethrough">MX$989</span>MX$789</h5>
                        </section>
                    </a>
                    <a href="/bandupshop/product.php?action=ver&id=10064">
                        <section id="serv3" class="servicio">
                            <div class="iconos">
                                <span class="span-lp">LP</span>
                                <img src="https://is2-ssl.mzstatic.com/image/thumb/Music125/v4/c3/d0/1c/c3d01c88-73e7-187e-fd62-e1744de979a6/21UMGIM09915.rgb.jpg/500x500.png"
                                    width="100%" height="100%" />
                            </div>
                            <h3>Fearless (Taylor's Version)</h3>
                            <h4><span>por</span>Taylor Swift</h4>
                            <h5><span class="strikethrough">MX$909</span>MX$899</h5>
                        </section>
                    </a>
                    <a href="/bandupshop/product.php?action=ver&id=10070">
                        <section id="serv4" class="servicio">
                            <div class="iconos">
                                <span class="span-cd">CD</span>
                                <img
                                    src="https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/cb/58/8b/cb588bc8-1872-b1ba-afb3-45c8b3e17e1d/886449876266.jpg/500x500.png" />
                            </div>
                            <h3>MOTOMAMI +</h3>
                            <h4><span>por</span>ROSALÍA</h4>
                            <h5><span class="strikethrough">MX$209</span>MX$169</h5>
                        </section>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<br><br>

<main id="main2" class="contenedor sombra">
    <a name="novedades" class="titulos-body">NOVEDADES</a>
    <div id="sliderNov" class="slider-novedades">
        <div class="slider-novedades-inner">
            <input class="slider-novedades-open" type="radio" id="slider-novedades-1" name="slider-novedades"
                aria-hidden="true" hidden="" checked="checked">
            <div class="slider-novedades-item">
                <div class="servicios">
                    <?php
                            $cont = 0;
                            $query = $link->query("SELECT * FROM productos ORDER BY id DESC LIMIT 4");
                        
                            while ($row = $query->fetch_assoc()) {
                        ?>
                    <a href="/bandupshop/product.php?action=ver&id=<?php echo $id[$cont] ?>">
                        <section id="serv13" class="servicio">
                            <div class="iconos">
                                <span class="span-<?php echo strtolower($tipo[$cont]) ?>">
                                    <?php echo $tipo[$cont] ?>
                                </span>
                                <?php echo '<img src="data:image/png;base64,'.$cover[$cont].'"/>';?>
                            </div>
                            <h3>
                                <?php echo str_replace("`", "'", $nombre[$cont]) ?>
                            </h3>
                            <h4><span>por</span>
                                <?php echo $artista[$cont] ?>
                            </h4>
                            <h5>MX$
                                <?php echo $precioV[$cont] ?>
                            </h5>
                        </section>
                    </a>
                    <?php
                            $cont++;
                            }
                        ?>
                </div>
            </div>
            <input class="slider-novedades-open" type="radio" id="slider-novedades-2" name="slider-novedades"
                aria-hidden="true" hidden="">
            <div class="slider-novedades-item">
                <div class="servicios">
                    <?php
                            $cont = 4;
                            $query = $link->query("SELECT * FROM productos ORDER BY id DESC LIMIT 4");
                            
                            while($row = $query->fetch_assoc()) {
                        ?>
                    <a href="/bandupshop/product.php?action=ver&id=<?php echo $id[$cont] ?>">
                        <section id="serv14" class="servicio">
                            <div class="iconos">
                                <span class="span-<?php echo strtolower($tipo[$cont]) ?>">
                                    <?php echo $tipo[$cont] ?>
                                </span>
                                <?php echo '<img src="data:image/png;base64,'.$cover[$cont].'"/>';?>
                            </div>
                            <h3>
                                <?php echo $nombre[$cont] ?>
                            </h3>
                            <h4><span>por</span>
                                <?php echo $artista[$cont] ?>
                            </h4>
                            <h5>MX$
                                <?php echo $precioV[$cont] ?>
                            </h5>
                        </section>
                    </a>
                    <?php
                            $cont++;
                            }
                        ?>
                </div>
            </div>
            <input class="slider-novedades-open" type="radio" id="slider-novedades-3" name="slider-novedades"
                aria-hidden="true" hidden="">
            <div class="slider-novedades-item">
                <div class="servicios">
                    <?php
                            $cont = 8;
                            $query = $link->query("SELECT * FROM productos ORDER BY id DESC LIMIT 4");
                            
                            while($row = $query->fetch_assoc()) {
                        ?>
                    <a href="/bandupshop/product.php?action=ver&id=<?php echo $id[$cont] ?>">
                        <section id="serv15" class="servicio">
                            <div class="iconos">
                                <span class="span-<?php echo strtolower($tipo[$cont]) ?>">
                                    <?php echo $tipo[$cont] ?>
                                </span>
                                <?php echo '<img src="data:image/png;base64,'.$cover[$cont].'"/>';?>
                            </div>
                            <h3>
                                <?php echo $nombre[$cont] ?>
                            </h3>
                            <h4><span>por</span>
                                <?php echo $artista[$cont] ?>
                            </h4>
                            <h5>MX$
                                <?php echo $precioV[$cont] ?>
                            </h5>
                        </section>
                    </a>
                    <?php
                            $cont++;
                            }
                        ?>
                </div>
            </div>
            <label for="slider-novedades-3" class="slider-novedades-control prev control-1">‹</label>
            <label for="slider-novedades-2" class="slider-novedades-control next control-1">›</label>
            <label for="slider-novedades-1" class="slider-novedades-control prev control-2">‹</label>
            <label for="slider-novedades-3" class="slider-novedades-control next control-2">›</label>
            <label for="slider-novedades-2" class="slider-novedades-control prev control-3">‹</label>
            <label for="slider-novedades-1" class="slider-novedades-control next control-3">›</label>
        </div>
    </div>
</main>

<br>
<br>

<main id="main3" class="contenedor sombra">
    <a name="preventas" class="titulos-body">PREVENTAS</a>
    <div class="slider-preventas">
        <div class="slider-preventas-inner">
            <input class="slider-preventas-open" type="radio" id="slider-preventas-1" name="slider-preventas"
                aria-hidden="true" hidden="" checked="checked">
            <div class="slider-preventas-item">
                <div class="servicios">
                    <a href="/bandupshop/product.php?action=ver&id=10001">
                        <section id="serv16" class="servicio">
                            <div class="iconos">
                                <span class="span-lp">LP</span>
                                <img
                                    src="https://is1-ssl.mzstatic.com/image/thumb/Music125/v4/5f/02/1b/5f021b51-68d3-e519-4c78-4f5a43064ef2/093624881438.jpg/1000x1000.png" />
                            </div>
                            <h3>Better Mistakes</h3>
                            <h4><span>por</span>Bebe Rexha</h4>
                            <h5>MX$679</h5>
                        </section>
                    </a>
                    <a href="/bandupshop/product.php?action=ver&id=10065">
                        <section id="serv20" class="servicio">
                            <div id="serv17" class="iconos">
                                <span class="span-boxset">Boxset</span>
                                <img
                                    src="https://is2-ssl.mzstatic.com/image/thumb/Music112/v4/05/05/f3/0505f338-9873-feb4-af7f-27a470405e5f/196589246974.jpg/1000x1000.png" />
                            </div>
                            <h3>RENAISSANCE</h3>
                            <h4><span>por</span>Beyoncé</h4>
                            <h5>MX$1519</h5>
                        </section>
                    </a>
                    <a href="/bandupshop/product.php?action=ver&id=10066">
                        <section id="serv18" class="servicio">
                            <div class="iconos">
                                <span class="span-cd">CD</span>
                                <img src="https://pbs.twimg.com/media/Fe_PEd7VEAAauUf?format=jpg&name=large"
                                    width="100%" height="100%" />
                            </div>
                            <h3>K23</h3>
                            <h4><span>por</span>Kenia Os</h4>
                            <h5><span class="strikethrough">MX$229</span>MX$179</h5>
                        </section>
                    </a>
                    <a href="/bandupshop/product.php?action=ver&id=10098">
                        <section id="serv19" class="servicio">
                            <div class="iconos">
                                <span class="span-cd">CD</span>
                                <img
                                    src="https://i.scdn.co/image/ab67616d0000b273fa747621a53c8e2cc436dee0" />
                            </div>
                            <h3>Midnights (Edición Especial)</h3>
                            <h4><span>por</span>Taylor Swift</h4>
                            <h5><span class="strikethrough">MX$209</span>MX$149</h5>
                        </section>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<br>

<footer class="footer">
    <div>
        <section>
            <p>
                <a><b>Conteo regresivo para la venta nocturna: </b></a><span id="days"></span> días / <span
                    id="hours"></span> horas / <span id="minutes"></span> minutos / <span id="seconds"></span> segundos
            </p>
        </section>
        <p> © 2022 BandUp.com | Todos los derechos reservados | <a href="/aviso-de-privacidad">Aviso de Privacidad</a>
        </p>
    </div>
</footer>

<br>
</body>

<script lenguage="javascript">
    //===
    // VARIABLES
    //===
    const DATE_TARGET = new Date('07/02/2024 0:01 AM');
    // DOM for render
    const SPAN_DAYS = document.querySelector('span#days');
    const SPAN_HOURS = document.querySelector('span#hours');
    const SPAN_MINUTES = document.querySelector('span#minutes');
    const SPAN_SECONDS = document.querySelector('span#seconds');
    // Milliseconds for the calculations
    const MILLISECONDS_OF_A_SECOND = 1000;
    const MILLISECONDS_OF_A_MINUTE = MILLISECONDS_OF_A_SECOND * 60;
    const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;
    const MILLISECONDS_OF_A_DAY = MILLISECONDS_OF_A_HOUR * 24

    //===
    // FUNCTIONS
    //===

    /**
     * Method that updates the countdown and the sample
     */
    function updateCountdown() {
        // Calcs
        const NOW = new Date()
        const DURATION = DATE_TARGET - NOW;
        const REMAINING_DAYS = Math.floor(DURATION / MILLISECONDS_OF_A_DAY);
        const REMAINING_HOURS = Math.floor((DURATION % MILLISECONDS_OF_A_DAY) / MILLISECONDS_OF_A_HOUR);
        const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
        const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MILLISECONDS_OF_A_SECOND);
        // Thanks Pablo Monteserín (https://pablomonteserin.com/cuenta-regresiva/)

        // Render
        SPAN_DAYS.textContent = REMAINING_DAYS;
        SPAN_HOURS.textContent = REMAINING_HOURS;
        SPAN_MINUTES.textContent = REMAINING_MINUTES;
        SPAN_SECONDS.textContent = REMAINING_SECONDS;
    }

    //===
    // INIT
    //===
    updateCountdown();
    // Refresh every second
    setInterval(updateCountdown, MILLISECONDS_OF_A_SECOND);
</script>

<script lenguage="javascript">
    const btnDark = document.querySelector('#dark');
    var main1 = document.getElementById('main1');
    var main2 = document.getElementById('main2');
    var main3 = document.getElementById('main3');
    var divS = document.getElementById('divS');

    var nav = document.getElementById('nav');
    var navReg = document.getElementById('navReg');
    var menu = document.getElementById('menu');

    var serv1 = document.getElementById('serv1');
    var serv2 = document.getElementById('serv2');
    var serv3 = document.getElementById('serv3');
    var serv4 = document.getElementById('serv4');
    var serv5 = document.getElementById('serv5');
    var serv6 = document.getElementById('serv6');
    var serv7 = document.getElementById('serv7');
    var serv8 = document.getElementById('serv8');
    var serv9 = document.getElementById('serv9');
    var serv10 = document.getElementById('serv10');
    var serv11 = document.getElementById('serv11');
    var serv12 = document.getElementById('serv12');
    var serv14 = document.getElementById('serv14');
    var serv15 = document.getElementById('serv15');
    var serv16 = document.getElementById('serv16');
    var serv17 = document.getElementById('serv17');
    var serv18 = document.getElementById('serv18');
    var serv19 = document.getElementById('serv19');
    var serv20 = document.getElementById('serv20');

    var sliderNov = document.getElementById('sliderNov');
    load();

    btnDark.addEventListener('click', () => {
        btnDark.classList.toggle('active');
        document.body.classList.toggle('dark');
        store(document.body.classList.contains('dark'));
        main1.classList.toggle('dark');
        main2.classList.toggle('dark');
        main3.classList.toggle('dark');
        divS.classList.toggle('dark');
        nav.classList.toggle('dark');
        navReg.classList.toggle('dark');
        menu.classList.toggle('dark');
        serv1.classList.toggle('dark');
        serv2.classList.toggle('dark');
        serv3.classList.toggle('dark');
        serv4.classList.toggle('dark');
        serv5.classList.toggle('dark');
        serv6.classList.toggle('dark');
        serv7.classList.toggle('dark');
        serv8.classList.toggle('dark');
        serv9.classList.toggle('dark');
        serv10.classList.toggle('dark');
        serv11.classList.toggle('dark');
        serv12.classList.toggle('dark');
        sliderNov.classList.toggle('dark');
        serv14.classList.toggle('dark');
        serv15.classList.toggle('dark');
        serv16.classList.toggle('dark');
        serv17.classList.toggle('dark');
        serv18.classList.toggle('dark');
        serv19.classList.toggle('dark');
        serv20.classList.toggle('dark');
        document.getElementById('logo').src = "img/BandUp-O.svg";
    });

    function load() {
        const darkmode = localStorage.getItem('dark');

        if (!darkmode) {
            store('false');
        } else if (darkmode == 'true') {
            btnDark.classList.toggle('active');
            document.body.classList.toggle('dark');
            main1.classList.toggle('dark');
            main2.classList.toggle('dark');
            main3.classList.toggle('dark');
            divS.classList.toggle('dark');
            nav.classList.toggle('dark');
            navReg.classList.toggle('dark');
            menu.classList.toggle('dark');
            serv1.classList.toggle('dark');
            serv2.classList.toggle('dark');
            serv3.classList.toggle('dark');
            serv4.classList.toggle('dark');
            serv5.classList.toggle('dark');
            serv6.classList.toggle('dark');
            serv7.classList.toggle('dark');
            serv8.classList.toggle('dark');
            serv9.classList.toggle('dark');
            serv10.classList.toggle('dark');
            serv11.classList.toggle('dark');
            serv12.classList.toggle('dark');
            serv14.classList.toggle('dark');
            serv15.classList.toggle('dark');
            serv16.classList.toggle('dark');
            serv17.classList.toggle('dark');
            serv18.classList.toggle('dark');
            serv19.classList.toggle('dark');
            serv20.classList.toggle('dark');
            sliderNov.classList.toggle('dark');
            document.getElementById('logo').src = "img/BandUp-O.svg";
        }
    }

    function store(value) {
        localStorage.setItem('dark', value);
    }
</script>

</html>