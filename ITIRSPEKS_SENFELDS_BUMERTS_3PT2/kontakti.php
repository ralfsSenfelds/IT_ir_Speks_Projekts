<?php require ('assets/header.php'); ?>

<section id="kontakti">
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2175.576800307131!2d24.109457015321418!3d56.956051601158116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecfcfc2808bd9%3A0x49da87e710cdef2e!2zS3JpxaFqxIHFhmEgVmFsZGVtxIFyYSBpZWxhIDEzLCBDZW50cmEgcmFqb25zLCBSxKtnYSwgTFYtMTAxMA!5e0!3m2!1slv!2slv!4v1716299325735!5m2!1slv!2slv" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div id="contact-header">
        <h1>Radās jautājumi?</h1>
        <h4>Droši sazinies ar mums jebkurā diennakts laikā un mēs cēntīsiemies jums palīdzēt pēc iespējas ātrāk!</h4>
    </div>
    <div class="container">
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-phone"></i>
                <h3>Tālrunis</h3>
                <p>+371 69 999 999</p>
                <p>+371 68 888 888</p>
            </div>
            <div class="contact-icon">
                <i class="fas fa-envelope"></i>
                <h3>E-pasts</h3>
                <p>ITIR@SPEKS.com</p>
                <p>SUPPORT@SPEKS.lv</p>
            </div>
            <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Adrese</h3>
                <p>Krišjāņa Valdemāra iela 13, <br> Rīga, LV-1010, Latvija</p>
            </div>
        </div>
        <div class="contact-form">
            <div class="instrukcijas">
                <h3>Lūdzu, ievadiet sekojošos datus šajā formā:</h3>
                <ol>
                    <li><span>Vārds:</span> Ievadiet savu pilno vārdu, piemēram, "Jānis Bērziņš".</li>
                    <li><span>E-pasts:</span> Lūdzu, ievadiet savu derīgo e-pastu adresi, piemēram, "janis.berzins@inbox.lv"</li>
                    <li><span>Tālrunis:</span> Ievadiet savu telefona numuru, piemēram, <br>"371+ 29 123 456".</li>
                    <li><span>Ziņojums:</span> Atstājiet šeit savu ziņojumu vai jautājumu, norādot visus nepieciešamos datus vai piezīmes.</li>
                </ol>
                <p>Pārliecinieties, ka sniegtā informācija ir precīza un pareiza, lai mēs varētu labāk atbildēt uz jūsu pieprasijumu.</p>
            </div>
            <div>
                <form class="form-box" action="" method="post">
                    <label>Vārds:</label>
                    <input type="text" name="vards" placeholder="Vārds" class="input-box" required="">
                    <label>E-pasts:</label>
                    <input type="email" name="epasts" placeholder="E-pasts" class="input-box" required="">
                    <label>Talrunis:</label>
                    <input type="tel" name="talrunis" placeholder="Tālrunis" class="input-box" required="">
                    <label>Ziņojums:</label>
                    <textarea name="zinojums" placeholder="Tava ziņa" class="input-box" required=""></textarea>
                    <button type="submit" class="btn" name="nosutit">Nosūtīt!</button>
                </form>
            </div>
        </div>
    </div>
</section>
            
<?php require ('assets/footer.php'); ?>