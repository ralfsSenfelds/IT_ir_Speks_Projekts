<?php require('assets/header.php'); ?>
<?php require('assets/crud_operations.php'); ?>

<section id="start">
    <div class="container">
        <h1>IT ir spēks <img src="./assets/images/logo.png" alt=""></h1>
        <p>Izmanto šo iespēju iegūt IT karjeru kādā no uzņēmumiem!</p>
        <div class="button-group">
            <a href="vakances.php"><button class="btn">Apskatīt vakances</button></a>
        </div>
        <div id="popupOverlay" class="popup-overlay"></div>
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>How to Apply for Vacancies</h2>
                <div class="steps">
                    <div class="step">
                        <img src="assets/images/solis1.png" alt="Step 1">
                        <p>Solis 1: Atrodi navigācijas panelī sadaļu vakances.</p>
                    </div>
                    <div class="step">
                        <img src="assets/images/solis2.png" alt="Step 2">
                        <p>Solis 2: Atrodi sev vēlamo vakanci uz kuru vēlies pretendēt.</p>
                    </div>
                    <div class="step">
                        <img src="assets/images/solis3.png" alt="Step 3">
                        <p>Solis 3: Ievadi savu informāciju, pievieno CV un spied nosūtīt.</p>
                    </div>
                </div>
            </div>
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
            <a class="btn" href="kontakti.php">Par mums</a>
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
<section id="jaunumu_saraksts" class="container">
    <div>
        <h1 class="nodalas_virsraksts">Aktualitātes</h1>
    </div>
    <div class="boxes">
        <?php
        $savienojums = mysqli_connect($servers, $lietotajs, $parole, $db_nosaukums);
        $query = "SELECT Aktualitates_ID, Attels, Virsraksts, Teksts FROM itspeks_aktualitates ORDER BY Pievienosanas_laiks DESC LIMIT 3";
        $result = mysqli_query($savienojums, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($savienojums));
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $imageData = base64_encode($row['Attels']);
                $imageType = 'image/jpeg';
                if (strpos($imageData, '/9j/') === 0) { 
                    $imageType = 'image/jpeg';
                } elseif (strpos($imageData, 'iVBORw0KGgoAAAANSUhEUgAAAB') === 0) { 
                    $imageType = 'image/png';
                }
                echo '<div class="box">';
                echo '<div class="image-container">';
                echo '<img src="data:' . $imageType . ';base64,' . $imageData . '" alt="Image">';
                echo '</div>';
                echo '<div class="text-container">';
                echo '<h3>' . $row['Virsraksts'] . '</h3>';
                // Truncate the news text to a certain number of characters
                $text = $row['Teksts'];
                $max_length = 150; // Maximum number of characters to display
                if (strlen($text) > $max_length) {
                    $text = substr($text, 0, $max_length) . '...';
                }
                echo '<p>' . $text . '</p>';
                echo '<a href="aktualitates.php?id=' . $row ['Aktualitates_ID'] . '" class="read-more-btn">Lasīt vairāk</a>';
                echo '</div>';
                echo '</div>';
            }
        }
        else {
            echo '<p>Nav pieejamu aktualitāšu.</p>';
        }
        mysqli_close($savienojums);
        ?>
    </div>
    <a href="aktualitates.php"><button id="visi-jaunumi-btn">Apskatīt visus jaunumus</button></a>
</section>

<section id="vakances">
    <div class="container">
        <div class="vakances-augsa">
            <h2>Vakances</h2>
            <p>Vai esi gatavs jaunam profesionālam izaicinājumam? Mēs piedāvājam ne tikai darbu, bet arī iespēju augt un attīstīties. Ja esi motivēts, enerģisks un gatavs pierādīt sevi, tad šīs vakances ir tieši Tev. Pievienojies vietā, kur tavs talants tiks novērtēts un atbalstīts!</p>
        </div>
        <div class="grid-container">
    <?php
    // Query to fetch latest 6 vacancies based on the adding time
    $vakances_query = "SELECT Attels, Vakance, Apraksts FROM itspeks_vakances ORDER BY Pievienosanas_laiks DESC LIMIT 6";
    $savienojums = mysqli_connect($servers, $lietotajs, $parole, $db_nosaukums);
    $vakances_result = mysqli_query($savienojums, $vakances_query);

    if (!$vakances_result) {
        echo "<p>Error: " . mysqli_error($savienojums) . "</p>";
    } else {
        if (mysqli_num_rows($vakances_result) > 0) {
            while ($vakances_row = mysqli_fetch_assoc($vakances_result)) {
                echo "<div class='grid-item'>";
                echo "<div class='image-container'>";
                echo "<img src='data:image/png;base64," . base64_encode($vakances_row['Attels']) . "' alt='Vacancy Image'>";
                echo "</div>";
                echo "<div class='overlay'>";
                echo "<h3>" . htmlspecialchars($vakances_row['Vakance']) . "</h3>";
                // Truncate the vacancy description to a certain number of characters
                $description = $vakances_row['Apraksts'];
                $max_length = 100; // Maximum number of characters to display
                if (strlen($description) > $max_length) {
                    $description = substr($description, 0, $max_length) . '...';
                }
                echo "<p>" . htmlspecialchars($description) . "</p>";
                echo "<a href='vakances.php' class='read-more-btn'>Skatīt vairāk</a>"; // Link to vakances.php
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No vacancies found.</p>";
        }
    }
    ?>
</div>
    </div>
</section>

<?php require('assets/footer.php'); ?>
