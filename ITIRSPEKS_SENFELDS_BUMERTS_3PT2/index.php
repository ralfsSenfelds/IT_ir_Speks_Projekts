<?php require('assets/header.php'); ?>
<section id="start">
    <div class="container">
        <h1>IT ir spēks <img src="./assets/images/logo.png" alt=""></h1>
        <p>Izmanto šo iespēju iegūt IT karjeru kādā no uzņēmumiem!</p>
        <div class="button-group">
            <a href="vakances.php"><button class="btn">Apskatīt vakances</button></a>
            
            <button class="btn btn-popup">Kā pieteikties?</button>

            <div id="popupOverlay" class="popup-overlay"></div>

            <div id="popup" class="popup">
                <div class="popup-content">
                    <span class="close-btn">&times;</span>
                    <h2>Popup Content</h2>
                    <p>This is an example popup.</p>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const popup = document.getElementById('popup');
                    const popupButton = document.querySelector('.btn-popup');
                    const closeButton = document.querySelector('.close-btn');
                    const popupOverlay = document.getElementById('popupOverlay');

                    popupButton.addEventListener('click', () => {
                        popup.classList.add('show');
                        popupOverlay.classList.add('show');
                    });

                    closeButton.addEventListener('click', () => {
                        popup.classList.remove('show');
                        popupOverlay.classList.remove('show');
                    });

                    popupOverlay.addEventListener('click', () => {
                        popup.classList.remove('show');
                        popupOverlay.classList.remove('show');
                    });
                });
            </script>
        </div>
    </div>
    <div>
        <div class="box-main">
            <div class="start-box">
                <h2><i class="fa-solid fa-clipboard-list"></i><br>IT vakances</h2>
            </div>
            <div class="start-box">
                <h2><i class="fa-solid fa-briefcase"></i><br>Aktuālie piedāvājumi</h2>
            </div>
            <div class="start-box">
                <h2><i class="fa-solid fa-phone"></i><br>Saziņa ar speciālistiem</h2>
            </div>
        </div>
    </div>
</section>
<section id="about-us">
    <div class="container-left">
        <div class="aboutus">
            <h1>Par mums</h1>
            <p>Mēs sadarbojies ar vairāk nekā 10 lielākajām IT kompānijām pasaulē, tāpēc sadarbojies ar mums!</p>
            <button class="btn">Par mums</button>
        </div>
    </div>
    <div class="container-right">
        <img src="./assets/images/logo.png" alt="">
    </div>
</section>
<section id="banner">
    <div class="banner-one">
    </div>
</section>
<section id="partners">
    <h1>Mūsu partneri</h1>
    <div class="slideshow-container" id="slideshow-container">
        <div class="mySlides"><a class="partner-link" href="https://www.apple.com" target="_blank"><img src="./assets/images/partner1.png" alt="Partner 1"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.microsoft.com" target="_blank"><img src="./assets/images/partner2.jpg" alt="Partner 2"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.samsung.com" target="_blank"><img src="./assets/images/partner3.jpg" alt="Partner 3"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.amazon.com" target="_blank"><img src="./assets/images/partner4.jpg" alt="Partner 4"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.intel.com" target="_blank"><img src="./assets/images/partner5.png" alt="Partner 5"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.tencent.com" target="_blank"><img src="./assets/images/partner6.png" alt="Partner 6"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.nvidia.com" target="_blank"><img src="./assets/images/partner7.webp" alt="Partner 7"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.adobe.com" target="_blank"><img src="./assets/images/partner8.png" alt="Partner 8"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.stc.com" target="_blank"><img src="./assets/images/partner9.webp" alt="Partner 9"></a></div>
        <div class="mySlides"><a class="partner-link" href="https://www.disney.com" target="_blank"><img src="./assets/images/partner10.jpg" alt="Partner 10"></a></div>
    </div>
</section>
<section id="jaunumu_saraksts">
    <div class="container">
        <div class="virsraksts_container">
            <h2 class="nodalas_virsraksts">Aktuālie jaunumi</h2>
        </div>
        <div class="boxes">
            <div class="box">
                <img src="placeholder.png" alt="Placeholder image">
                <h3>Jauns processors</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, quis?</p>
                <a href="#">Lasīt vairāk</a>
            </div>
            <div class="box">
                <img src="placeholder.png" alt="Placeholder image">
                <h3>Jauna programmesanas valoda</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, quis?</p>
                <a href="#">Lasīt vairāk</a>
            </div>
            <div class="box">
                <img src="placeholder.png" alt="Placeholder image">
                <h3>Datorprogrammaturas revolucija</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, quis?</p>
                <a href="#">Lasīt vairāk</a>
            </div>
            <a href="aktualitates.php"><button id="visi-jaunumi-btn">Apskatīt visus jaunumus</button></a>
        </div>
    </div>
</section>
<section id="vakances">
    <div class="container">
    <div class="vakances-augsa">
    <h2>Vakances</h2>
    <p>Vai esi gatavs jaunam profesionālam izaicinājumam? Mēs piedāvājam ne tikai darbu, bet arī iespēju augt un attīstīties. Ja esi motivēts, enerģisks un gatavs pierādīt sevi, tad šīs vakances ir tieši Tevi. Pievienojies vietā, kur tavs talants tiks novērtēts un atbalstīts!</p>
    </div>
    <div class="grid-container">
        <div class="grid-item">
                <img src="https://via.placeholder.com/500" alt="Placeholder Image">
                <div class="overlay">
                    <h3>Column 1</h3>
                    <p>Text on image 1</p>
                    <a href="">Skatīt vairāk</a>
                </div>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/500" alt="Placeholder Image">
                <div class="overlay">
                    <h3>Column 2</h3>
                    <p>Text on image 2</p>
                    <a href="">Skatīt vairāk</a>
                </div>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/500" alt="Placeholder Image">
                <div class="overlay">
                    <h3>Column 3</h3>
                    <p>Text on image 3</p>
                    <a href="">Skatīt vairāk</a>
                </div>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/500" alt="Placeholder Image">
                <div class="overlay">
                    <h3>Column 4</h3>
                    <p>Text on image 4</p>
                    <a href="">Skatīt vairāk</a>
                </div>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/500" alt="Placeholder Image">
                <div class="overlay">
                    <h3>Column 5</h3>
                    <p>Text on image 5</p>
                    <a href="">Skatīt vairāk</a>
                </div>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/500" alt="Placeholder Image">
                <div class="overlay">
                    <h3>Column 6</h3>
                    <p>Text on image 6</p>
                    <a href="">Skatīt vairāk</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require('assets/footer.php'); ?>